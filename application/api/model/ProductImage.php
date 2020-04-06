<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/4/6 18:02
 * Description:
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];
    
    public function imgUrl()
    {
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}