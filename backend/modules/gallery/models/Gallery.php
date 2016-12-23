<?php

namespace backend\modules\gallery\models;

use backend\modules\news\models\Helper;
use common\models\galery\Gallery as BaseGallery;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class Gallery extends BaseGallery
{

    public $photos;

    private $_uploadPath = 'img/gallery';
    private $_mediumDir = '/medium';
    private $_miniDir = '/mini';


    private $_mediumWidthImage = 400;
    private $_mediumHeightImage = 200;
    private $_miniWidthImage = 180;
    private $_miniHeightImage = 130;

    public $GalleryPhotos;

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['photos'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 20],
            ]
        );
    }

    

    public function saveGallery(){
        $this->save();

        $uploadPath   = $this->_uploadPath;
        $mediumDir    = $this->_mediumDir;
        $miniDir      = $this->_miniDir;

        $baseDir  = Yii::getAlias('@frontend/web');

        $this->GalleryPhotos= Yii::$app->request->post('GalleryPhotos');

        $files = UploadedFile::getInstances($this, 'photos');
        if($files){
            if (!is_dir($baseDir . '/' . $uploadPath)) {
                mkdir($baseDir . '/' . $uploadPath, 0777, TRUE);
            }

            if (!is_dir($baseDir . '/' . $uploadPath . $mediumDir)) {
                mkdir($baseDir . '/' . $uploadPath . $mediumDir, 0777, TRUE);
            }

            if (!is_dir($baseDir . '/' . $uploadPath . $miniDir)) {
                mkdir($baseDir . '/' . $uploadPath . $miniDir, 0777, TRUE);
            }


            foreach ($files as $key => $file){
                $galleryImage = new GalleryImage();

                $nameFile = $galleryImage->transliterate($file->baseName) . '.' . $file->extension;
                $mediumNameFile  = $galleryImage->transliterate($file->baseName) . '_medium' . '.' . $file->extension;
                $miniNameFile  = $galleryImage->transliterate($file->baseName) . '_mini' . '.' . $file->extension;

                if ($file->saveAs($baseDir . '/' . $uploadPath . '/' . $nameFile)) {
                    chmod($baseDir . '/' . $uploadPath . '/' . $nameFile, 0777);

                    Helper::image_resize($baseDir . '/' . $uploadPath . '/' . $nameFile, $baseDir . '/' . $uploadPath  . $mediumDir . '/' . $mediumNameFile, $this->_mediumWidthImage, $this->_mediumHeightImage, 100);
                    chmod($baseDir . '/' . $uploadPath  . $mediumDir . '/' . $mediumNameFile, 0777);

                    Helper::image_resize($baseDir . '/' . $uploadPath . '/' . $nameFile, $baseDir . '/' . $uploadPath  . $miniDir . '/' . $miniNameFile, $this->_miniWidthImage, $this->_miniHeightImage, 100);
                    chmod($baseDir . '/' . $uploadPath  . $miniDir . '/' . $miniNameFile, 0777);

                    $galleryImage->alt = $this->GalleryPhotos[$key]['image_alt'];
                    $galleryImage->description = $this->GalleryPhotos[$key]['image_desc'];
                    $galleryImage->gallery_id = $this->id;
                    $galleryImage->img_url = $nameFile;
                    $galleryImage->medium_img_url = $mediumNameFile;
                    $galleryImage->mini_img_url =$miniNameFile;

                    $galleryImage->save();
                    $this->GalleryPhotos[$key]['gallery_id'] = $galleryImage->id;

                }
            }

        }
    }

    public function updateGallery(){

       $this->deleteGaleryImage();

       $this->updateDescription();

        $this->saveGallery();
    }

    public function deleteGaleryImage(){
        $uploadPath   = $this->_uploadPath;
        $mediumDir    = $this->_mediumDir;
        $miniDir      = $this->_miniDir;

        $baseDir  = Yii::getAlias('@frontend/web');

        $deletedImages=[];
        $id=[];
        $temp = Yii::$app->request->post('GalleryPhotosOld');
        if($temp){
            foreach ($temp as $item){
                $id[] = $item['gallery_id'] . ', ';
            }
            $deletedImages = GalleryImage::find()
                            ->where(['not in', 'id', $id])
                            ->andWhere(['gallery_id'=> $this->id])
                            ->all();
        }else{
            $deletedImages = GalleryImage::find()
                            ->where(['gallery_id' => $this->id])
                            ->all();
        }



        //удаляем файлы
        foreach ($deletedImages as $item){
            if($item->img_url != null){
                $link = $item->img_url;
                $mainDir = $baseDir .'/'. $uploadPath;

                if($link && is_file($mainDir . '/' . $link) && is_writable($mainDir .'/' . $link)){
                    unlink($mainDir . '/' . $link);
                }
                $link = $item->medium_img_url;
                $mediumDir = $baseDir . '/' . $uploadPath  . $mediumDir;

                if($link && is_file($mediumDir . '/' . $link) && is_writable($mediumDir .'/' . $link)){
                    unlink($mediumDir . '/' . $link);
                }

                $link = $item->mini_img_url;
                $miniDir = $baseDir . '/'. $uploadPath .  $miniDir;
                if($link && is_file($miniDir . '/' . $link) && is_writable($miniDir .'/' . $link)){
                    unlink($miniDir . '/' . $link);
                }
            }
            $item->delete();
        }



        //GalleryImage::deleteAll('id NOT IN ' . $id . ' AND gallery_id = '. $this->id);

        //GalleryImage::deleteAll(['gallery_id' => $this->id]);
    }

    public function updateDescription(){
        $GalleryPhotosOld= Yii::$app->request->post('GalleryPhotosOld');
        foreach ($GalleryPhotosOld as $item){
            $galeryImage = GalleryImage::findOne($item['gallery_id']);
            $galeryImage->alt = $item['image_alt'];
            $galeryImage->description = $item['image_desc'];
            $galeryImage->save();
        }

    }
}