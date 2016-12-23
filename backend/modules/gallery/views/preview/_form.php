<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Preview */
/* @var $uploadModel backend\modules\gallery\models\uploadPreview*/
/* @var $form yii\widgets\ActiveForm */

?>

<div class="preview-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => "Украинском",
                'content' =>
                    $form->field($model, 'alt_ua')->textInput().
                    $form->field($model, 'title_ua')->textInput(),
                    'active' => true
            ],
            [
                'label' => "Русском",
                'content' =>
                    $form->field($model, 'alt_ru')->textInput().
                    $form->field($model, 'title_ru')->textInput()
            ],
        ],
    ]);
    ?>

    <?= $form->field($model, 'url')->fileInput() ?>

   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>