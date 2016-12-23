<?php
    namespace backend\modules\delivery\controllers;

    use backend\modules\delivery\models\Delivery;
    use yii;
    use yii\web\Controller;
    use yii\filters\AccessControl;

class DeliveryController extends Controller{

    public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'actions' => ['index', 'send'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],

            ];
        }

    public function actionIndex(){
        $delivery_model =new Delivery();
        return $this->render('index', ['delivery_model' =>$delivery_model]);
    }

    public function actionSend(){
        $delivery_model =new Delivery();

        if($delivery_model->load(Yii::$app->request->post()) &&$delivery_model->validate() ){
            if($res = $delivery_model->Send()){
                return $this->render('index', ['delivery_model' =>$delivery_model, 'res' => $res ]);
            }
        }
        return $this->render('index', ['delivery_model' =>$delivery_model, 'res' => false ]);
    }
}