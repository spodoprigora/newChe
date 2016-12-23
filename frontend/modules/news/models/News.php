<?php

namespace frontend\modules\news\models;


use common\models\news\NewsTag;
use common\models\news\Tags;

use common\models\news\Video;
use frontend\modules\core\models\Preview;
use yii;
use common\models\news\News as BaseNews;
use yii\helpers\ArrayHelper;
use frontend\modules\gallery\models\Gallery;


class News extends BaseNews
{

    public function getPreview(){
        $preview = Preview::find()
            ->where(['news_id' => $this->id ])
            ->one();
        if($preview)
            return $preview;
        return null;
    }
    
    public function getVideo(){
        $video = Video::find()
            ->where(['news_id' => $this->id])
            ->one();
        if($video)
            return $video;
        return null;
    }

   

    public function formatDate(){
        $today = strtotime('today');
        if($today < $this->date_news){
            return date('H:i', $this->date_news);
        }else{
            return  \Yii::$app->formatter->asDate($this->date_news, 'dd.MM.Y');
        }
    }


    public function getTags($lang = 'ua')
    {
        $tags = Tags::find()
            ->leftJoin('news_tag', '`news_tag`.`tag_id` = `tags`.`id`')
            ->where(['news_tag.news_id' => $this->id])
            ->andWhere(['lang' => $lang])
            ->all();

        return $tags;
    }

    public function getDate($language)
    {
        $mounth = date('m', $this->date_news);
        if($language =='ru'){
            switch ($mounth){
                case 1: $m='января'; break;
                case 2: $m='февраля'; break;
                case 3: $m='марта'; break;
                case 4: $m='апреля'; break;
                case 5: $m='мая'; break;
                case 6: $m='июня'; break;
                case 7: $m='июля'; break;
                case 8: $m='августа'; break;
                case 9: $m='сентября'; break;
                case 10: $m='октября'; break;
                case 11: $m='ноября'; break;
                case 12: $m='декабря'; break;
            }
        }
        else{
            switch ($mounth){
                case 1: $m='січня'; break;
                case 2: $m='лютого'; break;
                case 3: $m='березня'; break;
                case 4: $m='квітня'; break;
                case 5: $m='травня'; break;
                case 6: $m='червня'; break;
                case 7: $m='липня'; break;
                case 8: $m='серпня'; break;
                case 9: $m='вересня'; break;
                case 10: $m='жовтня'; break;
                case 11: $m='листопада'; break;
                case 12: $m='грудня'; break;
            }
        }
        return date('H:i', $this->date_news) . ', ' . date('d', $this->date_news).'&nbsp;'. $m.'&nbsp;'. date('Y', $this->date_news);
    }

    public function getAnnouncementDate($language)
    {
        $mounth = date('m', $this->announcement_date);
        if($language =='ru'){
            switch ($mounth){
                case 1: $m='января'; break;
                case 2: $m='февраля'; break;
                case 3: $m='марта'; break;
                case 4: $m='апреля'; break;
                case 5: $m='мая'; break;
                case 6: $m='июня'; break;
                case 7: $m='июля'; break;
                case 8: $m='августа'; break;
                case 9: $m='сентября'; break;
                case 10: $m='октября'; break;
                case 11: $m='ноября'; break;
                case 12: $m='декабря'; break;
            }
        }
        else{
            switch ($mounth){
                case 1: $m='січня'; break;
                case 2: $m='лютого'; break;
                case 3: $m='березня'; break;
                case 4: $m='квітня'; break;
                case 5: $m='травня'; break;
                case 6: $m='червня'; break;
                case 7: $m='липня'; break;
                case 8: $m='серпня'; break;
                case 9: $m='вересня'; break;
                case 10: $m='жовтня'; break;
                case 11: $m='листопада'; break;
                case 12: $m='грудня'; break;
            }
        }
        return date('H:i', $this->announcement_date) . ', ' . date('d', $this->announcement_date).'&nbsp;'. $m.'&nbsp;'. date('Y', $this->announcement_date);
    }


    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gelery_id']);
    }
    
    public function getNewsWithTags($lang = 'ua'){
        
        $tags = $this->getTags($lang);

        $ids = ArrayHelper::getColumn($tags, 'id');

        $news = News::find()
            ->leftJoin('news_tag', 'news_tag.news_id = news.id')
            ->where(['in','news_tag.tag_id', $ids])
            ->andWhere(['<>','news.id', $this->id])
            ->orderBy(['news.date_news'=> SORT_DESC])
            ->distinct()
            ->limit(9)
            ->all();

        if($news)
            return $news;
        else
            return null;



    }
}