<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 15:56
 */

namespace App\Transformers\Blog;

use App\Models\DbBlog\Article;
use App\Transformers\AppTransformer;

class ArticleTransformer extends AppTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'tags'
    ];

    public function transform(Article $article){
        return [
            'id' => $article->id,
            'title' => $article->title,
            'author' => $article->author,
            'updatedAt' => $article->updated_at->timestamp,
            'createdAt' => $article->created_at->timestamp,
            'deletedAt' => $article->deleted_at->timestamp ?? null,
            'summary' => $article->summary,
            'contentMd' => $article->content_md,
            'contentHtml' => $article->content_html,
            'tagsJson' => $article->tags_json,
            'status'=> $article->status,
        ];
    }

    /**
     * Include Tags
     *
     * @param Article $article
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeTags(Article $article)
    {
        $tags = $article->tags;

        return $this->collection($tags, new TagTransformer());
    }
}
