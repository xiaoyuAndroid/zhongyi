<?php

namespace app\api\model;

use app\lib\enum\ProductStatus;
use think\Model;

class Product extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'pivot', 'from', 'create_time'];
    
    //
    
    /**
     * 图片属性
     */
    public function imgs()
    {
        return $this->hasMany('ProductImage', 'product_id', 'id');
    }
    
    protected function getMainImgUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value, $data);
    }
    
    public function properties()
    {
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }
    
    public static function getMostRecent($count, $user_id = 0, $status)
    {
        $whereArr['user_id']     = ['neq', $user_id]; // 不等于条件
        $whereArr['status']      = $status; // 等于条件
        //$products            = self::limit($count)->where($whereArr)->order('create_time desc')->fetchSql();
        $products = self::limit($count)->where($whereArr)->order('create_time desc')->select();
        
        return $products;
    }
    
    public static function getAllByCategory($category_id, $user_id = 0, $status)
    {
        $whereArr['user_id']     = ['neq', $user_id]; // 不等于条件
        $whereArr['status']      = $status; // 等于条件
        $whereArr['category_id'] = ['eq', $category_id]; // 等于条件
        $products                = self::where($whereArr)->select();
        
        return $products;
    }
    
    /**
     * 获取商品详情
     *
     * @param $id
     *
     * @return null | Product
     */
    public static function getProductDetail($id)
    {
        $product = self::with('imgs,properties,imgs.imgUrl')->find($id);
        
        return $product;
    }
    
}
