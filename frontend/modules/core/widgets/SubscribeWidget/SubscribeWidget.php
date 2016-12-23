<?php
    namespace frontend\modules\core\widgets\SubscribeWidget;

    use common\models\core\UsersEmail;
    use yii\base\Widget;

class SubscribeWidget extends Widget
{
    public function run(){
        $model = new UsersEmail();
        return $this->render('form', ['model'=> $model]);
    }
 }