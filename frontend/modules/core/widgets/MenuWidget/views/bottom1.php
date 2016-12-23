<?php
    use yii\helpers\Url;

    $language ='ua';
    $session = Yii::$app->session;
    $session->open();
    if ($session->has('lang') && $session['lang'] == 'ru' ){
        $language ='ru';
    }
?>

<ul class="footer-nav footer-nav-menu col-lg-3 col-md-2 col-sm-6 col-xs-6">
   <?php foreach ($menus as  $menu) : ?>
            <li><a href='<?= Url::toRoute($menu['full_uri']) ?>' ><?= $menu['header_'. $language] ?></a></li>
    <?php endforeach; ?>
</ul>
