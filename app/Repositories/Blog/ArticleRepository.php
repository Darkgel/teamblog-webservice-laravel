<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:33
 */

namespace App\Repositories\Blog;

use App\Exceptions\SystemException;
use App\Models\DbBlog\Article;
use App\Models\DbBlog\Tag;
use Carbon\Carbon;
use Enum\ErrorCode;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository extends BaseRepository
{
    /**
     * @param int $id 文章id
     * @return Article|null
     */
    public function getArticleById($id){
        $model = Article::find($id);
        return $model;
    }

    /**
     * @param int $pageNum
     * @param int $pageSize
     * @param int $withDeleted
     *
     * @return LengthAwarePaginator
     */
    public function getArticles($pageNum, $pageSize, $withDeleted = self::WITHOUT_DELETED){
        if($withDeleted === self::WITH_DELETED){
            $models = Article::withTrashed()
                ->orderBy('created_at', 'desc')
                ->paginate($pageSize, ['*'], 'pageNum', $pageNum);
        } else {
            $models = Article::orderBy('created_at', 'desc')
                ->paginate($pageSize, ['*'], 'pageNum', $pageNum);
        }

        return $models;
    }

    /**
     * @param array $articleData
     *
     * @return Article | null
     */
    public function save($articleData){
        if(empty($articleData['id']) || intval($articleData['id'] < 1)){//新的文章
            /** @var Article $model */
            $model = Article::getDefaultInstance();
        }else{
            /** @var Article $model */
            $model = Article::find(intval($articleData['id']));
        }
        unset($articleData['id']);
        $model->fill($articleData);

        $model->status = intval($articleData['status']) ?? Article::STATUS_DRAFT;

        //处理summary,截取content_html的前200字
        if(empty($model->summary)){
            //先截取1000字
            $subContent = \mb_substr($model->contentHtml, 0, 100);
            $subContent = \strip_tags($subContent);
            $model->summary = \mb_substr($subContent, 0 , 200) . '...';
        }

        return ($model->save()) ? $model : null;
    }

    /**
     * 保存文章，同时建立文章与标签之间的关联
     *
     * @param array 包含tags数据的文章数组
     *  eg ：
     *      [
     *          'title' => 'this is title',
     *          'author' => 'darkgel',
     *          ...
     *          'tags' => '1,2,3'//tag id 字符串
     *      ]
     *
     * @return Article | null
     */
    public function saveArticleWithTags($data){
        try{
            $newTagIdArray = [];
            \DB::connection('db_blog')->beginTransaction();
            if(isset($data['tags'])){
                $newTagIdArrayTmp = explode(',', $data['tags']);
                foreach($newTagIdArrayTmp as $tagIdString){
                    $newTagIdArray[] = intval($tagIdString);
                }
                unset($data['tags']);
            }
            $article = $this->save($data);

            //关联标签到文章
            if(!is_null($article)){
                $this->associateArticleWithTags($article, $newTagIdArray);
                \DB::connection('db_blog')->commit();
                return $article;
            }

            throw new SystemException(ErrorCode::SYSTEM_DB_WRITE_ERROR);

        } catch (\Exception $e){
            try{
                \DB::connection('db_blog')->rollBack();
            }catch(\Exception $e){
                //记录日志
                \Log::error($e->getMessage(), $e->getTrace());
            }

            return null;
        }
    }

    /**
     * 删除文章
     * @param int $id tag id
     * @return bool
     */
    public function deleteArticleById($id){
        try{
            /** @var $model Article */
            $model = Article::find($id);
            return $model->delete();
        } catch (\Exception $e){
            return false;
        }
    }

    /**
     * 关联文章与标签
     * @param Article $article
     * @param array $newTagIdArray
     */
    public function associateArticleWithTags($article, $newTagIdArray){
        //先获得已经与该文章关联的tag id
        $associatedTagIdsResult  = \DB::connection('db_blog')
            ->table('article_tag_association')
            ->where('article_id', $article->id)
            ->get(['tag_id'])->toArray();

        $associatedTagIdArray = [];
        foreach ($associatedTagIdsResult as $item){
            $associatedTagIdArray[] = $item->tag_id;
        }

        //需要添加的关联关系
        $addAssociatedTagIdArray = array_diff($newTagIdArray, $associatedTagIdArray);
        if(count($addAssociatedTagIdArray) > 0){
            $insertAssociation = [];
            foreach($addAssociatedTagIdArray as $tagId){
                $insertAssociation[] = [
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'article_id' => $article->id,
                    'tag_id' => \intval($tagId),
                ];
            }
            \DB::connection('db_blog')
                ->table('article_tag_association')
                ->insert($insertAssociation);
        }

        //需要删除的关联关系
        $deleteAssociatedTagIdArray = array_diff($associatedTagIdArray, $newTagIdArray);
        if(count($deleteAssociatedTagIdArray) > 0){
            \DB::connection('db_blog')
                ->table('article_tag_association')
                ->where('article_id', $article->id)
                ->whereIn('tag_id', $deleteAssociatedTagIdArray)
                ->delete();
        }
    }

    /**
     * @param string $year
     * @param int $pageNum
     * @param int $pageSize
     * @param int $withDeleted
     *
     * @return LengthAwarePaginator
     */
    public function getArticlesArchive($year, $pageNum, $pageSize, $withDeleted){
        $beginTimestamp = Carbon::create(intval($year), 1, 1, 0, 0, 0)->toDateTimeString();
        $endTimestamp = Carbon::create(intval($year), 12, 31, 23, 59, 59)->toDateTimeString();

        if($withDeleted === self::WITH_DELETED){
            $models = Article::withTrashed()
                ->where([
                  ['created_at', '>=', $beginTimestamp],
                  ['created_at', '<=', $endTimestamp],
                ])->orderBy('created_at', 'desc')
                ->paginate($pageSize, ['*'], 'pageNum', $pageNum);
        } else {
            $models = Article::where([
                ['created_at', '>=', $beginTimestamp],
                ['created_at', '<=', $endTimestamp],
            ])->orderBy('created_at', 'desc')
            ->paginate($pageSize, ['*'], 'pageNum', $pageNum);
        }

        return $models;
    }
}
