<?php
namespace frontend\modules\news\widgets\SliderWidget;

use Yii;
use yii\base\Widget;

class SliderWidget extends Widget
{

    public $model;

    private $_cacheTimeImages = 3600;

    public function run()
    {
        if (!$this->model->gelery_id) {
            return FALSE;
        }

        $key = 'NewGallery' . $this->model->id;
        $cache = Yii::$app->cache;
        $gallery = $this->model->gallery;

        //$cache->flush();

        $images = $cache->get($key);

        if (!$images) {
            $images = $gallery->galleryImages;

            $cache->set($key, $images, $this->_cacheTimeImages);
        }

        return $this->render('index', [
            'images'  => $images,
            'basePath' => $gallery->getUploadPath(),
        ]);
    }

}