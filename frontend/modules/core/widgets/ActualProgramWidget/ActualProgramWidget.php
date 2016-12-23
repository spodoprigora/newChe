<?php
namespace frontend\modules\core\widgets\ActualProgramWidget;



use common\models\news\News;

use common\models\news\Video;
use frontend\modules\core\models\Preview;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


class ActualProgramWidget extends Widget
{
    private $news_array;

    public function run()
    {
        $now =time();
        $news = News::find()
                ->where(['show_in_actual' => '1'])
                ->andWhere(['<', 'date_news', $now])
                ->andWhere(['is_advertising'=>'0'])
                ->andWhere(['is_announcement'=>'0'])
                ->orderBy(['date_news' =>SORT_DESC])
                ->limit(12)
                ->all();
        $this->news_array = ArrayHelper::toArray($news, [
           'common\models\news\News' => [
               'id',
               'type',
               'title_ua',
               'title_ru',
               'short_description_ua' => function($news){
                  return StringHelper::truncate($news->short_description_ua, 70);
               },
               'short_description_ru' => function($news){
                   return StringHelper::truncate($news->short_description_ru, 70);
               },
               'date_news' => function($news){
                   return $this->dateFormat($news->date_news);
               },
               'preview' => function($news){
                   if($news->type == 'text'){
                       $temp = [];
                       $preview = Preview::find()
                           ->where(['news_id' => $news->id ])
                           ->one();
                       if($preview){
                           $temp['preview_url'] = $preview->getSmallUrl();
                           $temp['preview_alt_ua'] = $preview->alt_ua;
                           $temp['preview_alt_ru'] = $preview->alt_ru;
                           $temp['preview_title_ua'] = $preview->title_ua;
                           $temp['preview_title_ru'] = $preview->title_ru;
                       }

                       return $temp;
                   }
                   return '';
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
           ]
        ]);
        return $this->render('actual', ['news' => $this->news_array]);
    }


    private function dateFormat($date){
        $now = date("Y-m-d", time());
        $news_date =date("Y-m-d", $date);
        if($now == $news_date){
            //return  \Yii::$app->formatter->asTime($date, 'HH:i');
            return date('H:i', $date);
        }else{
            return  \Yii::$app->formatter->asDate($date, 'dd.MM.Y');
        }

    }
}