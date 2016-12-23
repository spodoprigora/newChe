<?php

namespace backend\modules\news\models;

use yii;
use common\models\news\Video as BaseVideo;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class Video extends BaseVideo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['youtube_link', 'link'], 'string', 'max' => 255],
                ['youtube_link', 'match', 'pattern' => '/^[\w-]*$/i', 'message' => 'Некорректная ссылка на видео']
            ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'youtube_link' => 'Youtube ссылка',
            'link' => 'Видео',
        ];
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

    public function beforeValidate()
    {
       if (parent::beforeValidate()) {
            if($this->youtube_link != null || $this->link != null )
                return true;
       }
      

        
       $this->addError('youtube_link', 'Не выбрано видео для новости');
       return false;
    }

}