<?php
    use yii\bootstrap\Html;
?>

<div class="tags-line"></div>
<p>
    <b>Теги:</b>
    <?php
        $count= count($tags);
        for($i=0; $i<$count; $i++){
            echo  Html::a($tags[$i]->name, ['/pages/index/tag-search',  'id'=>$tags[$i]->id], ['class'=> 'link']);
            if(($i< $count-1)){
                echo ', ';
            }
        }
    ?>
</p>