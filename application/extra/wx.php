<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/4/6 16:28
 * Description:
 */

return [
    //  +---------------------------------
    //  微信相关配置
    //  +---------------------------------
    
    // 小程序app_id
    'app_id' => 'wx4a1b6af8f2de497d',
    // 小程序app_secret
    'app_secret' => 'd5eec08092734735afacb0a10a55b9ed',
    
    // 微信使用code换取用户openid及session_key的url地址
    'login_url' => "https://api.weixin.qq.com/sns/jscode2session?" .
        "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
   
    // 微信获取access_token的url地址
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?" .
        "grant_type=client_credential&appid=%s&secret=%s",


];