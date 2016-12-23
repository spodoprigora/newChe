<?php
namespace frontend\modules\core\widgets\BigSliderWidget;

use common\models\pages\Baner;


use yii;
use yii\base\Widget;



class BigSliderWidget extends Widget
{
    private $baner_array;

    public function run(){
        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }

        $baners = Baner::find()
            ->where(['active' => '1'])
            ->orderBy(['order'=> SORT_ASC])
            ->all();

        return $this->render('slider', ['baners' => $baners, 'language' => $language]);
    }
}