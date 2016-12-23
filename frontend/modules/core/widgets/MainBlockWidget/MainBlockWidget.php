<?php

namespace frontend\modules\core\widgets\MainBlockWidget;


use common\models\news\MainNews;
use common\models\news\News;
use common\models\news\Video;
use common\models\program\Program;
use frontend\modules\core\models\Preview;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


class MainBlockWidget extends Widget
{
    private $main_array;

    public function run()
    {

        $main = Program::find()
            ->with('news')
            ->where(['active' => '1'])
            ->andWhere(['is_main' => '1'])
            ->one();

        if(!is_null($main)){

            $this->main_array = ArrayHelper::toArray($main, [
                'common\models\program\Program' =>[
                    'id',
                    'name_ua',
                    'name_ru',
                    'title_ua',
                    'title_ru',
                    'news' => function(){
                        $now = time();
                        return News::find()
                            ->where(['is_main' => '1'])
                            ->andWhere(['<', 'date_news', $now])
                            ->andWhere(['is_advertising'=>'0'])
                            ->andWhere(['is_announcement'=>'0'])
                            ->orderBy(['date_news' => SORT_DESC])
                            ->limit(11)
                            ->all();
                    },
                ]
            ]);
        }

        $primary_news='';
        foreach ($this->main_array['news'] as $key => &$news){
            if($news['primary_time'] > time() ) {
                $primary_news = ArrayHelper::remove($this->main_array['news'], $key);
                break;
            }
        }

        if(!empty($primary_news)){
            array_unshift($this->main_array['news'], $primary_news);
        }


        foreach ($this->main_array['news'] as $key => &$news){
            $news['title_ua']= StringHelper::truncate($news['title_ua'], 100);
            $news['title_ru']= StringHelper::truncate($news['title_ru'], 100);
            $news['short_description_ua']= StringHelper::truncate($news['short_description_ua'], 110);
            $news['short_description_ru']= StringHelper::truncate($news['short_description_ru'], 110);
            $news['date_news'] = $this->dateFormat($news['date_news']);
            if($news['type'] == 'text'){
                $preview = Preview::find()
                    ->where(['news_id' => $news['id'] ])
                    ->one();
                if($preview){
                    $news['preview']['url'] = $preview->getBigUrl();
                    $news['preview']['alt_ua'] = $preview->alt_ua;
                    $news['preview']['alt_ru'] = $preview->alt_ru;
                    $news['preview']['title_ua'] = $preview->title_ua;
                    $news['preview']['title_ru'] = $preview->title_ru;
                }
                
                
            }else{
                $video =Video::find()
                        ->where(['news_id' => $news['id']])
                        ->one();
                if($video){
                    $news['video']['youtube_link'] = $video->youtube_link;
                    $news['video']['link'] = $video->getUrl();
                    $news['video']['youtube_preview'] = $video->getYoutubePreviewUrl();
                }
               
            }
            
        }



        return $this->render('main', ['program' =>$this->main_array]);
    }

      private function dateFormat($date){
        $today = strtotime('today');
        if($today < $date){
            //return  \Yii::$app->formatter->asTime($date, 'HH:i');
            return date('H:i', $date);
        }else{
            return  \Yii::$app->formatter->asDate($date, 'dd.MM.Y');
        }

    }
}