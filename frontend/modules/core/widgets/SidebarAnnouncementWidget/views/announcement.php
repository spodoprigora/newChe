<?php
use yii\bootstrap\Html;
use yii\helpers\Url;

$language ='ua';
$session = Yii::$app->session;
$session->open();
if ($session->has('lang') && $session['lang'] == 'ru' ){
    $language ='ru';
}
$count =7;
$block1='';
$block2='';
?>

<?php
foreach ($news as $item){
    $temp='';
    if($item['type'] == 'text'){
        $temp = "<div class='preview clear'>
                    <a href='". Url::toRoute(['/news/news/item',  'id'=>$item['id']])."'><figure>";
        if(!empty($item['preview'])){
            $temp .= "<img src='" .$item['preview']['url'] . "' alt='" .$item['preview']['alt_'. $language] ."' title='" .$item['preview']['title_'. $language] . "'>";
        }
        if($item['announcement_date']){
            $temp .= "<figcaption class='time'>" . $item['announcement_date'] ."</figcaption>";
        }
        $temp .="</figure><h2>". $item['title_'. $language] . "</h2></a>" .
                   
                    "<p>" .$item['short_description_'. $language] . "</p>
                </div> <!-- end preview -->";
    }else{
        if(array_key_exists("type", $item['video'])){
            if($item['video']['type'] == 'youtube'){
                $temp .="<div class='preview clear'>
                            <figure class='play-in-modal' data-id='" .$item['id']. "'>
                                <img src='" . $item['video']['youtube_preview'] . "'>
                                <span class='play-icon'></span>";
                if($item['announcement_date']){
                    $temp .="<figcaption class='time'>" . $item['announcement_date'] ."</figcaption>";
                }
                $temp .="</figure>" .
                            Html::a('<h2>' .$item['title_'. $language].'</h2>', ['/news/news/item',  'id'=>$item['id']]) .
                            "<p>" . $item['short_description_'. $language]. "</p>
                        </div> <!-- end preview -->";
            }else{
                $temp .="<div class='preview clear'>
                            <figure class='play-in-modal video' data-id='" .$item['id']. "'>
                                <video poster='' >
                                    <source src='" . $item['video']['video'] ."' type='video/mp4'>
                                </video>";
                if($item['announcement_date']){
                    $temp .="<figcaption class='time'>" . $item['announcement_date']. "</figcaption>";
                }
                $temp .="</figure>" .
                            Html::a('<h2>' .$item['title_'. $language].'</h2>', ['/news/news/item',  'id'=>$item['id']]) .
                            "<p>" . $item['short_description_'. $language] ."</p>
                        </div> <!-- end preview -->";
            }
        }
    }

    if($count >0){
        $block1 .=$temp;
        $count--;
    }
    else{
        $block2 .=$temp;
    }
}


?>




<section class="announce-slider-wrap">
    <?php if($language == 'ru'):?>
        <h1>Анонсы</h1>
    <?php else:?>
        <h1>Анонси</h1>
    <?php endif;?>
    <div class="announce-slider" id="announce-slider-v" >
        <?= $block2; ?>
        <?= $block1; ?>
    </div> <!-- end news-slider -->
</section>
<div class="clear"></div>
