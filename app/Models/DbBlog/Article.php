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
    protected $fillable = ['title', 'author', 'summary', 'content_md', 'content_html', 'tags_json', 'status'];

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @param string $summary
     */
    public function setSummary(string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @param string $content_md
     */
    public function setContentMd(string $content_md): void
    {
        $this->content_md = $content_md;
    }

    /**
     * @param string $content_html
     */
    public function setContentHtml(string $content_html): void
    {
        $this->content_html = $content_html;
    }

    /**
     * @param string $tags_json
     */
    public function setTagsJson(string $tags_json): void
    {
        $this->tags_json = $tags_json;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * 标签对象
     */
    public function tags(){
        return $this->belongsToMany('App\Models\DbBlog\Tag', 'article_tag_association', 'article_id', 'tag_id');
    }

    /**
     * @return static
     */
    public static function getDefaultInstance(){
        $model = new static;

        $model->title = '';
        $model->author = '';
        $model->summary = '';
        $model->content_md = '';
        $model->content_html = '';
        $model->tags_json = '';
        $model->status = self::STATUS_DRAFT;

        return $model;
    }

}
