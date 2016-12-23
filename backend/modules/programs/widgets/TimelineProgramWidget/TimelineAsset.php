<?php
namespace backend\modules\programs\widgets\TimelineProgramWidget;

use yii\web\AssetBundle;

class TimelineAsset extends AssetBundle
{

    public $js = [
        'js/timeline.js',
    ];

    public $css = [
        'css/timeline.css',
    ];

    public $depends = [
        // we will use jQuery
        'yii\web\JqueryAsset'
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public function init()
    {   
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }

}