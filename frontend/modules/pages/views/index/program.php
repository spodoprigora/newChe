<?php

use frontend\modules\pages\widgets\ProgramWidget\ProgramWidget;
use frontend\modules\pages\widgets\LastNewsWidget\LastNewsWidget;
use frontend\modules\pages\widgets\ProjectNewsWidget\ProjectNewsWidget;
use frontend\modules\pages\widgets\SeeWidget\SeeWidget;
use frontend\modules\pages\widgets\TvShowWidget\TvShowWidget;
use yii\bootstrap\Html;

?>

<!-- BROADCAST-HEADER -->

<div class="broadcast-header clear">
    <figure>
        <?php if($preview = $program->preview):?>
            <?= Html::img($preview->getProgramBigUrl(), ['alt' => $preview->{'alt_' . $language}, 'title' => $preview->{'title_' . $language} ]) ?>
        <?php endif;?>

        <figcaption>
            <div class="container">
                <?= $program->{'name_' . $language}?>
            </div><!-- end container -->
        </figcaption>
    </figure>
    <div class="container about-broadcast clear">
        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
            <table >
                <tr>
                    <td>Жанр:</td>
                    <?php if($genre = $program->genre):?>
                        <td><?= $genre->{'name_' . $language}?></td>
                    <?php endif;?>

                </tr>
                <tr>

                    <?= TvShowWidget::widget(['language' => $language, 'program_id' => $program->id]); ?>
                </tr>
            </table>
        </div><!-- end col-lg-4 col-md-5 col-sm-5 col-xs-12 -->
        <div class="col-lg-8 col-md-7 col-sm-7 col-xs-12">
            <p><?= $program->{'short_description_'. $language}?></p>

            <?= Html::a('Архив', [''], ['class' => 'see-all arhiv', 'id'=> 'archive']) ?>
        </div><!-- end col-lg-8 col-md-7 col-sm-7 col-xs-12 -->
    </div><!-- end container -->
</div><!-- end broadcast-header -->

<main class="container clear">

    <!-- BROADCAST -->

    <div class="broadcast news-post col-lg-8 col-md-8 col-sm-12">
        <div class="text">
           <?= $program->{'description_' . $language}?>
        </div><!-- end text -->

        <div class="social-comments">
            <div class="comments-btn">
                <span id="vk-btn">Вконтакте</span>
                <span id="fb-btn">Facebook</span>
            </div><!-- end comments-btn -->
            <div class="vk-comments">
            
                <?= \frontend\modules\pages\widgets\VkCommentWidget\VkCommentWidget::widget([
                    'apiId' => 5723102
                ]); ?>

            </div><!-- end vk-comments -->
            <div class="fb-comments">

                <?= \frontend\modules\pages\widgets\FbCommentWidget\FbCommentWidget::widget([
                    'appId' => 1157837294281208,
                    'clientOptions' => [
                        'data-width' => '100%'
                    ]
                ]); ?>

            </div><!-- end fb-comments -->
        </div><!-- end social-comments -->

        <!-- CURRENT-PROGRAMS-SLIDER -->


        <?= LastNewsWidget::widget(['program_id' =>$program->id, 'language' => $language]); ?>


    </div><!-- end broadcast news-post col-lg-8 col-md-8 col-sm-12 -->

    <!-- SIDEBAR -->

    <aside class="sidebar col-lg-4 col-md-4 col-sm-12">
        <section class="calendar-wrap hidden">
            <h1>Архив</h1>
            <div id="program_calendar" data-program="<?=$program->id?>" data-day="<?= $setCalendarDate; ?>" data-now="<?= $now?>">
            </div><!-- end calendar -->
        </section>

        <!-- PROGRAM-TOPICS -->

        <?= ProgramWidget::widget(['program_id' =>$program->id, 'language' => $language]); ?>
       

        <!-- NEWS-SLIDER -->

        <?= ProjectNewsWidget::widget(['program_id' => $program->id, 'language' => $language]); ?>
        
        <div class="clear"></div>

        <!-- TV-PROGRAM -->

        <section>

            <?= TvShowWidget::widget(['language' => $language]); ?>
            <div class="social-network">
                <h1>Социальные сети</h1>
            </div><!-- end social-network -->
        </section>

    </aside>

</main>
<div class="modal-video" id="modal-content">

</div><!-- end modal-video -->

<!-- *********** PEREDACHA end *********** -->

