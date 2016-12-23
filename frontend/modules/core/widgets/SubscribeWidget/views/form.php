<?php
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
?>

<div class="col-lg-6 col-md-8 col-sm-9 col-xs-12 subscribe-block">
    <p>Подписаться на рассылку</p>

    <?= Html::beginForm(['/pages/index/delivery'], '', ['class' => 'subscribe']); ?>
        <?= Html::activeInput('email', $model,'email',  ['placeholder' => 'Введите Ваш email']); ?>
        <?= Html::submitButton('отправить') ?>
    <?= Html::endForm() ?>

</div><!-- end col-lg-6 col-md-8 col-sm-9 col-xs-12 subscribe-block -->