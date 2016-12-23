<?php
namespace backend\modules\news\models;

use common\models\news\Tags as BaseTags;

class Tags extends BaseTags
{

    public function getFormElements()
    {
        return [

            'name' =>  ['type' => 'textInput',],
            'lang' =>  ['type' => 'widget',
                        'nameWidget'  => '\kartik\select2\Select2',
                        'attributes'  => [
                            'data'      => $this->getListLangs(),
                            'options'   => [
                                'prompt'  => 'Выберите язык тега',
                                'id' => 'mark-id',
                                ]
                            ],
                        ],
        ];
    }

    public function getViewAttributes()
    {
        return ['id', 'name', 'lang'];
    }

    public function getListLangs()
    {
        return [
            'ru' => 'Русский',
            'ua' => 'Украинский',
        ];
    }


}