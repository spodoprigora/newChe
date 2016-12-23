<?php
namespace frontend\modules\pages\widgets\VkCommentWidget;

use yii\base\Widget;
use yii\helpers\Html;

class VkCommentWidget extends Widget
{

    public $apiId;
    public $limitComments;
    public $clientOptions;
    public $initOptions;

    public $idBlockComments = 'vk_comments';
    
    private $_vkOpenApiUrl = '//vk.com/js/api/openapi.js?136';
    private $_view;

    public function init()
    {
        if (!$this->apiId || !$this->idBlockComments) {
            throw new \yii\web\BadRequestHttpException();
        }

        $this->_view = $this->getView();

        if (!$this->clientOptions || !isset($this->clientOptions[ 'limit' ])) {
            $this->clientOptions[ 'limit' ] = ($this->limitComments) ? $this->limitComments : 10;
        }

        $this->initOptions[ 'apiId' ] = $this->apiId;

        $this->_view->registerJsFile($this->_vkOpenApiUrl);
    }

    public function run()
    {
        $this->_view->registerJs('VK.init(' . json_encode($this->initOptions) . ');');

        echo Html::tag('div', NULL, ['id' => $this->idBlockComments]);

        $this->_view->registerJs('VK.Widgets.Comments("' . $this->idBlockComments . '", ' . json_encode($this->clientOptions) . ');');

    }

}
?>