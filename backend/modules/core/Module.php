<?php
namespace backend\modules\core;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\core\controllers';
    public $defaultRoute = 'index';
    public $menuOrder = 1;

    public function init()
    {
        return parent::init();
    }

    public function getMenuItems()
    {
        return [
            [
                'label' => 'Home',
                'url'   => '/core/index/index',
            ],
            [
                'label' => 'Site',
                'items' => [
                    [
                        'label' => 'Text blocks',
                        'url'   => '/core/text-block/index',
                    ],
                    [
                        'label' => 'Pages',
                        'url'   => '/core/page/index',
                    ],
                    [
                        'label' => 'Social links',
                        'url'   => '/core/social-links/index',
                    ],
                    [
                        'label' => 'Type menu',
                        'url'   => '/core/type-menu/index',
                    ],
                ],
            ]
        ];
    }

    public function getFrontendRoutes()
    {
        return [
            'controllers' => [
                'index' => [
                    'name' => 'Index',
                    'actions' => [
                       /* 'index' => [
                            'name' => 'Вывод главной страницы',
                        ],*/
                        'pages' => [
                            'name' => 'Вывод простой страницы'
                        ],
                    ]
                ],
            ]
        ];
    }

}