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
    /**
     * @param int $id 文章id
     * @return Article|null
     */
    public function getArticleById($id){
        $article = Article::find($id);

        return $article;
    }
}
