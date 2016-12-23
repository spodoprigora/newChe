<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\programs\models\ProgramSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name_ua') ?>

    <?= $form->field($model, 'name_ru') ?>

    <?= $form->field($model, 'title_ua') ?>

    <?= $form->field($model, 'title_ru') ?>

    <?php // echo $form->field($model, 'short_description_ua') ?>

    <?php // echo $form->field($model, 'short_description_ru') ?>

    <?php // echo $form->field($model, 'description_ua') ?>

    <?php // echo $form->field($model, 'description_ru') ?>

    <?php // echo $form->field($model, 'meta_title_ua') ?>

    <?php // echo $form->field($model, 'meta_title_ru') ?>

    <?php // echo $form->field($model, 'meta_keywords_ua') ?>

    <?php // echo $form->field($model, 'meta_keywords_ru') ?>

    <?php // echo $form->field($model, 'meta_description_ua') ?>

    <?php // echo $form->field($model, 'meta_description_ru') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'display_order') ?>

    <?php // echo $form->field($model, 'is_public_rss') ?>

    <?php // echo $form->field($model, 'is_main') ?>

    <?php // echo $form->field($model, 'preview_id') ?>

    <?php // echo $form->field($model, 'genre_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
