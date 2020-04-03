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
    public function items(){
        return $this->hasMany('banner_item','banner_id','id');
    }
    
    public function categorys(){
        return $this->hasOne('category','topic_img_id','id')->field('id,name,topic_img_id');
    }
    public static function getBannerByID($id)
    {
        
        //$result = Db::query('select * from banner_item where banner_id = ?',[$id]); //原生SQL查询
        
        $result = Db::table('banner_item')        // Db类查询器
            ->where('banner_id','=',$id)
            //->fetchSql()
            ->select();
        
        
        return $result;
    }
}

