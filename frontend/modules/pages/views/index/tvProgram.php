<?php
use frontend\modules\core\widgets\SidebarAnnouncementWidget\SidebarAnnouncementWidget;
use frontend\modules\pages\widgets\PopularWidget\PopularWidget;
use frontend\modules\pages\widgets\ProgramWidget\ProgramWidget;
use frontend\modules\pages\widgets\TvShowWidget\TvShowWidget;
?>

<!-- *********** PROGRAMS start *********** -->

<main class="container programs-wrap clear">

    <!-- PROGRAMS -->

    <div class="programs clear col-lg-8 col-md-8 col-sm-12">
        <?php if($language == 'ru'):?>
            <h1>Телепрограма</h1>
        <?php else: ?>
            <h1>Телепрограма</h1>
        <?php endif;?>

        <?php $days = ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'нд']; ?>

        <ul class="week clear">
            <?php foreach ($days as $key => $day):?>
                <?php if($curentDay == ($key+1) ):?>
                    <li class="day selected-day" data-day='day-<?= $key+1;?>' >
                        <span class="day-week"><?= $day;?></span><br>
                        <span class=" day-date"><?= date('d.m.Y', $monday +(60*60*24)* $key+1)?></span>
                    </li>
                <?php else: ?>
                    <li class="day" data-day='day-<?= $key+1;?>' >
                        <span class="day-week"><?= $day;?></span><br>
                        <span class=" day-date"><?= date('d.m.Y', $monday +(60*60*24)* $key+1)?></span>
                    </li>
                <?php endif; ?>
            <?php endforeach;?>
        </ul>

        <?= TvShowWidget::widget(['language' => $language, 'type' =>'big']); ?>
        
      
        <!-- CURRENT-PROGRAMS-SLIDER -->

        
        <?= PopularWidget::widget(['language'=>$language])?>
        
        

    </div><!-- end programs col-lg-8 col-md-8 col-sm-12 -->

    <!-- SIDEBAR -->

    <aside class="sidebar col-lg-4 col-md-4 col-sm-12">

        <!-- PROGRAM-TOPICS -->

        <?= ProgramWidget::widget(['language'=> $language])?>


        <!-- ANNOUNCE-SLIDER -->

        <?= SidebarAnnouncementWidget::widget();?>

        <div class="clear"></div>

        
        <!-- SOCIAL-NETWORK -->

        <div class="social-network">
            <h1>Социальные сети</h1>
        </div><!-- end social-network -->

    </aside>

</main>
<div class="modal-video" id="modal-content">

</div><!-- end modal-video -->

<!-- *********** PROGRAMMA end *********** -->
