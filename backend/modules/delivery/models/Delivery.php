<?php
namespace backend\modules\delivery\models;



use backend\modules\core\models\CoreParams;
use common\models\core\UsersEmail;
use Swift_SwiftException;
use yii;
use yii\base\Model;

class Delivery extends Model
{
    public $emails;
    public $params;


    public function rules()
    {
        return [
            [['emails', 'params'], 'required', 'message'=>'Поле не может быть пустым'],
        ];
    }
    
    public function Send(){
        //config SwiftMailler
        $host = CoreParams::find()->where(['code'=>'smtp_host'])->one();
        $admin_email = CoreParams::find()->where(['code' => 'email'])->one();
        $password = CoreParams::find()->where(['code' => 'password'])->one();
        $port = CoreParams::find()->where(['code' => 'port'])->one();
        $encription = CoreParams::find()->where(['code' => 'encryption'])->one();
        $name = explode('@', $admin_email->value)[0];

        if($host && $admin_email && $password && $port && $encription && $name){
            Yii::$app->mailer->messageConfig = [
                'from' => [$admin_email->value => $name],
            ];
            Yii::$app->mailer->transport = [
                'class' => 'Swift_SmtpTransport',
                'host' =>  $host->value,
                'username' => $name,
                'password' => $password->value,
                'port' => $port->value,
                'encryption' => $encription->value,

            ];
            $params = CoreParams::findOne($this->params);
            $emails = UsersEmail::find()
                ->where(['in', 'id', $this->emails])
                ->all();
            if($emails && $params && $params->value !=''){
                $text = $params->value;
                $from = $admin_email->value;
                $messages = [];
                foreach ($emails as $item){
                    $messages[] = Yii::$app->mailer->compose()
                        ->setCharset('utf-8')
                        ->setFrom($from)
                        ->setSubject('Новий Чернігів')
                        ->setHtmlBody($text)
                        ->setTo($item->email);
                }
                try {
                    $res = Yii::$app->mailer->sendMultiple($messages);
                }
                 catch (Swift_SwiftException $e) {
                    return $e->getMessage();
                 }


                if($res>0){
                    return $res;
                }
            }
        }
        return false;
    }

}