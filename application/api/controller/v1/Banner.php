<?php
/**
 * @url
 * @http
 * User: yumeng
 * CreateTime: 2020/3/26 20:48
 * Description:
 */

namespace app\api\controller\v1;

use app\api\validate\AddressNew;
use app\api\validate\IDMustBePositiveInt;
use think\Exception;
use think\exception\HttpException;
use app\api\model\Banner as BannerModel;
use app\lib\exception\MissException;

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
       
        $banner = BannerModel::with(['items','items.img'])->find($id);
        //$banner = BannerModel::get($id);
        //$banner->hidden(['description','banner_id']);
        //$img_url = config('setting.img_url');
        return json($banner);
        
        //$banner = BannerModel::getBannerByID($id);//Db类查询器
        //if(!$banner){
        //    //throw new MissException();
        //    throw new MissException();
        //}
        //return json($banner);
    }
}