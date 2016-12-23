<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\news\models\News */
/* @var $preview backend\modules\gallery\models\Preview */
/* @var $video backend\modules\news\models\Video */

$this->title = 'Добавить Новость';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'preview' => $preview,
        'video' => $video,
    ]) ?>

</div>