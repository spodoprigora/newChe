<?php

namespace backend\modules\news\models;

use yii;
use common\models\news\News as BaseNews;
use yii\helpers\ArrayHelper;
use backend\modules\news\models\Program;
use backend\modules\gallery\models\Preview;
use yii\web\UploadedFile;
use tpmanc\imagick\Imagick;


class News extends BaseNews
{

    const TIMESTAMP_ONE_HOUR = 3600;

    public $tagsRu;
    public $tagsUa;
    public $previewFile;
    public $videoFile;

    private $_uploadPath = 'img/news/preview';
    private $_uploadVideoPath = 'video';
    private $_widthImage = 180;
    private $_heightImage = 130;

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['tagsRu', 'tagsUa'], 'safe'],
                [['previewFile'], 'image'],
                [['videoFile'], 'file',  'extensions' => ['mpeg', 'mp4'] ],
            ]
        );
    }

    public function getListType()
    {
        return [
            'text'  => 'Текстовая новость',
            'video' => 'Видео новость',
        ];
    }

    public function getListTimeAdversting()
    {
        return [
            self::TIMESTAMP_ONE_HOUR + time()           => '1 час',
            self::TIMESTAMP_ONE_HOUR * 2  + time()      => '2 часа',
            self::TIMESTAMP_ONE_HOUR * 24 + time()      => '1 день',
            self::TIMESTAMP_ONE_HOUR * 24 * 7 + time()  => '1 неделя',
        ];
    }

    public function getTagsRu()
    {
        $data = [];

        $tags = $this->getTags()->where(['lang' => 'ru'])->all();

        foreach ($tags as $tag) {
            $data[] = $tag->name;
        }

        return $data;
    }

    public function getTagsUa()
    {
        $data = [];
        
        $tags = $this->getTags()->where(['lang' => 'ua'])->all();

        foreach ($tags as $tag) {
            $data[] = $tag->name;
        }

        return $data;
    }

    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])
            ->viaTable(NewsTag::tableName(), ['news_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!is_int($this->date_news)) {
                $this->date_news    = str_replace('/', '-', $this->date_news);
                $this->date_news    = strtotime($this->date_news);
            }
            if (!is_int($this->announcement_date)) {
                $this->announcement_date   = str_replace('/', '-', $this->announcement_date);
                $this->announcement_date    = strtotime($this->announcement_date);
            }
            if($this->translate_ru == 0){
                $this->title_ru = $this->title_ua;
                $this->short_description_ru = $this->short_description_ua;
                $this->description_ru = $this->description_ua;
            }
            $this->meta_title_ua = $this->title_ua;
            $this->meta_title_ru = $this->title_ru;
            $this->meta_description_ua = $this->short_description_ua;
            $this->meta_description_ru = $this->short_description_ru;
            $this->saveTimeAdversting();



            return TRUE;
        }

        return FALSE;
    }

    public function afterSave()
    {
        $this->saveTags();
    }

    public function beforeDelete()
    {
        $this->deletePreview();
        $this->deleteVideo();
        return true;

    }

    public function isHasBigPreview()
    {
        $preview = $this->preview;

        if (!$preview) {
            return FALSE;
        }

        $dataUrl = unserialize($preview->url);

        if (!$preview->url || !$dataUrl[ 'big' ]) {
            return FALSE;
        }

        return TRUE;
    }

    public function getBigPreview()
    {
        $preview = $this->preview;
        $dataUrl = unserialize($preview->url);

        return '/' . $this->_uploadPath . '/' . $dataUrl[ 'big' ];
    }

    private function saveTimeAdversting()
    {
        if (!$this->is_advertising) {
            $this->advertising_time = 0;
        }

        if (!$this->is_primary) {
            $this->primary_time = 0;
        }
    }

    private function saveTags()
    {

        $listTags = ArrayHelper::map($this->newsTags, 'tag_id', 'id');

        //print_r($this->tagsRu);
        //exit;

        if ($this->tagsRu && is_array($this->tagsRu)) {
            foreach ($this->tagsRu as $nameTag) {
                $tag = Tags::find()
                                ->where(['name' => $nameTag])
                                ->andWhere(['lang' => 'ru'])
                                ->one();

                if (!$tag) {
                    $tag = new Tags();
                    $tag->name = $nameTag;
                    $tag->lang = 'ru';
                    $tag->save();
                }

                if (!isset($listTags[ $tag->id ])) {

                    $link = new NewsTag();
                    $link->news_id = $this->id;
                    $link->tag_id = $tag->id;
                    $link->save();

                } else {
                    unset($listTags[ $tag->id ]);
                }
            }
        }

        if ($this->tagsUa && is_array($this->tagsUa)) {
            foreach ($this->tagsUa as $nameTag) {

                $tag = Tags::find()
                                ->where(['name' => $nameTag])
                                ->andWhere(['lang' => 'ua'])
                                ->one();

                if (!$tag) {
                    $tag = new Tags();
                    $tag->name = $nameTag;
                    $tag->lang = 'ua';
                    $tag->save();
                }

                if (!isset($listTags[ $tag->id ])) {

                    $link = new NewsTag();
                    $link->news_id = $this->id;
                    $link->tag_id = $tag->id;
                    $link->save();

                } else {
                    unset($listTags[ $tag->id ]);
                }
            }
        }

        foreach ($listTags as $idTag) {
            $model = NewsTag::findOne($idTag);
            $model->delete();
        }
    }

    public function saveVideo(Video $video){
        $oldType = $this->getOldAttribute('type');
        if($oldType == 'text'){
            $this->deletePreview();
        }


        if($video->youtube_link != null){
            $video->news_id = $this->id;
            if($video->save()){
                return true;
            }else{
                return false;
            }
        }
        else{
            $uploadVideoPath       = $this->_uploadVideoPath;
            $file = UploadedFile::getInstance($this, 'videoFile');
            if($file){
                $this->deleteVideo();
                $nameFile = $video->transliterate($file->baseName) . '.' . $file->extension;
                $baseDir  = Yii::getAlias('@frontend/web');
                if (!is_dir($baseDir . '/' . $uploadVideoPath)) {
                    mkdir($baseDir . '/' . $uploadVideoPath, 0777, TRUE);
                }
                if ($file->saveAs($baseDir . '/' . $uploadVideoPath . '/' . $nameFile)) {
                    chmod($baseDir . '/' . $uploadVideoPath . '/' . $nameFile, 0777);
                }
                $video->link = $nameFile;
                $video->news_id =$this->id;
                if($video->save()) {
                    return true;
                }
                else {
                    $video->validate();
                    return false;
                }
            }
            else{
                if(!$video->validate()){
                    //$this->delete();
                    return false;
                }
                return true;
            }

        }
    }

    public function savePreview(Preview $preview)
    {
        $oldType = $this->getOldAttribute('type');
        if($oldType == 'video'){
            $this->deleteVideo();
        }


        $file             = UploadedFile::getInstance($this, 'previewFile');
        $preview->news_id = $this->id;
        $uploadPath       = $this->_uploadPath;
        $thumbsDir        = $uploadPath . '/thumbs';

        if ($file) {

            $this->deletePreview();

            $dataUrl = ['big' => '', 'small' => ''];

            $nameFile = $preview->transliterate($file->baseName) . '.' . $file->extension;
            $thumbFile = $preview->transliterate($file->baseName) . '.jpg'; 
            $baseDir  = Yii::getAlias('@frontend/web');

            if (!is_dir($baseDir . '/' . $uploadPath)) {
                mkdir($baseDir . '/' . $uploadPath, 0777, TRUE);
            }

            if ($file->saveAs($baseDir . '/' . $uploadPath . '/' . $nameFile)) {
                chmod($baseDir . '/' . $uploadPath . '/' . $nameFile, 0777);
                $dataUrl[ 'big' ] = $nameFile;

                if (!is_dir($baseDir . '/' . $thumbsDir)) {
                    mkdir($baseDir . '/' . $thumbsDir, 0777, TRUE);
                }

                Helper::image_resize($baseDir . '/' . $uploadPath . '/' . $nameFile, $baseDir . '/' . $thumbsDir . '/' . $thumbFile, $this->_widthImage, $this->_heightImage, 100);

                //$img = Imagick::open($baseDir . '/' . $uploadPath . '/' . $nameFile)->resize($this->_widthImage, $this->_heightImage)->saveTo($baseDir . '/' . $thumbsDir . '/' . $nameFile);

                $dataUrl[ 'small' ] = $thumbFile;
                chmod($baseDir . '/' . $thumbsDir . '/' . $thumbFile, 0777);

                $preview->url = ($dataUrl[ 'big' ] || $dataUrl[ 'small' ]) ? serialize($dataUrl) : NULL;
            }

        }

        if($preview->save())
            return true;
        else
            return false;

    }

    public function getPreview()
    {
        return $this->hasOne(Preview::className(), ['news_id' => 'id']);
    }

    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['news_id' => 'id']);
    }

    public function deletePreview()
    {
        $preview = $this->preview;
        $uploadPath = $this->_uploadPath;

        if ($preview) {
            $dataUrl = unserialize($preview->url);
            $baseDir = Yii::getAlias('@frontend/web/') . $uploadPath;

            if ($dataUrl[ 'big' ] && is_file($baseDir . '/' . $dataUrl[ 'big' ]) && is_writable($baseDir . '/' . $dataUrl[ 'big' ])) {
                unlink($baseDir . '/' . $dataUrl[ 'big' ]);
            }

            if ($dataUrl[ 'small' ] && is_file($baseDir . '/thumbs/' . $dataUrl[ 'small' ]) && is_writable($baseDir . '/thumbs/' . $dataUrl[ 'small' ])) {
                unlink($baseDir . '/thumbs/' . $dataUrl[ 'small' ]);
            }
            $preview->delete();
        }

    }

    public function deleteVideo(){
        $video = $this->video;
        $uploadPath = $this->_uploadVideoPath;

        if($video){
             if($video->link != null){
                 $link = $video->link;
                 $baseDir = Yii::getAlias('@frontend/web/') . $uploadPath;

                 if($link && is_file($baseDir . '/' . $link) && is_writable($baseDir . '/' . $link)){
                     unlink($baseDir . '/' . $link);
                 }
             }
            $video->delete();
        }
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(
            parent::attributeLabels(),
            [
                'tagsRu' =>'Теги на русском',
                'tagsUa' => 'Теги українською'
            ]);
      
    }
}