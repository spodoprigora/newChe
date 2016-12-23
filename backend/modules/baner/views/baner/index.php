<?php

use common\models\news\News;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\baner\models\SearchBaner */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Слайдер';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="baner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать слайдер', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            [
                'label'=>'Новость',
                'attribute' => 'news.title_ua',
                'filter' => Html::activeDropDownList($searchModel, 'news_id', ArrayHelper::map(News::find()->all(), 'id', 'title_ua'), ['class' => 'form-control', 'prompt' => 'Выберите новость']),
            ],
            'title_ua',
            'order',
            [
                'attribute' => 'img_link',
                'label' => 'Изображение',
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->img_link, $model->getUrl(), ['class' => 'hello', 'target'=> '_blank']); //неработает таргет бланк
                }
            ],
            /*[
                'attribute' => 'img_link',
                'label' => 'Изображение',
                'filter' => false,
                'format' => 'html',
                'value' => function ($model, $key, $index, $column) {
                    return Html::img($model->getUrl(),
                        ['width' => '200px', 'style' => 'max-width:100%']);
                }
            ],*/
            [
                'attribute' => 'active',
                'filter'    => Html::activeDropDownList($searchModel, 'active', ['0' => 'Не активный', '1' => 'Активный'], ['class' => 'form-control', 'prompt' => 'Все']),
                'value'     => function($searchModel) {
                    return ($searchModel->active) ? '<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                },
                'format'    => 'html',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
