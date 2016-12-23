<?php

use frontend\modules\core\widgets\SidebarAnnouncementWidget\SidebarAnnouncementWidget;
use yii\widgets\LinkPager;
$name['name_ua'] = 'Факт новини';
$name['name_ru'] = 'Факт новости';
$type = false;
$id = 'calendar';

?>

<!-- *********** ALL NEWS start *********** -->

<main class="container all-news clear">

    <!-- BREAKING NEWS -->

    <div class="breaking-news clear col-lg-8 col-md-8 col-sm-12">
        <div class="title">

            <?php if(isset($arhiv)):?>
                <?php if($language == 'ru'):?>
                    <h1>Архив</h1>
                <?php else: ?>
                    <h1>Архив</h1>
                <?php endif;?>

                <?php $program = null; $type = true; $id = 'arhiv_calendar'; ?>
            <?php else: ?>
                <?php if(isset($anons)):?>
                    <?php if($language == 'ru'):?>
                        <h1>Анонсы</h1>
                    <?php else: ?>
                        <h1>Анонси</h1>
                    <?php endif;?>
                    <?php $program = null; $type = true; $id = 'anons_calendar';?>
                <?php else:?>
                    <h1><?= $program ? $program['name_'. $language]: $name['name_'. $language]?></h1>
                <?php endif;?>
            <?php endif;?>




            <a href="" id='archive' class="see-all">Архив</a>
        </div><!-- end title-line -->

        <?php if(!empty($news['today'])):?>
            <div class="title-line"></div>
            <div class="date">
                <?php if($language =='ru'):?>
                    <?=$today; ?><span class="line">Сегодня</span>
                <?php else:?>
                    <?=$today; ?><span class="line">Сьогодні</span>
                <?php endif;?>
            </div>
            <?php foreach ($news['today'] as $item):?>
               <?= $this->render('section', ['item' => $item, 'program' => $program, 'language' => $language, 'type' => $type]); ?>
            <?php endforeach;?>
        <?php endif; ?>


        <?php if(!empty($news['yesterday'])):?>
            <div class="title-line"></div>
            <div class="date">
                <?php if($language =='ru'):?>
                    <?=$yesterday; ?><span class="line">Вчера</span>
                <?php else:?>
                    <?=$yesterday; ?><span class="line">Вчора</span>
                <?php endif;?>
            </div><!-- end date -->
            <?php foreach ($news['yesterday'] as $item):?>
                <?= $this->render('section', ['item' => $item, 'program' => $program, 'language' => $language, 'type' => $type]); ?>
            <?php endforeach;?>
        <?php endif; ?>


        <?php if(!empty($news['in_mounth'])):?>
            <div class="title-line"></div>
            <div class="date">
                <?php if($language =='ru'):?>
                    <span>В этом месяце</span>
                <?php else:?>
                    <span>В цьому місяці</span>
                <?php endif;?>
            </div><!-- end date -->
                <?php foreach ($news['in_mounth'] as $item):?>
                    <?= $this->render('section', ['item' => $item, 'program' => $program, 'language' => $language, 'type' => $type]); ?>
                <?php endforeach;?>
        <?php endif; ?>

        <?php if(!empty($news['earlier'])):?>
            <div class="title-line"></div>
            <div class="date">
                <?php if($language =='ru'):?>
                    <span>Ранее</span>
                <?php else:?>
                    <span>Раніше</span>
                <?php endif;?>
            </div><!-- end date -->
                <?php foreach ($news['earlier'] as $item):?>
                    <?= $this->render('section', ['item' => $item, 'program' => $program, 'language' => $language, 'type' => $type]); ?>
                <?php endforeach;?>
        <?php endif;?>


        <div class="clear"></div><!-- end clear -->

        <?php if($language =='ru'):?>
            <?= LinkPager::widget([
                'maxButtonCount' => 5,
                'pagination' => $pages,
                'lastPageLabel' => 'ПОСЛЕДНЯЯ',
                'firstPageLabel' => 'ПЕРВАЯ',
                'nextPageLabel' => 'СЛЕДУЮЩАЯ',
                'prevPageLabel' => 'ПРЕДЫДУЩАЯ',
            ]);?>
        <?php else:?>
            <?= LinkPager::widget([
                'maxButtonCount' => 5,
                'pagination' => $pages,
                'lastPageLabel' => 'ОСТАННЯ',
                'firstPageLabel' => 'ПЕРША',
                'nextPageLabel' => 'НАСТУПНА',
                'prevPageLabel' => 'ПОПЕРЕДНЯ',
            ]);?>
        <?php endif;?>
    </div><!-- end breaking-news col-lg-8 col-md-8 col-sm-12 -->


    <!-- SIDEBAR -->

    <aside class="sidebar col-lg-4 col-md-4 col-sm-12">
        <?php $class= $showCalendar? '' : 'hidden'; ?>
        <section class="calendar-wrap <?= $class; ?>">
            <h1>Архив</h1>
            <div id="<?= $id?>" data-program="<?= $program ? $program->id: null ?>"  data-day="<?= $setCalendarDate; ?>" >
            </div><!-- end calendar -->
        </section>
       <!-- <section class="live">
            <h2>Новый Чернигов <span>|</span> <span>LIVE</span></h2>
            <video controls>
                <source src="" type="video/mp4">
            </video>
        </section>-->

        <!-- ANNOUNCE-SLIDER -->

        <?= SidebarAnnouncementWidget::widget()?>
        <br>
    </aside>

</main>
<div class="modal-video" id="modal-content">

</div><!-- end modal-video -->


<!-- *********** ALL NEWS end *********** -->
