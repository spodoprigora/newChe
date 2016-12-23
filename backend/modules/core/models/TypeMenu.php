<?php

namespace backend\modules\core\models;

use Yii;
use common\models\core\TypeMenu as BaseTypeMenu;
use yii\helpers\ArrayHelper;

class TypeMenu extends BaseTypeMenu
{

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['display_order'], 'default', 'value' => 0],
                [['code'], 'match', 'pattern' => '/^[a-zA-Z][a-zA-Z\d_-]*[a-zA-Z\d]$/']
            ]
        );
    }

    public function getFormElements()
    {
        return [
            'title'         => ['type' => 'textInput'],
            'code'          => ['type' => 'textInput'],
            'display_order' => ['type' => 'textInput'],
            'active'        => ['type' => 'checkbox'],
        ];
    }

    public function getViewAttributes()
    {
        return ['id', 'title', 'code', 'display_order', 'active'];
    }


}
