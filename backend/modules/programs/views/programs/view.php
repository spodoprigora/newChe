<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\programs\models\Programs */

$this->title = $model->name_ua;
$this->params['breadcrumbs'][] = ['label' => 'Программы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="programs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверенны что хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name_ua',
            'name_ru',
            'title_ua',
            'title_ru',
            'short_description_ua:ntext',
            'short_description_ru:ntext',
            'description_ua:ntext',
            'description_ru:ntext',
            'meta_title_ua',
            'meta_title_ru',
            'meta_keywords_ua',
            'meta_keywords_ru',
            'meta_description_ua',
            'meta_description_ru',
            [
                'attribute' => 'active',
                'value' => $model->active == 0 ? 'нет' : 'да'
            ],
            'display_order',
            [
                'attribute' => 'is_public_rss',
                'value' => $model->is_public_rss == 0 ? 'нет' : 'да'
            ],
            [
                'attribute' =>'preview_id',
                'value' => $model->preview->getProgramBigUrl()
            ],
            [
                'attribute' => 'preview_id',
                'value'=> $model->preview->getProgramSmallUrl(),
                'label' => 'Превью для телепрограммы',
            ],
            [
                'attribute' =>'genre_id',
                'value' => $model->genre->name_ua
            ],
        ],
    ]) ?>

</div>
