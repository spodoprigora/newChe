<?php
    namespace frontend\modules\pages\widgets\LastNewsWidget;


    use frontend\modules\news\models\News;
    use yii\base\Widget;

    class LastNewsWidget extends Widget{
        
        public $program_id;
        public $language;
        
        public function Run(){

            $now =time();
            $news = News::find()
                ->where(['program_id' => $this->program_id])
                ->andWhere(['<', 'date_news', $now])
                ->andWhere(['is_advertising'=>'0'])
                ->andWhere(['is_announcement'=>'0'])
                ->orderBy(['date_news' =>SORT_DESC])
                ->limit(10)
                ->all();
            
            
            
            return $this->render('last_news', ['news' => $news, 'language' => $this->language] );
        }
    }
    