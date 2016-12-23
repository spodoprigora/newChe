<?php
namespace frontend\modules\core\widgets\LastStoriesWidget;


use common\models\news\Video;
use common\models\pages\Baner;


use frontend\modules\core\models\Preview;
use frontend\modules\news\models\News;
use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


class LastStoriesWidget extends Widget
{
    private $news_array;
    
    public function run(){

        $language ='ua';
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('lang') && $session['lang'] == 'ru' ){
            $language ='ru';
        }


        $now =time();
        $news = News::find()
            ->where(['show_in_last_stories' => '1'])
            ->andWhere(['<', 'date_news', $now])
            ->andWhere(['is_advertising'=>'0'])
            ->andWhere(['is_announcement'=>'0'])
            ->orderBy(['date_news'=> SORT_DESC])
            ->limit(10)
            ->all();
    $this->news_array = ArrayHelper::toArray($news, [
        'frontend\modules\news\models\News' => [
            'id',
            'type',
            'title_ua' => function($news){
                return StringHelper::truncate($news->title_ua, 50);
            },
            'title_ru' => function($news){
                return StringHelper::truncate($news->title_ru, 50);
            },
            'short_description_ua' => function($news){
                return StringHelper::truncate($news->short_description_ua, 80);
            },
            'short_description_ru' => function($news) {
                return StringHelper::truncate($news->short_description_ru, 80);
            },
            'date' => function($news){
                return $news->formatDate();
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
            'video' => function($news){
                if($news->type == 'video'){
                    $temp =[];
                    $video = Video::find()
                        ->where(['news_id' => $news->id])
                        ->one();
                    if($video){
                        $temp['youtube_link'] = $video->youtube_link;
                        $temp['youtube_preview'] = $video->getYoutubePreviewUrl();
                        $temp['link'] = $video->getUrl();
                    }

                    return $temp;
                }
                return '';
            },
        ]
    ]);

        $a = serialize(['small'=>'new-tv-2.jpg', 'big'=>'new-tv-2.jpg']);
        return $this->render('last_stories', ['news' => $this->news_array, 'language'=> $language]);
    }
}