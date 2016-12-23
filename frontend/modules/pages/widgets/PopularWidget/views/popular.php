<?php
    use yii\bootstrap\Html;
    use yii\helpers\StringHelper;

    $count = 0;
?>

<section class="current-program-wrap">
    <?php if($language =='ru'):?>
        <h1>Популярное</h1>
    <?php else:?>
        <h1>Популярні</h1>
    <?php endif;?>
    <div class="current-program-slider clear" id="current-program-h" >
        <?php foreach ($news as $item):?>
            <?php if($count == 0):?>
                <div class="item">
            <?php endif;?>
            <div class="preview">
                <?php if($item->type == 'text'): ?>
                    <?php if($preview = $item->preview):?>
                        <img src="<?= $preview->getSmallUrl();?>" alt="<?=$preview->{'alt_' .$language};?>" title="<?=$preview->{'title_'. $language};?>">
                    <?php endif; ?>
                    <?= Html::a('<h5>' .StringHelper::truncate($item['short_description_'. $language], 80).'</h5>', ['/news/news/item',  'id'=>$item['id']])?>
                    <span class="time"><?=$item->formatDate();?></span>
                <?php else: ?>
                    <?php if($video = $item->video):?>
                        <?php if(!empty($video->youtube_link)):?>
                            <figure class="video play-in-modal"  data-id="<?=$item['id']?>">
                                <img class="play-in-modal" src="<?= $video->getYoutubePreviewUrl(); ?>">
                                <span class="play-icon"></span>
                            </figure>
                            <?= Html::a('<h5>' .StringHelper::truncate($item['short_description_'. $language], 80).'</h5>', ['/news/news/item',  'id'=>$item['id']])?>
                            <span class="time"><?=$item->formatDate();?></span>
                        <?php else:?>
                            <figure class="video play-in-modal" data-id="<?=$item['id']?>">
                                <video poster="">
                                    <source src="<?= $video->getUrl(); ?>" type="video/mp4"></source>
                                </video>
                            </figure>
                            <?= Html::a('<h5>' .StringHelper::truncate($item['short_description_'. $language], 80).'</h5>', ['/news/news/item',  'id'=>$item['id']])?>
                            <span class="time"><?=$item->formatDate();?></span>
                        <?php endif;?>
                    <?php endif;?>
                <?php endif; ?>
            </div> <!-- end preview -->
            <?php $count++?>
            <?php if($count == 2) $count = 0; ?>
            <?php if($count == 0):?>
                </div>
            <?php endif;?><!-- end item -->
        <?php endforeach;?>
        <?php if($count == 1):?>
    </div>
    <?php endif;?><!-- end item -->
    </div>
    <!-- end current-program-slide -->
    <!--<div class="see-more">
        <a href="" class="see-more-link">Показать еще</a>
    </div>--><!-- end see-more-->
</section>


