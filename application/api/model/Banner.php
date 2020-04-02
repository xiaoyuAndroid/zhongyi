<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/3/30 19:51
 * Description:
 */

namespace app\api\model;


use think\Db;
use think\Exception;
use think\Model;

class Banner extends Model
{
    public static function getBannerByID($id)
    {
        //$result = Db::query('select * from banner_item where banner_id = ?',[$id]);
        $result = Db::table('banner_item')
            ->where('banner_id','=',$id)
            //->fetchSql()
            ->select();
        return $result;
    }
}

