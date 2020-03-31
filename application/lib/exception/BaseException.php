<?php
/**
 * Created by PhpStorm.
 * User: yumeng
 * Date: 2020/3/31
 * Time: 16:34
 */

namespace app\lib\exception;


/*
 * Class BaseException
 * 自定义异常类的基类
 * */
use think\Exception;

class BaseException extends Exception
{
    public $code      = 400;
    public $msg       = 'invalid parameters';
    public $errorCode = 999;
    
    public $shouldToClient = TRUE;
    
    /*
     * 构造函数，接收一个关联数组
     * @param array $params关联数组只应包含code、msg和errorCode，且不应该是空值
     *
     * */
    public function __construct($params = [])
    {
        if ( !is_array($params) ) {
            return;
        }
        if ( array_key_exists('code', $params) ) {
            $this->code = $params['code'];
        }
        if ( array_key_exists('msg', $params) ) {
            $this->msg = $params['msg'];
        }
        if ( array_key_exists('errorCode', $params) ) {
            $this->errorCode = $params['errorCode'];
        }
        
    }
}