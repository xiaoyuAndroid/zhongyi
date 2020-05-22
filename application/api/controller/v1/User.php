<?php
/**
 * Created by PhpStorm.
 * User: yumeng
 * Date: 2020/5/22
 * Time: 16:31
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;


class User extends BaseController
{
    public function wx_info()
    {
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException([
                'code' => 404,
                'msg' => '用户收获地址不存在',
                'errorCode' => 60001
            ]);
        }
        $nickname=input('post.nickname');
        $data['nickname'] = $nickname;
        $user->save($data);
        return json( new SuccessMessage(),200);
    }
}