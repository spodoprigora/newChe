<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\programs\models\Programs */

$this->title = 'Обновить программу: ' . $model->name_ua;
$this->params['breadcrumbs'][] = ['label' => 'Программы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_ua, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="programs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'preview' => $preview
    ]) ?>

</div>
