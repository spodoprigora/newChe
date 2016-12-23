<?php

use backend\modules\gallery\models\Gallery;
use common\models\program\Ganre;
use kartik\select2\Select2;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use zxbodya\yii2\elfinder\TinyMceElFinder;
use zxbodya\yii2\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\modules\programs\models\Programs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="programs-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => "Українською",
                'content' =>
                    $form->field($model, 'name_ua')->textInput().
                    $form->field($model, 'title_ua')->textInput().
                    $form->field($model, 'short_description_ua')->textarea(['rows' => 5]).
                    $form->field($model, 'description_ua')->widget(TinyMce::className(), [
                            'options' => ['rows' => '4'],
                            'language' => 'ru',
                            'settings' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste code fullscreen image textcolor preview media"
                                ],
                                'forced_root_block' => FALSE,
                                'menu' => [
                                    'table' => [
                                        'title' => 'Table',
                                        'items' => 'inserttable tableprops deletetable | cell row column',
                                    ],
                                    'tools' => [
                                        'title' => 'Tools',
                                        'items' => 'spellchecker code',
                                    ],
                                ],
                                'toolbar' => "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image quotes code fullscreen imagetools | forecolor backcolor preview media imageupload",
                                'setup' => [
                                    "apply" => new \yii\web\JsExpression("function(ed) {
                                    ed.addButton('quotes', {
                                        title : 'цитата',
                                        text: 'Цитата',
                                        onclick: function() {
                                            ed.insertContent('<blockquote><p><strong><em>Текст цитаты</em></strong></p><div class=\"blockquote-bottom\"><p>Тектс футера цитаты</p></div></blockquote><br>');
                                        }
                                    });
                                }")
                                ]
                            ],
                            'fileManager' => [
                                'class' => TinyMceElFinder::className(),
                                'connectorRoute' => 'programs/connector',
                            ],
                        ]
                    ).
                    //$form->field($model, 'meta_title_ua')->textInput().
                    //$form->field($model, 'meta_description_ua')->textarea(['rows' => 10]).
                    $form->field($model, 'meta_keywords_ua')->textarea(['rows' => 3]),
                'active' => true
            ],
            [
                'label' => "Русским",
                'content' =>
                    $form->field($model, 'name_ru')->textInput().
                    $form->field($model, 'title_ru')->textInput().
                    $form->field($model, 'short_description_ru')->textarea(['rows' => 5]).
                    $form->field($model, 'description_ru')->widget(TinyMce::className(), [
                            'options' => ['rows' => '10'],
                            'language' => 'ru',
                            'settings' => [
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste code fullscreen image textcolor preview media"
                                ],
                                'forced_root_block' => FALSE,
                                'menu' => [
                                    'table' => [
                                        'title' => 'Table',
                                        'items' => 'inserttable tableprops deletetable | cell row column',
                                    ],
                                    'tools' => [
                                        'title' => 'Tools',
                                        'items' => 'spellchecker code',
                                    ],
                                ],
                                'toolbar' => "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image quotes code fullscreen imagetools | forecolor backcolor preview media imageupload",
                                'setup' => [
                                    "apply" => new \yii\web\JsExpression("function(ed) {
                                    ed.addButton('quotes', {
                                        title : 'цитата',
                                        text: 'Цитата',
                                        onclick: function() {
                                            ed.insertContent('<blockquote><p><strong><em>Текст цитаты</em></strong></p><div class=\"blockquote-bottom\"><p>Тектс футера цитаты</p></div></blockquote><br>');
                                        }
                                    });
                                }")
                                ]
                            ],
                            'fileManager' => [
                                'class' => TinyMceElFinder::className(),
                                'connectorRoute' => 'programs/connector',
                            ],
                        ]
                    ).
                  //$form->field($model, 'meta_title_ru')->textInput().
                  //$form->field($model, 'meta_description_ru')->textarea(['rows' => 10]).
                    $form->field($model, 'meta_keywords_ru')->textarea(['rows' => 3]),
            ],
        ],
    ]);
    ?>



    <?= $form->field($model, 'display_order')->textInput() ?>
    <?= $form->field($model, 'active')->checkbox(['checked' => true]) ?>
    <?= $form->field($model, 'is_public_rss')->checkbox(['checked' => true]) ?>

   




    <p><b>Превью (1940x380)</b></p>
    <?php if($model->preview_id && unserialize($model->preview->url)['big']!= '') : ?>
        <div class="row">
            <div class="col-lg-4">
                <?= Html::img($preview->getProgramBigUrl(), ['class' => 'img-responsive']); ?>
            </div>
        </div>
        <br><br>
        <p><b>Обновить превью</b></p>
    <?php endif; ?>

    <?= $form->field($model, 'previewFile')->fileInput()->label(FALSE); ?>
    <p><b>Данные превью</b></p>
    <?= Tabs::widget([
        'items' => [
                [
                    'label' => "Українською",
                    'content' =>
                        $form->field($preview, 'title_ua')->textInput().
                        $form->field($preview, 'alt_ua')->textInput(),
                    'active' => true
                ],
                [
                    'label' => "Русским",
                    'content' =>
                        $form->field($preview, 'title_ru')->textInput().
                        $form->field($preview, 'alt_ru')->textInput()
                ],
            ],
        ]);
        ?>

    <p><b>Превью для телепрограммы (114x91)</b></p>
    <?php if($model->preview_id && unserialize($model->preview->url)['small']!= '') : ?>
        <div class="row">
            <div class="col-lg-4">
                <?= Html::img($preview->getProgramSmallUrl(), ['class' => 'img-responsive']); ?>
            </div>
        </div>
        <br><br>
        <p><b>Обновить превью</b></p>
    <?php endif; ?>



    <?= $form->field($model, 'smallPreviewFile')->fileInput()->label(FALSE); ?>

    <br>

    <?= $form->field($model, 'genre_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Ganre::find()->all(), 'id', 'name_ua'),
        'options' => ['prompt' => 'Выберите жанр']
    ]); ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
