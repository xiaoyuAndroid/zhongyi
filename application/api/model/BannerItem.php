<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    //
    public function img()
    {
        return $this->belongsTo('Image','img_id','id');
    }
    
}
