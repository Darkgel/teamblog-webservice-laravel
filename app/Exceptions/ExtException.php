<?php
/**
 * Created by PhpStorm.
 * User: Darkgel
 * Date: 2018/12/29
 * Time: 16:03
 */

namespace App\Exceptions;

use Exception;

class ExtException extends Exception
{
    protected $extra;

    /**
     * @param int $code 错误码
     * @param string $msg 错误信息
     * @param array $extra 可用于传递多余的信息
     * @param bool $isAlarm 调用预警为true，否则为false
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     */
    function __construct($code, $msg = '', $extra = [], $isAlarm = false, Exception $previous = null)
    {
        $this->extra = $extra;
        parent::__construct($msg, $code, $previous);
        if($isAlarm){
            // TODO  预警操作
        }
    }

    public function getExtra(){
        return $this->extra;
    }
}
