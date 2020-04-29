<?php
/**
 * @url
 * @http
 * Author: yumeng
 * CreateTime: 2020/4/5 12:46
 * Description:
 */

namespace app\api\controller\v1;

use app\api\model\Image;
use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\enum\ProductStatus;
use app\lib\exception\ProductException;
use app\api\service\Token as TokenService;
use think\Request;

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
    public function getAllProductByUser($user_id)
    {
        //$user_id = TokenService::getCurrentUid();
        $products = ProductModel::getAllByUser($user_id,0,true);
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
    
    public function addProduct()
    {
        $uploadData = input('post.');
        $file = $_FILES['image'];
        $imageName = $file['name'];
        $imageTName = $file['tmp_name'];
        $folder = ROOT_PATH . 'public/uploads';
        $success = move_uploaded_file($imageTName,"$folder/$imageName");
        $oldimage = $folder.'/'.$imageName;
        $newimage = '/product-'.$uploadData['radioSelected'].'@'.mt_rand(0, 100000).'.png';
        $newimageurl = ROOT_PATH . 'public/images'.$newimage;
        $a = copy($oldimage,$newimageurl);
    
        $imageId = Image::create(
            [
                'url'       => $newimage,
                'from'         => 1,
            ]);
        
        $firstPorduct = ProductModel::create(
            [
                'name'         => $uploadData['productName'],
                'category_id'  => $uploadData['radioSelected'],
                'main_img_url' => $newimage,
                'from'         => 1,
                'img_id'       => $imageId->id,
                'status'       => ProductStatus::cangku,
                'origin'       => 2,
                'user_id'      => $uploadData['user_id'],
                'origin_user'  => 0
            ]);
        $status = true;
        return json($status);
    }
    
    public function modifyProduct(){
        $put = input('get.');
        $product_id = $put['id'];
        $type = $put['type'];
        
        $product = ProductModel::getProductDetail2($product_id);
        
        if($type=='shangjia'){
            $product->status=2;
            $product->save();
        }
        if($type=='xiajia'){
            $product->status=1;
            $product->save();
        }
        
        $success = true;
        return json($success);
        
    }
    
}