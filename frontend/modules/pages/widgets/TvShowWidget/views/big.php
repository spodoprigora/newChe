<?php

?>

<?php foreach ($tvPrograms as $key=>$day ):?>
    <?php if($curentDay ==$key):?>
        <div class="schedule clear" id='day-<?= $key;?>'>
    <?php else: ?>
        <div class="schedule clear hidden" id='day-<?= $key;?>'>
    <?php endif;?>
        <?php foreach ($day as $time=> $item):?>
            <div class="program-item">
                <span class="time-item"><?= $time?></span>
                        <span class="cover-item">
                            <img src="<?= $item['image']?>" >
                        </span>
                <span class="title-item"><?= $item['name_' . $language];?></span>
            </div><!-- end program-item -->
        <?php endforeach;?>
    </div><!-- end schedule -->
<?php endforeach;?>