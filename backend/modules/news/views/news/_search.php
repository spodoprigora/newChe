<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\news\models\searchModels\NewsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'title_ua') ?>

    <?php // echo $form->field($model, 'title_ru') ?>

    <?php // echo $form->field($model, 'short_description_ua') ?>

    <?php // echo $form->field($model, 'short_description_ru') ?>

    <?php // echo $form->field($model, 'description_ua') ?>

    <?php // echo $form->field($model, 'description_ru') ?>

    <?php // echo $form->field($model, 'date_news') ?>

    <?php // echo $form->field($model, 'program_id') ?>

    <?php // echo $form->field($model, 'is_advertising') ?>

    <?php // echo $form->field($model, 'advertising_time') ?>

    <?php // echo $form->field($model, 'gelery_id') ?>

    <?php // echo $form->field($model, 'meta_title_ua') ?>

    <?php // echo $form->field($model, 'meta_title_ru') ?>

    <?php // echo $form->field($model, 'meta_keywords_ua') ?>

    <?php // echo $form->field($model, 'meta_keywords_ru') ?>

    <?php // echo $form->field($model, 'meta_description_ua') ?>

    <?php // echo $form->field($model, 'meta_description_ru') ?>

    <?php // echo $form->field($model, 'is_public_rss') ?>

    <?php // echo $form->field($model, 'show_in_last_stories') ?>

    <?php // echo $form->field($model, 'show') ?>

    <?php // echo $form->field($model, 'show_in_actual') ?>

    <?php // echo $form->field($model, 'is_announcement') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>