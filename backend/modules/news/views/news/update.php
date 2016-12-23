<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\news\models\News */

$this->title = 'Обновить Новость: ' . $model->title_ua;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title_ua, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="news-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'preview' => $preview,
        'video' => $video,
    ]) ?>

</div>