<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
        'css/libs.min.css',
        'css/style.css',

    ];
    public $js = [
        'js/libs.min.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
      //  'yii\bootstrap\BootstrapAsset',
    ];
   
    public function registerAssetFiles($view)
    {
        parent::registerAssetFiles($view);

        $manager = $view->getAssetManager();
        $view->registerJsFile($manager->getAssetUrl($this, 'https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'), ['condition' => 'lte IE9', 'position'=>\yii\web\View::POS_HEAD]);
        $view->registerJsFile($manager->getAssetUrl($this, 'https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'), ['condition' => 'lte IE9', 'position'=>\yii\web\View::POS_HEAD]);
    }
}
