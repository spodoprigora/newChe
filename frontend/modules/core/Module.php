<?php
namespace frontend\modules\core;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'frontend\modules\core\controllers';
    public $defaultRoute = 'index';

    public function init()
    {
        return parent::init();
    }

}