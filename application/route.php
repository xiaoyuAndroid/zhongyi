<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];

use think\Route;

//Route::rule('banner/:id','api/v1.Banner/getBanner');
Route::rule('api/:version/banner/:id','api/:version.Banner/getBanner');

Route::rule('api/:version/theme','api/:version.Theme/getSimpleThemeList');
Route::rule('api/:version/theme/:id','api/:version.Theme/getComplexOne');
//
//Route::rule('api/:version/product/by_category','api/:version.Product/getCategoryById');
//Route::get('api/:version/product/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
//Route::rule('api/:version/product/recent','api/:version.Product/getRecent');

Route::group('api/:version/product',function(){
    Route::rule('/by_category','api/:version.Product/getCategoryById');
    Route::get('/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
    Route::rule('/recent','api/:version.Product/getRecent');
    Route::rule('/user_id/:user_id','api/:version.Product/getProductByUser');
    Route::rule('/modify/:product_id','api/:version.Product/modifyProduct');
    Route::rule('/user/:user_id','api/:version.Product/getAllProductByUser');

    
});
Route::rule('api/:version/category/all','api/:version.Category/getAllCategories');

// Token
Route::post('api/:version/token/user','api/:version.Token/getToken');
Route::post('api/:version/token/verify','api/:version.Token/verifyToken');
Route::rule('api/:version/token/userinfo','api/:version.Token/userInfo');

//Address
Route::post('api/:version/address', 'api/:version.Address/createOrUpdateAddress');
Route::get('api/:version/getaddress', 'api/:version.Address/getUserAddress');

//Order
Route::post('api/:version/order', 'api/:version.Order/placeOrder');
Route::get('api/:version/order/:id', 'api/:version.Order/getDetail',[], ['id'=>'\d+']);

Route::post('api/:version/product/add','api/:version.Product/addProduct');