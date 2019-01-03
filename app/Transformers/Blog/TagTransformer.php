<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/1/3
 * Time: 15:09
 */

namespace App\Transformers\Blog;

use App\Transformers\AppTransformer;
use App\Models\DbBlog\Tag;

class TagTransformer extends AppTransformer
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'articles'
    ];

    public function transform(Tag $tag){
        return [
            'id' => $tag->id,
            'createdAt' => $tag->created_at->timestamp,
            'updatedAt' => $tag->updated_at->timestamp,
            'name' => $tag->name,
            'description' => $tag->description,
        ];
    }

    /**
     * Include Articles
     *
     * @param Tag $tag
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeArticles(Tag $tag)
    {
        $articles = $tag->articles;

        return $this->collection($articles, new ArticleTransformer());
    }
}
