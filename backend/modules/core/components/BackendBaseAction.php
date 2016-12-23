<?php
namespace backend\modules\core\components;

use Yii;
use yii\base\Action;
use yii\web\NotFoundHttpException;

class BackendBaseAction extends Action
{

    public $modelName;
    public $title       = 'Title';
    public $viewPath    = '@backend/modules/core/views/crud';
    public $scenarios   = '';
    public $breadcrumbs;
    public $help;

    protected function findModel($id)
    {
        $model = call_user_func(array($this->modelName, 'findOne'), array($id));
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}