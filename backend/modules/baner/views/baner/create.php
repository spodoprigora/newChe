<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\baner\models\Baner */

$this->title = 'Создать слайдер';
$this->params['breadcrumbs'][] = ['label' => 'Слайдер', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="baner-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
