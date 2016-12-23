<?php
use frontend\modules\core\widgets\SidebarAnnouncementWidget\SidebarAnnouncementWidget;
use frontend\modules\core\widgets\SidebarLastNewsWidget\SidebarLastNewsWidget;
use frontend\modules\news\widgets\SliderWidget\SliderWidget;
use frontend\modules\news\widgets\TagWidget\TagWidget;
use frontend\modules\news\widgets\TopicalNewsWidget\TopicalNewsWidget;
?>
<main class="container news-page clear">
    <div class="news-post-wrap clear col-lg-8 col-md-8 col-sm-12">
        <div class="title-line">
          <h1><?= $model->{'title_' . $language}; ?></h1>
        </div><!-- end title-line -->
        <div class="post-date">
            <?= $model->getDate($language); ?>
        </div><!-- end post-date -->
        <div class="news-post">
            <figure class="figure-1">
                <?php if($model['type'] == 'text'):?>
                    <?php if($preview = $model->getPreview()):?>
                        <figure class="video">
                            <img src="<?= $preview->getBigUrl();?>"  alt="<?= $preview['alt_'. $language]?>" title="<?= $preview['title_'. $language]?>">
                        </figure>
                    <?php endif; ?>
                <?php else:?>
                    <?php if($video = $model->getVideo()):?>
                        <?php if(!empty($video->youtube_link)):?>
                            <figure class="video">
                                <div data-type="youtube" data-video-id="<?= $video->youtube_link;?>"></div>
                            </figure>
                        <?php else: ?>
                            <figure  class="video">
                                <video poster="" controls>
                                    <source src="<?= $video->getUrl(); ?>" type="video/mp4"></source>
                                </video>
                            </figure>
                        <?php endif; ?>
                    <?php endif;?>
                <?php endif;?>
                <figcaption>
                    <?= $model->{"short_description_" . $language}; ?>
                </figcaption>
            </figure>
            <div class="text">

                <?= $model->{"description_" . $language}; ?>

                <!-- NEWS-POST-SLIDER -->

                <?= SliderWidget::widget(['model' => $model]); ?>

                <?= TagWidget::widget(['model' => $model, 'language' => $language]); ?>
                

        </div><!-- end text -->
      </div><!-- end news-post -->

      <!-- TOPICAL-NEWS -->

      <?= TopicalNewsWidget::widget(['model' => $model, 'language' => $language]); ?>
      
    </div><!-- end news-post-wrap col-lg-8 col-md-8 col-sm-12 -->

    <!-- SIDEBAR -->

    <aside class="sidebar col-lg-4 col-md-4 col-sm-12">
      <!--<section class="live">
        <h2>Новый Чернигов <span>|</span> <span>LIVE</span></h2>
        <video src="video/video-1.mp4" ></video>
      </section>-->
        <?= SidebarLastNewsWidget::widget();?>

        <?= SidebarAnnouncementWidget::widget()?>
        <div class="clear"></div>
        <br>
    </aside>

</main>
<div class="modal-video" id="modal-content">

</div><!-- end modal-video -->