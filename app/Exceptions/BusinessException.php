<?php
/**
 * 当出现业务逻辑无法正常执行的情况下，需要抛出该业务异常（BusinessException）
 * BusinessException的code必须提供，并且存在于\Enum\ErrorCode中
 *
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:02
 */

namespace App\Exceptions;

use Exception;
use Enum\ErrorCode;

class BusinessException extends ExtException
{
    /**
     * @param int $code 业务级错误码（参考app\Common\Enum\ErrorCode.php）
     * @param string $message 错误信息，如不传入值或传入空字符串，则会使用app\Common\Enum\ErrorCode.php中对应的错误信息
     * @param array $extra 可用于传递多余的信息
     * @param bool $isAlarm 调用预警为true，否则为false
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct($code, $message = "", $extra = [], $isAlarm = false, Exception $previous = null)
    {
        $message = ($message === "") ? ErrorCode::$statusTexts[$code] : $message;
        parent::__construct($code, $message, $extra, $isAlarm, $previous);
    }
}
