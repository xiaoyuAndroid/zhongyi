<?php

namespace app\api\model;

use think\Model;

class BannerItem extends Model
{
    //
    public function imageUrl()
    {
        return $this->belongsTo('Image','img_id','id');
    }
    
}
