<?php
namespace frontend\modules\pages\widgets\FbCommentWidget;

use yii\base\Widget;
use yii\helpers\Html;

class FbCommentWidget extends Widget
{

    public $appId;
    public $limitComments;
    public $clientOptions;

    public $classBlockComments = 'fb-comments';
    
    private $_fbApiUrl = '//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.8';
    private $_view;



    public function init()
    {

        if (!$this->appId || !$this->classBlockComments) {
            throw new \yii\web\BadRequestHttpException();
        }

        $this->_view = $this->getView();

        echo Html::tag('div', NULL, ['id' => 'fb-root']);

        if (!$this->clientOptions || !isset($this->clientOptions[ 'data-numposts' ])) {
            $this->clientOptions[ 'data-numposts' ] = ($this->limitComments) ? $this->limitComments : 5;
        }

        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';

        $this->clientOptions[ 'data-href' ] =  $protocol . '://' . $_SERVER[ 'SERVER_NAME' ];
        $this->clientOptions[ 'class' ] = $this->classBlockComments;

        $this->_view->registerJs('(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "' . $this->_fbApiUrl . '&appId=' . $this->appId . '";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));');
    }

    public function run()
    {

        echo Html::tag('div', NULL, $this->clientOptions);

    }

}
?>