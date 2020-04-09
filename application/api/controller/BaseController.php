<?php
/**
 * Created by PhpStorm.
 * User: yumeng
 * Date: 2020/4/9
 * Time: 9:21
 */

namespace app\api\controller;


use app\api\service\Token;
use think\Controller;

class BaseController extends Controller
{
    protected function checkExclusiveScope()
    {
        Token::needExclusiveScope();
    }
    
    
    protected function checkPrimaryScope()
    {
        Token::needPrimaryScope();
    }
    
    protected function checkSuperScope()
    {
        Token::needSuperScope();
    }
    
}