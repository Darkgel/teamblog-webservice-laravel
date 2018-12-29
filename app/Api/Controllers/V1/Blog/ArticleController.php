<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 15:53
 */

namespace App\Api\Controllers\V1\Blog;

use App\Api\Controllers\V1\V1Controller;
use App\Repositories\Blog\ArticleRepository;
use App\Exceptions\BusinessException;
use App\Transformers\Blog\ArticleTransformer;
use Enum\ErrorCode;

class ArticleController extends V1Controller
{
    public function detail(ArticleRepository $articleRepository, $id){
        try{
            $cacheKey = __METHOD__."_".$id;
            if(\Cache::has($cacheKey)){
                $content = \Cache::get($cacheKey);
                return $this->response->array($content);
            }

            $article = $articleRepository->getArticleById($id);
            if(is_null($article)) throw new BusinessException(ErrorCode::BUSINESS_NOT_FOUND);

            return $this->response
                ->item($article, new ArticleTransformer())
                ->header(self::CACHE_KEY_AND_TIME_HEADER, [$cacheKey]);

        } catch (BusinessException $e) {
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }
}
