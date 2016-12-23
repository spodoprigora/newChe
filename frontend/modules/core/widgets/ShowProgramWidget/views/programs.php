<?php
    /**
     * @var $bundle
     * @var $programs
     */
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

<?php foreach ($programs as $program): ?>
    <div>
        <div class="title">
            <h1><?= $program['name_'. $language]?></h1>
            <?= Html::a($program['title_'. $language], ['/type', 'id' => $program['id']], ['class' => 'see-all']) ?>
        </div><!-- end title-line -->
        <div class="title-line"></div>
        <?php foreach ($program['news'] as $news) :?>
            <?php if($news_count<2): ?>
                <!--//остальные новости-->
                <?php if($news['type'] == 'text' ): ?>
                    <section class="text-bottom">
                        <?php if(!empty($news['preview_url'])):?>
                            <figure class="video">
                                <img src="<?= $news['preview_url'];?>"  alt="<?= $news['preview_alt_'. $language]?>" title="<?= $news['preview_title_'. $language]?>">
                            </figure>
                        <?php endif; ?>
                        <?= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['/news/news/item', 'id' => $news['id']], ['class' => 'breaking-item']) ?>
                        <p class="annotate"><?= $news['short_description_'. $language]?></p>
                        <?= Html::a($program['name_' . $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link'])?>
                        <span class="time"><?= $news['date_news']?></span>
                    </section>
                    <?php $news_count++; ?>
                <?php else: ?>
                    <section class="text-bottom">
                        <?php if(array_key_exists("video_type", $news)):?>
                            <?php if($news['video_type'] =='youtube'):?>
                                <figure class="video play-in-modal" data-id="<?=$news['id']?>">
                                    <!--<div data-type="youtube" data-video-id="<?=''// $news['video']*?>"></div>-->
                                    <img src="<?= $news['youtube_preview'];?>">
                                    <span class="play-icon"></span>
                                </figure>
                            <?php else:?>
                                <figure class="video play-in-modal" data-id="<?=$news['id']?>">
                                    <video preload="metadata" >
                                        <source src="<?= $news['video']; ?>" type="video/mp4"></source>
                                    </video>
                                </figure>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['/news/news/item', 'id' => $news['id']], ['class' => 'breaking-item']) ?>
                        <p class="annotate"><?= $news['short_description_'. $language]?></p>
                        <?= Html::a($program['name_' . $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link'])?>
                        <span class="time"><?= $news['date_news']?></span>
                    </section>
                    <?php $news_count++; ?>
                <?php endif;?>
            <?php else: ?>
                <!--//скрытый блок формируем строку для вывода-->
                <?php
                    if($news['type'] == 'text' ){
                        $hide_block .= "<section class='text-bottom'>";
                        if(!empty($news['preview_url'])){
                            $hide_block .="<figure class='video'>
                                                <img src='{$news['preview_url']}'  alt='{$news['preview_alt_'. $language]}' title='{$news['preview_title_'. $language]}'>
                                        </figure>";
                        }
                        $hide_block .= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['/news/news/item', 'id' => $news['id']], ['class' => 'breaking-item']) .
                                            "<p class='annotate'>{$news['short_description_'. $language]}</p>" .
                                            Html::a($program['name_' . $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link']) .
                                            "<span class='time'>{$news['date_news']}</span>
                                        </section>";
                    }
                    else{
                        $hide_block .="<section class='text-bottom'>";
                        if(array_key_exists("video_type", $news)){
                            if($news['video_type'] =='youtube'){
                                $hide_block .="<figure class='video play-in-modal' data-id='{$news['id']}'>".
                                                 /*<div data-type='youtube' data-video-id='{$news['video']}'></div>*/
                                                "<img src='{$news['youtube_preview']}'>
                                                <span class='play-icon'></span>         
                                          </figure>";
                            }
                            else{
                                $hide_block .="<figure class='video play-in-modal' data-id='{$news['id']}'>
                                                <video poster='' controls>
                                                    <source src='{$news['video']}' type='video/mp4'></source>
                                                </video>
                                            </figure>";
                            } 
                        }
                        
                        $hide_block .= Html::a('<h2>'.$news['title_'. $language]. '</h2>', ['/news/news/item', 'id' => $news['id']], ['class' => 'breaking-item']) .
                            "<p class='annotate'>{$news['short_description_'. $language]}</p>" .
                            Html::a($program['name_' . $language], ['/type',  'id'=>$program['id']], ['class'=>'backstage-link']) .
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
        <?php if($hide_block != ''):?>
            <div class="see-more">
                <div class="clear"></div>
                <?php if($language == 'ru'):?>
                    <?= Html::a('Показать еще', [''], ['class' => 'see-more-link']) ?>
                <?php else:?>
                    <?= Html::a('Показати ще', [''], ['class' => 'see-more-link']) ?>
                <?php endif;?>
            </div><!-- end see-more -->
        <?php endif;?>
        <?php $hide_block='';?>
    </div>
<?php endforeach; ?>
<div class="clear"></div>