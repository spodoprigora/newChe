<?php
namespace backend\modules\core\components;


use common\models\program\TimelineProgram;
use Yii;


class CRUDIndex extends BackendBaseAction
{

    public $view = 'crud-index';

    public function run()
    {
        $searchModel  = $this->controller->model;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->controller->viewPath = $this->viewPath;

        return $this->controller->render($this->view, [
            'breadcrumbs'   => $this->breadcrumbs,
            'searchModel'   => $searchModel,
            'dataProvider'  => $dataProvider,
            'title'         => $this->title,
            'columns'       => $this->controller->getColumns(),
            'help'          => $this->help,
           
        ]);

    }

}