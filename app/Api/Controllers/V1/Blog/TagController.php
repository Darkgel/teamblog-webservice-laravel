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
}
