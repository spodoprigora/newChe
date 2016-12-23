<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\programs\models\ProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Программы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать Программу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name_ua',
            //'name_ru',
            //'title_ua',
            //'title_ru',
            // 'short_description_ua:ntext',
            [
                'attribute'=>'short_description_ua',
                'contentOptions' =>['style'=>'white-space: normal;']


            ],
            // 'short_description_ru:ntext',
            // 'description_ua:ntext',
            // 'description_ru:ntext',
            // 'meta_title_ua',
            // 'meta_title_ru',
            // 'meta_keywords_ua',
            // 'meta_keywords_ru',
            // 'meta_description_ua',
            // 'meta_description_ru',
             'active',
             'display_order',
            // 'is_public_rss',
            // 'is_main',
            // 'preview_id',
            // 'genre_id',

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
