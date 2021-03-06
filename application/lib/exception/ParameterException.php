<?php
/**
 * Created by PhpStorm.
 * User: yumeng
 * Date: 2020/3/31
 * Time: 16:29
 */


namespace app\lib\exception;

/**
 * Class ParameterException
 * 通用参数类异常错误
 */
class ParameterException extends BaseException
{
    public $code = 400;
    public $errorCode = 10000;
    public $msg = "invalid parameters";
}