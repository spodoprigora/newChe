<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\programs\models\Programs */

$this->title = 'Создать Программу';
$this->params['breadcrumbs'][] = ['label' => 'Программы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'preview' => $preview,
    ]) ?>

</div>
