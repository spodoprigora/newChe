<?php

namespace common\models\galery;

use common\models\news\News;
use yii;

/**
 * This is the model class for table "gallery".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 *
 * @property GalleryImage[] $galleryImages
 * @property News[] $news
 */
class Gallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryImages()
    {
        return $this->hasMany(GalleryImage::className(), ['gallery_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['gelery_id' => 'id']);
    }
}
