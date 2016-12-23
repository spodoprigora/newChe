<?php

namespace backend\modules\core\models;

use Yii;
use common\models\core\CoreParams as BaseCoreParams;

class CoreParams extends BaseCoreParams
{

    public function attributeLabels()
    {
        return [
            'code'  => 'Ключ параметра',
            'value' => 'Значение параметра',
        ];
    }

    public function getFormElements()
    {
        return [

            'code'   =>  ['type' => 'textInput',],

            'value'  => ['type' => 'widget', 'nameWidget' => '\zxbodya\yii2\tinymce\TinyMce', 'attributes' => 
                            [
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
                                ],
                            ]
                       ],
        ];
    }

    public function getViewAttributes()
    {
        return ['id', 'code', 'value'];
    }

}
