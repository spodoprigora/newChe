<?php
namespace backend\modules\core\components;

use Yii;
use backend\modules\core\components\BackendBaseAction;

class CRUDUpdate extends BackendBaseAction
{

    public $title             = 'Update';
    public $view              = 'crud-update';
    public $activeFormConfig  = ['options' => ['enctype' => 'multipart/form-data']];

    public function run($id)
    {
        $dataJs = [];
        $model  = $this->findModel($id);

        if (!empty($this->scenarios)) {
            if (is_string($this->scenarios)) {
                $model->setScenario($this->scenarios);
            }
        }

        $this->controller->viewPath = $this->viewPath;

        if (method_exists($model, 'getJsCrud')) {
            $js = $model->getJsCrud();
            $dataJs = [
                'script' => [
                    'data' => $js[ 'script' ],
                    'pos' => $js[ 'pos' ],
                ],
            ];
        }

        if (method_exists($model, 'getJsFileCrud')) {
            $js = $model->getJsFileCrud();
            $dataJs = [
                'file' => [
                    'data' => $js[ 'file' ],
                ],
            ];
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->controller->render($this->view, [
                'breadcrumbs'       => $this->breadcrumbs,
                'model'             => $model,
                'formElements'      => $model->getFormElements(),
                'title'             => $this->title,
                'activeFormConfig'  => $this->activeFormConfig,
                'dataJs'            => $dataJs,
            ]);
        }
    }

}