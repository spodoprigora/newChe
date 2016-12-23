<?php

namespace common\models\pages;


use frontend\modules\news\models\News;
use yii;

/**
 * This is the model class for table "baner".
 *
 * @property integer $id
 * @property integer $news_id
 * @property integer $order
 * @property string $img_link
 * @property integer $active
 *
 * @property News $news
 */
class Baner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'baner';
    }

    public function getUrl(){
        return '/img/baners/' . $this->img_link;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }
}
