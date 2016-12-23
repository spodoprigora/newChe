<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Europe/Kiev',
    /*'language'=>'ru-RU',*/
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];