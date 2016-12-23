<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\programs\models\GanreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Жанр';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ganre-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать жанр', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name_ua',
            'name_ru',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'title'=> 'Delete',
                            'aria-label'=>"Delete",
                            'data-confirm'=>'Вы действительно хотите удалить запись?',
                            'data-method'=>'POST'
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
