<?php
use backend\modules\programs\widgets\TimelineProgramWidget\TimelineProgramWidget;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?= Html::beginForm(); ?>

    <?= TimelineProgramWidget::widget(['program' => $program]); ?>
    
    <?= Html::submitInput('Обновить', ['class' => 'btn btn-success']); ?>


<?= Html::endForm(); ?>