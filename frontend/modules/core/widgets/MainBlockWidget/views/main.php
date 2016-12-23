<?php

    use yii\bootstrap\Html;

    $news_count =0;
    $hide_block ='';

    $language ='ua';
    $session = Yii::$app->session;
    $session->open();
    if ($session->has('lang') && $session['lang'] == 'ru' ){
        $language ='ru';
    }
?>
<?php if(!is_null($program)):?>

    <div>
        <div class="title">
            <h1><?= $program['name_'. $language]?></h1>
            <?= Html::a($program['title_'. $language], ['/type', 'id' => $program['id']], ['class' => 'see-all']) ?>
        </div><!-- end title-line -->
        <div class="title-line"></div>
        <?php foreach ($program['news'] as $news) :?>
            <?php if($news_count == 0): ?>
                <!--//главная новость-->
                <?php if($news['type'] == 'text' ): ?>
                    <section class="text-right clear">
                        <?php if(!empty($news['preview'])): ?>
                            <figure class="video">
                                <img src="<?= $news['preview']['url'];?>"  alt="<?= $news['preview']['alt_'. $language]?>" title="<?= $news['preview']['title_'. $language]?>">
                            </figure>
                        <?php endif; ?>
                        <?= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['/news/news/item', 'id' => $news['id']], ['class' => 'breaking-item']) ?>
                        <p class="annotate"><?= $news['short_description_'. $language]?></p>
                        <?= Html::a($program['name_'. $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link'])?>
                        <span class="time"><?= $news['date_news']?></span>
                    </section>
                    <?php $news_count++; ?>
                <?php else: ?>
                    <section class="text-right clear">
                        <?php if(array_key_exists("youtube_link", $news['video'])):?>
                            <?php if(!is_null($news['video']['youtube_link']) && $news['video']['youtube_link'] != ''):?>
                                <figure class="video play-in-modal" data-id="<?=$news['id']?>">
                                   <!-- <div data-type="youtube" data-video-id="<?=''// $news['video']['youtube_link']?>"></div>-->
                                    <img src="<?= $news['video']['youtube_preview']; ?>">
                                    <span class="play-icon"></span>
                                </figure>
                            <?php else:?>
                                <figure   class="video play-in-modal" data-id="<?=$news['id']?>">
                                    <video poster="" controls>
                                        <source src="<?= $news['video']['link']; ?>" type="video/mp4"></source>
                                    </video>
                                </figure>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['/news/news/item', 'id' => $news['id']], ['class' => 'breaking-item']) ?>
                        <p class="annotate"><?= $news['short_description_'. $language]?></p>
                        <?= Html::a($program['name_'. $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link'])?>
                        <span class="time"><?= $news['date_news']?></span>
                    </section>
                    <?php $news_count++; ?>
                <?php endif;?>
            <?php elseif($news_count<3): ?>
                <!--//остальные новости-->
                <?php if($news['type'] == 'text' ): ?>
                    <section class="text-bottom">
                        <?php if(!empty($news['preview'])):?>
                            <figure class="video">
                                <img src="<?= $news['preview']['url'];?>"  alt="<?= $news['preview']['alt_'. $language]?>" title="<?= $news['preview']['title_'. $language]?>">
                            </figure>
                        <?php endif; ?>
                        <?= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['/news/news/item', 'id' => $news['id']], ['class' => 'breaking-item']) ?>
                        <p class="annotate"><?= $news['short_description_'. $language]?></p>
                        <?= Html::a($program['name_'. $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link'])?>
                        <span class="time"><?= $news['date_news']?></span>
                    </section>
                    <?php $news_count++; ?>
                <?php else: ?>
                    <section class="text-bottom">
                        <?php if(array_key_exists("youtube_link", $news['video'])):?>
                            <?php if(!empty($news['video']['youtube_link'])):?>
                                <figure  class="video play-in-modal" data-id="<?=$news['id']?>">
                                    <!-- <div data-type="youtube" data-video-id="<?=''// $news['video']['youtube_link']?>"></div>-->
                                    <img src="<?= $news['video']['youtube_preview']; ?>">
                                    <span class="play-icon"></span>
                                </figure>
                            <?php else:?>
                                <figure  class="video play-in-modal" data-id="<?=$news['id']?>">
                                    <video poster ='' controls>
                                        <source src="<?= $news['video']['link']; ?>" type="video/mp4">
                                    </video>
                                </figure>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['/news/news/item', 'id' => $news['id']], ['class' => 'breaking-item']) ?>
                        <p class="annotate"><?= $news['short_description_'. $language]?></p>
                        <?= Html::a($program['name_'. $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link'])?>
                        <span class="time"><?= $news['date_news']?></span>
                    </section>
                    <?php $news_count++; ?>
                <?php endif;?>
            <?php else: ?>
                <!--//скрытый блок формируем строку для вывода-->
                <?php
                if($news['type'] == 'text' ){
                    $hide_block .= "<section class='text-bottom'>";
                    if(!empty($news['preview'])){
                        $hide_block .="<figure class='video'>
                                          <img src='{$news['preview']['url']}'  alt='{$news['preview']['alt_'. $language]}' title='{$news['preview']['title_'. $language]}'>
                                      </figure>";
                    }
                    $hide_block .= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['index/news-page', 'id' => $news['id']], ['class' => 'breaking-item']) .
                                        "<p class='annotate'>{$news['short_description_'. $language]}</p>" .
                                        Html::a($program['name_'. $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link']) .
                                       "<span class='time'>{$news['date_news']}</span>
                                    </section>";
                }
                else{
                    $hide_block .="<section class='text-bottom'>";
                    if(array_key_exists("youtube_link", $news['video'])){
                        if(!is_null($news['video']['youtube_link'])){
                            $hide_block .="<figure class='video play-in-modal' data-id='{$news['id']}'>".
                                           /* <div data-type='youtube' data-video-id='{$news['video']['youtube_link']}'></div>*/
                                            "<img src='{$news['video']['youtube_preview']}'>
                                             <span class='play-icon'></span>
                                        </figure>";
                        }
                        else{
                            $hide_block .="<figure class='video play-in-modal' data-id='{$news['id']}'>
                                           <video poster='' controls>
                                                <source src='{$news['video']['link']}' type='video/mp4'>
                                           </video>
                                      </figure>";
                        }
                    }
                    $hide_block .= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['index/news-page', 'id' => $news['id']], ['class' => 'breaking-item']) .
                        "<p class='annotate'>{$news['short_description_'. $language]}</p>" .
                        Html::a($program['name_'. $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link']) .
                        "<span class='time'>{$news['date_news']}</span>";
                    $hide_block .=" </section>";
                }
                ?>
            <?php endif;?>
        <?php endforeach; ?>
        <?php $news_count=0; ?>
        <div class="clear"></div>
        <?php if($hide_block!=''):?>
            <div class="news_hide">
                <?= $hide_block; ?>
            </div>
        <?php endif;?>
        <div class="clear"></div>
        <div class="see-more">
            <div class="clear"></div>
            <?php if($language == 'ru'):?>
                <?= Html::a('Показать еще', [''], ['class' => 'see-more-link']) ?>
            <?php else:?>
                <?= Html::a('Показати ще', [''], ['class' => 'see-more-link']) ?>
            <?php endif;?>

        </div><!-- end see-more -->
        <?php $hide_block='';?>
    </div>

<div class="clear"></div>

<?php endif; ?>