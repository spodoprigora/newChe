<?php

namespace common\models\news;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property string $youtube_link
 * @property string $link
 * @property integer $news_id
 *
 * @property News $news
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['news_id'], 'required'],
            [['news_id'], 'integer'],
            [['youtube_link', 'link'], 'string', 'max' => 255],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'youtube_link' => 'Youtube Link',
            'link' => 'Link',
            'news_id' => 'News ID',
        ];
    }
    public function getUrl(){
        return '/video/'. $this->link;
    }
    
    public function getYoutubePreviewUrl(){
        if(!empty($this->youtube_link))
            return 'http://img.youtube.com/vi/' .$this->youtube_link .'/0.jpg';
        return null;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }
}
