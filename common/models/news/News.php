<?php

namespace common\models\news;

use common\models\galery\Gallery;
use common\models\pages\Baner;
use common\models\program\Program;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $type
 * @property string $title_ua
 * @property string $title_ru
 * @property string $short_description_ua
 * @property string $short_description_ru
 * @property string $description_ua
 * @property string $description_ru
 * @property integer $translate_ru
 * @property integer $date_news
 * @property integer $video_id
 * @property integer $program_id
 * @property integer $is_advertising
 * @property integer $advertising_time
 * @property integer $is_primary
 * @property integer $primary_time
 * @property integer $is_main
 * @property integer $gelery_id
 * @property string $meta_title_ua
 * @property string $meta_title_ru
 * @property string $meta_keywords_ua
 * @property string $meta_keywords_ru
 * @property string $meta_description_ua
 * @property string $meta_description_ru
 * @property integer $is_public_rss
 * @property integer $show_in_last_stories
 * @property integer $show
 * @property integer $show_in_actual
 * @property integer $is_announcement
 * @propery integer $announcement_date
 * @property integer $rating
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title_ua', 'short_description_ua', 'description_ua', 'date_news'], 'required'],
            [['type', 'short_description_ua', 'short_description_ru', 'description_ua', 'description_ru'], 'string'],
            [['program_id', 'is_advertising', 'advertising_time', 'is_primary', 'primary_time', 'is_main', 'gelery_id', 'is_public_rss', 'show_in_last_stories', 'show', 'show_in_actual', 'is_announcement', 'translate_ru'], 'integer'],
            [['title_ua', 'title_ru', 'meta_title_ua', 'meta_title_ru', 'meta_keywords_ua', 'meta_keywords_ru', 'meta_description_ua', 'meta_description_ru'], 'string', 'max' => 255],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Program::className(), 'targetAttribute' => ['program_id' => 'id']],
            [['gelery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gelery_id' => 'id']],
            [['announcement_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                    => 'Ид',
            'type'                  => 'Тип новости',
            'title_ua'              => 'Заголовок українською',
            'title_ru'              => 'Заголовок на русском',
            'short_description_ua'  => 'Короткий опис українською',
            'short_description_ru'  => 'Краткое описание на русском',
            'description_ua'        => 'Текст українською',
            'description_ru'        => 'Текст на русском',
            'translate_ru'          => 'Переведено на русский',
            'date_news'             => 'Дата публикации новости',
            'program_id'            => 'Программа',
            'is_advertising'        => 'Реклама',
            'advertising_time'      => 'Время публикации рекламы',
            'is_primary'            => 'Cамая главная новость',
            'primary_time'          => 'Cамая главная новость время',
            'is_main'               => 'Добавить в главные новости',
            'gelery_id'             => 'Галерея',
            'meta_title_ua'         => 'Заголовок українською',
            'meta_title_ru'         => 'Заголовок на русском',
            'meta_keywords_ua'      => 'Ключові слова українською',
            'meta_keywords_ru'      => 'Ключевые слова на русском',
            'meta_description_ua'   => 'Опис українською',
            'meta_description_ru'   => 'Описание на русском',
            'is_public_rss'         => 'Публиковать в Rss',
            'show_in_last_stories'  => 'Показать в последних новостях',
            'show'                  => 'Показать',
            'show_in_actual'        => 'Показать в актуальных новостях',
            'is_announcement'       => 'Анонс',
            'announcement_date'     => 'Дата анонса',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBaners()
    {
        return $this->hasMany(Baner::className(), ['news_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGelery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gelery_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTags()
    {
        return $this->hasMany(NewsTag::className(), ['news_id' => 'id']);
    }

    public function formatAnnouncementDate(){
        if($this->announcement_date){
            $today = strtotime('today');
            if($today < $this->announcement_date){
                return date('H:i', $this->announcement_date);
            }else{
                return  \Yii::$app->formatter->asDate($this->announcement_date, 'dd.MM.Y');
            }
        }
        else{
            return false;
        }
        
    }
}
