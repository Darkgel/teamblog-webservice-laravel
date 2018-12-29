<?php
/**
 * 该应用中所有Api Controller的基类，在往该类添加代码时需谨慎
 *
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 15:18
 */

namespace App\Http\Controllers;

use Dingo\Api\Routing\Helpers;

class ApiController extends AppController
{
    /**
     * 该常量用于将业务逻辑处理状态从Controller传递到最终的响应
     * 相关代码：
     *  App\Http\Middleware\BusinessFormatOutput ： 标记需要格式化输出的请求
     *  App\Listeners\AddBusinessStatusToResponse : 事件handler，格式化输出，添加业务逻辑处理结果
     *
     * 使用例子（在action中） ：
     *   return $this->response->array([
     *       'detail' => 'this is detail'
     *   ])->header(self::BUSINESS_STATUS_HEADER, [
     *       ErrorCode::BUSINESS_UNKNOWN_ERROR, '业务逻辑执行失败',
     *   ]);
     *
     * 在上面的例子中，通过使用withHeader方法，ErrorCode::BUSINESS_UNKNOWN_ERROR和'业务逻辑执行失败'会传递到最终响应中，
     * 构成响应的'code'和'msg'部分
     *
     * @author shiweihua
     * @date 2018/10/19
     */
    const BUSINESS_STATUS_HEADER = 'business-status-1aB2BrGs2wXWfMBMt0VdHnmo4tDQBCA0YSEiL4M';
    const CACHE_KEY_AND_TIME_HEADER = 'cache-key-time-1aB2BrGs2wXWfMBMt0VdHnmo4tDQBCA0YSEiL4M';

    use Helpers;
}
