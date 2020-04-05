<?php

namespace app\api\model;

use think\Model;

class Theme extends BaseModel
{
    
    protected $hidden = ['delete_time', 'update_time'];
    
    public function topImg()
    {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
    
    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }
    
    public function products()
    {
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }
    
    public static function getThemeWithProducts($id)
    {
        $theme = self::with('products,topImg,headImg')->find($id);
        
        return $theme;
    }
    
}
