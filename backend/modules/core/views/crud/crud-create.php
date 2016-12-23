<?php

use yii\helpers\Html;

$this->title = $title;

$this->render('_breadcrumbs', ['breadcrumbs' => $breadcrumbs]);

if (isset($dataJs[ 'script' ])) {
    $this->registerJs($dataJs[ 'script' ][ 'data' ], $dataJs[ 'script' ][ 'pos' ]);
}
if (isset($dataJs[ 'file' ])) {
    $this->registerJsFile($dataJs[ 'file' ][ 'data' ]);
}

?>
<div class="crud-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('crud-form', [
        'model'             => $model,
        'formElements'      => $formElements,
        'activeFormConfig'  => $activeFormConfig,
    ]) ?>

</div>