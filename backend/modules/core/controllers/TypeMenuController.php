<?php

namespace backend\modules\core\controllers;

use Yii;
use backend\modules\core\components\BackendController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * TypeMenuController implements the CRUD actions for TypeMenu model.
 */
class TypeMenuController extends BackendController
{

    public $searchModel = 'backend\modules\core\models\searchModels\TypeMenuSearch';
    public $modelName   = 'backend\modules\core\models\TypeMenu';

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
                'title'           => 'Типы меню',
            ],
            'create' => [
                'class'           => 'backend\modules\core\components\CRUDCreate',
                'title'           => 'Создать новый тип меню',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Типы меню',
                                          ],
                                      ],
            ],
            'update' => [
                'class'           => 'backend\modules\core\components\CRUDUpdate',
                'title'           => 'Обновить тип меню',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Типы меню',
                                          ],
                                      ],
            ],
            'view' => [
                'class'           => 'backend\modules\core\components\CRUDView',
                'title'           => 'Просмотр типа меню',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Типы меню',
                                          ],
                                      ],
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
            ['attribute'  => 'code'],
            ['attribute'  => 'title'],
            ['attribute'  => 'display_order'],
            $this->getGridActive(),
            $this->getGridActions(),

        ];
    }
}
