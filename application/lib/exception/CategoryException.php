<?php
/**
 * Created by PhpStorm.
 * User: yumeng
 * Date: 2020/3/31
 * Time: 16:29
 */


namespace app\lib\exception;


class CategoryException extends BaseException
{
    public $code = 404;
    public $msg = '指定类目不存在，请检查商品ID';
    public $errorCode = 20000;
}