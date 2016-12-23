<?php
    use yii\bootstrap\Html;
?>

<div class="modal-content">
    <span class="close">+</span>
    <h2><?= $model['title_'. $language]?></h2>
    <?php if($model->is_announcement == 1 ):?>
        <?php if(!is_null($model->announcement_date)):?>
            <p class="post-date"><?= $model->getAnnouncementDate($language)?> </p>
        <?php endif;?>
    <?php else:?>
        <p class="post-date"><?= $model->getDate($language)?> </p>  
    <?php endif;?>
    
    <figure class="figure-1">
        <?php if($video = $model->getVideo()):?>
            <?php if(!empty($video->youtube_link)):?>
                <figure class="video">
                    <div data-type="youtube" data-video-id="<?= $video->youtube_link; ?>"></div>
                </figure>
            <?php else:?>
                <video poster="" controls>
                    <source src="<?= $video->getUrl(); ?>" type="video/mp4">
                </video>
            <?php endif;?>
        <?php endif; ?>
        <figcaption>
            <?= Html::a($model['short_description_'. $language], ['news/item', 'id'=> $model->id]); ?>
        </figcaption>
    </figure>
</div><!-- end modal-content -->