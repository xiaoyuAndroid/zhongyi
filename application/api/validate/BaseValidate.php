<?php
/**
 * Author: yumeng
 * CreateTime: 2020/3/29 16:52
 * Description:
 */

namespace app\api\validate;


use think\Request;
use think\Validate;
use app\lib\exception\ParameterException;

/**
 * Class BaseValidate
 * 验证类的基类
 */

class BaseValidate extends Validate
{
    /**
     * 检测所有客户端发来的参数是否符合验证类规则
     * 基类定义了很多自定义验证方法
     * 这些自定义验证方法其实，也可以直接调用
     * @throws ParameterException
     * @return true
     */
    
    public function goCheck()
    {
        //必须设置content-type:application/json
        $request = Request::instance();
        $params = $request->param();
        //$params['token'] = $request->header('token');
        
        if (!$this->batch()->check($params)) {
            $exception = new ParameterException(
                [
                    // $this->error有一个问题，并不是一定返回数组，需要判断
                    'msg' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]
            );
            throw $exception;
        }
        return true;
    }
    
    protected function isPositiveInteger($value, $rule='', $data='', $field='')
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        return $field . '必须是正整数';
    }
}