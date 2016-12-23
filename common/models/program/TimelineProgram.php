<?php

namespace common\models\program;


use Yii;

/**
 * This is the model class for table "programs_timeline_program".
 *
 * @property integer $id
 * @property integer $program_id
 * @property string $tv_show
 * @property string $date
 * @property string $time
 * @property string $type
 * @property string $days
 */
class TimelineProgram extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'programs_timeline_program';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['program_id', 'time', 'type'], 'required'],
            [['time', 'type'], 'required'],
            [['program_id'], 'integer'],
            [['date', 'time'], 'safe'],
            [['type', 'tv_show', 'tv_show_preview'], 'string'],
            //[['days'], 'string', 'max' => 255],
            [['program_id'], 'exist', 'skipOnError' => true, 'targetClass' => Program::className(), 'targetAttribute' => ['program_id' => 'id']],
            [['days'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Ид',
            'program_id' => 'Программа',
            'tv_show' => 'Передача',
            'tv_show_preview' => 'Превью передачи (114x91)',
            'date' => 'Дата',
            'time' => 'Время',
            'type' => 'Тип',
            'days' => 'Дни',
        ];
    }

    public function getProgram()
    {
        return $this->hasOne(Program::className(), ['id' => 'program_id']);
    }
    
    public static function getTvProgramDate($numDay, $language){
        $monday =  strtotime("Monday this week");
        $temp = date('d m', $monday + ($numDay * 60*60*24 -1));
        $temp = explode(' ', $temp);

        if($language =='ru'){
            switch ($temp[1]){
                case 1: $m='января'; break;
                case 2: $m='февраля'; break;
                case 3: $m='марта'; break;
                case 4: $m='апреля'; break;
                case 5: $m='мая'; break;
                case 6: $m='июня'; break;
                case 7: $m='июля'; break;
                case 8: $m='августа'; break;
                case 9: $m='сентября'; break;
                case 10: $m='октября'; break;
                case 11: $m='ноября'; break;
                case 12: $m='декабря'; break;
            }
        }
        else{
            switch ($temp[1]){
                case 1: $m='січня'; break;
                case 2: $m='лютого'; break;
                case 3: $m='березня'; break;
                case 4: $m='квітня'; break;
                case 5: $m='травня'; break;
                case 6: $m='червня'; break;
                case 7: $m='липня'; break;
                case 8: $m='серпня'; break;
                case 9: $m='вересня'; break;
                case 10: $m='жовтня'; break;
                case 11: $m='листопада'; break;
                case 12: $m='грудня'; break;
            }
        }
        return $temp[0] . '&nbsp;'. $m.'&nbsp;';
    }
}
