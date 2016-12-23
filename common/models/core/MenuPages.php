<?php

namespace common\models\core;

use Yii;

/**
 * This is the model class for table "core_menu_pages".
 *
 * @property integer $id
 * @property integer $page_id
 * @property integer $type_id
 *
 * @property CorePages $page
 * @property CoreTypeMenu $type
 */
class MenuPages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'core_menu_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'type_id'], 'required'],
            [['page_id', 'type_id'], 'integer'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TypeMenu::className(), 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'type_id' => 'Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Pages::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(TypeMenu::className(), ['id' => 'type_id']);
    }
}
