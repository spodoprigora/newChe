<?php
namespace frontend\modules\core\widgets\MenuWidget;


use common\models\core\Pages;
use common\models\core\TypeMenu;


use common\models\program\Program;
use yii\base\Widget;
use yii\helpers\ArrayHelper;


class MenuWidget extends Widget
{
    public $typeMenu;
    public $template;

    private $_menu;

    public function run()
    {
        
        $menu = TypeMenu::find()
            ->where(['code' => $this->typeMenu])
            ->andWhere(['active' => 1])
            ->one();

        $pages = Pages::find()
            ->joinWith('menuPages')
            ->where(['core_menu_pages.type_id' => $menu->id])
            ->andWhere(['parent_id' => 0])
            ->andWhere(['active' => 1])
            ->orderBy(['display_order' => SORT_ASC])
            ->all();

        $this->_menu = ArrayHelper::toArray($pages, [
            'common\models\core\Pages' => [
                 'id' ,
                 'parent_id',
                 'header_ua',
                 'header_ru' ,
                 'uri',
                 'full_uri',
                 'route',
                 'module',
                 'menu_class',
                 'display_order',
                 'submenu' => function($pages){
                     $temp ='';
                         $temp = Pages::find()
                             ->where(['parent_id' => $pages->id])
                             ->andWhere(['active'=> 1])
                             ->orderBy(['display_order' => SORT_ASC])
                             ->all();
                     return $temp;
                 },

            ],
        ]);



        $On_programs = Program::find()
            ->where(['is_main' => '0'])
            ->andWhere(['active' => '1'])
            ->orderBy(['display_order' => SORT_ASC])
            ->all();

        $Off_programs = Program::find()
            ->where(['is_main' => '0'])
            ->andWhere(['active' => '0'])
            ->orderBy(['display_order' => SORT_ASC])
            ->all();
        
        return $this->render($this->template, ['menus' => $this->_menu, 'On_programs' => $On_programs, 'Off_programs' => $Off_programs]);
    }
}