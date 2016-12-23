<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Gallery */
/* @var $photos backend\modules\gallery\models\GalleryImage */

$this->title = 'Обновить фотоальбом: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Фотоальбом', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="gallery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'photos' => $photos
    ]) ?>

</div>
