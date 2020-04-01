<?php
/**
 * Author: yumeng
 * CreateTime: 2020/3/29 16:52
 * Description:
 */

namespace app\api\validate;

class ThemeProduct extends BaseValidate
{
    protected $rule = ['t_id' => 'number', 'p_id' => 'number'];
}
