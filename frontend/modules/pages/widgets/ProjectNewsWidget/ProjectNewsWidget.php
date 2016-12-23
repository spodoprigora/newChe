<?php


namespace frontend\modules\pages\widgets\ProjectNewsWidget;


use frontend\modules\news\models\News;
use yii\base\Widget;

class ProjectNewsWidget extends  Widget
{
    public $language;
    public $program_id;
    
    public function Run(){

        $now = time();
        $news = News::find()
            ->where(['program_id' => $this->program_id])
            ->andWhere(['is_advertising'=>'0'])
            ->andWhere(['is_announcement'=>'0'])
            ->andWhere(['<', 'date_news', $now])
            ->orderBy(['date_news'=> SORT_DESC])
            ->limit(12)
            ->all();

        return $this->render('projectNews',['news'=> $news, 'language'=> $this->language]);
    }
    
    

}