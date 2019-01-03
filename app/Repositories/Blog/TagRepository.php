<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/1/3
 * Time: 15:16
 */

namespace App\Repositories\Blog;

use App\Models\DbBlog\Tag;
use App\Repositories\AppRepository;

class TagRepository extends AppRepository
{
    /**
     * @param int $id 标签id
     * @return Tag|null
     */
    public function getTagById($id){
        $tag = Tag::find($id);

        return $tag;
    }
}
