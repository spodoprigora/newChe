<?php
namespace backend\modules\core\components;

use Yii;
use backend\modules\core\components\BackendBaseAction;

class CRUDView extends BackendBaseAction
{

    public $title = 'View';
    public $view  = 'crud-view';

    public function run($id)
    {
        $this->controller->viewPath = $this->viewPath;

        $model = $this->findModel($id);

        if (!empty($this->scenarios)) {
            if (is_string($this->scenarios)) {
                $model->setScenario($this->scenarios);
            }
        }

        return $this->controller->render($this->view, [
            'breadcrumbs'     => $this->breadcrumbs,
            'model'           => $model,
            'title'           => $this->title,
            'viewAttributes'  => $model->getViewAttributes(),
        ]);
    }

}