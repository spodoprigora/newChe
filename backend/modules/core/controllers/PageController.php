<?php

namespace backend\modules\core\controllers;

use Yii;
use backend\modules\core\components\BackendController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use zxbodya\yii2\elfinder\ConnectorAction;

/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends BackendController
{

    public $searchModel = 'backend\modules\core\models\searchModels\PagesSearch';
    public $modelName   = 'backend\modules\core\models\Pages';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view', 'connector'],
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
                'title'           => 'Страницы',
            ],
            'create' => [
                'class'           => 'backend\modules\core\components\CRUDCreate',
                'title'           => 'Создать страницу',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Страницы',
                                          ],
                                      ],
            ],
            'update' => [
                'class'           => 'backend\modules\core\components\CRUDUpdate',
                'title'           => 'Обновить страницу',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Страницы',
                                          ],
                                      ],
            ],
            'view' => [
                'class'           => 'backend\modules\core\components\CRUDView',
                'title'           => 'Просмотр страницы',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Страницы',
                                          ],
                                      ],
            ],
            'delete' => [
                'class'           => 'backend\modules\core\components\CRUDDelete',
                'modelName'       => $this->modelName,
            ],
            'connector' => array(
                'class' => ConnectorAction::className(),
                'settings' => array(
                    'root' => Yii::getAlias('@frontend/web/') . $this->model->filePath,
                    'URL' => '/' . $this->model->filePath . '/',
                    'rootAlias' => 'Home',
                    'mimeDetect' => 'none'
                )
            ),
        ];
    }

    public function getColumns()
    {
        return [

            //$this->getGridSerialColumn(),
            ['attribute' => 'id'],
            ['attribute' => 'uri'],
            ['attribute' => 'header_ua'],
            ['attribute' => 'header_ru'],
            ['attribute' => 'display_order'],
            $this->getGridActive(),
            $this->getGridActions(),

        ];
    }
    
}
