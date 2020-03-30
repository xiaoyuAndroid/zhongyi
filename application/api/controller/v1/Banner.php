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
use think\Exception;
use think\exception\HttpException;
use app\api\model\Banner as BannerModel;

class Banner
{
    /**
     * @return string
     *
     * Description:
     * Author: yumeng
     * CreateTime: 2020/3/26 21:13
     */
    
    public function getBanner($id)
    {
        $validate = new IDMustBePositiveInt();
        $validate->goCheck();
        try {
            $banner = BannerModel::getBannerByID($id);
        } catch (Exception $ex) {
            $err = [
                'err_code' => 1000,
                'err_msg'  => $ex->getMessage(),
            ];
            
            return json($err, 404);
            
        }
        
        
        return $banner;
        //return 'xxx';
        // throw new HttpException(203, '页面不存在');
    }
}