<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Preview */

$this->title = 'Создать превью';
$this->params['breadcrumbs'][] = ['label' => 'Превью', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preview-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
