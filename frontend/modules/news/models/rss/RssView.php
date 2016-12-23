<?php


namespace frontend\modules\news\models\rss;


use yii\helpers\ArrayHelper;

class RssView extends \Zelenin\yii\extensions\Rss\RssView
{

    public function init()
    {
        parent::init();
        $this->feed=new Feed();
    }

    public function renderChannel()
    {
        $this->getFeed()->addChannel(ArrayHelper::getValue($this->channel, 'link'));
        foreach ($this->channel as $element => $value) {
            if (is_array($value) && !isset($value['content'])) {
                foreach ($value as $el)
                    $this->addChannelElement($element, $el);
            }
            else
                $this->addChannelElement($element, $value);
        }
    }

    private function addChannelElement($element, $value) {
        if (is_string($value)) {
            $this->getFeed()->addChannelElement($element, $value);
        }
        elseif (is_array($value)) {
            $this->getFeed()->addChannelElement($element, $value['content'],$value['attribute']);
        } else {
            $result = call_user_func($value, $this, $this->getFeed());
            if (is_string($result) || is_array($result)) {
                $this->getFeed()->addChannelElement($element, $result);
            }
        }
    }

    public function renderItem($model)
    {
        $this->getFeed()->addItem();
        foreach ($this->items as $element => $value) {
            if (is_string($value)) {
                if (is_string($element)) {
                    $this->getFeed()->addItemElement($element, $value);
                } else {
                    $this->getFeed()->addItemElement($value, ArrayHelper::getValue($model, $value));
                }
            } else {
                $result = call_user_func($value, $model, $this, $this->getFeed());
                if (is_string($result) || is_array($result)) {
                    $this->getFeed()->addItemElement($element, $result);
                }
            }
        }
    }
}