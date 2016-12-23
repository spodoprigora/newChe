<?php

namespace common\models\core;

use frontend\modules\gallery\models\Gallery;
use Yii;

/**
 * This is the model class for table "core_pages".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $header_ua
 * @property string $header_ru
 * @property string $uri
 * @property string $full_uri
 * @property string $route
 * @property string $module
 * @property string $menu_class
 * @property string $content_ua
 * @property string $content_ru
 * @property integer $display_order
 * @property integer $active
 * @property string $meta_title_ua
 * @property string $meta_title_ru
 * @property string $meta_description_ua
 * @property string $meta_description_ru
 * @property string $meta_keywords_ua
 * @property string $meta_keywords_ru
 * @property integer $gellery_id
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'core_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'display_order', 'active', 'gelery_id'], 'integer'],
            [['header_ua', 'header_ru', 'uri', 'route'], 'required'],
            [['content_ua', 'content_ru', 'meta_description_ua', 'meta_description_ru'], 'string'],
            [['header_ua', 'header_ru', 'full_uri', 'route', 'module', 'menu_class', 'meta_title_ua', 'meta_title_ru', 'meta_keywords_ua', 'meta_keywords_ru'], 'string', 'max' => 255],
            [['uri'], 'string', 'max' => 100],
            [['uri'], 'unique'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'parent_id' => 'Родительская страница',
            'header_ua' => 'Заголовок українською',
            'header_ru' => 'Заголовок на русском',
            'uri' => 'Адрес',
            'full_uri' => 'Полный Адрес',
            'route' => 'Маршрут',
            'module' => 'Модуль',
            'menu_class' => 'Класс Меню',
            'content_ua' => 'Контент українською',
            'content_ru' => 'Контент на русском',
            'display_order' => 'Порядок отображения',
            'active' => 'Активировать',
            'meta_title_ua' => 'Мета заголовок українською',
            'meta_title_ru' => 'Мета заголовок на русском',
            'meta_description_ua' => 'Мета опис українською',
            'meta_description_ru' => 'Мета описание на русском',
            'meta_keywords_ua' => 'Мета ключові слова українською',
            'meta_keywords_ru' => 'Мета ключевые слова на русском',
            'gelery_id' => 'Фотоальбом',
        ];
    }

    public function getMenuPages()
    {
        return $this->hasMany(MenuPages::className(), ['page_id' => 'id']);
    }

    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'gelery_id']);
    }
}
