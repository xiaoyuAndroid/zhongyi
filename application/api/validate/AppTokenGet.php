<?php
/**
 * Author: yumeng
 * CreateTime: 2020/3/29 16:52
 * Description:
 */

namespace app\api\validate;

class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'ac' => 'require|isNotEmpty',
        'se' => 'require|isNotEmpty'
    ];
}
