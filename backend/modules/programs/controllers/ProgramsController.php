<?php

namespace backend\modules\programs\controllers;

use backend\modules\gallery\models\Preview;
use Yii;
use backend\modules\programs\models\Programs;
use backend\modules\programs\models\ProgramSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use zxbodya\yii2\elfinder\ConnectorAction;

/**
 * ProgramsController implements the CRUD actions for Programs model.
 */
class ProgramsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
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
            'connector' => array(
                'class' => ConnectorAction::className(),
                'settings' => array(
                    'root' => Yii::getAlias('@frontend/web/img'),
                    'URL' => '/img/',
                    'rootAlias' => 'Home',
                    'mimeDetect' => 'none'
                )
            ),
        ];
    }
    
    /**
     * Lists all Programs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProgramSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Programs model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Programs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Programs();
        $model->is_public_rss = true;
        $model->active = true;
        $preview = new Preview();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                if($model->savePreview($preview) && $model->save())
                    return $this->redirect(['view', 'id' => $model->id]);

            return $this->render('update', ['model' => $model, 'preview' => $preview]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'preview' => $preview
            ]);
        }
    }

    /**
     * Updates an existing Programs model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $preview = $model->preview;
        
        if(!$preview){
            $preview = new Preview();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->savePreview($preview) && $model->save())
                return $this->redirect(['view', 'id' => $model->id]);
            return $this->render('update', ['model' => $model, 'preview' => $preview]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'preview' => $preview,
            ]);
        }
    }

    /**
     * Deletes an existing Programs model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Programs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Programs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Programs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
