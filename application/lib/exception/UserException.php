<?php
/**
 * Created by PhpStorm.
 * User: yumeng
 * Date: 2020/3/31
 * Time: 16:29
 */


namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 404;
    public $msg = '用户不存在';
    public $errorCode = 60000;
}