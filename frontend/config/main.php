<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'core' => [
            'class' => 'frontend\modules\core\Module',
        ],
        'pages' => [
            'class' => 'frontend\modules\pages\Module',
        ],
        'news' => [
            'class' => 'frontend\modules\news\Module',
        ]
    ],
    'components' => [
        'request' => [
            'class' => 'frontend\modules\core\components\FrontRequest',
            'csrfParam' => '_csrf-frontend',
			'baseUrl' => ''
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'core/index/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                 ''                                 => 'core/index/index',
                'rss'                               => 'news/news/rss',
                'rss/<lang:(ua|ru)+>'               => 'news/news/rss',
                'sitemap.xml'                       => 'core/index/sitemap',
                '<module>/<controller>/<action>'    => '<module>/<controller>/<action>',
            ],
        ],
    ],
   'params' => $params,
];