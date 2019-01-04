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
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository extends AppRepository
{
    /**
     * @param int $id 文章id
     * @return Article|null
     */
    public function getArticleById($id){
        $model = Article::find($id);
        return $model;
    }

    /**
     * @param int $pageNum
     * @param int $pageSize
     *
     * @return LengthAwarePaginator
     */
    public function getArticles($pageNum, $pageSize){
        $models = Article::paginate($pageSize, ['*'], 'pageNum', $pageNum);
        return $models;
    }
}
