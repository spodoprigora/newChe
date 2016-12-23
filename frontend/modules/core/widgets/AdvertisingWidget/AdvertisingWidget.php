<?php

namespace frontend\modules\core\widgets\AdvertisingWidget;


use common\models\news\News;

use common\models\news\Video;
use frontend\modules\core\models\Preview;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


class AdvertisingWidget extends Widget
{
    private $news_array;

    public function run(){
        $now = time();
        $news = News::find()
                    ->where(['is_advertising'=>'1'])
                    ->andWhere(['is_announcement'=>'0'])
                    ->andWhere(['>','advertising_time', $now])
                    ->orderBy(['date_news'=> SORT_DESC])
                    ->limit(1)
                    ->one();

        if(!empty($news)){
            $this->news_array = ArrayHelper::toArray($news, [
                'common\models\news\News' => [
                    'id',
                    'type',
                    'title_ua' => function($news){
                        return StringHelper::truncate($news->title_ua, 50);
                    },
                    'title_ru'=> function($news){
                        return StringHelper::truncate($news->title_ru, 50);
                    },
                    'short_description_ua' => function($news){
                        return StringHelper::truncate($news->short_description_ua, 100);

                    },
                    'short_description_ru' => function($news){
                        return StringHelper::truncate($news->short_description_ru, 100);
                    },
                    'date_news' => function($news){
                        return $this->dateFormat($news->date_news);
                    },
                    'video' => function($news){
                        if($news->type == 'video'){
                            $result =[];
                            if($news['type']=='video'){
                                $video = Video::find()
                                    ->where(['news_id' => $news->id])
                                    ->one();
                                if($video){
                                    if(!empty($video->youtube_link)){
                                        $result['type'] = 'youtube';
                                        $result['video'] = $video->youtube_link;
                                        $result['youtube_preview'] = $video->getYoutubePreviewUrl();
                                    }
                                    else{
                                        $result['type'] = 'link';
                                        $result['video'] = $video->getUrl();
                                    }
                                }
                               
                            }
                            return $result;
                        }
                        return '';
                    },

                    'preview' => function($news){
                        if($news->type == 'text') {
                            $result = [];
                            if ($news['type'] == 'text') {
                                $preview = Preview::find()
                                    ->where(['news_id' => $news->id])
                                    ->one();
                                if($preview){
                                    $result['preview_url'] = $preview->getBigUrl();
                                    $result['preview_alt_ua'] = $preview->alt_ua;
                                    $result['preview_alt_ru'] = $preview->alt_ru;
                                    $result['preview_title_ua'] = $preview->title_ua;
                                    $result['preview_title_ru'] = $preview->title_ru;
                                }

                            }
                            return $result;
                        }
                        return '';
                    },


                ]
            ]);
            return $this->render('advertising', ['news' => $this->news_array] );
        }

        return $this->render('advertising', ['news' => null] );
    }
    private function cropstring($string, $count){
        $res = substr($string, 0, $count);
        $res = rtrim($res, "!,.-");
        $res = substr($res, 0, strrpos($res, ' '));
        return $res."… ";
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