<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/4/13 20:10
 * Description:
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\Token;
use app\api\model\Product as ProductModel;
use app\lib\enum\ProductStatus;
use app\lib\exception\OrderException;


class Order extends BaseController
{
    //protected $beforeActionList = [
    //    'checkExclusiveScope' => ['only' => 'placeOrder'],
    //    'checkPrimaryScope' => ['only' => 'getDetail,getSummaryByUser'],
    //    'checkSuperScope' => ['only' => 'delivery,getSummary']
    //];
    
    /**
     * 下单
     * @url /order
     * @HTTP POST
     */
    public function placeOrder()
    {
        //(new OrderPlace())->goCheck();
        $orderInfo = input('post.orderInfo/a');
        $chooseInfo = input('post.chooseInfo/a');
        $chooseProduct = implode(',',$chooseInfo);
        $to_user = Token::getCurrentUid();
    
        $product = ProductModel::getProductDetail2($orderInfo['0']);
        if($product->status==3 || $product->status==99){
           throw new OrderException([
                   'msg' => '要交换的商品状态异常',
                   'errorCode' => 60001,
               'code'=>301,
           ]);
        }
        $origin_user = $product->user_id;
        
        $first = $this->exchange($to_user,$product);
        
        foreach ($chooseInfo as $key=>$value){
            $product = ProductModel::getProductDetail2($value);
            $second = $this->exchange($origin_user,$product);
        }
        
        $status['pass'] = true;
        return json($status);
        
    }
    
    public function exchange($to_user,$product){
        $product->status = ProductStatus::huanzou;
        $product->origin_user=$to_user;
        $product->save();
    
        $firstPorduct = ProductModel::create(
            [
                'name'         => $product->name,
                'category_id'  => $product->category_id,
                'main_img_url' => strstr($product->main_img_url,'/pro'),
                'from'         => $product->from,
                'img_id'       => $product->img_id,
                'status'       => ProductStatus::cangku,
                'origin'       => 2,
                'user_id'      => $to_user,
                'origin_user'  => 0
            ]);
        
        return $firstPorduct;
        
    }
    
}