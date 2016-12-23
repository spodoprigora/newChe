<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model backend\modules\gallery\models\Gallery */
    /* @var $photo backend\modules\gallery\models\GalleryImage */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]);?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

        <div id="image-block">
            <?php
                if (isset($photos)) {
                    echo Html::hiddenInput('count', count($photos) - 1, ['id' => 'count']);
                    $i = 0;
                    foreach ($photos as $photo) {
            ?>
                        <div class="row block" style="margin-bottom:10px;">
                            <div class="col-lg-4">
                                <img src="<?=$photo->getUrl();?>" alt="<?=$photo->alt;?>" style="width: 100%;">
                            </div>
                            <div class="col-lg-8">
                                <?=Html::label('Альтернативный текст изображения ', "GalleryPhotos-{$i}-image_desc");?>
                                <?=Html::textInput("GalleryPhotosOld[{$i}][image_alt]", $photo->alt, ["id" => "GalleryPhotos-{$i}-image_alt", 'class' => 'form-control']);?>
                                <?=Html::label('Описание изображения ', "GalleryPhotos-{$i}-image_desc");?>
                                <?=Html::textarea("GalleryPhotosOld[{$i}][image_desc]", $photo->description, ["id" => "GalleryPhotos-{$i}-image_desc", 'class' => 'form-control']);?>
                                <?=Html::hiddenInput("GalleryPhotosOld[{$i}][gallery_id]", $photo->id);?>
                                <?=Html::buttonInput(('Удалить'), ['class' => 'btn btn-danger', 'style' => 'margin-top: 10px;']);?>
                            </div>
                        </div>
            <?php
                $i++;
                    }
                } else {
                    echo Html::hiddenInput('count', -1, ['id' => 'count']);
                }
            ?>
            <h2>Добавить изображение</h2>
            <br>
                <?= $form->field($model, 'photos[]')->fileInput(['multiple' => true])->label('Фотографии');?>
            <br>

            <div class="row block hide" id="template-block-image" style="margin-bottom:10px;">
                <div class="col-lg-4">
                    <img style="width: 100%;">
                </div>
                <div class="col-lg-8">
                    <label for="">Альтернативный текст изображения <span></span></label>
                    <input type="text" class="form-control">
                    <label for="">Описание изображения <span></span></label>
                    <textarea rows="5" class="form-control"></textarea>
                </div>
            </div>

            <div id="image-block-new"></div>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>