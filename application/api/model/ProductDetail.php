<?php
/**
 * Created by PhpStorm.
 * User: yumeng
 * Date: 2020/5/22
 * Time: 17:16
 */

namespace app\api\model;


class ProductDetail extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'product_id', 'id'];
}
