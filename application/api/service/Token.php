<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/4/6 16:27
 * Description:
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken()
    {
        $randChar  = getRandChar(32);
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('secure.token_salt');
        
        return md5($randChar . $timestamp . $tokenSalt);
    }
    
    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()
            ->header('token');
        $vars  = Cache::get($token);
        if ( !$vars ) {
            throw new TokenException();
        } else {
            if ( !is_array($vars) ) {
                $vars = json_decode($vars, TRUE);
            }
            if ( array_key_exists($key, $vars) ) {
                return $vars[ $key ];
            } else {
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }
    
    /**
     * 当需要获取全局UID时，应当调用此方法
     *而不应当自己解析UID
     *
     */
    public static function getCurrentUid()
    {
        $uid = self::getCurrentTokenVar('uid');
        //$scope = self::getCurrentTokenVar('scope');
        //if ($scope == ScopeEnum::Super)
        //{
            // 只有Super权限才可以自己传入uid
            // 且必须在get参数中，post不接受任何uid字段
            //$userID = input('get.uid');
            //if (!$userID)
            //{
            //    throw new ParameterException(
            //        [
            //            'msg' => '没有指定需要操作的用户对象'
            //        ]);
            //}
            //return $userID;
        //}
        //else
        //{
            return $uid;
        //}
    }
}