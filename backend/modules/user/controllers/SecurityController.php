<?php
namespace backend\modules\user\controllers;


use backend\modules\user\models\User;
use yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\modules\user\models\LoginForm;

class SecurityController extends Controller
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'index'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    // Вход в админ панель
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        $model->load(Yii::$app->request->post());
        
        $user = new User();
        $a = $user->setPassword('admin');
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->request->isAjax) {
                echo 'ok';
                exit;
            }
            return $this->goBack();
        }
        return (Yii::$app->request->isAjax) ? $this->renderPartial('login', ['model' => $model]) : $this->render('login', ['model' => $model]);

    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}