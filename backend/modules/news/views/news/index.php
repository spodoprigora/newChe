<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\news\models\searchModels\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'type',
            'title_ua',
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Переведено на русский?',
                'content' => function($model){ return ($model->translate_ru) ? 'Да' : 'Нет';},
                'filter' => Html::activeDropDownList($searchModel, 'translate_ru', ['0' => 'Нет', '1' => 'Да'], ['class' => 'form-control', 'prompt' => 'Выберите вариант']),
            ],
            //'title_ru',
            //'short_description_ua:ntext',
            // 'short_description_ru:ntext',
            // 'description_ua:ntext',
            // 'description_ru:ntext',
            // 'date_news',
            // 'program_id',
            // 'is_advertising',
            // 'advertising_time:datetime',
            // 'gelery_id',
            // 'meta_title_ua',
            // 'meta_title_ru',
            // 'meta_keywords_ua',
            // 'meta_keywords_ru',
            // 'meta_description_ua',
            // 'meta_description_ru',
            // 'is_public_rss',
            // 'show_in_last_stories',
            // 'show',
            // 'show_in_actual',
            // 'is_announcement',

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