<?php
namespace backend\modules\programs\controllers;

use backend\modules\news\models\Program;
use Yii;
use backend\modules\core\components\BackendController;
use yii\bootstrap\Html;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\programs\models\Programs;
use yii\helpers\ArrayHelper;

class TimelineProgramController extends BackendController
{

    public $searchModel = 'backend\modules\programs\models\searchModels\TimelineProgramSearch';
    public $modelName   = 'backend\modules\programs\models\TimelineProgram';

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
                'title'           => 'Время для телепрограммы',
                
            ],
            'create' => [
                'class'           => 'backend\modules\core\components\CRUDCreate',
                'title'           => 'Добавить время телепрограммы',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Время для передач',
                                          ],
                                      ],
            ],
            'update' => [
                'class'           => 'backend\modules\core\components\CRUDUpdate',
                'title'           => 'Обновить время телепрограммы',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Время для передач',
                                          ],
                                      ],
            ],
            'view' => [
                'class'           => 'backend\modules\core\components\CRUDView',
                'title'           => 'Просмотр времени телепрограммы',
                'modelName'       => $this->modelName,
                'breadcrumbs'     =>  [
                                          [
                                              'url'   => ['index'],
                                              'label' => 'Время для передач',
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
            [
                'attribute' => 'program_id',
                'content' => function($model){
                    return $model->program->name_ua;
                },
                'filter' => ArrayHelper::map(Program::find()->all(), 'id', 'name_ua'),
            ],
            ['attribute' => 'tv_show'],
            ['attribute' => 'tv_show_preview'],
            ['attribute' => 'date'],
            ['attribute' => 'time'],
            ['attribute' => 'type'],
            $this->getGridActions(),

        ];
    }

}
?>