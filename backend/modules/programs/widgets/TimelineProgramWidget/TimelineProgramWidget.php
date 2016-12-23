<?php
namespace backend\modules\programs\widgets\TimelineProgramWidget;

use yii\base\Widget;

class TimelineProgramWidget extends Widget
{

    public $program;

    public function init()
    {
        TimelineAsset::register($this->getView());
    }

    public function run()
    {
        $timelineRelations = $this->program->timeline;
        $dataTimeline = [
            'program' => NULL,
            'items'   => [],
        ];

        $dataTimeline[ 'program' ] = $this->program;

        foreach ($this->program->timeline as $timeline) {
            
            $dataTimeline[ 'items' ][ $timeline->type_program ][ 'time' ][]         = $timeline->time;

            if ($timeline->type_program !== 'every-day') {
                $dataTimeline[ 'items' ][ $timeline->type_program][ 'days' ][] = $timeline->day;
            }
        }

        return $this->render('index', [
            'dataTimeline' => $dataTimeline,
        ]);
    }

}
?>