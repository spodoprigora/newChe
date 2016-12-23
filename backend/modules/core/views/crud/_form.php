<?php
use yii\helpers\Html;

if ($paramsElement[ 'type' ] == 'image') :
    if (!empty($model->$nameElement)) {
        echo Html::beginTag('div', ['class' => 'row']);
            echo Html::beginTag('div', ['class' => 'col-md-4']);
                echo Html::img('/' . $model->filePath . '/' . $model->$nameElement, ['class' => 'img-responsive']);
            echo Html::endTag('div');
        echo Html::endTag('div');
    }
endif;

$f = $form->field($model, $nameElement, $fieldAttributes);

// лейбл
if (isset($paramsElement[ 'label' ])) :
    $f->label($paramsElement[ 'label' ]);
endif;

// текст подсказка
if (isset($paramsElement[ 'hint' ])) :
    $f->hint($paramsElement[ 'hint' ]);
endif;

switch ($paramsElement[ 'type' ]) :

    case 'checkboxlist':
        $f->checkboxList($paramsElement[ 'items' ], $attributes);
        break;

    case 'dropdownlist':
        $f->dropdownlist($paramsElement[ 'items' ], $attributes);
        break;

    case 'file':
    case 'image':
        $f->fileInput($attributes);
       
        break;
    case 'preview':
        if(isset($attributes['html'])){
            echo $attributes['html'];
        }
        $f->fileInput();
        break;
    case 'widget':
        $f->widget($paramsElement[ 'nameWidget' ], $attributes);
        break;

    case 'userWidget':
        echo call_user_func([$paramsElement[ 'nameWidget' ], 'widget'], $attributes);
        break;

    default:
        $f->$paramsElement[ 'type' ]($attributes);

endswitch;

if ($paramsElement[ 'type' ] !== 'userWidget') {
    echo $f;
}
?>