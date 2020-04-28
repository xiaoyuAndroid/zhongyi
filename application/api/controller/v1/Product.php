<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/4/5 12:46
 * Description:
 */

namespace app\api\controller\v1;

use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\enum\ProductStatus;
use app\lib\exception\ProductException;
use app\api\service\Token as TokenService;

class Product
{
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        //$user_id = TokenService::getCurrentUid();
        $products = ProductModel::getMostRecent($count, 0, ProductStatus::shangjia);
        if ( !$products ) {
            throw new ProductException();
        }
        
        return json($products);
    }
    
    public function getProductByUser($user_id)
    {
        //$user_id = TokenService::getCurrentUid();
        $products = ProductModel::getAllByUser($user_id,ProductStatus::cangku);
        if ( !$products ) {
            throw new ProductException();
        }
        
        return json($products);
    }
    
    public function getCategoryById($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        //$user_id = TokenService::getCurrentUid();
        $products = ProductModel::getAllByCategory($id, 0, ProductStatus::shangjia);
        if ( !$products ) {
            throw new ProductException();
        }
        
        return json($products);
    }
    
    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if ( !$product ) {
            throw new ProductException();
        }
        
        return json($product);
    }
    
}