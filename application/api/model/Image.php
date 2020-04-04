<?php

namespace app\api\model;

use think\Model;

class Image extends Model
{
    //$value就是Image这个表的Url字段，$data是一条记录的完整字段
    public function getUrlAttr($value, $data)
    {
        $finalUrl = $value;
        if ( $data['from'] == 1 ) {
            $finalUrl = config('setting.img_url') . $value;
        }
        
        return $finalUrl;
    }
    //
}
