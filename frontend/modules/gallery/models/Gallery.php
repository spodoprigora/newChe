<?php

namespace frontend\modules\gallery\models;

use common\models\galery\Gallery as BaseGallery;
use Yii;

class Gallery extends BaseGallery
{

    private $_uploadPath = 'img/gallery';
    private $_mediumDir = '/medium';
    private $_miniDir = '/mini';

    public function getUploadPath()
    {
        return $this->_uploadPath;
    }

}