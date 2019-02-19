<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/1/3
 * Time: 15:12
 */

namespace App\Api\Controllers\V1\Blog;

use App\Api\Controllers\V1\V1Controller;
use App\Exceptions\BusinessException;
use Enum\ErrorCode;
use App\Transformers\Blog\TagTransformer;
use App\Repositories\Blog\TagRepository;
use Dingo\Api\Http\Request;

class TagController extends V1Controller
{
    /**
     * 标签详情
     * @author darkgel
     * @date 2019/1/3
     */
    /**
     * @SWG\Get(
     *     path="/blog/tag/{id}",
     *     summary="标签详情",
     *     tags={"Blog/Tag"},
     *     description="通过标签id获取相应的标签详情",
     *     operationId="V1.Blog.Tag.detail",
     *     produces={"application/json"},
     *     @SWG\Parameter(name="id",in="path",description="标签id",type="integer",required=true),
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
     *                      property="data", description="标签详情",
     *                      @SWG\Property(property="id",type="integer",description="标签id",),
     *                      @SWG\Property(property="updatedAt",type="integer",description="更新时间",),
     *                      @SWG\Property(property="createdAt",type="integer",description="创建时间",),
     *                      @SWG\Property(property="name",type="string",description="标签名称",),
     *                      @SWG\Property(property="description",type="string",description="标签描述",),
     *                 ),
     *              ),
     *          ),
     *     )
     *  )
     */
    public function detail(TagRepository $tagRepository, $id){
        try{
            $cacheKey = __METHOD__."_".$id;
            if(\Cache::has($cacheKey)){
                $content = \Cache::get($cacheKey);
                return $this->response->array($content);
            }

            $tag = $tagRepository->getTagById($id);
            if(is_null($tag)) throw new BusinessException(ErrorCode::BUSINESS_NOT_FOUND);

            return $this->response
                ->item($tag, new TagTransformer())
                ->header(self::CACHE_KEY_AND_TIME_HEADER, [$cacheKey]);

        } catch (BusinessException $e){
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }

    /**
     * 标签列表
     * @author darkgel
     * @date 2019/1/3
     */
    public function index(TagRepository $tagRepository, Request $request){
        try{
            $pageNum = intval($request->query('pageNum', 1));
            $pageSize = intval($request->query('pageSize', 15));
            $withDeleted = intval($request->query('withDeleted'), TagRepository::WITHOUT_DELETED);

            $cacheKey = __METHOD__."_"."pageNum:".$pageNum."_"."pageSize:".$pageSize;
            if(\Cache::has($cacheKey)){
                $content = \Cache::get($cacheKey);
                return $this->response->array($content);
            }
            $tags = $tagRepository->getTags($pageNum, $pageSize, $withDeleted);

            return $this->response
                ->paginator($tags, new TagTransformer())
                ->header(self::CACHE_KEY_AND_TIME_HEADER, [$cacheKey]);

        } catch (BusinessException $e) {
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }

    /**
     * 创建标签
     * @author Darkgel
     * @date 2019/1/3
     */
    public function create(TagRepository $tagRepository, Request $request){
        try{
            $postData = $request->post();
            //校验数据有效性
            /** @var \Illuminate\Validation\Validator $validator*/
            $validator = \Validator::make($postData, [
                'name' => 'required|max:128|unique:db_blog.tag,name',
                'description' => 'max:1024'
            ]);
            if($validator->fails()) throw new BusinessException(ErrorCode::BUSINESS_INVALID_PARAM, "", $validator->errors()->toArray());
            $tag = $tagRepository->createTag($postData);
            if(is_null($tag)){
                throw new BusinessException(ErrorCode::BUSINESS_SERVER_ERROR);
            }else{//业务逻辑执行成功
                return $this->response->item($tag, new TagTransformer());
            }

        } catch (BusinessException $e){
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }

    /**
     * 更新标签
     * @author Darkgel
     * @date 2019/1/3
     */
    public function update(TagRepository $tagRepository, Request $request, $id){
        try{
            $inputData = $request->input();
            //校验数据有效性
            /** @var \Illuminate\Validation\Validator $validator*/
            $validator = \Validator::make($inputData, [
                'description' => 'max:1024',
            ]);
            if($validator->fails()) throw new BusinessException(ErrorCode::BUSINESS_INVALID_PARAM, "", $validator->errors()->toArray());

            if($tagRepository->updateTagById(intval($id), $inputData)){//业务逻辑执行成功
                return $this->response->array([]);
            }else{
                throw new BusinessException(ErrorCode::BUSINESS_SERVER_ERROR);
            }

        } catch (BusinessException $e){
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }

    /**
     * 删除标签
     * @author Darkgel
     * @date 2019/1/3
     */
    public function delete(TagRepository $tagRepository, $id){
        try{
            if($tagRepository->deleteTagById($id)){
                return $this->response->array([]);
            }else{
                throw new BusinessException(ErrorCode::BUSINESS_SERVER_ERROR);
            }
        } catch (BusinessException $e){
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }

    public function getSimilarTagsByTagName(TagRepository $tagRepository, Request $request, $tagName = ''){
        try{
            $limit = intval($request->query('limit', 10));
            $cacheKey = __METHOD__."_"."tagName:".$tagName."_"."limit:".$limit;
            if(\Cache::has($cacheKey)){
                $content = \Cache::get($cacheKey);
                return $this->response->array($content);
            }
            $tags = $tagRepository->getSimilarTagsByTagName($tagName, $limit);

            return $this->response
                ->collection($tags, new TagTransformer())
                ->header(self::CACHE_KEY_AND_TIME_HEADER, [$cacheKey]);

        } catch (BusinessException $e){
            return $this->response->array($e->getExtra())
                ->header(self::BUSINESS_STATUS_HEADER, [$e->getCode(), $e->getMessage()]);
        }
    }
}
