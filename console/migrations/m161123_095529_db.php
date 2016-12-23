<?php

use yii\db\Migration;

class m161123_095529_db extends Migration
{
    public function up()
    {
        //таблица банер
        $this->createTable('{{baner}}',[
            'id'             => $this->primaryKey(),
            'news_id'        => $this->integer(11)->defaultValue(NULL),
            'order'          => $this->integer(11)->notNull(),
            'img_link'       => $this->string(255)->notNull(),
            'active'         => $this->smallInteger(1),
            'title_ua'       => $this->string(255)->defaultValue(NULL),
            'title_ru'       => $this->string(255)->defaultValue(NULL),
            'description_ua' => $this->text()->defaultValue(NULL),
            'description_ru' => $this->text()->defaultValue(NULL),

        ]);

        // таблица для связивания типов меню с таблицей страниц
        $this->createTable('{{core_menu_pages}}', [
            'id'            => $this->primaryKey(),
            'page_id'       => $this->integer(11)->notNull(),
            'type_id'       => $this->integer(11)->notNull(),

        ]);

        // таблица страниц
        $this->createTable('{{core_pages}}', [
            'id'                  => $this->primaryKey(),
            'parent_id'           => $this->integer(11)->defaultValue(0),
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
            'display_order'       => $this->integer(11)->defaultValue(0),
            'active'              => $this->smallInteger(1)->defaultValue(0),
            'gelery_id'           => $this->integer(11)->defaultValue(NULL),
        ]);

        //таблица с внутренними параметрами
        $this->createTable('{{core_params}}',[
            'id'    => $this->primaryKey(),
            'code'  => $this->string(255)->notNull(),
            'value' => $this->text()->notNull(),
        ]);

        //таблица с типами меню
        $this->createTable('{{core_type_menu}}',[
            'id'            => $this->primaryKey(),
            'code'          => $this->string(255)->notNull(),
            'title'         => $this->string(255)->notNull(),
            'display_order' => $this->integer(11)->defaultValue(0),
            'active'        => $this->smallInteger(1)->defaultValue(0),
        ]);

         //таблица галерея
        $this->createTable('{{gallery}}',[
            'id'          => $this->primaryKey(),
            'name'        => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
        ]);

        //таблица с изображениями галереии
        $this->createTable('{{gallery_image}}',[
            'id'             => $this->primaryKey(),
            'img_url'        => $this->string(255)->notNull(),
            'medium_img_url' => $this->string(255)->notNull(),
            'mini_img_url'   => $this->string(255)->notNull(),
            'alt'            => $this->string(255)->notNull(),
            'description'    => $this->text()->notNull(),
            'gallery_id'     => $this->integer(11)->defaultValue(NULL),
        ]);

        //таблица жанры передач
        $this->createTable('{{ganre}}',[
            'id'      => $this->primaryKey(),
            'name_ua' => $this->string(50)->notNull(),
            'name_ru' => $this->string(50)->notNull(),

        ]);

        //таблица новости
        $this->createTable('{{news}}',[
            'id'                   => $this->primaryKey(),
            'type'                 => "enum('text','video') NOT NULL",
            'title_ua'             => $this->string(255)->notNull(),
            'title_ru'             => $this->string(255)->notNull(),
            'short_description_ua' => $this->text()->notNull(),
            'short_description_ru' => $this->text()->notNull(),
            'description_ua'       => $this->text()->notNull(),
            'description_ru'       => $this->text()->notNull(),
            'date_news'            => $this->integer(11)->notNull(),
            'program_id'           => $this->integer(11)->defaultValue(NULL),
            'is_advertising'       => $this->smallInteger(1)->defaultValue(0),
            'advertising_time'     => $this->integer(11)->defaultValue(0),
            'is_primary'           => $this->integer(11)->defaultValue(0),
            'primary_time'         => $this->integer(11)->defaultValue(0),
            'is_main'              => $this->integer(11)->defaultValue(NULL),
            'gelery_id'            => $this->integer(11)->defaultValue(NULL),
            'meta_title_ua'        => $this->string(255)->defaultValue(NULL),
            'meta_title_ru'        => $this->string(255)->defaultValue(NULL),
            'meta_keywords_ua'     => $this->string(255)->defaultValue(NULL),
            'meta_keywords_ru'     => $this->string(255)->defaultValue(NULL),
            'meta_description_ua'  => $this->string(255)->defaultValue(NULL),
            'meta_description_ru'  => $this->string(255)->defaultValue(NULL),
            'is_public_rss'        => $this->smallInteger(1)->defaultValue(1),
            'show_in_last_stories' => $this->smallInteger(1)->defaultValue(0),
            'show'                 => $this->smallInteger(1)->defaultValue(1),
            'show_in_actual'       => $this->smallInteger(1)->defaultValue(0),
            'is_announcement'      => $this->smallInteger(1)->defaultValue(0),
            'announcement_date'    => $this->integer(11)->defaultValue(NULL),
            'rating'               => $this->integer(11)->notNull()->defaultValue(0),
            'translate_ru'         => $this->smallInteger(1)->defaultValue(0)
        ]);

        //таблица связывающая новости с тегами
        $this->createTable('{{news_tag}}',[
            'id'      => $this->primaryKey(),
            'news_id' => $this->integer(11)->defaultValue(NULL),
            'tag_id'  => $this->integer(11)->defaultValue(NULL)
        ]);

        //таблица первью
        $this->createTable('{{preview}}',[
            'id'       => $this->primaryKey(),
            'url'      => $this -> string(255)->defaultValue(NULL),
            'alt_ua'   => $this->string(255)->notNull(),
            'alt_ru'   => $this->string(255)->notNull(),
            'title_ua' => $this->string(255)->notNull(),
            'title_ru' => $this->string(255)->notNull(),
            'news_id'  => $this->integer(11)->defaultValue(NULL),
        ]);

        //таблица c программами
        $this->createTable('{{program}}',[
            'id'                   => $this->primaryKey(),
            'name_ua'              => $this->string(255)->notNull(),
            'name_ru'              => $this->string(255)->notNull(),
            'title_ua'             => $this->string(255)->notNull(),
            'title_ru'             => $this->string(255)->notNull(),
            'short_description_ua' => $this->text(),
            'short_description_ru' => $this->text(),
            'description_ua'       => $this->text(),
            'description_ru'       => $this->text(),
            'meta_title_ua'        => $this->string(255)->notNull(),
            'meta_title_ru'        => $this->string(255)->notNull(),
            'meta_keywords_ua'     => $this->string(255)->notNull(),
            'meta_keywords_ru'     => $this->string(255)->notNull(),
            'meta_description_ua'  => $this->string(255)->notNull(),
            'meta_description_ru'  => $this->string(255)->notNull(),
            'active'               => $this->smallInteger(1)->defaultValue(1),
            'display_order'        => $this->integer(11)->notNull(),
            'is_public_rss'        => $this->smallInteger(1)->defaultValue(1),
            'is_main'              => $this->smallInteger(1)->defaultValue(0),
            'preview_id'           => $this->integer(11)->defaultValue(NULL),
            'genre_id'             => $this->integer(11)->defaultValue(NULL),
        ]);

        //таблица с программой телепередач
        $this->createTable('{{programs_timeline_program}}',[
            'id'         => $this->primaryKey(),
            'program_id' => $this->integer(11)->defaultValue(NULL),
            'tv_show'    => $this->string(255)->defaultValue(NULL),
            'tv_show_preview' => $this->string(255)->defaultValue(NULL),
            'date'       => $this->date()->defaultValue(NULL),
            'time'       => $this->time()->notNull(),
            'type'       => "enum('every-day','every-week','weekdays','custom') NOT NULL",
            'days'       => $this->string(255)->defaultValue(NULL),
        ]);

        //таблица с тегами
        $this->createTable('{{tags}}',[
            'id'   => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            'lang' => "enum('ua','ru') NOT NULL",
        ]);

        //таблица с email
        $this->createTable('{{users_email}}',[
            'id'    => $this->primaryKey(),
            'email' => $this->string(50)->notNull()

        ]);

        //таблица видео
        $this->createTable('{{video}}',[
            'id'           => $this->primaryKey(),
            'youtube_link' => $this->string(255)->defaultValue(NULL),
            'link'         => $this->string(255)->defaultValue(NULL),
            'news_id'      => $this->integer(11)->defaultValue(NULL),

        ]);


        //Индексы таблицы `baner`
        $this->createIndex('FK_baner_news_id', '{{baner}}', 'news_id');

        //Индексы таблицы `core_menu_pages`
        $this->createIndex('idx_core_menu_pages_page_id', '{{core_menu_pages}}', 'page_id');
        $this->createIndex('idx_core_menu_pages_type_id', '{{core_menu_pages}}', 'type_id');

        //Индексы таблицы `core_pages`
        $this->createIndex('uix_core_pages_uri', '{{core_pages}}', 'uri', TRUE);
        $this->createIndex('FK_core_pages_gallery_id', '{{core_pages}}', 'gelery_id');

        //Индексы таблицы `core_params`
        $this->createIndex('code', '{{core_params}}', 'code', TRUE);

        //Индексы таблицы `core_type_menu`
        $this->createIndex('uix_core_type_menu_code', '{{core_type_menu}}', 'code', TRUE);

        //Индексы таблицы `gallery_image`
        $this->createIndex('gallery_image_fk0', '{{gallery_image}}', 'gallery_id');

        //Индексы таблицы `news`
        $this->createIndex('FK_news_program_id', '{{news}}', 'program_id');
        $this->createIndex('FK_news_gallery_id', '{{news}}', 'gelery_id');

        //Индексы таблицы `news_tag`
        $this->createIndex('FK_news_tag_tags_id', '{{news_tag}}', 'tag_id');
        $this->createIndex('FK_news_tag_news_id', '{{news_tag}}', 'news_id');

        //Индексы таблицы `preview`
        $this->createIndex('FK_preview_news_id', '{{preview}}', 'news_id');

        //Индексы таблицы `program`
        $this->createIndex('FK_program_preview_id', '{{program}}', 'preview_id');
        $this->createIndex('FK_program_ganre_id', '{{program}}', 'genre_id');

        //Индексы таблицы `programs_timeline_program`
        $this->createIndex('programm_id', '{{programs_timeline_program}}', 'program_id');

        //Индексы таблицы `video`
        $this->createIndex('FK_video_news_id', '{{video}}', 'news_id');


        //Ограничения внешнего ключа таблицы `baner`
        $this->addForeignKey('FK_baner_news_id', '{{baner}}', 'news_id', '{{news}}', 'id', 'SET NULL', 'SET NULL');

        //Ограничения внешнего ключа таблицы `core_menu_pages`
        $this->addForeignKey('fk_core_menu_pages_page_id', '{{core_menu_pages}}', 'page_id', '{{core_pages}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_core_menu_pages_type_id', '{{core_menu_pages}}', 'type_id', '{{core_type_menu}}', 'id', 'CASCADE', 'CASCADE');

        //Ограничения внешнего ключа таблицы `core_pages`
        $this->addForeignKey('FK_core_pages_gallery_id', '{{core_pages}}', 'gelery_id', '{{gallery}}', 'id', 'SET NULL', 'SET NULL');
        
        //Ограничения внешнего ключа таблицы `gallery_image`
        $this->addForeignKey('gallery_image_fk0', '{{gallery_image}}', 'gallery_id', '{{gallery}}', 'id', 'SET NULL', 'SET NULL');

        //Ограничения внешнего ключа таблицы `news`
        $this->addForeignKey('FK_news_gallery_id', '{{news}}', 'gelery_id', '{{gallery}}', 'id', 'SET NULL', 'SET NULL');
        $this->addForeignKey('FK_news_program_id', '{{news}}', 'program_id', '{{program}}', 'id', 'SET NULL', 'SET NULL');

        //Ограничения внешнего ключа таблицы `news_tag`
        $this->addForeignKey('FK_news_tag_news_id', '{{news_tag}}', 'news_id', '{{news}}', 'id', 'SET NULL', 'SET NULL');
        $this->addForeignKey('FK_news_tag_tags_id', '{{news_tag}}', 'tag_id', '{{tags}}', 'id', 'SET NULL', 'SET NULL');

        //Ограничения внешнего ключа таблицы `preview`
        $this->addForeignKey('FK_preview_news_id', '{{preview}}', 'news_id', '{{news}}', 'id', 'SET NULL', 'SET NULL');

        //Ограничения внешнего ключа таблицы `program`
        $this->addForeignKey('FK_program_ganre_id', '{{program}}', 'genre_id', '{{ganre}}', 'id', 'SET NULL', 'SET NULL');
        $this->addForeignKey('FK_program_preview_id', '{{program}}', 'preview_id', '{{preview}}', 'id', 'SET NULL', 'SET NULL');

        //Ограничения внешнего ключа таблицы `programs_timeline_program`
        $this->addForeignKey('programs_timeline_program_ibfk_1', '{{programs_timeline_program}}', 'program_id', '{{program}}', 'id', 'CASCADE', 'CASCADE');

        //Ограничения внешнего ключа таблицы `video`
        $this->addForeignKey('FK_video_news_id', '{{video}}', 'news_id', '{{news}}', 'id', 'SET NULL', 'SET NULL');
    }

