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
        $orderInfo = $orderInfo['0'];
        $chooseInfo = input('post.chooseInfo/a');
        $chooseProduct = implode(',',$chooseInfo);
        $uid = Token::getCurrentUid();
        //
        $product = ProductModel::getProductDetail2($orderInfo);
        $product->status = ProductStatus::huanzou;
        $product->origin_user=$uid;
        
        $product->save();
        
    
        $firstPorduct = ProductModel::create(
            [
                'name'         => $product->name,
                'category_id'  => $product->category_id,
                'main_img_url' => strstr($product->main_img_url,'/pro'),
                'from'         => $product->from,
                'img_id'       => $product->img_id,
                'status'       => ProductStatus::cangku,
         'origin' => $product->user_id,
         'user_id' => $product->user_id,
         'origin_user' => 0
            ]);
        return '5';
        
        $order->user_id = $this->uid;
        $order->order_no = $orderNo;
        $order->total_price = $snap['orderPrice'];
        $order->total_count = $snap['totalCount'];
        $order->snap_img = $snap['snapImg'];
        $order->snap_name = $snap['snapName'];
        $order->snap_address = $snap['snapAddress'];
        $order->snap_items = json_encode($snap['pStatus']);
        $order->save();
        
        $a = $chooseInfo;
        //$uid = Token::getCurrentUid();
        //$order = new OrderService();
        //$status = $order->place($uid, $products);
        //return $status;
    }
    
}