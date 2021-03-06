<?php

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;
use think\Controller;
use think\Request;
use app\api\model\Theme as ThemeModel;

class Theme extends Controller
{
    public function getSimpleThemeList($ids = '')
    {
        (new IDCollection())->goCheck();
        $theme = ThemeModel::with('topicImg,headImg')->select();
        
        if ( !$theme ) {
            throw new ThemeException();
        }
        
        return json($theme);
        //return $theme;
        
    }
    
    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        
        $theme = ThemeModel::getThemeWithProducts($id);
        if ( !$theme ) {
            throw new ThemeException();
        }
        return $theme;
    }
    
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }
    
    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }
    
    /**
     * 保存新建的资源
     *
     * @param  \think\Request $request
     *
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }
    
    /**
     * 显示指定的资源
     *
     * @param  int $id
     *
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }
    
    /**
     * 显示编辑资源表单页.
     *
     * @param  int $id
     *
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }
    
    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int            $id
     *
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    
    /**
     * 删除指定资源
     *
     * @param  int $id
     *
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
