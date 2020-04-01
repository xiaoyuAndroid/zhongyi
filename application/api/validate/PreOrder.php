<?php
/**
 * Author: yumeng
 * CreateTime: 2020/3/29 16:52
 * Description:
 */


namespace app\api\validate;


class PreOrder extends BaseValidate
{
    protected $rule = [
        'order_no' => 'require|length:16'
    ];
}