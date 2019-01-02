<?php
/**
 * 版本v1下所有Controller的基类
 *
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 15:53
 */

namespace App\Api\Controllers\V1;

use App\Http\Controllers\ApiController;

class V1Controller extends ApiController
{
    /**
     * @SWG\Swagger(
     *     schemes={"http","https"},
     *     host=L5_SWAGGER_CONST_HOST,
     *     @SWG\SecurityScheme(
     *         securityDefinition="client",
     *         type="apiKey",
     *         name="Authorization",
     *         in="header",
     *     ),
     *     security={{"client": {}},},
     *     @SWG\Info(
     *         version="1.0",
     *         title=" Team Blog API接口文档",
     *         description="Team Blog API接口文档",
     *         @SWG\Contact(
     *             name="darkgel",
     *             email="1627116986@qq.com"
     *         )
     *     ),
     * )
     */
}
