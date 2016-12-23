<?php
use yii\helpers\StringHelper;
use yii\helpers\Url;

?>
<section class="new-tv-bg clear">
    <div class="container">
        <?php if($language == 'ru'):?>
            <h1>Новое на ТВ</h1>
        <?php else:?>
            <h1>Нове на ТБ</h1>
        <?php endif;?>
    </div><!-- end container -->
    <div id="new-tv-slider" class="owl-new-tv-slider">
        <?php foreach ($news as $item) :?>
            <?php if($item['type']=='text'):?>
                <a href="<?= Url::to(['/news/news/item', 'id' => $item['id']])?>" class="new-tv-box">
                    <?php if(!empty($item['preview'])):?>
                       <img src="<?= $item['preview']['url'];?>" alt="<?= $item['preview']['alt_'. $language]?>" title="<?= $item['preview']['title_'. $language]?>">
                    <?php endif; ?>
                    <h2 class="title"><?= StringHelper::truncate($item['title_'. $language], 50, '...');?></h2>
                    <p class="annotate"><?= StringHelper::truncate($item['short_description_'. $language], 50, '...')?></p>
                    <span class="time"><?= $item['date']?></span>
                </a>
            <?php else: ?>
                <div class="new-tv-box">
                    <?php if(array_key_exists("youtube_link", $item['video'])):?>
                        <?php if(!empty($item['video']['youtube_link'])):?>
                            <figure class="video play-in-modal" data-id="<?=$item['id']?>">
                                <img src="<?= $item['video']['youtube_preview']; ?>">
                                <span class="play-icon"></span>
                            </figure>
                        <?php else:?>
                            <figure class="video play-in-modal" data-id="<?=$item['id']?>">
                                <video preload="metadata" >
                                    <source src="<?= $item['video']['link']; ?>" type="video/mp4"></source>
                                </video>
                            </figure>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a href="<?= Url::to(['/news/news/item', 'id' => $item['id']])?>" class="new-tv-box">
                        <h2 class="title"><?= StringHelper::truncate($item['title_'. $language], 50, '...');?></h2>
                        <p class="annotate"><?= StringHelper::truncate($item['short_description_'. $language], 50, '...')?></p>
                        <span class="time"><?= $item['date']?></span>
                     </a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div> <!-- end owl-carousel -->
</section>