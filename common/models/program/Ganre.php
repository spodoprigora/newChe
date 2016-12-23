<?php

namespace common\models\program;

use Yii;

/**
 * This is the model class for table "ganre".
 *
 * @property integer $id
 * @property string $name_ua
 * @property string $name_ru
 * @property Program[] $programs
 */
class Ganre extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ganre';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
            [['name_ua', 'name_ru'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'name_ua' => 'Назва українською',
            'name_ru' => 'Название  на русском'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['genre_id' => 'id']);
    }
}
