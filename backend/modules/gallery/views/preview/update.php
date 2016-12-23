<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Preview */

$this->title = 'Обновить превью ' . $model->alt_ua;
$this->params['breadcrumbs'][] = ['label' => 'Превью', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->alt_ua, 'url' => ['view', 'id' => $model->alt_ua]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="preview-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
