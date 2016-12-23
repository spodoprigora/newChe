<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\baner\models\Baner */

$this->title = 'Обновить слайдер: ' . $model->news->title_ua;
$this->params['breadcrumbs'][] = ['label' => 'Слайдер', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->news->title_ua ? $model->news->title_ua : $model->title_ua, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="baner-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
