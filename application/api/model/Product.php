<?php

namespace app\api\model;

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
    
    /**
     * 获取商品详情
     *
     * @param $id
     *
     * @return null | Product
     */
    public static function getProductDetail($id)
    {
        $product = self::with('imgs,properties,imgs.imgUrl')
            ->find($id);
        
        return $product;
    }
    
}
