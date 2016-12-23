<?php

namespace backend\modules\baner\models;


use backend\modules\news\models\News;
use yii;
use common\models\pages\Baner as BaseBaner;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;


class Baner extends BaseBaner
{
    private $_uploadPath = 'img/baners';

    public $uploadImage;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['img_link', 'active'], 'required'],
            [['news_id', 'order', 'active'], 'integer'],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
            [['title_ua', 'title_ru', 'description_ua', 'description_ru'], 'string'],
            [['uploadImage'], 'image' ],
        ];
    }




    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'news_id' => 'Ид новости',
            'order' => 'Порядок',
            'img_link' => 'Картинка',
            'active' => 'Активный',
            'title_ua' => 'Заголовок українською',
            'title_ru' => 'Заголовок на русском',
            'description_ua' => 'Короткий опис українською',
            'description_ru' => 'Краткое описание на русском',
        ];
    }

    public function deleteBaner(){
        $uploadPath = $this->_uploadPath;
        $baseDir = Yii::getAlias('@frontend/web/') . $uploadPath;
        if ($this->img_link && is_file($baseDir . '/' . $this->img_link) && is_writable($baseDir . '/' . $this->img_link)) {
            unlink($baseDir . '/' . $this->img_link);
        }

    }

    public function saveBaner(){
        $uploadPath       = $this->_uploadPath;

        $file = UploadedFile::getInstance($this, 'uploadImage');
        if($file){

            $this->deleteBaner();

            $nameFile = $this->transliterate($file->baseName) . '.' . $file->extension;
            $baseDir  = Yii::getAlias('@frontend/web');

            if (!is_dir($baseDir . '/' . $uploadPath)) {
                mkdir($baseDir . '/' . $uploadPath, 0777, TRUE);
            }

            if ($file->saveAs($baseDir . '/' . $uploadPath . '/' . $nameFile)) {
                chmod($baseDir . '/' . $uploadPath . '/' . $nameFile, 0777);
            }

            $this->img_link = $nameFile;



        }
        if($this->save())
            return true;
        return false;
        
    }

    private function transliterate($st) {
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