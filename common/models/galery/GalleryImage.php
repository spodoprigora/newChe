<?php

namespace common\models\galery;


use yii;

/**
 * This is the model class for table "gallery_image".
 *
 * @property integer $id
 * @property string $img_url
 * @property string $medium_img_url
 * @property string $mini_img_url
 * @property string $alt
 * @property string $description
 * @property integer $gallery_id
 *
 * @property Gallery $gallery
 */
class GalleryImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_url', 'medium_img_url', 'mini_img_url', 'gallery_id'], 'required'],
            [['gallery_id'], 'integer'],
            [['description'], 'string'],
            [['img_url', 'medium_img_url', 'mini_img_url', 'alt'], 'string', 'max' => 255],
            [['gallery_id'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['gallery_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'img_url' => 'Img Url',
            'medium_img_url' => 'Medium Img Url',
            'mini_img_url' => 'Mini Img Url',
            'alt' => 'Alt',
            'description' => 'Description',
            'gallery_id' => 'Gallery ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gallery_id']);
    }

    public function getUrl(){
        return '/img/gallery/' . $this->img_url;
    }
}
