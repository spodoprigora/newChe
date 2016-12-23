<?php
namespace frontend\modules\core\components;

use common\models\core\Pages;
use Yii;
use yii\web\Request;
use yii\helpers\Url;


class FrontRequest extends Request
{

    private $_url;

    protected function resolveRequestUri()
    {
        if ($this->_url === null) {
            $this->_url = parent::resolveRequestUri();
        }

        $session            = Yii::$app->session;
        Yii::$app->language = ($session->has('lang')) ? $session->get('lang') : 'ua';
        

        $request_uri = parse_url($this->_url);
        $request_uri = $request_uri['path'];

        if ($request_uri != '/' && substr($request_uri, -1, 1) == '/') {
            // удаляем слэш в конце
            $request_uri = substr($request_uri, 0, -1);
        }

        $page = Pages::find()
                          ->where(['full_uri' => $request_uri])
                          ->andWhere(['active'=> '1'])
                          ->one();

        if (!$page) {
            return $this->_url;
        }

        if ($page->module === 'core') {
            Yii::$app->params[ 'page' ] = $page;
        }

        return $page->route;
    }

}