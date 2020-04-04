<?php

namespace app\api\model;

use think\Model;

class Image extends BaseModel
{
    //$value就是Image这个表的Url字段，$data是一条记录的完整字段
    public function getUrlAttr($value, $data)
    {
        return $this->prefixImgUrl($value,$data);
    }
    //
}
