<?php
/**
 * Author: yumeng
 * CreateTime: 2020/3/29 16:52
 * Description:
 */

namespace app\api\validate;

class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15',
    ];
}
