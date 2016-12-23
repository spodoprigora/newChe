<?php
use yii\bootstrap\Html;
use yii\helpers\StringHelper;

$topical_block[0] ='';
$topical_block[1] ='';
$topical_block[2] ='';
$count =0;
$str ='';
$showMore =false;

$allCount =0;
$showCount =18;


if($models){
    foreach ($models as  $model){
        if($count == 0){  //заполняем первую колонку
            $class = $allCount>2 ? 'hidden' : '';
            if($model['type'] == 'text') {
                if($preview = $model->getPreview()) {
                    $src =$preview->getSmallUrl();
                    $alt = $preview['alt_'. $language];
                    $title = $preview['title_' . $language];
                    $str .= "<div class='preview $class'>
                            <figure class='video'>".
                                 Html::a('<img src=' .$src .'  alt=' . $alt . ' title=' . $title . '>' .'<p>'  . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item', 'id'=>$model['id']], ['class' => 'topical-items']) .
                             "</figure>";
                    $str .= "</div>";
                }
            }
            else{
                if($video = $model->getVideo()){
                    if(!empty($video->youtube_link)){
                        $youtube_previev = $video->getYoutubePreviewUrl();
                        $str .= "<div class='preview $class'>
                                <figure class='video play-in-modal  data-id='".$model->id . "'>
                                    <img src='" . $youtube_previev . "'>
                                    <span class='play-icon'></span>
                                 </figure>";
                        $str .= Html::a('<p>' . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item',  'id'=>$model['id']], ['class' => 'topical-items']);
                        $str .= "</div>";
                    }
                    else{
                        $str .= "<div class='preview $class'>
                                <figure  class='video play-in-modal' data-id='" . $model->id . "'>
                                    <video poster='' controls> <source src='{$video->getUrl()}' type='video/mp4'></source> </video>
                                </figure>";
                        $str .= Html::a('<p>'  . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item',  'id'=>$model['id']], ['class' => 'topical-items']);
                        $str .= "</div>";
                    }
                }
            }
            $topical_block[0] .= $str;
            $str= '';
            $count++;
            $allCount++;
            continue;
        }
        if($count == 1){ //заполняем вторую колонку
            $class = $allCount>2 ? 'hidden' : '';
            if($model['type'] == 'text') {
                if($preview = $model->getPreview()) {
                    $src =$preview->getSmallUrl();
                    $alt = $preview['alt_'. $language];
                    $title = $preview['title_' . $language];
                    $str .= "<div class='preview $class'>
                            <figure class='video'>".
                                Html::a('<img src=' .$src .'  alt=' . $alt . ' title=' . $title . '>' .'<p>'  . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item', 'id'=>$model['id']], ['class' => 'topical-items']) .
                            "</figure>";
                    $str .= "</div>";
                }
            }
            else{
                if($video = $model->getVideo()){
                    if(!empty($video->youtube_link)){
                        $youtube_previev = $video->getYoutubePreviewUrl();
                        $str .= "<div class='preview $class'>
                                <figure class='video play-in-modal' data-id='".$model->id . "'>
                                    <img src='" . $youtube_previev . "'>
                                    <span class='play-icon'></span>
                                 </figure>";
                        $str .= Html::a('<p>'  . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item',  'id'=>$model['id']], ['class' => 'topical-items']);
                        $str .= "</div>";
                    }
                    else{
                        $str .= "<div class='preview $class'>
                                <figure  class='video play-in-modal' data-id='" . $model->id . "'>
                                    <video poster='' controls> <source src='{$video->getUrl()}' type='video/mp4'></source> </video>
                                    </figure>";
                        $str .= Html::a('<p>'  . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item',  'id'=>$model['id']], ['class' => 'topical-items']);
                        $str .= "</div>";
                    }
                }
            }
            $topical_block[1] .= $str;
            $str= '';
            $count++;
            $allCount++;
            continue;
        }
        if($count == 2){ //заполняем третью колонку
            $class = $allCount>2 ? 'hidden' : '';
            if($model['type'] == 'text') {
                if($preview = $model->getPreview()) {
                    $src =$preview->getSmallUrl();
                    $alt = $preview['alt_'. $language];
                    $title = $preview['title_' . $language];
                    $str .= "<div class='preview $class'>
                            <figure class='video'>".
                                Html::a('<img src=' .$src .'  alt=' . $alt . ' title=' . $title . '>'. '<p>'  . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item', 'id'=>$model['id']], ['class' => 'topical-items']) .
                            "</figure>";
                    $str .="</div>";
                }
            }
            else{
                if($video = $model->getVideo()){
                    if(!empty($video->youtube_link)){
                        $youtube_previev = $video->getYoutubePreviewUrl();
                        $str .= "<div class='preview $class'>
                                <figure class='video play-in-modal' data-id='".$model->id . "'>
                                    <img src='" . $youtube_previev . "'>
                                    <span class='play-icon'></span>
                                 </figure>";
                        $str .= Html::a('<p>'  . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item',  'id'=>$model['id']], ['class' => 'topical-items']);
                        $str .= "</div>";
                    }
                    else{
                        $str .= "<div class='preview $class'>
                                <figure  class='video play-in-modal' data-id='" . $model->id . "'>
                                    <video poster='' controls> <source src='{$video->getUrl()}' type='video/mp4'></source> </video>
                                    </figure>";
                        $str .= Html::a('<p>'  . StringHelper::truncate($model['short_description_'. $language], 85) .'</p>', ['/news/news/item',  'id'=>$model['id']], ['class' => 'topical-items']);
                        $str .= "</div>";
                    }
                }
            }
            $topical_block[2] .= $str;
            $str= '';
            $count = 0;
            $allCount++;
            continue;
        }
    }
}
?>
<?php if($models): ?>
    <div class="topical-news clear">
        <div class="title-line">
            <?php if($language =='ru'):?>
                <h1>Новости по теме</h1>
            <?php else:?>
                <h1>Новини по темі</h1>
            <?php endif;?>
        </div><!-- end title-line -->

        <div class="topical-block">

            <?=$topical_block[0]; ?>

        </div> <!-- end topical-block -->
        <div class="topical-block">

            <?=$topical_block[1]; ?>

        </div>
        <div class="topical-block">

            <?=$topical_block[2]; ?>

        </div>

        <div class="clear"></div> <!-- end clear -->

        <div class="see-more">
            <?php if($allCount > 2):?>
                <a href="" class="see-more-link topical">Показать еще</a>
            <?php endif; ?>
        </div><!-- end see-more -->
    </div>
<?php endif;?>
