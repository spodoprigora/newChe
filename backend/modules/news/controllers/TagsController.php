<?php
namespace backend\modules\news\controllers;

use Yii;
use backend\modules\core\components\BackendController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;

class TagsController extends BackendController
{

    public $modelName   = '\backend\modules\news\models\Tags';
    public $searchModel = '\backend\modules\news\models\searchModels\TagsSearch';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'index' => [
                'class'           => 'backend\modules\core\components\CRUDIndex',
                'title'           => 'Теги',
            ],
            'create' => [
                'class'           => 'backend\modules\core\components\CRUDCreate',
                'title'           => 'Добавить Тег',
                'modelName'       => $this->modelName,
            ],
            'update' => [
                'class'           => 'backend\modules\core\components\CRUDUpdate',
                'title'           => 'Обновить Тег',
                'modelName'       => $this->modelName,
            ],
            'view' => [
                'class'           => 'backend\modules\core\components\CRUDView',
                'title'           => 'Просмотр Тега',
                'modelName'       => $this->modelName,
            ],
            'delete' => [
                'class'           => 'backend\modules\core\components\CRUDDelete',
                'modelName'       => $this->modelName,
            ],
        ];
    }

    public function getColumns()
    {
        return [
            $this->getGridSerialColumn(),
            ['attribute'  => 'name'],
            [
                'attribute'  => 'lang',
                'filter' => Html::activeDropDownList($this->model, 'lang', $this->model->getListLangs(), ['class' => 'form-control', 'prompt' => ''])
            ],
            $this->getGridActions(),

        ];
    }

}