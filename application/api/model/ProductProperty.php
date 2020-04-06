<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/4/6 18:02
 * Description:
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden = ['product_id', 'delete_time', 'id'];
}