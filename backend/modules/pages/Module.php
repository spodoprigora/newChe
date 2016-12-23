<?php
namespace backend\modules\pages;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\pages\controllers';
    public $defaultRoute = 'index';
    public $menuOrder = 1;

    public function init()
    {
        return parent::init();
    }

    /*public function getFrontendRoutes()
    {
        return [
            'controllers' => [
                'index' => [
                    'name' => 'Index',
                    'actions' => [
                        'fakt' => [
                            'name' => 'Вывод страницы фактов',
                        ],
                        'anons' => [
                            'name' => 'Вывод страницы анонсов',
                        ],
                        'efir' => [
                            'name' => 'Вывод страницы эфира',
                        ],
                        'arhiv' => [
                            'name' => 'Вывод страницы архива',
                        ],
                    ]
                ],
            ]
        ];
    }*/

}