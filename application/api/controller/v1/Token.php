<?php

namespace app\api\controller\v1;

use app\api\service\UserToken;
use app\api\service\Token as TokenService;
use app\api\validate\TokenGet;

use app\lib\exception\TokenException;
use think\Cache;
use think\Controller;
use think\Request;

class Token extends Controller
{
    
    public function getToken($code = '')
    {
        (new TokenGet())->goCheck();
        $wx = new UserToken($code);
        //$a = Cache::get('d3de4857d79a53685d6121aa21ef049f');
        $token   = $wx->get();
        
        return json(['token' => $token]);
    }
    
    
    // 校验Token
    public function verifyToken($token = '')
    {
        if ( !$token ) {
            throw new ParameterException(['token不允许为空']);
        }
        $valid   = TokenService::verifyToken($token);
       
        
        return json(['isValid' => $valid]);
    }
    
    // 获取userInfo
    public function userInfo()
    {
        $user_id = TokenService::getCurrentUid();
        
        return json(['user_id' => $user_id]);
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
