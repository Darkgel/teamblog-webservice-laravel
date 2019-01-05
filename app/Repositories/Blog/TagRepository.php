<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/1/3
 * Time: 15:16
 */

namespace App\Repositories\Blog;

use App\Models\DbBlog\Tag;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository extends BaseRepository
{
    /**
     * @param int $id 标签id
     * @return Tag|null
     */
    public function getTagById($id){
        $tag = Tag::find($id);
        return $tag;
    }

    /**
     * @param int $pageNum
     * @param int $pageSize
     * @param int $withDeleted
     *
     * @return LengthAwarePaginator
     */
    public function getTags($pageNum, $pageSize, $withDeleted = self::WITHOUT_DELETED){
        if($withDeleted === self::WITH_DELETED){
            $models = Tag::withTrashed()->paginate($pageSize, ['*'], 'pageNum', $pageNum);
        }else{
            $models = Tag::paginate($pageSize, ['*'], 'pageNum', $pageNum);
        }

        return $models;
    }

    /**
     * 创建标签
     * @param array $tagData
     *
     * @return bool
     */
    public function createTag($tagData){
        $model = Tag::getDefaultInstance();
        $model->fill($tagData);
        return $model->save();
    }

    /**
     * 更新标签
     * @param int $id tag id
     * @param array $tagData
     *
     * @return bool
     */
    public function updateTagById($id, $tagData){
        /** @var $model Tag */
        $model = Tag::find($id);
        //不允许修改name,id
        unset($tagData['id'], $tagData['name']);
        $model->fillable(['description',]);
        return $model->update($tagData);
    }

    /**
     * 删除标签
     * @param int $id tag id
     * @return bool
     */
    public function deleteTagById($id){
        try{
            /** @var $model Tag */
            $model = Tag::find($id);
            return $model->delete();
        } catch (\Exception $e){
            return false;
        }
    }
}
