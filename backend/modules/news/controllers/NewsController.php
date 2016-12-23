<?php

namespace backend\modules\news\controllers;

use backend\modules\news\models\Video;
use Yii;
use backend\modules\news\models\News;
use backend\modules\news\models\searchModels\NewsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use zxbodya\yii2\elfinder\ConnectorAction;
use backend\modules\gallery\models\Preview;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'remove-preview', 'connector', 'remove-video'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
     * Displays a single News model.
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model    = new News();
        $model->is_public_rss = true;
        $preview  = new Preview();
        $video = new Video();
              
        if ($model->load(Yii::$app->request->post()) && $model->save()){
            if($model->type == 'text'){
                if($preview->load(Yii::$app->request->post()) ){
                    if($model->savePreview($preview))
                        return $this->redirect(['view', 'id' => $model->id]);
                }
                return $this->render('create', [
                    'video' => $video,
                    'model'   => $model,
                    'preview' => $preview,
                ]);
            }
            else{
                if($video->load(Yii::$app->request->post())){
                    if($model->saveVideo($video))
                        return $this->redirect(['view', 'id' => $model->id]);
                }
                return $this->render('create', [
                    'video' => $video,
                    'model'   => $model,
                    'preview' => $preview,
                ]);
            }
        } else {
            return $this->render('create', [
                'video' => $video,
                'model'   => $model,
                'preview' => $preview,
            ]);
        }
    }

    /**
     * Updates an existing News model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $preview = $model->preview;
        $video = $model->video;

        if (!$preview) {
            $preview = new Preview();
        }

        if(!$video){
            $video = new Video();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->type == 'text'){
                if($preview->load(Yii::$app->request->post())){
                    if($model->savePreview($preview) && $model->save())
                        return $this->redirect(['view', 'id' => $model->id]);
                }
                return $this->render('update', [
                        'model' => $model,
                        'preview' => $preview,
                        'video' => $video,
                ]);
            }
            else{
                if($video->load(Yii::$app->request->post())) {
                    if ($model->saveVideo($video) && $model->save())
                        return $this->redirect(['view', 'id' => $model->id]);
                }
                return $this->render('update', [
                        'model' => $model,
                        'preview' => $preview,
                        'video' => $video,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'preview' => $preview,
                'video' => $video,
            ]);
        }
    }

    /**
     * Deletes an existing News model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionRemovePreview($id)
    {
        $model = $this->findModel($id);

        $model->deletePreview();
        $preview = $model->preview;

        if ($preview) {
            $preview->delete();
        }

        return $this->redirect(['/news/news/update', 'id' => $id]);
    }

    public function actionRemoveVideo($id){
        $model = $this->findModel($id);
        $model->deleteVideo();

        $video= $model->video;

        if($video){
            $video->delete();
        }
        return $this->redirect(['/news/news/update', 'id'=> $id]);
        
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
