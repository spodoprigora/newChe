<?php
namespace backend\modules\core\models;

use backend\modules\gallery\models\Gallery;
use Yii;
use common\models\core\Pages as BasePages;
use yii\helpers\ArrayHelper;
use common\models\core\MenuPages;
use yii\helpers\Html;
use yii\helpers\Url;

class Pages extends BasePages
{

    public $menus;
    public $filePath = 'img/core';

    public function getFormElements()
    {
        $this->setMenus();

        $query = self::find()->where(['<>', 'uri', '/']);

        if (!$this->isNewRecord) {
            $query->andWhere(['<>', 'id', $this->id]);
        }

        return [
            'title' => [
                'type' => 'tabs',
                'itemTabs' => [
                    [
                        'title'     => 'Основной блок',
                        'active'    => TRUE,
                        'elements'  => [
                            'parent_id'     => ['type' => 'dropdownlist', 'items' => ArrayHelper::map($query->andWhere(['<>', 'module', 'pages'])->all(), 'id', 'header_ru'), 'attributes' => ['prompt' => 'Выберите родительскую страницу']],
                            'uri'           => ['type' => 'textInput'],
                            //'route'         => ['type' => 'dropdownlist', 'items' => $this->getListRoutes(), 'attributes' => ['prompt' => 'Choose route']],
                            'menus'         => [
                                                    'type' => 'checkboxlist',
                                                    'items' => ArrayHelper::map(TypeMenu::find()->orderBy(['display_order' => SORT_ASC])->all(), 'id', 'title'),
                                                    'attributes' => [
                                                        'item' => function($index, $label, $name, $checked, $value) {
                                                            return $this->getTemplateForCheckboxList($index, $label, $name, $checked, $value);
                                                        }
                                                    ],
                                                ],
                            'menu_class'    => ['type' => 'textInput'],
                            'display_order' => ['type' => 'textInput'],
                            'active'        => ['type' => 'checkbox'],
                            'gelery_id'    => ['type' => 'dropdownlist', 'items' => ArrayHelper::map(Gallery::find()->all(), 'id', 'name'), 'attributes' => ['prompt' => 'Выбирите фотоальбом']],
                        ],
                    ],
                    [
                        'title'     => 'Інформація українською',
                        'active'    => FALSE,
                        'elements'  => [
                            'header_ua'           => ['type' => 'textInput', 'fieldAttributes' => ['template' => '{label}{input}']],
                            'content_ua'          => ['type' => 'widget', 'nameWidget' => '\zxbodya\yii2\tinymce\TinyMce', 'attributes' => 
                                                          [
                                                              'options' => ['rows' => '10'],
                                                              'language' => 'ru',
                                                              'settings' => [
                                                                  'plugins' => [
                                                                      "advlist autolink lists link charmap print preview anchor",
                                                                      "searchreplace visualblocks code fullscreen",
                                                                      "insertdatetime media table contextmenu paste code fullscreen image textcolor preview media"
                                                                  ],
                                                                  'forced_root_block' => FALSE,
                                                                  'menu' => [
                                                                      'table' => [
                                                                          'title' => 'Table',
                                                                          'items' => 'inserttable tableprops deletetable | cell row column',
                                                                      ],
                                                                      'tools' => [
                                                                          'title' => 'Tools',
                                                                          'items' => 'spellchecker code',
                                                                      ],
                                                                  ],

                                                                  'toolbar' => "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image quotes code fullscreen imagetools | forecolor backcolor preview media imageupload",
                                                                  'setup' => [
                                                                      "apply" => new \yii\web\JsExpression("function(ed) {
                                                                        ed.addButton('quotes', {
                                                                            title : 'quotes',
                                                                            text: 'Quotes',
                                                                            onclick: function() {
                                                                                ed.insertContent('<blockquote><p><strong><em>Текст цитаты</em></strong></p><div class=\"blockquote-bottom\"><p>Тектс футера цитаты</p></div></blockquote><br>');
                                                                            }
                                                                        });
                                                                    }")
                                                                  ]
                                                              ],
                                                              'fileManager' => [
                                                                  'class' => \zxbodya\yii2\elfinder\TinyMceElFinder::className(),
                                                                  'connectorRoute' => 'page/connector',
                                                              ],
                                                          ]
                                                     ],
                            'meta_title_ua'       => ['type' => 'textInput', 'fieldAttributes' => ['template' => '{label}{input}']],
                            'meta_keywords_ua'    => ['type' => 'textarea', 'attributes' => ['rows' => '5']],
                            'meta_description_ua' => ['type' => 'textarea', 'attributes' => ['rows' => '10']],
                        ],
                    ],
                    [
                        'title'     => 'Информация на русском',
                        'active'    => FALSE,
                        'elements'  => [
                            'header_ru'           => ['type' => 'textInput', 'fieldAttributes' => ['template' => '{label}{input}']],
                            'content_ru'          => ['type' => 'widget', 'nameWidget' => '\zxbodya\yii2\tinymce\TinyMce', 'attributes' => 
                                                          [
                                                              'options' => ['rows' => '10'],
                                                              'language' => 'ru',
                                                              'settings' => [
                                                                  'plugins' => [
                                                                      "advlist autolink lists link charmap print preview anchor",
                                                                      "searchreplace visualblocks code fullscreen",
                                                                      "insertdatetime media table contextmenu paste code fullscreen image textcolor preview media"
                                                                  ],
                                                                  'forced_root_block' => FALSE,
                                                                  'menu' => [
                                                                      'table' => [
                                                                          'title' => 'Table',
                                                                          'items' => 'inserttable tableprops deletetable | cell row column',
                                                                      ],
                                                                      'tools' => [
                                                                          'title' => 'Tools',
                                                                          'items' => 'spellchecker code',
                                                                      ],
                                                                  ],

                                                                  'toolbar' => "bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image quotes code fullscreen imagetools | forecolor backcolor preview media imageupload",
                                                                  'setup' => [
                                                                      "apply" => new \yii\web\JsExpression("function(ed) {
                                                                            ed.addButton('quotes', {
                                                                                title : 'quotes',
                                                                                text: 'Quotes',
                                                                                onclick: function() {
                                                                                    ed.insertContent('<blockquote><p><strong><em>Текст цитаты</em></strong></p><div class=\"blockquote-bottom\"><p>Тектс футера цитаты</p></div></blockquote><br>');
                                                                                }
                                                                            });
                                                                        }")
                                                                  ]
                                                              ],
                                                              'fileManager' => [
                                                                  'class' => \zxbodya\yii2\elfinder\TinyMceElFinder::className(),
                                                                  'connectorRoute' => 'page/connector',
                                                              ],
                                                          ]
                                                     ],
                            'meta_title_ru'       => ['type' => 'textInput', 'fieldAttributes' => ['template' => '{label}{input}']],
                            'meta_keywords_ru'    => ['type' => 'textarea', 'attributes' => ['rows' => '5']],
                            'meta_description_ru' => ['type' => 'textarea', 'attributes' => ['rows' => '10']],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getViewAttributes()
    {
        return ['id', 'uri', 'header_ua', 'header_ru', 'display_order', 'active', 'gelery_id'];
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
         [
            'menus' => 'Меню'
        ]);
    }
    public function beforeValidate()
    {
        if(empty($this->route)){
            $this->route = 'core/index/pages';
        }
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->module = substr($this->route, 0, strpos($this->route, '/'));
            if ($this->parent_id) {
                $parent = self::findOne($this->parent_id);
                $this->full_uri = $parent->full_uri . '/' . $this->uri;
            } else {
                $this->parent_id  = 0;
                $this->full_uri   = '/' . $this->uri;
            }
            return TRUE;
        }
        return FALSE;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $menus = (!empty($_POST[ 'Pages' ][ 'menus' ])) ? $_POST[ 'Pages' ][ 'menus' ] : [];
        $this->saveMenus($menus);
    }

    public function setMenus()
    {
        $this->menus = ArrayHelper::getColumn($this->menuPages, 'type_id');
    }

    // метод который генерирует шаблон для списка чекбоксов
    public function getTemplateForCheckboxList($index, $label, $name, $checked, $value)
    {
        return "<div class='checkbox'><label>" . Html::checkbox($name, $checked, ['value' => $value]) . "{$label}</label></div>";
    }

    // метод для сохранения связей между новостью и ее категориями
    private function saveMenus($menus)
    {
        
        // получаем список категорий, к которым относится данная новость
        $listMenus = ArrayHelper::map($this->menuPages, 'id', function($model){ return $model;});
        
        // перебираем все новости, которые были отмечены
        foreach ($menus as $menuId) {

            // если нет отмеченной новости в списке текущих связей,
            // тогда сохраняем связь
            if (!isset($listMenus[ $menuId ])) {
                $link           = new MenuPages();
                $link->page_id  = $this->id;
                $link->type_id  = $menuId;
                $link->save();
            } else {
                unset($listMenus[ $menuId ]);
            }
        }

        // Удаляем новости, которые были unchecked
        foreach ($listMenus as $model) {
            $model->delete();
        }
    }

    private function getListRoutes()
    {
        $modules = include(Yii::getAlias('@backend/config/modules.php'));
        $rules = [];
        $method = 'getFrontendRoutes';
        foreach ($modules as $nameModule => $object) {
            $module = Yii::$app->getModule($nameModule);
            if (method_exists($module, $method)) {
                $listRoutes = $module->$method();
                foreach ($listRoutes[ 'controllers' ] as $nameController => $dataController) {
                    foreach ($dataController[ 'actions' ] as $nameAction => $dataAction) {
                        $rules[ $nameModule . '/' . $nameController . '/' . $nameAction ] = $dataAction[ 'name' ];
                    }
                }
                if (isset($listRoutes[ 'no-action' ])) {
                    foreach ($listRoutes[ 'no-action' ] as $item) {
                        $rules[ $item[ 'href' ] ] = $item[ 'name' ];
                    }
                }
            }
        }
        return $rules;
    }

    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    public function getChidrens()
    {
        return $this->hasMany(self::className(), ['parent_id', 'id']);
    }

}
