<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Tabs;

?>

<div class="crud-form">

    <?php $form = ActiveForm::begin($activeFormConfig); ?>

    <?php foreach ($formElements as $nameElement => $paramsElement) : ?>
      
          <?php

              // Если форма должна иметь вкладки
              if ($paramsElement[ 'type' ] === 'tabs') {
                  $items  = [];
                  $i      = 0;

                  // перебираем вкладки
                  foreach ($paramsElement[ 'itemTabs' ] as $tab) {
                      $items[ $i ][ 'label' ]   = $tab[ 'title' ];
                      $items[ $i ][ 'content' ] = '';
                      if (isset($tab[ 'active' ]) && $tab[ 'active' ]) {
                          $items[ $i ]['active'] = TRUE;
                      }

                      // перебираем элементы вкладок
                      foreach ($tab[ 'elements' ] as $tabElementName => $tabElementParams) {
                          $attributes       = isset($tabElementParams[ 'attributes' ]) ? $tabElementParams[ 'attributes' ] : [];
                          $fieldAttributes  = isset($tabElementParams[ 'fieldAttributes' ]) ? $tabElementParams[ 'fieldAttributes' ] : [];
                          $items[$i][ 'content' ] .= $this->render('_form', [
                                                                'form'            => $form,
                                                                'model'           => $model,
                                                                'nameElement'     => $tabElementName,
                                                                'paramsElement'   => $tabElementParams,
                                                                'attributes'      => $attributes,
                                                                'fieldAttributes' => $fieldAttributes,
                                                        ]);
                      }
                      $i++;
                  }
                  echo Tabs::widget(['items' => $items]);

              // простая форма
              } else {
                  $attributes       = isset($paramsElement[ 'attributes' ]) ? $paramsElement[ 'attributes' ] : [];
                  $fieldAttributes  = isset($paramsElement[ 'fieldAttributes' ]) ? $paramsElement[ 'fieldAttributes' ] : [];
                  echo $this->render('_form', [
                          'form'            => $form,
                          'model'           => $model,
                          'nameElement'     => $nameElement,
                          'paramsElement'   => $paramsElement,
                          'attributes'      => $attributes,
                          'fieldAttributes' => $fieldAttributes,
                  ]);
              }
          ?>

    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>