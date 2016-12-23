<?php
    namespace frontend\modules\pages\widgets\TvShowWidget;

    use common\models\program\Program;
    use common\models\program\TimelineProgram;
    use yii\base\Widget;
    use yii\helpers\ArrayHelper;

    class TvShowWidget extends Widget{

        public $language;
        public $tvPrograms =[];
        public $program_id;
        public $type;
       
        public function Run(){
            $now = time();
            $monday =  strtotime("Monday this week");
            $curentDay =  date("w", time()) == 0 ? 7: date("w", time()) ;

            $startWeek = date('Y.m.d', $monday);
            $endWeek = date('Y.m.d', $monday+(60*60*24*7)-1 );
            //выдернуть программу на неделю

            //получаем ежедневные программы
            $timeline= TimelineProgram::find()
                        ->where(['type' => 'every-day'])
                        ->all();
            foreach ($timeline as $item){
                $count=7;

                $time = substr($item->time, 0, -3);
                $program = $item->program;

                for($i =1; $i<=$count; $i++){
                    if(!is_null($program) && $program != ''){
                        $this->tvPrograms[$i][$time]['name_ua'] =$program->name_ua;
                        $this->tvPrograms[$i][$time]['name_ru'] =$program->name_ru;
                        $this->tvPrograms[$i][$time]['image'] = $program->getSmallPreviewUrl();
                    }
                    else{
                        $this->tvPrograms[$i][$time]['name_ua'] =$item->tv_show;
                        $this->tvPrograms[$i][$time]['name_ru'] =$item->tv_show;
                        $this->tvPrograms[$i][$time]['image'] = '/img/programs/small_preview/'.$item->tv_show_preview;
                    }
                }

            }

            //получаем будничные программы
            $timeline= TimelineProgram::find()
                ->where(['type' => 'weekdays'])
                ->all();

            foreach ($timeline as $item){
                $count=5;
                $time = substr($item->time, 0, -3);
                $program = $item->program;
                for($i =1; $i<=$count; $i++){
                    if(!is_null($program) && $program != '') {
                        $this->tvPrograms[$i][$time]['name_ua'] = $program->name_ua;
                        $this->tvPrograms[$i][$time]['name_ru'] = $program->name_ru;
                        $this->tvPrograms[$i][$time]['image'] = $program->getSmallPreviewUrl();
                    }
                    else{
                        $this->tvPrograms[$i][$time]['name_ua'] =$item->tv_show;
                        $this->tvPrograms[$i][$time]['name_ru'] =$item->tv_show;
                        $this->tvPrograms[$i][$time]['image'] = '/img/programs/small_preview/'.$item->tv_show_preview;
                    }

                }
            }

            //получаем недельные программы
            $timeline= TimelineProgram::find()
                ->where(['type' => 'every-week'])
                ->all();
            foreach ($timeline as $item){

                $time = substr($item->time, 0, -3);
                $program = $item->program;
                $days = explode(',', $item->days);
                foreach ($days as $day){
                    if(!is_null($program) && $program != '') {
                        $this->tvPrograms[$day][$time]['name_ua'] = $program->name_ua;
                        $this->tvPrograms[$day][$time]['name_ru'] = $program->name_ru;
                        $this->tvPrograms[$day][$time]['image'] = $program->getSmallPreviewUrl();
                    }
                    else{
                        $this->tvPrograms[$day][$time]['name_ua'] =$item->tv_show;
                        $this->tvPrograms[$day][$time]['name_ru'] =$item->tv_show;
                        $this->tvPrograms[$day][$time]['image'] = '/img/programs/small_preview/'.$item->tv_show_preview;
                    }
                }
            }

            //получаем кастомные программы за эту неделю
            $timeline= TimelineProgram::find()
                ->where(['type' => 'custom'])
                ->andWhere(['between', 'date', $startWeek, $endWeek])
                ->all();
            foreach ($timeline as $item){
                $time = substr($item->time, 0, -3);
                $program = $item->program;
                $day = date("w", strtotime($item->date));
                if($day == 0){
                    $day = 7;
                }
                if(!is_null($program) && $program != ''){
                    $this->tvPrograms[$day][$time]['name_ua'] =$program->name_ua;
                    $this->tvPrograms[$day][$time]['name_ru'] =$program->name_ru;
                    $this->tvPrograms[$day][$time]['image'] = $program->getSmallPreviewUrl();
                }
                else{
                    $this->tvPrograms[$day][$time]['name_ua'] =$item->tv_show;
                    $this->tvPrograms[$day][$time]['name_ru'] =$item->tv_show;
                    $this->tvPrograms[$day][$time]['image'] = '/img/programs/small_preview/'.$item->tv_show_preview;
                }

            }

            foreach($this->tvPrograms as &$day){
                ksort($day);
            }

            if($this->type =='big'){
                return $this->render('big', ['language' => $this->language,
                    'tvPrograms' => $this->tvPrograms,
                    'curentDay' => $curentDay]);
                
            }
            
            if(empty($this->program_id)){
                return $this->render('tv', ['language'=> $this->language,
                    'monday' => $monday,
                    'tvPrograms' =>$this->tvPrograms,
                    'curentDay' =>$curentDay]);
            }
            else{
                $program = Program::findOne($this->program_id);
                foreach($this->tvPrograms as &$day){
                    foreach ($day as $key => $time){
                        if($time['name_ua'] != $program->name_ua){
                            unset($day[$key]);
                        }
                    }
                }
               return $this->render('see', ['language' => $this->language,
                     'tvPrograms' => $this->tvPrograms,
                     'curentDay' => $curentDay]);
            }
        }


    }