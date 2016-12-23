<?php
    namespace frontend\modules\pages\widgets\PopularWidget;

use frontend\modules\news\models\News;
use yii\base\Widget;

class PopularWidget extends Widget{
    public $language;

    public function Run(){

        $now =time();
        $news = News::find()
            ->where(['<', 'date_news', $now])
            ->andWhere(['is_advertising'=>'0'])
            ->andWhere(['is_announcement'=>'0'])
            ->orderBy(['rating' =>SORT_DESC, 'date_news' => SORT_DESC])
            ->limit(12)
            ->all();


        return $this->render('popular', ['language'=> $this->language,'news' => $news]);
    }

}