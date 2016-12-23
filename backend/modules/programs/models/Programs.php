<?php

namespace backend\modules\programs\models;

use common\models\galery\Preview;


use yii;
use common\models\program\Program as BaseProgram;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class Programs extends BaseProgram
{
    private $_uploadPath = 'img/programs/big_preview';
    private $_smallUploadPath = 'img/programs/small_preview';

    public $previewFile;
    public $smallPreviewFile;

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [

                [['previewFile', 'smallPreviewFile'], 'image'],

            ]
        );
    }

    public function getGenre()
    {
       return  Ganre::find()->where(['id' => $this->genre_id])->one();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->meta_title_ua = $this->title_ua;
            $this->meta_title_ru = $this->title_ru;
            $this->meta_description_ua = $this->short_description_ua;
            $this->meta_description_ru = $this->short_description_ru;
            return true;
        }

        return false;
    }

    public function beforeDelete()
    {
        $this->deletePreview();

        return true;

    }

    public function deletePreview($type = null)
    {
        $preview = $this->preview;
        $uploadPath = $this->_uploadPath;
        $smallUploadPath = $this->_smallUploadPath;
        $baseDir = Yii::getAlias('@frontend/web/') . $uploadPath;
        $smallBaseDir = Yii::getAlias('@frontend/web/') . $smallUploadPath;

        if ($preview) {
            $dataUrl = unserialize($preview->url);
            if($type == 'big'){
                $dataUrl = unserialize($preview->url);

                if($dataUrl[ 'big' ] != '' && $dataUrl[ 'small' ] != ''){
                    if ($dataUrl[ 'big' ] && is_file($baseDir . '/' . $dataUrl[ 'big' ]) && is_writable($baseDir . '/' . $dataUrl[ 'big' ])) {
                        unlink($baseDir . '/' . $dataUrl[ 'big' ]);
                    }
                    $dataUrl['big'] ='';
                    $preview->url = serialize($dataUrl);
                    $preview->save();
                    return true;

                }else if($dataUrl[ 'big' ] != '' && $dataUrl[ 'small' ] == ''){
                    if ($dataUrl[ 'big' ] && is_file($baseDir . '/' . $dataUrl[ 'big' ]) && is_writable($baseDir . '/' . $dataUrl[ 'big' ])) {
                        unlink($baseDir . '/' . $dataUrl[ 'big' ]);
                    }
                    $preview->delete();
                    return true;
                }
            }else if($type =='small'){


                if($dataUrl[ 'small' ] != '' && $dataUrl[ 'big' ] != ''){
                    if ($dataUrl[ 'small' ] && is_file($smallBaseDir . '/' . $dataUrl[ 'small' ]) && is_writable($smallBaseDir . '/' . $dataUrl[ 'small' ])) {
                        unlink($smallBaseDir . '/' . $dataUrl[ 'small' ]);
                    }
                    $dataUrl['small'] ='';
                    $preview->url = serialize($dataUrl);
                    $preview->save();
                    return true;

                }else if($dataUrl[ 'small' ] != '' && $dataUrl[ 'big' ] == ''){
                    if ($dataUrl[ 'small' ] && is_file($smallBaseDir . '/' . $dataUrl[ 'small' ]) && is_writable($smallBaseDir . '/' . $dataUrl[ 'small' ])) {
                        unlink($smallBaseDir . '/' . $dataUrl[ 'small' ]);
                    }
                    $preview->delete();
                    return true;
                }
            }

           //полное удаление
            if(is_null($type)){
                if ($dataUrl[ 'big' ] && is_file($baseDir . '/' . $dataUrl[ 'big' ]) && is_writable($baseDir . '/' . $dataUrl[ 'big' ])) {
                    unlink($baseDir . '/' . $dataUrl[ 'big' ]);
                }
                if ($dataUrl[ 'small' ] && is_file($smallBaseDir . '/' . $dataUrl[ 'small' ]) && is_writable($smallBaseDir . '/' . $dataUrl[ 'small' ])) {
                    unlink($smallBaseDir . '/' . $dataUrl[ 'small' ]);
                }
                $preview->delete();
                return true;
            }

        }
        return false;
    }

    public function savePreview(Preview $preview)
    {
        $file             = UploadedFile::getInstance($this, 'previewFile');
        $smallFile        = UploadedFile::getInstance($this, 'smallPreviewFile');

        $uploadPath       = $this->_uploadPath;
        $smallUploadPath = $this->_smallUploadPath;

        $baseDir  = Yii::getAlias('@frontend/web');

        if($preview->url != ''){
            $preview->news_id = null;
            $dataUrl = unserialize($preview->url);
        }
        else{
            $dataUrl = ['big' => '', 'small' => ''];
        }


        if ($file) {
            $this->deletePreview('big');

            $nameFile = $preview->transliterate($file->baseName) . '.' . $file->extension;
            if (!is_dir($baseDir . '/' . $uploadPath)) {
                mkdir($baseDir . '/' . $uploadPath, 0777, TRUE);
            }

            if ($file->saveAs($baseDir . '/' . $uploadPath . '/' . $nameFile)) {
                chmod($baseDir . '/' . $uploadPath . '/' . $nameFile, 0777);
                $dataUrl[ 'big' ] = $nameFile;
            }
        }
        if($smallFile){
            $this->deletePreview('small');
            $nameFile = $preview->transliterate($smallFile->baseName) . '.' . $smallFile->extension;
            if (!is_dir($baseDir . '/' . $smallUploadPath)) {
                mkdir($baseDir . '/' . $smallUploadPath, 0777, TRUE);
            }
            if ($smallFile->saveAs($baseDir . '/' . $smallUploadPath . '/' . $nameFile)) {
                chmod($baseDir . '/' . $smallUploadPath . '/' . $nameFile, 0777);
                $dataUrl[ 'small' ] = $nameFile;

            }

        }
        $preview->url = ($dataUrl[ 'big' ] || $dataUrl[ 'small' ]) ? serialize($dataUrl) : NULL;

        $preview_description = Yii::$app->request->post('Preview');
        $preview->alt_ru = $preview_description['alt_ru'];
        $preview->alt_ua = $preview_description['alt_ua'];
        $preview->title_ru = $preview_description['title_ru'];
        $preview->title_ua = $preview_description['title_ua'];

        if(is_null($preview->url)){
            $this->addError('previewFile', 'Необходимо выбрать превью');
            $this->addError('smallPreviewFile', 'Необходимо выбрать превью');
            return false;
        }else{
            $dataUrl = unserialize($preview->url);
            if($dataUrl['big'] == ''){
                $this->addError('previewFile', 'Необходимо выбрать превью');
                return false;
            }
            if($dataUrl['small'] == ''){
                $this->addError('smallPreviewFile', 'Необходимо выбрать превью');
                return false;
            }
            if($preview->save()){
                $this->preview_id = $preview->id;
                return true;
            }
            else
                return false;
        }
    }

    public function getListTimelineType()
    {
        return [
            'every-day'   => 'Каждый день',
            'every-week'  => 'Каждую неделю',
            'custom-time' => 'Произвольная дата',
        ];
    }

    public function getListTimelineDays()
    {
        return [
            '1' => 'Понедельник',
            '2' => 'Вторник',
            '3' => 'Среда',
            '4' => 'Четверг',
            '5' => 'Пятница',
            '6' => 'Суббота',
            '7' => 'Воскресенье',
        ];
    }

    public function getTimeline()
    {
        return $this->hasMany(TimelineProgram::className(), ['program_id' => 'id']);
    }
   
    



}