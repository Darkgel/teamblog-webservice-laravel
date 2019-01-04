<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 15:53
 */

namespace App\Api\Controllers\V1\Blog;

use App\Api\Controllers\V1\V1Controller;
use App\Models\DbBlog\Article;
use App\Repositories\Blog\ArticleRepository;
use App\Exceptions\BusinessException;
use App\Transformers\Blog\ArticleTransformer;
use Enum\ErrorCode;
use Dingo\Api\Http\Request;

class ArticleController extends V1Controller
{
    /**
     * 文章详情
     * @author darkgel
     * @date 2019/1/2
     */
    /**
     * @SWG\Get(
     *     path="/blog/article/{id}",
     *     summary="文章详情",
     *     tags={"Blog/Article"},
     *     description="通过文章id获取相应的文章详情",
     *     operationId="V1.Blog.Article.detail",
     *     produces={"application/json"},
     *     @SWG\Parameter(name="id",in="path",description="文章id",type="integer",required=true),
     *     @SWG\Response(
     *          response=200,
     *          description="success",
     *          @SWG\Schema(
     *              type="json",
     *              @SWG\Property(property="code",type="integer",description="业务逻辑状态码",),
     *              @SWG\Property(property="msg",type="string",description="业务逻辑处理结果信息",),
     *              @SWG\Property(
     *                  property="content",
     *                  @SWG\Property(
     *                      property="data", description="文章详情",
     *                      @SWG\Property(property="id",type="integer",description="文章id",),
     *                      @SWG\Property(property="title",type="string",description="文章标题",),
     *                      @SWG\Property(property="author",type="string",description="文章作者",),
     *                      @SWG\Property(property="updatedAt",type="integer",description="更新时间",),
     *                      @SWG\Property(property="createdAt",type="integer",description="创建时间",),
     *                      @SWG\Property(property="summary",type="string",description="文章摘要",),
     *                      @SWG\Property(property="contentHtml",type="string",description="文章内容（html格式）",),
     *                      @SWG\Property(property="tagsJson",type="string",description="标签，json字符串",),
     *                      @SWG\Property(property="status",type="integer", description="状态",),
     *                 ),
     *              ),
     *          ),
     *     )
     *  )
     */
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

    /**
     * 文章列表
     * @author darkgel
     * @date 2019/1/3
     */
    public function index(ArticleRepository $articleRepository, Request $request){
        try{
            $pageNum = intval($request->query('pageNum', 1));
            $pageSize = intval($request->query('pageSize', 15));

            $cacheKey = __METHOD__."_"."pageNum:".$pageNum."_"."pageSize:".$pageSize;
            if(\Cache::has($cacheKey)){
                $content = \Cache::get($cacheKey);
                return $this->response->array($content);
            }
            $articles = $articleRepository->getArticles($pageNum, $pageSize);

            return $this->response
                ->paginator($articles, new ArticleTransformer())
                ->header(self::CACHE_KEY_AND_TIME_HEADER, [$cacheKey]);

        } catch (BusinessException $e) {
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }

    public function save(ArticleRepository $articleRepository, Request $request){
        try{
            $status = $request->post('status', Article::STATUS_DRAFT);
            $postData = $request->post();
            //校验数据有效性
            /** @var \Illuminate\Validation\Validator $validator*/
            $validator = \Validator::make($postData, [
                'title' => 'required|max:255',
                'author' => 'required|max:128',
                'summary'=> 'max:512',
                'tags' => 'array',
            ]);
            if($validator->fails()) throw new BusinessException(ErrorCode::BUSINESS_INVALID_PARAM, "", $validator->errors()->toArray());

            if($articleRepository->save($postData, $status)){//业务逻辑执行成功
                return $this->response->array([]);
            }else{
                throw new BusinessException(ErrorCode::BUSINESS_SERVER_ERROR);
            }

        } catch (BusinessException $e) {
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }

    public function delete(ArticleRepository $articleRepository, $id){
        try{
            if($articleRepository->deleteArticleById($id)){
                return $this->response->array([]);
            }else{
                throw new BusinessException(ErrorCode::BUSINESS_SERVER_ERROR);
            }

        } catch (BusinessException $e) {
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }
}
