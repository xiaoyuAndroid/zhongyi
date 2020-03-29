<?php
/**
 * Author: yumeng
 * CreateTime: 2020/3/29 16:55
 * Description:
 */

namespace app\api\validate;


class IDMustBePositiveInt extends BaseValidate
{
    protected $rules = [
        'id' => 'require|isPositiveInteger',
    ];
}