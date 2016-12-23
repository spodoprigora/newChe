<?php

namespace common\models\galery;

use Yii;
use common\models\news\News;
use common\models\program\Program;

/**
 * This is the model class for table "preview".
 *
 * @property integer $id
 * @property integer $news_id
 * @property string $url
 * @property string $alt_ua
 * @property string $alt_ru
 * @property string $title_ua
 * @property string $title_ru
 *
 * @property News $news
 * @property Program[] $programs
 */
class Preview extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'preview';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['news_id'], 'integer'],
            [['url', 'alt_ua', 'alt_ru', 'title_ua', 'title_ru'], 'string', 'max' => 255],
            //[['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'news_id' => 'News ID',
            'url' => 'Url',
            'alt_ua' => 'Альтернативний текст українською',
            'alt_ru' => 'Альтернативный текст на русском',
            'title_ua' => 'Заголовок українською',
            'title_ru' => 'Заголовок на русском',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrograms()
    {
        return $this->hasMany(Program::className(), ['preview_id' => 'id']);
    }

    public function getProgramBigUrl(){
        $temp_array =unserialize($this->url);
        if($temp_array['big'] !='')
            return '/img/programs/big_preview/'.$temp_array['big'];
        return '';
    }
    public function getProgramSmallUrl(){
        $temp_array =unserialize($this->url);
        if($temp_array['small'] !='')
            return '/img/programs/small_preview/'.$temp_array['small'];
        return '';
    }

    public function transliterate($st) {
        $converter = array(
            'а' => 'a',   'б' => 'b',   'в' => 'v',
            'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
            'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n',
            'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u',
            'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
            'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
            'і' => 'i',   'ї' => 'yi',  "'" => '',
            "`" => '',

            'А' => 'A',   'Б' => 'B',   'В' => 'V',
            'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
            'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N',
            'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U',
            'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
            'Ь' => '\'',  'Ы' => 'Y',   'Ъ' => '\'',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
            'І' => 'I',   'Ї' => 'YI',
        );
        return $str=iconv("UTF-8","UTF-8//IGNORE",strtr($st, $converter));
    }
}