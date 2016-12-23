<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\programs\models\Ganre */

$this->title = 'Создать жанр';
$this->params['breadcrumbs'][] = ['label' => 'Жанр', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ganre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
