<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:33
 */

namespace App\Repositories\Blog;

use App\Models\DbBlog\Article;
use App\Repositories\AppRepository;

class ArticleRepository extends AppRepository
{
    public function getArticleById($id){
        $article = new Article();
        $article->id = 1;
        $article->title = 'article title one';
        $article->author = 'darkgel';
        $article->updated_at = time();
        $article->created_at = time();
        $article->summary = 'article summary one';
        $article->content_md = 'content md';
        $article->content_html = 'content html';
        $article->tags = 'tags1,tags2,tags3';
        $article->status = 2;

        return $article;
    }
}
