<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:33
 */

namespace App\Repositories\Blog;

use App\Models\DbBlog\Article;
use App\Models\DbBlog\Tag;
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
            $models = Article::withTrashed()->paginate($pageSize, ['*'], 'pageNum', $pageNum);
        } else {
            $models = Article::paginate($pageSize, ['*'], 'pageNum', $pageNum);
        }

        return $models;
    }

    /**
     * @param array $articleData
     *
     * @return bool
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

        //处理tag,提交的格式["2", "4", "5"](2,4,5分别为tag的id)
//        $tagArray = Tag::whereIn('id', $articleData['tags'])->get();
//        $tagsJsonArray = [];
//        foreach ($tagArray as $tag){
//            $tagsJsonArray[] = [
//                'tg_id' => $tag->id,
//                'tag_name' => $tag->name,
//            ];
//        }
//        $model->tags_json = json_encode($tagsJsonArray, JSON_UNESCAPED_UNICODE);

        //处理summary,截取content_html的前200字
        if(empty($model->summary)){
            //先截取1000字
            $subContent = \mb_substr($model->content_html, 0, 100);
            $subContent = \strip_tags($subContent);
            $model->summary = \mb_substr($subContent, 0 , 200) . '...';
        }

        return $model->save();
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
}
