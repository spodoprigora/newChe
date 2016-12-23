<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use trntv\yii\datetime\DateTimeWidget;
use zxbodya\yii2\tinymce\TinyMce;
use zxbodya\yii2\elfinder\TinyMceElFinder;
use backend\modules\news\models\Program;
use backend\modules\news\models\Tags;
use yii\helpers\Url;
use backend\modules\gallery\models\Gallery;

/* @var $this yii\web\View */
/* @var $model backend\modules\news\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?= $form->field($model, 'type')->widget(Select2::className(), [
                                              'data'        => $model->getListType(),
                                              'options'     => [
                                                  'prompt' => 'Выберите тип новости',
                                              ]
                                          ]) ?>

    <p><b>Основная информация</b></p>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => "Українською",
                'content' =>
                    $form->field($model, 'title_ua')->textInput().
                    $form->field($model, 'short_description_ua')->textarea(['rows' => 10]).
                    $form->field($model, 'description_ua')->widget(TinyMce::className(), [
                        'options' => ['rows' => '10', 'class' => 'myclass'],
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
                            'connectorRoute' => 'news/connector',
                        ],
                    ]
                    ),
                'active' => true
            ],
            [
                'label' => "Русским",
                'content' =>
                    $form->field($model, 'title_ru')->textInput().
                    $form->field($model, 'short_description_ru')->textarea(['rows' => 10]).
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
                            'connectorRoute' => 'news/connector',
                        ],
                    ]),
            ],

        ],
    ]);
    ?>
    <?= $form->field($model, 'translate_ru')->checkbox() ?>

    <?php //при ошибке валидации преобразуем поле date_news к timestamp
        if($model->date_news && !is_int($model->date_news)){
            $temp = str_replace('/', '-', $model->date_news);
            $date = date_create($temp);
            $model->date_news = date_timestamp_get($date);
        }
    ?>
    <?= $form->field($model, 'date_news')->widget(DateTimeWidget::className(), [
        'phpDatetimeFormat' => 'dd/MM/yyyy HH:mm',
        'clientOptions' => [
            'allowInputToggle' => false,
            'sideBySide' => false,
            'widgetPositioning' => [
               'horizontal' => 'auto',
               'vertical' => 'auto'
            ]
        ]
    ]); ?>

    
    <?= $form->field($model, 'program_id')->widget(Select2::className(), [
                                              'data'        => ArrayHelper::map(Program::find()->where(['<>', 'id', '4'])->all(), 'id', 'name_ru'),
                                              'options'     => [
                                                  'prompt' => 'Выберите программу',
                                              ]
                                          ]) ?>

    <?= $form->field($model, 'is_advertising')->checkbox() ?>

    <?= $form->field($model, 'advertising_time')->widget(Select2::className(), [
                                              'data'        => $model->getListTimeAdversting(),
                                              'options'     => [
                                                  'prompt' => 'Выберите время',
                                              ]
                                          ]) ?>

    <?= $form->field($model, 'is_main')->checkbox() ?>

    <?= $form->field($model, 'is_primary')->checkbox() ?>

    <?= $form->field($model, 'primary_time')->widget(Select2::className(), [
                                              'data'        => $model->getListTimeAdversting(),
                                              'options'     => [
                                                  'prompt' => 'Выберите время',
                                              ]
                                          ]) ?>

    <?= $form->field($model, 'gelery_id')->widget(Select2::className(), [
                                              'data'        => ArrayHelper::map(Gallery::find()->all(), 'id', 'name'),
                                              'options'     => [
                                                  'prompt' => 'Выберите галлерею',
                                              ]
                                          ]) ?>

    <?php $classPreview = ($model->type && $model->type === 'video') ? 'preview hiden' : 'preview'; ?>

    <div class="<?= $classPreview ?>">
        <p><b>Превью</b></p>
        <?php if($model->isHasBigPreview()) : ?>
            <div class="row">
                <div class="col-lg-4">
                      <?= Html::img($model->getBigPreview(), ['class' => 'img-responsive']); ?>
                </div>
            </div>
            <br><br>
            <?= Html::a('Удалить превью', Url::toRoute(['/news/news/remove-preview', 'id' => $model->id]), ['class' => 'btn btn-danger']); ?>
            <br><br>
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
    </div>
    

    
    <?php $classVideo = ($model->type && $model->type === 'text') ? 'video hiden' : 'video'; ?>
    <div class="<?= $classVideo; ?>">

        <?php if($video->youtube_link != null) : ?>
            <div class="row">
                <div class="col-lg-4">
                    <figure class="video">
                        <iframe  src="https://www.youtube.com/embed/<?= $video->youtube_link ;?>" frameborder="0" allowfullscreen></iframe>
                    </figure>
                </div>
            </div>
            <?= Html::a('Удалить видео', Url::toRoute(['/news/news/remove-video', 'id' => $model->id]), ['class' => 'btn btn-danger']); ?>
        <?php endif;?>

        <?php if($video->link != null) : ?>
            <div class="row">
                <div class="col-lg-4">
                    <video  width="100%" controls>
                        <source src="<?= $video->getUrl(); ?>" type="video/mp4">
                    </video>
                </div>
            </div>
            <?= Html::a('Удалить видео', Url::toRoute(['/news/news/remove-video', 'id' => $model->id]), ['class' => 'btn btn-danger']); ?>
        <?php endif;?>


        <p><b>Видео</b></p>

        <?= $form->field($model, 'videoFile')->fileInput()->label(FALSE); ?>

        <div class="youtube">
            <?= $form->field($video, 'youtube_link')->textInput(['placeholder' => "JlMRxPFXz2s"]); ?>
        </div>
        
    </div>

    
    <p><b>Мета данные</b></p>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => "Українською",
                'content' =>
                    //$form->field($model, 'meta_title_ua')->textInput().
                    //$form->field($model, 'meta_description_ua')->textarea(['rows' => 10]).
                    $form->field($model, 'meta_keywords_ua')->textarea(['rows' => 10]),
                'active' => true
            ],
            [
                'label' => "Русским",
                'content' =>
                    //$form->field($model, 'meta_title_ru')->textInput().
                    //$form->field($model, 'meta_description_ru')->textarea(['rows' => 10]).
                    $form->field($model, 'meta_keywords_ru')->textarea(['rows' => 10]),
            ],

        ],
    ]);
    ?>

    <p><b>Теги</b></p>

    <?php
        //print_r($model->tagsRU); print_r(ArrayHelper::map(Tags::find()->where(['lang' => 'ru'])->all(), 'id', 'name')); exit;
    ?>

    <?= Tabs::widget([
        'items' => [
            [
                'label' => "Украинский",
                'content' =>
                    Html::activeLabel($model, 'tagsUa').
                    Select2::widget([
                        'name' => 'News[tagsUa]',
                        'data'    => ArrayHelper::map(Tags::find()->where(['lang' => 'ua'])->all(), 'name', 'name'),
                        'value'   => $model->getTagsUa(),
                        'language' => 'ru',
                        'options' => [
                            'prompt' => 'Выберите теги',
                            'multiple' => TRUE,
                        ],
                        'pluginOptions' => [
                            'tags' => true,
                        ],
                    ]),
                'active' => true
            ],
            [
                'label' => "Русским",
                'content' =>
                    Html::activeLabel($model, 'tagsRu').
                    Select2::widget([
                        'name' => 'News[tagsRu]',
                        'data'    => ArrayHelper::map(Tags::find()->where(['lang' => 'ru'])->all(), 'name', 'name'),
                        'value'   => $model->getTagsRu(),
                        'language' => 'ru',
                        'options' => [
                            'prompt' => 'Выберите теги',
                            'multiple' => TRUE,
                        ],
                        'pluginOptions' => [
                            'tags' => true,
                        ],
                    ])
            ],

        ],
    ]);
    ?>

    <br>

    <?= $form->field($model, 'is_public_rss')->checkbox() ?>

    <?= $form->field($model, 'show_in_last_stories')->checkbox() ?>

     <?= $form->field($model, 'show_in_actual')->checkbox() ?>

    <?= $form->field($model, 'show')->checkbox() ?>

    <?= $form->field($model, 'is_announcement')->checkbox() ?>

    <?php //при ошибке валидации преобразуем поле announcement_date к timestamp
    if($model->announcement_date && !is_int($model->announcement_date)){
        $temp = str_replace('/', '-', $model->announcement_date);
        $date = date_create($temp);
        $model->announcement_date = date_timestamp_get($date);
    }
    ?>
    <?= $form->field($model, 'announcement_date')->widget(DateTimeWidget::className(), [
        'phpDatetimeFormat' => 'dd/MM/yyyy HH:mm',
        'clientOptions' => [
            'allowInputToggle' => false,
            'sideBySide' => false,
            'widgetPositioning' => [
                'horizontal' => 'auto',
                'vertical' => 'auto'
            ]
        ]
    ]); ?>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>