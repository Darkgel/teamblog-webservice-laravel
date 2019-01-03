<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:29
 */

namespace App\Models\DbBlog;

/**
 * @property int $id
 * @property string $title
 * @property string $author
 * @property string $summary
 * @property string $content_md
 * @property string $content_html
 * @property string $tags_json
 * @property int $status
 *
 * @property Tag[] $tags 文章关联的标签对象
 */
class Article extends BaseModel
{
    protected $table='article';

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * 标签对象
     */
    public function tags(){
        return $this->belongsToMany('App\Models\DbBlog\Tag', 'article_tag_association', 'article_id', 'tag_id');
    }

}
