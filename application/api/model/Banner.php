<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/3/30 19:51
 * Description:
 */

namespace app\api\model;


use think\Exception;

class Banner
{
    public static function getBannerByID($id)
    {
        try {
            1/0;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
        return 'this is banner info';
    }
}