<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\gallery\models\Preview */

$this->title = $model->alt_ua;
$this->params['breadcrumbs'][] = ['label' => 'Превью', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preview-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->alt_ua], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->alt_ua], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить превью?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'url:url',
            'alt_ua',
            'alt_ru',
            'title_ua',
            'title_ru',
        ],
    ]) ?>

</div>