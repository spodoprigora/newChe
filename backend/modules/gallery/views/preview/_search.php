<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\PreviewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="preview-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'url') ?>

    <?= $form->field($model, 'alt_ua') ?>

    <?= $form->field($model, 'alt_ru') ?>

    <?= $form->field($model, 'title_ua') ?>

    <?=  $form->field($model, 'title_ru') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
