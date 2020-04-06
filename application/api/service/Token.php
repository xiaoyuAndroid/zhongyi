<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/4/6 16:27
 * Description:
 */

namespace app\api\service;


class Token
{
    public static function generateToken()
    {
        $randChar  = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('secure.token_salt');
        
        return md5($randChar . $timestamp . $tokenSalt);
    }
}