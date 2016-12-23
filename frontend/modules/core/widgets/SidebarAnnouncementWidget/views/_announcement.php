<?php
    use yii\bootstrap\Html;

    $language ='ua';
    $session = Yii::$app->session;
    $session->open();
    if ($session->has('lang') && $session['lang'] == 'ru' ){
        $language ='ru';
    }
?>
<section class="announce-slider-wrap">
    <?php if($language == 'ru'):?>
        <h1>Анонсы</h1>
    <?php else:?>
        <h1>Анонси</h1>
    <?php endif;?>

    <div class="announce-slider" id="announce-slider-v" >
        <?php foreach ($news as $item):?>
            <?php if($item['type'] == 'text'):?>
                <div class="preview clear">
                    <figure>
                        <?php if(!empty($item['preview'])):?>
                                <img src="<?=$item['preview']['url'] ?>" alt="<?=$item['preview']['alt_'. $language] ?>" title="<?=$item['preview']['title_'. $language] ?>">
                        <?php endif; ?>
                        <?php if($item['announcement_date']):?>
                            <figcaption class="time"><?= $item['announcement_date']?></figcaption>
                        <?php endif; ?>
                    </figure>
                    <?= Html::a('<h2>' .$item['title_'. $language].'</h2>', ['index/news-page',  'id'=>$item['id']])?>
                    <p><?= $item['short_description_'. $language]?></p>
                </div> <!-- end preview -->
            <?php else:?>
                <?php if(array_key_exists("type", $item['video'])):?>
                    <?php if($item['video']['type'] == 'youtube'):?>
                        <div class="preview clear">
                            <figure class="play-in-modal" data-id="<?=$item['id']?>">
                                <img src="<?= $item['video']['youtube_preview']; ?>">
                                <span class="play-icon"></span>
                                <?php if($item['announcement_date']):?>
                                    <figcaption class="time"><?= $item['announcement_date']?></figcaption>
                                <?php endif; ?>
                            </figure>
                            <?= Html::a('<h2>' .$item['title_'. $language].'</h2>', ['index/news-page',  'id'=>$item['id']])?>
                            <p><?= $item['short_description_'. $language]?></p>
                        </div> <!-- end preview -->
                    <?php else:?>
                        <div class="preview clear">
                            <figure class="play-in-modal video" data-id="<?=$item['id']?>">
                                <video poster="" >
                                    <source src="<?= $item['video']['video'] ?>" type="video/mp4">
                                </video>
                                <?php if($item['announcement_date']):?>
                                    <figcaption class="time"><?= $item['announcement_date']?></figcaption>
                                <?php endif; ?>
                            </figure>
                            <?= Html::a('<h2>' .$item['title_'. $language].'</h2>', ['index/news-page',  'id'=>$item['id']])?>
                            <p><?= $item['short_description_'. $language]?></p>
                        </div> <!-- end preview -->
                    <?php endif;?>
                <?php endif;?>
            <?php endif;?>
        <?php endforeach;?>
    </div> <!-- end news-slider -->
</section>

<div class="clear"></div>