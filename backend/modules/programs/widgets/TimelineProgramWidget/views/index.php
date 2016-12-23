<?php
use yii\helpers\Html;
?>

<div class="form-group">
    <table class="table">
        <tr>
            <th>Тип трянсляции</th>
            <th>Время программы</th>
            <th>Дни программы</th>
        </tr>
        
        <?php if ($dataTimeline[ 'items' ]) : ?>
            <?php $i = 0; ?>
            <?php foreach ($dataTimeline[ 'items' ] as $typeProgram => $data) : ?>
                
                <tr>
                    <td>
                        <div class="clear">
                            <div class="one-info-timeline">
                      
                                <?= Html::dropDownList('TimelineProgram[' . $i . '][type]', $typeProgram, $dataTimeline[ 'program' ]->getListTimelineType(), [
                                    'class'   => 'form-control',
                                    'prompt'  => 'Выберите тип трансляции программы',
                                ]); ?>

                            </div>
                            <div class="one-operations-timeline">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        
                        <?php foreach ($data[ 'time' ] as $time) : ?>

                            <div class="clear">
                                <div class="many-info-timeline">

                                    <?= Html::textInput('TimelineProgram[' . $i . '][date][]', $time, ['class' => 'form-control']); ?>

                                </div>
                                <div class="many-operations-timeline">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    </td>

                    <td>
                      
                        <?php foreach ($data[ 'days' ] as $day) : ?>
                            
                            <div class="clear">
                                <div class="many-info-timeline">

                                    <?= Html::dropDownList('TimelineProgram[' . $i . '][days][]', $day, $dataTimeline[ 'program' ]->getListTimelineDays(), [
                                        'class'   => 'form-control',
                                        'prompt'  => 'Выберите день недели',
                                    ]); ?>

                                </div>
                                <div class="many-operations-timeline">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </td>
                </tr>
                
                <?php $i++; ?>
            <?php endforeach ;?>
            

        <?php else : ?>
            
                 <tr>
                    <td>
                        <div class="clear">
                            <div class="one-info-timeline">

                                <?= Html::dropDownList('TimelineProgram[0][type]', NULL, $dataTimeline[ 'program' ]->getListTimelineType(), [
                                    'class' => 'form-control',
                                    'prompt' => 'Выберите тип трансляции программы',
                                ]); ?>

                            </div>
                            <div class="one-operations-timeline">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="clear">
                            <div class="many-info-timeline">
                            
                                <?= Html::textInput('TimelineProgram[0][date][]', NULL, ['class' => 'form-control']); ?>

                            </div>
                            <div class="many-operations-timeline">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="clear">
                            <div class="many-info-timeline">

                                <?= Html::dropDownList('TimelineProgram[0][days][]', NULL, $dataTimeline[ 'program' ]->getListTimelineDays(), ['class' => 'form-control', 'prompt' => 'Выберите день недели']); ?>

                            </div>
                            <div class="many-operations-timeline">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </div>
                        </div>
                    </td>
                </tr>

        <?php endif; ?>

  </table>
</div>