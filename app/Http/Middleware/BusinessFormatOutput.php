<?php
/**
 * 标记请求需要被格式化处理，最终响应的格式为
 * [
 *      'code' => 10000,//业务逻辑处理结果码
 *      'msg' => '业务执行成功',//相应的提示信息
 *      'content' => [
 *            ....具体的返回
 *      ]
 * ]
 *
 * 具体处理响应的地方：app\Listeners\AddBusinessStatusToResponse.php
 *
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 17:08
 */

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class BusinessFormatOutput
{
    public function handle(Request $request, \Closure $next){
        config(['app.businessFormatOutputConfig1aB2BrGs2wXWfMBMt0VdHnmo4tDQBCA0YSEiL4M' => true]);

        return $next($request);
    }
}
