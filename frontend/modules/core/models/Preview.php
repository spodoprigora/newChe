<?php

namespace frontend\modules\core\models;

use yii;
use common\models\galery\Preview as BasePreview;



class Preview extends BasePreview
{

    public function getSmallUrl(){
        $temp_array =unserialize($this->url);
        if($temp_array['small'] !='')
            return '/img/news/preview/thumbs/'.$temp_array['small'];
        return '';
    }
    
    public function getBigUrl(){
        $temp_array =unserialize($this->url);
        if($temp_array['big'] !='')
            return '/img/news/preview/'.$temp_array['big'];
        return '';
    }
}