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
 * @property int $updated_at
 * @property int $created_at
 * @property string $summary
 * @property string $content_md
 * @property string $content_html
 * @property string $tags
 * @property int $status
 *
 * @property \Illuminate\Database\Eloquent\Collection $images 专题图片表
 */
class Article extends BaseModel
{
    protected $table='article';

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;


}
