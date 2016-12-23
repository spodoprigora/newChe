<?php

namespace backend\modules\core\controllers;

use Yii;
use backend\modules\core\components\BackendController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ParamsController implements the CRUD actions for Page model.
 */
class ParamsController extends BackendController
{

    public $searchModel = 'backend\modules\core\models\searchModels\CoreParamsSearch';
    public $modelName   = 'backend\modules\core\models\CoreParams';

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
                'title'           => 'Параметры системы',
                'help'            => '<p>Для настройки рассылки необходимо создать параметры:</p>
                                            <ul>
                                                <li>email - адрес с которого проводится рассылка</li>
                                                <li>password - пароль от почтового ящика</li>
                                                <li>smtp_host - smtp сервер</li>
                                                <li>port - порт smtp сервера</li>
                                                <li>encryption - кодирование</li>
                                            </ul>
                                    <p>Для текстов рассылки параметр должен начинаться со слова "рассылка"</p>',
            ],
            'create' => [
                'class'           => 'backend\modules\core\components\CRUDCreate',
                'title'           => 'Создать параметр системы',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Параметры системы',
                                          ],
                                      ],
            ],
            'update' => [
                'class'           => 'backend\modules\core\components\CRUDUpdate',
                'title'           => 'Обновить параметр системы',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Параметры системы',
                                          ],
                                      ],
            ],
            'view' => [
                'class'           => 'backend\modules\core\components\CRUDView',
                'title'           => 'Просмотр параметров системы',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Параметры системы',
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
          
            ['attribute' => 'code'],
            ['attribute' => 'value'],
            $this->getGridActions(),

        ];
    }
    
}
