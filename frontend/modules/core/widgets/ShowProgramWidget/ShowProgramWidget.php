<?php

namespace frontend\modules\core\widgets\ShowProgramWidget;


use common\models\news\News;
use common\models\news\Video;
use common\models\program\Program;
use frontend\modules\core\models\Preview;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


class ShowProgramWidget extends Widget
{
    public $start;
    public $finish;
    
    private $programs_array;
    
    

    public function run()
    {
        if(is_null($this->finish)){
            $this->finish = Program::find()->count();
        }

        $programs = Program::find()
            ->with('news')
            ->where(['active' =>'1'])
            ->andWhere(['is_main' => '0'])
            ->orderBy(['display_order' => SORT_ASC])
            ->offset($this->start)
            ->limit($this->finish)
            ->all();

        $this->programs_array = ArrayHelper::toArray($programs, [
            'common\models\program\Program' =>[
                'id',
                'name_ua',
                'name_ru',
                'title_ua',
                'title_ru',
                'news' => function($programs){
                    $now = time();
                    return News::find()
                        ->where(['program_id' => $programs->id])
                        ->andWhere(['show' => '1'])
                        ->andWhere(['<', 'date_news', $now])
                        ->andWhere(['is_advertising'=>'0'])
                        ->andWhere(['is_announcement'=>'0'])
                        ->orderBy(['date_news' => SORT_DESC])
                        ->limit(6)
                        ->all();
                },
            ]
        ]);

        foreach ($this->programs_array as &$program){
            foreach ($program['news'] as $key => &$news){
                $news['title_ua'] = StringHelper::truncate($news['title_ua'], 100);
                $news['title_ru'] = StringHelper::truncate($news['title_ru'], 100);
                $news['short_description_ua'] = StringHelper::truncate($news['short_description_ua'], 110);
                $news['short_description_ru'] = StringHelper::truncate($news['short_description_ru'], 110);
                $news['date_news'] = $this->dateFormat($news['date_news']);
                if($news['type'] == 'video'){
                    $video =Video::find()
                        ->where(['news_id' => $news['id']])
                        ->one();
                    if($video){
                        if(!empty($video->youtube_link)){
                            $news['video_type'] = 'youtube';
                            $news['video'] = $video->youtube_link;
                            $news['youtube_preview'] = $video->getYoutubePreviewUrl();
                        }
                        else{
                            $news['video_type'] = 'link';
                            $news['video'] = $video->getUrl();
                            
                        }
                    }
                   
                }else{ //если текстовая новость вытягиваем превью
                    $preview = Preview::find()
                        ->where(['news_id' => $news['id'] ])
                        ->one();
                    if($preview){
                        $news['preview_url'] = $preview->getBigUrl();
                        $news['preview_alt_ua'] = $preview->alt_ua;
                        $news['preview_alt_ru'] = $preview->alt_ru;
                        $news['preview_title_ua'] = $preview->title_ua;
                        $news['preview_title_ru'] = $preview->title_ru;
                    }
                    


                }
            }
        }
        return $this->render('programs', ['programs' =>$this->programs_array]);
    }

    private function cropstring($string, $count){
        $res = substr($string, 0, $count);
        $res = rtrim($res, "!,.-");
        $res = substr($res, 0, strrpos($res, ' '));
        return $res."… ";
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