<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = $title;

$this->render('_breadcrumbs', ['breadcrumbs' => $breadcrumbs]);

?>
<div class="crud-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a("Добавить", ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //Pjax::begin(); ?>

            <?= GridView::widget([

                'dataProvider'  => $dataProvider,
                'filterModel'   => $searchModel,
                'columns'       => $columns,

            ]); ?>

    <?php //Pjax::end(); ?>

    <?php if(isset($help)):?>
        <?= $help;?>
    <?php endif;?>
    
</div>