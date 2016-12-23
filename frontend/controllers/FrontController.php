<?php namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class FrontController extends Controller
{

    public function setMetaDescription($description){
        Yii::$app->view->registerMetaTag(['name' => 'description', 'content' => $description, ]);
    }
    public function setMetaKeywords($keywords){
        Yii::$app->view->registerMetaTag(['name' => 'keywords', 'content' => $keywords, ]);
    }
    public function setTitle($title){
        $this->View->title = $title;
    }
}
