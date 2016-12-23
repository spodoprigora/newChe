<?php

use frontend\modules\core\widgets\ActualProgramWidget\ActualProgramWidget;
use frontend\modules\core\widgets\AdvertisingWidget\AdvertisingWidget;
use frontend\modules\core\widgets\BanerAdvWidget\BanerAdvWidget;
use frontend\modules\core\widgets\BigSliderWidget\BigSliderWidget;
use frontend\modules\core\widgets\LastStoriesWidget\LastStoriesWidget;
use frontend\modules\core\widgets\MainBlockWidget\MainBlockWidget;
use frontend\modules\core\widgets\ShowProgramWidget\ShowProgramWidget;
use frontend\modules\core\widgets\SidebarAnnouncementWidget\SidebarAnnouncementWidget;
use frontend\modules\core\widgets\SidebarLastNewsWidget\SidebarLastNewsWidget;

/* @var $this yii\web\View */


?>

<!-- BIG SLIDER TOP -->

<?= BigSliderWidget::widget(); ?>

<!-- end big-slider-top -->

<!-- NEW ON TV -->

<?= LastStoriesWidget::widget(); ?>

<main class="container clear">

    <!-- BREAKING NEWS -->
	 <div class="breaking-news clear col-lg-8 col-md-8 col-sm-12">
         <?= MainBlockWidget::widget(); ?>

         <!-- COMMERCIAL BLOCK -->

         <?= AdvertisingWidget::widget()?>

         <!-- end commercial-block -->

         <!-- next news block -->

        <?= ShowProgramWidget::widget(['start' => 0, 'finish' => 3 ]); ?>


        <!-- CURRENT-PROGRAMS-SLIDER -->


        <?= ActualProgramWidget::widget();?>


        <?= ShowProgramWidget::widget(['start' => 3, 'finish' => null ]); ?>



    </div><!-- end breaking-news col-lg-8 col-md-8 col-sm-12 -->
	<!-- SIDEBAR -->

    <aside class="sidebar col-lg-4 col-md-4 col-sm-12">
        
        <?='' //BanerAdvWidget::widget()?>
        
        <!-- NEWS-SLIDER -->

        <?= SidebarLastNewsWidget::widget()?>

        <!-- ANNOUNCE-SLIDER -->

        <?= SidebarAnnouncementWidget::widget()?>
        
        <!-- EXCHANGE-RATE -->

        <div class="exchange-rate">
            <h1>Курсы валют</h1>
        </div><!-- end exchange-rate -->

        <!-- WEATHER -->

        <div class="weather">
            <h1>Погода</h1>
        </div><!-- end weather -->

        <!-- SOCIAL-NETWORK -->

        <div class="social-network">
            <h1>Социальные сети</h1>
        </div><!-- end social-network -->

    </aside>
	
</main>

<!-- MODAL-VIDEO -->


<div class="modal-video" id="modal-content">

</div><!-- end modal-video -->
