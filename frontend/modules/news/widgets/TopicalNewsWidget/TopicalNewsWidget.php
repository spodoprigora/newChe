<?php
namespace frontend\modules\news\widgets\TopicalNewsWidget;

use common\models\news\NewsTag;
use frontend\modules\news\models\News;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class TopicalNewsWidget extends Widget
{

    public $model;
    public $language;

    public function run()
    {

        $news = $this->model->getNewsWithTags($this->language);
        return $this->render('index', ['models' => $news, 'language' => $this->language]);
    }

}