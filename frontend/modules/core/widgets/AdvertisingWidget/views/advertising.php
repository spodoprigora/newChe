<?php
    use yii\bootstrap\Html;

    $language ='ua';
    $session = Yii::$app->session;
    $session->open();
    if ($session->has('lang') && $session['lang'] == 'ru' ){
        $language ='ru';
    }
?>
<?php if(!is_null($news)):?>
    <div class="commercial-block">
        <section class="text-right clear">
            <?php if($news['type'] == 'text'):?>
                <?php if(!empty($news['preview'])):?>
                    <figure class="video">
                        <img src="<?=$news['preview']['preview_url'];?>" alt="<?=$news['preview']['preview_alt_'. $language];?>" title="<?=$news['preview']['preview_title_'. $language];?>">
                    </figure>
                <?php endif; ?>
                <?= Html::a('<h2>' .$news['title_'. $language].'</h2>', ['index/news-page',  'id'=>$news['id']], ['class' => 'breaking-item'])?>
                <p class="annotate"><?= $news['short_description_'. $language] ?></p>
                <span class="backstage-link">Реклама</span>
                <?=''// Html::a('Реклама', ['index/news-page',  'id'=>$news['id']], ['class' => 'backstage-link'])?>
                <span class="time"><?=$news['date_news']?></span>
            <?php else:?>
                <?php if(array_key_exists("type", $news['video'])):?>
                    <?php if($news['video']['type'] == 'youtube'):?>
                        <figure class='video play-in-modal' data-id='<?= $news['id']?>'>
                            <!--<div data-type="youtube" data-video-id="<?=''// $news['video']['video']?>"></div>-->
                            <img src='<?= $news['video']['youtube_preview'] ?>'>
                            <span class='play-icon'></span>
                        </figure>
                        <?= Html::a('<h2>' .$news['title_'. $language].'</h2>', ['index/news-page',  'id'=>$news['id']], ['class' => 'breaking-item'])?>
                        <p class="annotate"><?= $news['short_description_'. $language] ?></p>
                        <?=''// Html::a('Реклама', ['index/news-page',  'id'=>$news['id']], ['class' => 'backstage-link'])?>
                        <span class="backstage-link">Реклама</span>
                        <span class="time"><?=$news['date_news']?></span>
                    <?php else:?>
                        <figure class="video play-in-modal" data-id='<?= $news['id']?>'>
                            <video poster="">
                                <source src="<?= $news['video']['video'] ?>" type="video/mp4">
                            </video>
                        </figure>
                        <?= Html::a('<h2>' .$news['title_'. $language].'</h2>', ['index/news-page',  'id'=>$news['id']], ['class' => 'breaking-item'])?>
                        <p class="annotate"><?= $news['short_description_'. $language] ?></p>
                        <?=''// Html::a('Реклама', ['index/news-page',  'id'=>$news['id']], ['class' => 'backstage-link'])?>
                        <span class="backstage-link">Реклама</span>
                        <span class="time"><?=$news['date_news']?></span>
                    <?php endif;?>
                <?php endif;?>
            <?php endif;?>
         </section>
    </div>
<?php endif; ?>