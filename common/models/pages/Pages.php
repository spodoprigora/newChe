<?php

namespace common\models\pages;

use common\models\menu\Menu;
use yii;

/**
 * This is the model class for table "pages".
 *
 * @property integer $id
 * @property string $content_ua
 * @property string $content_ru
 * @property string $link
 * @property integer $active
 * @property string $meta_title_ua
 * @property string $meta_title_ru
 * @property string $meta_keywords_ua
 * @property string $meta_keywords_ru
 * @property string $meta_description_ua
 * @property string $meta_description_ru
 *
 * @property Menu[] $menus
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'content_ua', 'content_ru', 'link', 'active', 'meta_title_ua', 'meta_title_ru', 'meta_keywords_ua', 'meta_keywords_ru', 'meta_description_ua', 'meta_description_ru'], 'required'],
            [['id', 'active'], 'integer'],
            [['content_ua', 'content_ru'], 'string'],
            [['link', 'meta_title_ua', 'meta_title_ru', 'meta_keywords_ua', 'meta_keywords_ru', 'meta_description_ua', 'meta_description_ru'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'content_ua' => 'Контент Ua',
            'content_ru' => 'Контент Ru',
            'link' => 'Link',
            'active' => 'Active',
            'meta_title_ua' => 'Meta Title Ua',
            'meta_title_ru' => 'Meta Title Ru',
            'meta_keywords_ua' => 'Meta Keywords Ua',
            'meta_keywords_ru' => 'Meta Keywords Ru',
            'meta_description_ua' => 'Meta Description Ua',
            'meta_description_ru' => 'Meta Description Ru',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['page_id' => 'id']);
    }
}
