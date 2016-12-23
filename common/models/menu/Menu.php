<?php

namespace common\models\menu;

use common\models\pages\Pages;
use yii;

/**
 * This is the model class for table "menu".
 *
 * @property integer $id
 * @property string $title_ua
 * @property string $title_ru
 * @property integer $active
 * @property integer $order
 * @property integer $parent_menu_id
 * @property string $type
 * @property integer $page_id
 *
 * @property Pages $page
 * @property Menu $parentMenu
 * @property Menu[] $menus
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title_ua', 'title_ru', 'active', 'order', 'type'], 'required'],
            [['active', 'order', 'parent_menu_id', 'page_id'], 'integer'],
            [['type'], 'string'],
            [['title_ua', 'title_ru'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pages::className(), 'targetAttribute' => ['page_id' => 'id']],
            [['parent_menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['parent_menu_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title_ua' => 'Title Ua',
            'title_ru' => 'Title Ru',
            'active' => 'Active',
            'order' => 'Order',
            'parent_menu_id' => 'Parent Menu ID',
            'type' => 'Type',
            'page_id' => 'Page ID',
            
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
    public function getParentMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'parent_menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['parent_menu_id' => 'id']);
    }
}
