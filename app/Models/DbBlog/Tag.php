<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/1/2
 * Time: 20:30
 */

namespace App\Models\DbBlog;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 *
 * @property Article[] $articles
 */
class Tag extends BaseModel
{
    protected $table='tag';

    public function articles(){
        return $this->belongsToMany('App\Models\DbBlog\Article', 'article_tag_association', 'tag_id', 'article_id');
    }
}