    public function down()
    {
        $this->dropForeignKey('FK_baner_news_id', '{{baner}}');
        $this->dropForeignKey('fk_core_menu_pages_page_id', '{{core_menu_pages}}');
        $this->dropForeignKey('fk_core_menu_pages_type_id', '{{core_menu_pages}}');
        $this->dropForeignKey('FK_core_pages_gallery_id', '{{core_pages}}');
        $this->dropForeignKey('gallery_image_fk0', '{{gallery_image}}');
        $this->dropForeignKey('FK_news_gallery_id', '{{news}}');
        $this->dropForeignKey('FK_news_program_id', '{{news}}');
        $this->dropForeignKey('FK_news_tag_news_id', '{{news_tag}}');
        $this->dropForeignKey('FK_news_tag_tags_id', '{{news_tag}}');
        $this->dropForeignKey('FK_preview_news_id', '{{preview}}');
        $this->dropForeignKey('FK_program_ganre_id', '{{program}}');
        $this->dropForeignKey('FK_program_preview_id', '{{program}}');
        $this->dropForeignKey('programs_timeline_program_ibfk_1', '{{programs_timeline_program}}');
        $this->dropForeignKey('FK_video_news_id', '{{video}}');

        $this->dropTable('{{baner}}');
        $this->dropTable('{{core_menu_pages}}');
        $this->dropTable('{{core_pages}}');
        $this->dropTable('{{core_params}}');        
        $this->dropTable('{{core_type_menu}}');        
        $this->dropTable('{{gallery}}');        
        $this->dropTable('{{gallery_image}}');
        $this->dropTable('{{ganre}}');
        $this->dropTable('{{news}}');
        $this->dropTable('{{news_tag}}');        
        $this->dropTable('{{preview}}');        
        $this->dropTable('{{program}}');
        $this->dropTable('{{programs_timeline_program}}');
        $this->dropTable('{{tags}}');
        $this->dropTable('{{users_email}}');
        $this->dropTable('{{video}}');

    }
}
