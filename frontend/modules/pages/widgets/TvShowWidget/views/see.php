<?php
    use backend\modules\programs\models\TimelineProgram;
?>

<td>Смотрите:</td>
<td>
    <?php foreach ($tvPrograms as $key => $item):?>
        <?php if($key >= $curentDay):?>
            <?php foreach ($item as  $key1 => $time):?>
                <?php if($curentDay == $key): ?>
                    <?php if($language =='ru'):?>
                        Сегодня – <?= $key1;?><br>
                    <?php else:?>
                        Согодні – <?= $key1;?><br>
                    <?php endif;?>
                <?php else: ?>
                   <?= TimelineProgram::getTvProgramDate($key, $language)?> – <?= $key1; ?><br>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
    <?php endforeach;?>
</td>
