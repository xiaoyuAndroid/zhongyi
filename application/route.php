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

Route::rule('api/:version/product/recent','api/:version.Product/getRecent');
Route::rule('api/:version/product/by_category','api/:version.Product/getCategoryById');

Route::rule('api/:version/category','api/:version.Category/getAllCategories');

Route::post('api/:version/token/user','api/:version.Token/getToken');
