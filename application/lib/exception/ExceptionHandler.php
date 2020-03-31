<?php
/**
 * Created by PhpStorm.
 * User: yumeng
 * Date: 2020/3/31
 * Time: 16:51
 */

namespace app\lib\exception;

use think\exception\Handle;
use think\Log;
use think\Request;
use Exception;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    
    public function render(Exception $e)
    {
        if ( $e instanceof BaseException ) {
            $this->code      = $e->code;
            $this->errorCode = $e->errorCode;
            $this->msg       = $e->msg;
            
        } else {
            
            if ( config('app_debug') ) {
                parent::render($e);
            }
            
            $this->code      = 500;
            $this->msg       = 'sorry, we make a mistake.';
            $this->errorCode = 999;
            
        }
        
        $request = Request::instance();
        $result  = ['msg' => $this->msg, 'request_url' => $request->url(true), 'errorCode' => $this->errorCode];
        
        return json($result, $this->code);
        
        
    }
    
    private function recordErrorLog(Exception $e)
    {
        Log::init(['type' => 'File', 'path' => LOG_PATH, 'level' => ['error']]);
        Log::record($e->getMessage(), 'error');
    }
}