<?php
/**
 * @url
 * @http
 * User: yumeng
 * CreateTime: 2020/3/26 20:48
 * Description:
 */

namespace app\api\controller\v1;
use app\api\validate\IDMustBePositiveInt;
use think\exception\HttpException;

class Banner
{
    /**
     * @return string
     *
     * Description:
     * Author: yumeng
     * CreateTime: 2020/3/26 21:13
     */
    
    public function getBanner()
    {
       $validate = new IDMustBePositiveInt();
       $validate->goCheck();
       //return 'xxx';
        throw new HttpException(203, '页面不存在');
    }
}