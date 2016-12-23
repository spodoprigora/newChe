<?php
namespace frontend\modules\news\widgets\TagWidget;

use yii\base\Widget;

class TagWidget extends Widget
{

    public $model;
    public $language;

    public function run()
    {
        if($tags = $this->model->getTags($this->language)){
            return $this->render('index', ['tags' => $tags]);
        }

        return false;

    }

}