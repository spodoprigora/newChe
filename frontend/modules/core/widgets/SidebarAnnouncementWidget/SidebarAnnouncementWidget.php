<?php

namespace frontend\modules\core\widgets\SidebarAnnouncementWidget;


use common\models\news\News;
use common\models\news\Video;
use common\models\program\Program;
use frontend\modules\core\models\Preview;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


class SidebarAnnouncementWidget extends Widget
{
    private $announcement_array;

    public function run(){
        $now = time();
        $news = News::find()
            ->where(['is_advertising'=>'0'])
            ->andWhere(['is_announcement'=>'1'])
            ->andWhere(['<', 'date_news', $now])
            ->orderBy(['date_news'=> SORT_DESC])
            ->limit(14)
            ->all();

        $this->announcement_array = ArrayHelper::toArray($news, [
             'common\models\news\News' => [
                 'id',
                 'type',
                 'title_ua'=> function($news){
                     return StringHelper::truncate($news->title_ua, 50);
                 },
                 'title_ru'=> function($news){
                     return StringHelper::truncate($news->title_ru, 50);
                 },
                 'short_description_ua' => function($news){
                     return StringHelper::truncate($news->short_description_ua, 70);
                 },
                 'short_description_ru' => function($news){
                     return StringHelper::truncate($news->short_description_ru, 70);
                 },
                 'date_news' => function($news){
                     return $this->dateFormat($news->date_news);
                 },
                 'announcement_date' => function($news){
                     return $news->formatAnnouncementDate();
                 },
                 'video' => function($news){
                     if($news->type == 'video'){
                         $temp =[];
                         $video = Video::find()
                             ->where(['news_id' => $news->id])
                             ->one();
                         if($video){
                             if(!empty($video->youtube_link)){
                                 $temp['type'] = 'youtube';
                                 $temp['video'] = $video->youtube_link;
                                 $temp['youtube_preview'] = $video->getYoutubePreviewUrl();
                             }
                             else{
                                 $temp['type'] = 'link';
                                 $temp['video'] = $video->getUrl();
                             }
                         }
                         return $temp;
                     }
                     return '';
                 },
                 'preview' => function($news){
                     if($news->type == 'text'){
                         $temp = [];
                         $preview = Preview::find()
                             ->where(['news_id' => $news->id ])
                             ->one();
                         if($preview){
                             $temp['url'] = $preview->getSmallUrl();
                             $temp['alt_ua'] = $preview->alt_ua;
                             $temp['alt_ru'] = $preview->alt_ru;
                             $temp['title_ua'] = $preview->title_ua;
                             $temp['title_ru'] = $preview->title_ru;
                         }
                         return $temp;
                     }
                     return '';
                 },
             ]
         ]);
        return $this->render('announcement', ['news' => $this->announcement_array] );
    }
   
    private function dateFormat($date){
        $now = date("Y-m-d", time());
        $news_date =date("Y-m-d", $date);
        if($now == $news_date){
            return date('H:i', $date);
        }else{
            return  \Yii::$app->formatter->asDate($date, 'dd.MM.Y');
        }

    }
}