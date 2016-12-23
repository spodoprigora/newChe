<?php

    namespace common\models\program;

    use common\models\program\Ganre;
    use common\models\galery\Gallery;
    use common\models\galery\Preview;
    use common\models\news\News;
    use yii;

/**
 * This is the model class for table "program".
 *
 * @property integer $id
 * @property string $name_ua
 * @property string $name_ru
 * @property string $title_ua
 * @property string $title_ru
 * @property string $short_description_ua
 * @property string $short_description_ru
 * @property string $description_ua
 * @property string $description_ru
 * @property string $meta_title_ua
 * @property string $meta_title_ru
 * @property string $meta_keywords_ua
 * @property string $meta_keywords_ru
 * @property string $meta_description_ua
 * @property string $meta_description_ru
 * @property integer $active
 * @property integer $display_order
 * @property integer $is_public_rss
 * @property integer $is_main
 * @property integer $is_fact_news
 * @property integer $preview_id
 * @property integer $genre_id
 * @property News[] $news
 * @property Gallery $galery
 * @property Ganre $genre
 * @property Preview $preview
 */
class Program extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'program';
    }


    public function rules()
    {
        return [
            [
                [
                    'name_ua', 'name_ru',
                    'title_ua', 'title_ru',
                    'short_description_ua', 'short_description_ru',
                    'description_ua', 'description_ru',
                    'active',
                    'display_order',
                    'is_public_rss',
                ],
                'required'
            ],
            [
                [
                    'meta_title_ua', 'meta_title_ru',
                    'meta_keywords_ua', 'meta_keywords_ru',
                    'meta_description_ua', 'meta_description_ru',
                ], 
                'string'
            ],
            [
                [
                    'active', 
                    'display_order', 
                    'is_public_rss', 
                    'is_main', 
                    'preview_id', 
                    'genre_id',
                ],
                'integer'
            ],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ganre::className(), 'targetAttribute' => ['genre_id' => 'id']],
            [['preview_id'], 'exist', 'skipOnError' => true, 'targetClass' => Preview::className(), 'targetAttribute' => ['preview_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_ua' => 'Назва програми українською',
            'name_ru' => 'Название программы на русском',
            'title_ua' => 'Заголовок програми українською',
            'title_ru' => 'Заголовок программы на русском',
            'short_description_ua' => 'Короткий опис українською',
            'short_description_ru' => 'Краткое описание на русском',
            'description_ua' => 'Опис українською',
            'description_ru' => 'Описание на русском',
            'meta_title_ua' => 'Мета заголовок українською',
            'meta_title_ru' => 'Мета заголовок на русском',
            'meta_keywords_ua' => 'Ключові слова українською',
            'meta_keywords_ru' => 'Ключевые слова на русском',
            'meta_description_ua' => 'Мета опис українською',
            'meta_description_ru' => 'Мета описание на русском',
            'active' => 'Активировать программу',
            'display_order' => 'Порядок отображения',
            'is_public_rss' => 'Публиковать в Rss',
            'is_main' => 'Главная',
            'preview_id' => 'Превью',
            'genre_id' => 'Жанр программы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['program_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Ganre::className(), ['id' => 'genre_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreview()
    {
        return $this->hasOne(Preview::className(), ['id' => 'preview_id']);
    }

    /**
     * @return string
     */
    private function getPreviewUrl(){
        $preview = $this->preview;
        $url =$preview->getUrl();
        return $url;
    }

    /**
     * @return string
     */
    public function getSmallPreviewUrl(){
        $preview = $this->preview;
        if($preview){
            $url =$preview->getProgramSmallUrl();
        }
        else{
            $url ='';
        }
        return $url;
    }
}
