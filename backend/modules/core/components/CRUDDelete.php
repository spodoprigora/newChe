<?php
namespace backend\modules\core\components;

use Yii;
use backend\modules\core\components\BackendBaseAction;

class CRUDDelete extends BackendBaseAction
{

    public function run($id)
    {
        $model = $this->findModel($id);

        if (!empty($this->scenarios)) {
            if (is_string($this->scenarios)) {
                $model->setScenario($this->scenarios);
            }
        }
        
        $this->controller->viewPath = $this->viewPath;
        
        $model->delete();

        return $this->controller->redirect(['index']);
    }

}