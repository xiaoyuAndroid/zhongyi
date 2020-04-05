<?php

namespace app\api\model;

use think\Model;

class Product extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'pivot', 'from', 'create_time'];
    
    //
    
    protected function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
    
    public static function getMostRecent($count)
    {
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        
        return $products;
    }
    
    public static function getAllByCategory($category_id)
    {
        $products = self::where('category_id', '=', $category_id)->select();
        
        return $products;
    }
}
