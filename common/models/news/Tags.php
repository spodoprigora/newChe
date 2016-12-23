<?php

namespace common\models\news;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $name
 * @property string $lang
 *
 * @property NewsTag[] $newsTags
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'lang'], 'required'],
            [['name', 'lang'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'lang' => 'Lang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTags()
    {
        return $this->hasMany(NewsTag::className(), ['tag_id' => 'id']);
    }
}
