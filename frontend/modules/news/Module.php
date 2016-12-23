<?php
namespace frontend\modules\news;

class Module extends \yii\base\Module
{

    public $controllerNamespace = 'frontend\modules\news\controllers';
    public $defaultRoute = 'index';

    public function init()
    {
        return parent::init();
    }

}