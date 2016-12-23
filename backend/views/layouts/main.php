<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Новый Чернигов',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [


        ['label' => 'Новости', 'url' => Url::to(['/news/news/index'])],
        ['label' => 'Программы', 'url' => Url::to(['/programs/programs/index'])],
        ['label' => 'Структура сайта', 'items' => [
            ['label' => 'Страницы', 'url' => Url::to(['/core/page/index'])],
            ['label' => 'Фотоальбом', 'url' => Url::to(['/gallery/gallery/index'])],
            ['label' => 'Сдайдер', 'url' => Url::to(['/baner/baner/index'])],
           
        ]],
        ['label' => 'Программа телепередач', 'url' => Url::to(['/programs/timeline-program/index'])],
        ['label' => 'Дополнительно', 'items' =>[
            ['label' => 'Жанры', 'url' => Url::to(['/programs/ganre/index'])],
            ['label' => 'Типы меню', 'url' => Url::to(['/core/type-menu/index'])],
            ['label' => 'Параметры системы', 'url' => Url::to(['/core/params/index'])],
            ['label' => 'Рассылка', 'url' => Url::to(['/delivery/delivery/index'])],
        ]],

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/security/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);


    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
