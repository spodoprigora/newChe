<?php
    use frontend\modules\core\widgets\SidebarAnnouncementWidget\SidebarAnnouncementWidget;
    use frontend\modules\core\widgets\SidebarLastNewsWidget\SidebarLastNewsWidget;
use frontend\modules\news\widgets\SliderWidget\SliderWidget;

?>



    <main class="container info-page clear">

        <div class="col-lg-8 col-md-8 col-sm-12 clear">
            <section class="info-page-post">
                <?= $page->{'content_' . $lang}; ?>
            </section>

            <?= SliderWidget::widget(['model' => $page]); ?>
        </div><!-- end col-lg-8 col-md-8 col-sm-12 -->

        <!-- SIDEBAR -->

        <aside class="sidebar col-lg-4 col-md-4 col-sm-12">
           <!-- <section class="live">
                <h2>Новый Чернигов <span>|</span> <span>LIVE</span></h2>
                <video src="video/video-1.mp4" ></video>
            </section>-->

            <!-- NEWS-SLIDER -->

            <?= SidebarLastNewsWidget::widget()?>

            <!-- ANNOUNCE-SLIDER -->

            <?= SidebarAnnouncementWidget::widget()?>

            <!-- EXCHANGE-RATE -->
        </aside>

    </main>

<!-- MODAL-VIDEO -->


<div class="modal-video" id="modal-content">

</div><!-- end modal-video -->