<?php
    use yii\bootstrap\Html;
?>

<section>
    <?php if($language =='ru'):?>
        <h1>Програмы</h1>
    <?php else:?>
        <h1>Програми</h1>
    <?php endif;?>

    <ul class="program-topics">
        <?php foreach ($programs as $program):?>
            <?php $class = ($program->id == $curent_id)? 'selected-topic': ''; ?>
            <li>
                <?= Html::a($program->{'name_'. $language}, ['/programs',  'id'=>$program->{'id'}], ['class' => $class])?>
            </li>
        <?php endforeach;?>
    </ul>
</section>