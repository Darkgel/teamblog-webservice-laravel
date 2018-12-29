<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:22
 */

namespace App\Listeners;

use Dingo\Api\Event\ResponseWasMorphed;
use App\Http\Controllers\ApiController;
use Enum\Time;
use Illuminate\Support\Facades\Cache;
use Enum\ErrorCode;

class AddBusinessStatusToResponse
{
    /**
     * Handle the event.
     * 将最后返回的响应封装一层，原本的数据被放到content中, 添加业务逻辑处理结果（code和msg）
     * 并且在需要的情况下缓存响应
     *
     * @author shiweihua
     * @date 2018/10/17
     * @param  ResponseWasMorphed $event
     * @return void
     */
    public function handle(ResponseWasMorphed $event)
    {
        $businessFormatOutput = config('app.businessFormatOutputConfig1aB2BrGs2wXWfMBMt0VdHnmo4tDQBCA0YSEiL4M', false);
        if (true === $businessFormatOutput) {
            $response = $event->response;
            $httpCode = $response->getStatusCode();
            $content = $event->content;
            if ($httpCode >= 200 && $httpCode < 300 && (is_array($content) || is_string($content))) {//只处理成功类的响应
                $headers = $response->headers;
                $businessStatus = $headers->get(ApiController::BUSINESS_STATUS_HEADER, null, false);
                $cacheKeyAndTimeHeader = $headers->get(ApiController::CACHE_KEY_AND_TIME_HEADER, null, false);
                $headers->remove(ApiController::BUSINESS_STATUS_HEADER);
                $headers->remove(ApiController::CACHE_KEY_AND_TIME_HEADER);
                $code = $businessStatus[0] ?? ErrorCode::SUCCESS;
                $msg = $businessStatus[1] ?? ErrorCode::$statusTexts[$code];
                $setCacheKey = $cacheKeyAndTimeHeader[0] ?? null;
                $setCacheTime = $cacheKeyAndTimeHeader[1] ?? Time::MINUTE_HALF_HOUR;
                if (isset($setCacheKey) && !empty($setCacheKey)) {//缓存响应
                    Cache::put($setCacheKey, $content, $setCacheTime);
                }
                $responseContent = ['code' => $code, 'msg' => $msg, 'content' => $content,];
                $response->setContent($responseContent);
            }
        }
    }
}
