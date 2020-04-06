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
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count = 15)
    {
        (new Count())->goCheck();
        $products = ProductModel::getMostRecent($count);
        if(!$products){
            throw new ProductException();
        }
        return json($products);
    }
    
    public function getCategoryById($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $products = ProductModel::getAllByCategory($id);
        if(!$products){
            throw new ProductException();
        }
        return json($products);
    }
    
    public function getOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $product = ProductModel::getProductDetail($id);
        if(!$product){
            throw new ProductException();
        }
        return json($product);
    }
    
}