<?php

use backend\modules\core\models\CoreParams;
use backend\modules\delivery\models\UsersEmail;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Рассылка';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="delivery-form">

    <?php $form = ActiveForm::begin([
        'action' => ['send'],
    ]); ?>

    <?= $form->field($delivery_model, 'emails')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(UsersEmail::find()->all(), 'id', 'email'),
            'value' => '',
            'options' => ['multiple' => true, 'placeholder' => 'Выберите email ...'],
        ])->label('Email');;
    ?>

    <br>

    <?= $form->field($delivery_model, 'params')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(CoreParams::find()->where(['like', 'code', 'рассылка'])->all(), 'id', 'code'),
        'value' => '',
        'options' => ['placeholder' => 'Выберите рассылку ...'],
    ])->label('Рассылка');;
    ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton('Отправить',['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php if(isset($res)):?>
        <?php if(is_int($res)):?>
            <h3 class="alert-success">Ваше пиисьмо отправленно <?= $res?> адресатам</h3>
        <?php else: ?>
            <h3 class="alert alert-danger">Что то пошло не так! <br><span><?= $res;?></span></h3>
        <?php endif;?>
    <?php endif;?>
</div>