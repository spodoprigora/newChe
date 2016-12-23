<?php

use yii\db\Migration;

class m161026_130928_pages extends Migration
{

    public function up()
    {
        // таблица страниц
        $this->createTable('{{core_pages}}', [
            'id'                  => $this->primaryKey(),
            'parent_id'           => $this->integer()->defaultValue(0),
            'header_ua'           => $this->string(255)->notNull(),
            'header_ru'           => $this->string(255)->notNull(),
            'uri'                 => $this->string(100)->notNull(),
            'full_uri'            => $this->string(100)->notNull(),
            'route'               => $this->string(255)->notNull(),
            'module'              => $this->string(255)->notNull(),
            'menu_class'          => $this->string(255)->defaultValue(NULL),
            'content_ua'          => $this->text()->defaultValue(NULL),
            'content_ru'          => $this->text()->defaultValue(NULL),
            'meta_title_ua'       => $this->string(255)->defaultValue(NULL),
            'meta_title_ru'       => $this->string(255)->defaultValue(NULL),
            'meta_description_ua' => $this->text()->defaultValue(NULL),
            'meta_description_ru' => $this->text()->defaultValue(NULL),
            'meta_keywords_ua'    => $this->string(255)->defaultValue(NULL),
            'meta_keywords_ru'    => $this->string(255)->defaultValue(NULL),
            'display_order'       => $this->integer()->defaultValue(0),
            'active'              => $this->smallInteger(1)->defaultValue(0),
        ]);

        // создание связи таблицы мета-данных страниц с таблицей страниц
        $this->createIndex('uix_core_pages_uri', '{{core_pages}}', 'uri', TRUE);

         // таблица для типов меню
        $this->createTable('{{core_type_menu}}', [
            'id'            => $this->primaryKey(),
            'code'          => $this->string(255)->notNull(),
            'title'         => $this->string(255)->notNull(),
            'display_order' => $this->integer()->defaultValue(0),
            'active'        => $this->smallInteger(1)->defaultValue(0),

        ]);

        // создание уникального индекса для поля code таблицы типов меню
        $this->createIndex('uix_core_type_menu_code', '{{core_type_menu}}', 'code', TRUE);

        // таблица для связивания типов меню с таблицей страниц 
        $this->createTable('{{core_menu_pages}}', [
            'id'            => $this->primaryKey(),
            'page_id'       => $this->integer(11)->notNull(),
            'type_id'       => $this->integer(11)->notNull(),

        ]);

        // создание связи таблицы меню-страницы с таблицей страниц
        $this->createIndex('idx_core_menu_pages_page_id', '{{core_menu_pages}}', 'page_id');
        $this->addForeignKey('fk_core_menu_pages_page_id', '{{core_menu_pages}}', 'page_id', '{{core_pages}}', 'id', 'CASCADE', 'CASCADE');

        // создание связи таблицы меню-страницы с таблицей типов меню
        $this->createIndex('idx_core_menu_pages_type_id', '{{core_menu_pages}}', 'type_id');
        $this->addForeignKey('fk_core_menu_pages_type_id', '{{core_menu_pages}}', 'type_id', '{{core_type_menu}}', 'id', 'CASCADE', 'CASCADE');

        $this->createPages();
    }

    public function down()
    {
        $this->dropForeignKey('fk_core_menu_pages_type_id', '{{core_menu_pages}}');
        $this->dropForeignKey('fk_core_menu_pages_page_id', '{{core_menu_pages}}');
        $this->dropTable('{{core_menu_pages}}');
        $this->dropTable('{{core_type_menu}}');
        $this->dropTable('{{core_pages}}');
    }

    private function createPages()
    {
        $this->insert('{{core_type_menu}}', [
            'title'         => 'Верхнее меню',
            'code'          => 'top',
            'display_order' => 0,
            'active'        => 1,
        ]);

        $this->insert('{{core_type_menu}}', [
            'title'         => 'Нижнее меню',
            'code'          => 'bottom',
            'display_order' => 0,
            'active'        => 1,
        ]);

        $this->insert('{{core_pages}}', [
            'uri'         => '/',
            'full_uri'    => '/',
            'route'       => 'core/index/index',
            'header_ua'   => 'Главная',
            'header_ru'   => 'Главная',
            'module'      => 'core',
            'active'      => 1,
        ]);
    }

}
