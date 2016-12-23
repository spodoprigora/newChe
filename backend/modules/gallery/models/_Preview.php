<?php

namespace backend\modules\gallery\models;

use yii;
use common\models\galery\Preview as BasePreview;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class Preview extends BasePreview
{
   

    public function rules()
    {
        return [
            [['alt_ua', 'alt_ru', 'title_ua', 'title_ru'], 'required'],
            [['alt_ua', 'alt_ru', 'title_ua', 'title_ru'], 'string', 'max' => 255],
            [['url'], 'image',  'extensions' => 'png, jpg' ],
        ];
    }


   public function beforeValidate()
    {
        $file = UploadedFile::getInstance($this, 'url');
        if($file){
            return parent::beforeValidate();
        }
        $this->addError('url', 'Изображение не выбранно');
        return false;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Изображение',
            'alt_ua' => 'Alt на украинском',
            'alt_ru' => 'Alt на русском',
            'title_ua' => 'Title на украинском',
            'title_ru' => 'Title на русском',
           
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
        );
        return strtr($st, $converter);
    }
    
}