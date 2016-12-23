<?php
namespace backend\modules\core\components;

use yii\web\Controller;
use yii\helpers\Html;

class BackendController extends Controller
{

    public $model;
    public $searchModel;

    public function init()
    {
        parent::init();
        $this->model = new $this->searchModel();
    }

    protected function getGridSerialColumn()
    {
        return ['class' => 'yii\grid\SerialColumn'];
    }

    protected function getGridActions()
    {
        return [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Действия',
        ];
    }

    protected function getGridActive($attribute = 'active')
    {
        return [
            'attribute' => $attribute,
            'filter'    => Html::activeDropDownList($this->model, $attribute, ['0' => 'No', '1' => 'Yes'], ['class' => 'form-control', 'prompt' => '']),
            'value'     => function($model) use ($attribute) {
                              return ($model->$attribute) ? '<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>' : '<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>';
            },
            'format'    => 'html',
        ];
    }

    protected function getGridImage()
    {
        return [

        ];
    }

}