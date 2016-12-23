<?php
    use yii\bootstrap\Html;
?>

<div class="big-slider-top">
    <div id="big-slider" class="owl-big-slider">
        <?php
        foreach ($baners as $baner): ?>
            <section>
                <img src="<?= $baner->getUrl(); ?>" alt="slide-1">
                <?php if($news = $baner->news):?>
                    <div class="slide-text">
                        <div class="container">
                            <?= Html::a('<h2>'. $baner->news->{'title_'. $language} .'</h2>', ['/news/news/item',  'id'=>$baner->news->id], ['class'=>''])?>
                            <div class="text col-lg-8 col-md-9">
                                <?= $baner->news->{'short_description_'. $language} ?>
                            </div><!-- end text col-lg-8 col-md-9  -->
                            <div class="col-lg-4 col-md-3 col-sm-12">
                                <?php if($baner->news->program):?>
                                    <?= Html::a($baner->news->program->{'name_' . $language}, ['/type', 'id' => $baner->news->program->id], ['class' => 'backstage-link']) ?>
                                <?php endif;?>
                                <span class="time"><?= $baner->news->formatDate(); ?></span>
                            </div> <!-- end col-lg-4 col-md-3 col-sm-12 -->
                        </div> <!-- end container -->
                    </div><!-- end slide-text -->
                <?php else: ?>
                    <?php if(!is_null($baner->{'title_'. $language})):?>
                        <div class="slide-text">
                            <div class="container">
                                <h2><?= $baner->{'title_'. $language} ?></h2>
                                <div class="text col-lg-8 col-md-9">
                                    <?= $baner->{'description_'. $language} ?>
                                </div><!-- end text col-lg-8 col-md-9  -->
                            </div> <!-- end container -->
                        </div><!-- end slide-text -->
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        <?php endforeach; ?>
    </div>
</div><!-- end big-slider-top -->