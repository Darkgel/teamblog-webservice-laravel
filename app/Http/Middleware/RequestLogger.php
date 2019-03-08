<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2019/2/26
 * Time: 10:47
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequestLogger
{
    public function handle(Request $request, Closure $next) {
        /** @var \Dingo\Api\Http\Response $response */
        $response = $next($request);

        $requestInput = $request->all();
        $requestMethod = $request->method();
        $requestPath = $request->path();
        $requestClientIp = $request->getClientIp();

        $responseHeaders = $response->headers->all();
        $responseHttpStatus = $response->status();

        \Log::channel('request')->info('请求&响应信息', [
            'request' => [
                'requestMethod' => $requestMethod,
                'requestPath' => $requestPath,
                'requestInput' => $requestInput,
                'requestClientIp' => $requestClientIp,
            ],
            'response' => [
                'responseHttpStatus' => $responseHttpStatus,
                'responseHeaders' => $responseHeaders,
            ],
        ]);

        return $response;
    }
}
