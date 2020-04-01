<?php
/**
 * Author: yumeng
 * CreateTime: 2020/3/29 16:52
 * Description:
 */


namespace app\api\validate;


class IsValidUserToken extends BaseValidate
{
    protected $rule = [
        'token' => 'isValidUserToken'
    ];
}