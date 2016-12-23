<?php

namespace backend\modules\programs\models;

use Yii;
use common\models\program\TimelineProgram as BaseTimelineProgram;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class TimelineProgram extends BaseTimelineProgram
{

    public $smallPreviewFile;
    private $_smallUploadPath = 'img/programs/small_preview';


    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                [['smallPreviewFile'], 'image'],
            ]
        );
    }

    public function getFormElements()
    {
        $att ='';
        if ($this->days) {
            $this->days = explode(',', $this->days);
        }
        if($this->tv_show_preview !=''){
            $att .='<div class="row">
                        <div class="col-lg-4">
                            <img class="img-responsive" src="/' .$this->_smallUploadPath . '/' . $this->tv_show_preview .'" alt="">
                            
                        </div>
                    </div>
                    <br>
                    <br>';
        }

        return [

            'program_id' => [
                                'type' => 'widget',
                                'nameWidget' => '\kartik\select2\Select2',
                                'attributes' => [

                                    'data' => ArrayHelper::map(Programs::find()->where(['<>', 'id', '4'])->all(), 'id', 'name_ru'),
                                    'options' => [
                                        'prompt' => 'Выберите программу',
                                    ],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]
                            ],
            'tv_show' =>  ['type' => 'textInput'],
            'tv_show_preview' =>  [
                                        'type' => 'preview',
                                        'attributes'=> [
                                            'html'=> $att
                                        ]
                                  ],
            'time'       => [
                                'type' => 'widget',
                                'nameWidget' => '\kartik\time\TimePicker',
                                'attributes' => [
                                    'pluginOptions' => [
                                        'minuteStep' => 5,
                                        'showMeridian' => FALSE,
                                    ],
                                ],
                            ],
            'date'       => [
                                'type' => 'widget',
                                'nameWidget' => 'yii\jui\DatePicker',
                                'attributes' => [
                                    'options' => [
                                        'class' => 'form-control',
                                    ],
                                    'language' => 'ru',
                                    'dateFormat' => 'yyyy-MM-dd',
                                ],
                            ],
            'type'       => [
                                'type' => 'widget',
                                'nameWidget' => '\kartik\select2\Select2',
                                'attributes' => [
                                    'data' => $this->getListType(),
                                    'options' => [
                                        'prompt' => 'Выберите временной тип для программы',
                                    ]
                                ]
                            ],
            'days'       => [
                                'type' => 'widget',
                                'nameWidget' => '\kartik\select2\Select2',
                                'attributes' => [
                                    'data' => $this->getListDays(),
                                    'options' => [
                                        'multiple' => TRUE,
                                        'prompt' => 'Выберите дни',
                                        'id' => 'day-id',
                                    ]
                                ]
                            ],

        ];
    }

    public function beforeValidate()
    {
        if ($this->type === 'every-week' && empty($this->days)) {
            $this->addError('days', 'Вы должны выбрать день программы');
            return FALSE;
        }
        if($this->type ==='custom' && empty($this->date)){
            $this->days = null;
            $this->addError('date', 'Вы должны указать дату');
            return FALSE;
        }

        if($this->tv_show != '' ){
            if($this->savePreview()){
                return true;
            }
            $this->addError('tv_show_preview', 'Вы должны загрузить первью');
            return false;
        }
        return true;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            switch ($this->type) {
                case 'every-day':
                    $this->days = implode(',', range(1, 7));
                    $this->date = null;
                    break;
                case 'weekdays':
                    $this->days = implode(',', range(1, 5));
                    $this->date = null;
                    break;
                case 'every-week':
                    $this->days = implode(',', $this->days);
                    $this->date = null;
                    break;
                case 'custom':
                    $this->days = null;
                    break;
                default:
                    break;
            }

            if(!$this->isNewRecord && $this->tv_show != '' && $this->tv_show_preview !=''){
                $this->deletePreview();
            }
            return TRUE;
        }

        return FALSE;
    }

    public function savePreview(){
        $baseDir  = Yii::getAlias('@frontend/web');
        $smallFile        = UploadedFile::getInstance($this, 'tv_show_preview');
        if ($smallFile) {
            $nameFile = $this->transliterate($smallFile->baseName) . '.' . $smallFile->extension;

            if (!is_dir($baseDir . '/' . $this->_smallUploadPath)) {
                mkdir($baseDir . '/' . $this->_smallUploadPath, 0777, TRUE);
            }
            if ($smallFile->saveAs($baseDir . '/' . $this->_smallUploadPath . '/' . $nameFile)) {
                chmod($baseDir . '/' . $this->_smallUploadPath . '/' . $nameFile, 0777);
                $this->tv_show_preview =$nameFile;
                return true;
            }
        }
        else{
            if($this->getOldAttribute('tv_show_preview')){
                $this->tv_show_preview =   $this->getOldAttribute('tv_show_preview');
                return true;
            }
            return false;
        }
        return false;
    }

    public function deletePreview(){
        $baseDir  = Yii::getAlias('@frontend/web');
        if($this->tv_show != '' && $this->tv_show_preview !='' && $this->isAttributeChanged('tv_show_preview')){
            $previewPath = $this->getOldAttribute('tv_show_preview');
            $path =$baseDir . '/' . $this->_smallUploadPath . '/' .$previewPath;
            if (is_file($path) && is_writable($path)) {
                unlink($path);
            }

        }
    }

    public function getViewAttributes()
    {
        return ['id', 'program_id', 'tv_show','tv_show_preview','date', 'time', 'type'];
    }

    public function getListDays()
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

    public function getListType()
    {
        return [
            'every-day'   => 'Каждый день',
            'weekdays'    => 'По будням',
            'every-week'  => 'Каждую неделю',
            'custom'      => 'Произвольная дата',
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

}