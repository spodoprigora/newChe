<?php

namespace frontend\modules\core\widgets\BanerAdvWidget;

use common\models\galery\Preview;
use common\models\news\News;
use common\models\news\Video;
use common\models\program\Program;
use yii\base\Widget;
use yii\helpers\ArrayHelper;


class BanerAdvWidget extends Widget
{
    private $news_array;

    public function run()
    {



        return $this->render('baner');
    }
}