<?php
    use yii\bootstrap\Html;
?>

<?php if($language =='ru'):?>
    <h1>Телепрограмма</h1>
<?php else:?>
    <h1>Телепрограма</h1>
<?php endif;?>
<div class="tv-program-widget">
    <?php foreach ($tvPrograms as $key =>$tvProgram):?>
        <?php $class = $curentDay ==$key ? '': 'hidden'; ?>
        <ul class="tv-program <?= $class;?>" id="<?= 'day-'.$key; ?>">
            <?php foreach($tvProgram as $time => $program): ?>
                <li>
                    <span class="prog-time"><?= $time;?></span><?= $program['name_'. $language]; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach;?>

    <div class="tv-program-week">
        <?php $days = ['пн', 'вт', 'ср', 'чт', 'пт', 'сб', 'нд']; ?>
        <?php foreach ($days as $key => $day):?>
            <?php if($curentDay == ($key+1) ):?>
                <?= Html::a($day, ['/tv'], ['class'=>'selected-day tv', 'data-day' =>'day-'.($key +1)])?>
            <?php else: ?>
                <?= Html::a($day, ['/tv'], ['class'=> 'tv', 'data-day' =>'day-' .($key+1)])?>
            <?php endif; ?>
         <?php endforeach;?>
        <?= Html::a('тиждень', ['/efir/tvProgram']);?><!-- переход на страницу с тв программой-->
    </div><!-- end tv-program-week -->
</div><!-- end tv-program-widget -->