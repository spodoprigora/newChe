<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $title;

$this->render('_breadcrumbs', ['breadcrumbs' => $breadcrumbs]);

?>
<div class="crud-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model'       => $model,
        'attributes'  => $viewAttributes,
    ]) ?>

</div>