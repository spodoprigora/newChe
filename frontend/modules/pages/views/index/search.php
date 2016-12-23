<?php

    use frontend\modules\core\widgets\SidebarAnnouncementWidget\SidebarAnnouncementWidget;
use frontend\modules\core\widgets\SidebarLastNewsWidget\SidebarLastNewsWidget;
use yii\widgets\LinkPager;

?>

<!-- *********** ALL NEWS start *********** -->

<main class="container all-news clear">

    <!-- BREAKING NEWS -->

    <div class="breaking-news clear col-lg-8 col-md-8 col-sm-12">
        <div class="title">
            <?php if($language == 'ru'):?>
                <h1>Результаты поиска</h1>
            <?php else: ?>
                <h1>Результати пошуку</h1>
            <?php endif;?>
        </div><!-- end title-line -->
        <?php if(empty($news)):?>
            <div class="title-line"></div>
            <?php if($language == 'ru'):?>
                <p class="result">Извините. По Вашему запросу ничего не найдено.</p>
                
            <?php else: ?>
                <p class="result">Вибачте. За Вашим запитом нічого не знайдено.</p>

            <?php endif;?>

        <?php endif;?>

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
                <?= $this->render('search_section', ['item' => $item, 'language' => $language]); ?>
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
                <?= $this->render('search_section', ['item' => $item, 'language' => $language]); ?>
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
                <?= $this->render('search_section', ['item' => $item, 'language' => $language]); ?>
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
                <?= $this->render('search_section', ['item' => $item, 'language' => $language]); ?>
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
        <!-- <section class="live">
             <h2>Новый Чернигов <span>|</span> <span>LIVE</span></h2>
             <video controls>
                 <source src="" type="video/mp4">
             </video>
         </section>-->

        <?= SidebarLastNewsWidget::widget();?>

        <!-- ANNOUNCE-SLIDER -->

        <?= SidebarAnnouncementWidget::widget();?>
    </aside>

</main>
<div class="modal-video" id="modal-content">

</div><!-- end modal-video -->


<!-- *********** ALL NEWS end *********** -->
