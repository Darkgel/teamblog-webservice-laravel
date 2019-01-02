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
    public function transform(Article $article){
        return [
            'id' => $article->id,
            'title' => $article->title,
            'author' => $article->author,
            'updatedAt' => (string)$article->updated_at,
            'createdAt' => (string)$article->created_at,
            'summary' => $article->summary,
            'contentMd' => $article->content_md,
            'contentHtml' => $article->content_html,
            'tags' => $article->tags,
            'status'=> $article->status,
        ];
    }
}
