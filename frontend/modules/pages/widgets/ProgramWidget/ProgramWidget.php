<?php
    namespace frontend\modules\pages\widgets\ProgramWidget;
   
use common\models\program\Program;
use yii\base\Widget;

class ProgramWidget extends Widget{

    public $language;
    public $program_id;

    public function Run(){
        $programs = Program::find()
            ->where(['is_main' => '0'])
            ->all();


        return $this->render('programs', ['programs'=> $programs, 'curent_id'=> $this->program_id, 'language'=> $this->language]);

    }


}