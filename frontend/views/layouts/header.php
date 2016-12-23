<?php
    use frontend\modules\core\widgets\MenuWidget\MenuWidget;
    use yii\bootstrap\Html;
    use yii\helpers\Url;

    $session = Yii::$app->session;
    $session->open();
    if ($session->has('lang')){
        $language = $session['lang'];
    }
    else{
        $language ='ua';
    }

?>

<!-- TOP BAR -->
<div class="top-bar-bg">
    <header class="container clear">
        <div class="top-bar">
            <a href="<?= Url::to(['/']); ?>" class="logo">
                <img src="<?='/img/logo-new-che.png'; ?>" alt="Новый Чернигов лого">
                <h1 style="display: none;">новый чернигов</h1>
            </a>
            <div class="language">
                <?php if($language =='ru'):?>
                    <?= Html::a('ua', ['/core/index/lang', 'lang' => 'ua']) ?>
                    <?= Html::a('ru', ['/core/index/lang', 'lang' => 'ru'], ['class' => 'language-selected']) ?>
                <?php else:?>
                    <?= Html::a('ua', ['/core/index/lang', 'lang' => 'ua'], ['class' => 'language-selected']) ?>
                    <?= Html::a('ru', ['/core/index/lang', 'lang' => 'ru']) ?>
                <?php endif;?>
            </div><!-- end language -->
            <nav class="main-menu">

               <?= MenuWidget::widget(['typeMenu' => 'top', 'template' => 'main']); ?>

            </nav>

            <?= Html::beginForm(['/search'], 'get', ['class' => 'search']) ?>
                <?= Html::input('text', 'query_string',  '', ['placeholder' => $language == 'ru'? 'поиск': 'пошук']) ?>
                <?= Html::submitButton('') ?>
            <?= Html::endForm() ?>


            <!-- HAMBURGER -->
                <?= MenuWidget::widget(['typeMenu' => 'top', 'template' => 'main_hamburger']); ?>
            
            
        </div><!-- end top-bar -->
    </header>
</div> <!-- end top-bar-bg -->