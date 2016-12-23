<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Gallery */

$this->title = 'Создать фотоальбом';
$this->params['breadcrumbs'][] = ['label' => 'Фотоальбом', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>
