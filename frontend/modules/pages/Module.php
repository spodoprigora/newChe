<?php
namespace frontend\modules\pages;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'frontend\modules\pages\controllers';
    public $defaultRoute = 'index';

    public function init()
    {
        return parent::init();
    }

}