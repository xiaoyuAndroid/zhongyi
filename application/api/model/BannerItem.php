<?php

namespace app\api\model;

use think\Model;

class BannerItem extends BaseModel
{
    //
    public function imageUrl()
    {
        return $this->belongsTo('Image','img_id','id');
    }
    
}
