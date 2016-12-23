<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\news\models\News */

$this->title = $model->title_ua;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить эту новость?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'title_ua',
            'title_ru',
            'short_description_ua:ntext',
            'short_description_ru:ntext',
            'description_ua:ntext',
            'description_ru:ntext',
            [
                'attribute' => 'translate_ru',
                'value' => $model->translate_ru == 0 ? 'нет' : 'да'
            ],
            'date_news:datetime',
            [
                'attribute' =>'program_id',
                'value' => $model->program->name_ua
            ],
            [
                'attribute' => 'is_advertising',
                'value' => $model->is_advertising == 0 ? 'нет' : 'да'
            ],
            [
                'attribute' => 'advertising_time',
                'format'=>'datetime',
                'value'=> $model->advertising_time ==0 ? null : $model->advertising_time

            ],
            'gelery_id',
            'meta_title_ua',
            'meta_title_ru',
            'meta_keywords_ua',
            'meta_keywords_ru',
            'meta_description_ua',
            'meta_description_ru',
            [
                'attribute' => 'is_public_rss',
                'value' => $model->is_public_rss == 0 ? 'нет' : 'да'
            ],
            [
                'attribute' => 'show_in_last_stories',
                'value' => $model->show_in_last_stories == 0 ? 'нет' : 'да'
            ],
            [
                'attribute' => 'show',
                'value' => $model->show == 0 ? 'нет' : 'да'
            ],
            [
                'attribute' => 'show_in_actual',
                'value' => $model->show_in_actual == 0 ? 'нет' : 'да'
            ],
            [
                'attribute' => 'is_announcement',
                'value' => $model->is_announcement == 0 ? 'нет' : 'да'
            ],
            [
                'attribute' => 'announcement_date',
                'format' => 'datetime',
                'value' => $model->announcement_date == 0 ? null : $model->announcement_date
            ],

        ],
    ]) ?>

</div>