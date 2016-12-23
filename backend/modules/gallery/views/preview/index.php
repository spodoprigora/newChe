<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\gallery\models\PreviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Превью';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preview-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать превью', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'attribute' => 'url',
                'label' => 'Изображение',
                'filter' => false,
                'format' => 'html',
                'value' => function ($model, $key, $index, $column) {
                    return Html::img($model->getUrl(),
                        ['width' => '80px', 'style' => 'max-width:100%']);
                }
            ],
            'alt_ua',
            //'alt_ru',
            'title_ua',
            // 'title_ru',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
