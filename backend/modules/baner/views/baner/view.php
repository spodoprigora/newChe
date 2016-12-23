<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\baner\models\Baner */

$this->title = $model->news->title_ua;
$this->params['breadcrumbs'][] = ['label' => 'Слайдер', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="baner-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действидельно хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'news_id',
            'order',
            'img_link',
            [
                'attribute' => 'active',
                'value' => $model->active == 0 ? 'нет' : 'да'
            ],
            'title_ua',
            'title_ru',
            'description_ua',
            'description_ru'
        ],
    ]) ?>

</div>
