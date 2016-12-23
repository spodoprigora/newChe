<?php

namespace common\models\core;

use Yii;

/**
 * This is the model class for table "core_params".
 *
 * @property integer $id
 * @property string $code
 * @property string $value
 */
class CoreParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'core_params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'value'], 'required'],
            [['value'], 'string'],
            [['code'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код',
            'value' => 'Значение',
        ];
    }
}
