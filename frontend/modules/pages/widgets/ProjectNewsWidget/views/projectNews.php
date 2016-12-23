<?php
    use yii\bootstrap\Html;
use yii\helpers\StringHelper;

?>

<section class="news-slider-wrap">
   <?php if($language == 'ru'):?>
        <h1>Новости проекта</h1>
   <?php else:?>
       <h1>Новини проекта</h1>
   <?php endif;?>

    <div class="news-slider" id="news-slider-v" >
        <?php foreach ($news as $item):?>
            <div class="preview clear">
            <?php if($item->type == 'text'):?>
                <figure>
                    <?php if($preview = $item->getPreview()):?>
                        <?php $smallUrl = $preview->getSmallUrl();?>
                        <?php if(!empty($smallUrl)):?>
                            <img src="<?=$smallUrl ?>" alt="<?=$preview->{'alt_'. $language} ?>" title="<?=$preview->{'title_'. $language} ?>">
                        <?php endif; ?>
                    <?php endif;?>
                    <figcaption class="time"><?= $item->formatDate()?></figcaption>
                </figure>
                <?= Html::a('<h5>'  .StringHelper::truncate($item->{'title_'. $language}, 50).'</h5>', ['index/news-page',  'id'=>$item->id])?>
                <p><?= StringHelper::truncate($item->{'short_description_'. $language}, 100); ?></p>
            <?php else: ?>

                <?php if($video = $item->getVideo() ):?>
                    <?php if($video->youtube_link != ''):?>
                        <figure class="play-in-modal" data-id="<?=$item->id; ?>">
                            <img src="<?= $video->getYoutubePreviewUrl(); ?>">
                                <span class="play-icon"></span>
                                <figcaption class="time"><?= $item->formatDate()?></figcaption>
                            </figure>
                            <?= Html::a('<h5>'  .StringHelper::truncate($item->{'title_'. $language}, 50).'</h5>', ['index/news-page',  'id'=>$item->id])?>
                            <p><?= StringHelper::truncate($item->{'short_description_'. $language}, 100); ?></p>
                    <?php else:?>
                        <figure class="play-in-modal video" data-id="<?=$item->id; ?>">
                            <video poster="" >
                                <source src="<?= $video->getUrl();?>" type="video/mp4">
                            </video>
                            <figcaption class="time"><?= $item->formatDate(); ?></figcaption>
                        </figure>
                        <?= Html::a('<h5>'  .StringHelper::truncate($item->{'title_'. $language}, 50).'</h5>', ['index/news-page',  'id'=>$item->id])?>
                        <p><?= StringHelper::truncate($item->{'short_description_'. $language}, 100); ?></p>
                    <?php endif;?>
                <?php endif;?>
            <?php endif;?>
            </div> <!-- end preview -->
        <?php endforeach;?>
    </div> <!-- end news-slider -->
</section>
