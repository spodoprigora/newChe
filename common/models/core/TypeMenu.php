<?php

namespace common\models\core;

use Yii;

/**
 * This is the model class for table "core_type_menu".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property integer $display_order
 * @property integer $active
 *
 * @property CoreMenuPages[] $coreMenuPages
 */
class TypeMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'core_type_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'title'], 'required'],
            [['display_order', 'active'], 'integer'],
            [['code', 'title'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'code'          => 'Код',
            'title'         => 'Заголовок',
            'display_order' => 'Порядок отображения',
            'active'        => 'Активно',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuPages()
    {
        return $this->hasMany(MenuPages::className(), ['type_id' => 'id']);
    }

    public function getLinksPages()
    {
        return $this->hasMany(Pages::className(), ['id' => 'page_id'])
            ->viaTable(MenuPages::tableName(), ['type_id' => 'id']);
    }
}
