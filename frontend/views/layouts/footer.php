<?php
    use frontend\modules\core\widgets\SubscribeWidget\SubscribeWidget;
    use frontend\modules\core\widgets\MenuWidget\MenuWidget;
?>

<!-- FOOTER -->
<footer>
    <div class="footer-bar-bg">
        <div class="footer-bar container clear">
            <div class="col-lg-6 col-md-4 col-sm-3 col-xs-12">
                <a href="" class="logo"><img src="/img/logo-new-che.png" alt="Новый Чернигов лого"></a>
            </div><!-- end col-lg-6 col-md-4 col-sm-3 col-xs-12 -->
            <?= SubscribeWidget::widget();?>
        </div><!-- end footer-bar container -->
    </div><!-- end footer-bar-bg -->
    <div class="footer-bg">
        <div class="footer container clear">
            <?= MenuWidget::widget(['typeMenu' => 'bottom', 'template' => 'bottom']); ?>
           
            <?= MenuWidget::widget(['typeMenu' => 'bottom1', 'template' => 'bottom1']); ?>

           
            <div class="footer-text col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <p>Всі права захищені &copy; Телекомпанія «Новий Чернігів» 2009-2016</p>
                <p>При копіюванні і рерайті матеріалів гіперпосилання на сайт «Новий Чернігів» обов'язкове. Передрук в газетах і електронних ЗМІ — виключно за наявності письмової угоди з Редакцією!</p>
                <table>
                    <tr>
                        <td>E-mail редакції: <span>info@newch.tv</span></td>
                        <td>Тел.: <span>+38 (0422) 672 699</span></td>
                    </tr>
                    <tr>
                        <td class="social">
                            <a class="inst" href=""></a>
                            <a class="fb" href=""></a>
                            <a class="goo" href=""></a>
                            <a class="twit" href=""></a>
                            <a class="you" href=""></a>
                            <a class="pin" href=""></a>
                        </td>
                        <td class="author">Created by <a href="">AIK Socialism</a></td>
                    </tr>
                </table>
                <div class="xs-only">
                    <p>E-mail редакції: <span>info@newch.tv</span></p>
                    <p>Тел.: <span>+38 (0422) 672 699</span></p>
                    <p class="social">
                        <a class="inst" href=""></a>
                        <a class="fb" href=""></a>
                        <a class="goo" href=""></a>
                        <a class="twit" href=""></a>
                        <a class="you" href=""></a>
                        <a class="pin" href=""></a>
                    </p>
                    <p class="author">Created by <a href="">AIK Socialism</a></p>
                </div><!-- end xs-only -->
            </div><!-- end footer-text col-lg-6 col-md-6 -->
        </div><!-- end footer container -->
    </div><!-- end footer-bg -->
    <div class="statistics container">

    </div><!-- end statistics container -->
</footer>