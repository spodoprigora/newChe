<?php
use yii\bootstrap\Html;
use yii\helpers\StringHelper;

?>


<section class="text-right clear">
    <?php if($item['type'] == 'text'):?>
        <?php if($preview = $item->getPreview()):?>
            <figure class="video">
                <img src="<?= $preview->getBigUrl();?>"  alt="<?= $preview['alt_'. $language]?>" title="<?= $preview['title_'. $language]?>">
            </figure>
        <?php endif; ?>
    <?php else:?>
        <?php if($video = $item->getVideo()):?>
            <?php if(!empty($video->youtube_link)):?>
                <figure  class="video play-in-modal" data-id="<?=$item['id']?>">
                    <!--<div data-type="youtube" data-video-id="<?=''// $video->youtube_link;?>"></div>-->
                    <img src="<?= $video->getYoutubePreviewUrl(); ?>">
                    <span class="play-icon"></span>
                </figure>
            <?php else: ?>
                <figure  class="video play-in-modal" data-id="<?=$item['id']?>">
                    <video poster ='' controls>
                        <source src="<?= $video->getUrl(); ?>" type="video/mp4">
                    </video>
                </figure>
            <?php endif; ?>
        <?php endif;?>
    <?php endif;?>

    <?= Html::a('<h2>' .$item['title_'. $language].'</h2>', ['/news/news/item',  'id'=>$item['id']], ['class'=> 'breaking-item'])?>

    <p class="annotate"><?= StringHelper::truncate($item['short_description_'. $language], 200)?></p>
    <?php if($program = $item->program): ?>
        <?= Html::a($program->{'name_'. $language}, ['/type',  'id'=>$program->id], ['class'=>'backstage-link'])?>
        <span class="time"><?= $item->formatDate() ?></span>
    <?php else:?>
        <span class="time main-list"><?= $item->formatDate() ?></span>
    <?php endif;?>

</section>