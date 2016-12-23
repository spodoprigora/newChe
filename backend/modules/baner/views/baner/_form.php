<?php

use backend\modules\news\models\News;
use kartik\select2\Select2;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\baner\models\Baner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="baner-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php

        echo $form->field($model, 'news_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(News::find()->all(), 'id', 'title_ua'),
        'options' => ['placeholder' => 'Выберите новость'],
        'pluginOptions' => [
        'allowClear' => true
        ],
    ])->label('Новость');
    ?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => "Українською",
                'content' =>
                    $form->field($model, 'title_ua')->textInput().
                    $form->field($model, 'description_ua')->textarea(['rows' => 10])
            ],
            [
                'label' => "Русским",
                'content' =>
                    $form->field($model, 'title_ru')->textInput().
                    $form->field($model, 'description_ru')->textarea(['rows' => 10])
            ],

        ],
    ]);
    ?>





    <?= $form->field($model, 'order')->textInput() ?>

    <?php if($model->img_link != null):?>
        <div class="row">
            <div class="col-lg-4">
                <?= Html::img($model->getUrl(), ['class' => 'img-responsive']); ?>
            </div>
        </div>

    <?php endif; ?>
    <?= $form->field($model, 'uploadImage')->fileInput()->label('Изображение 1927х560') ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
