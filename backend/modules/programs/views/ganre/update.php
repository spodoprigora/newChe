<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\programs\models\Ganre */

$this->title = 'Обновить жанр: ' . $model->name_ua;
$this->params['breadcrumbs'][] = ['label' => 'Жанр', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_ua, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="ganre-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
