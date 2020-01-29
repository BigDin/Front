<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Подтверждение результатов вычисления';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="result-confirm">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Подтвердите результаты вычисления расстояния до места замыкания. Если расстояние вычислено с ошибкой, внесите изменения.</p>

    <?php $form = ActiveForm::begin([
        'id' => 'reg-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8 danger\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>
    
        <?= $form->field($model, 'record_id', [
            'options'=> [
                'style' => 'display: none;'
            ]
        ])->input('number') ?>
    
        <?= $form->field($model, 'front', [
            'options'=> [
                'style' => 'display: none;'
            ]
        ])->input('number') ?>
    
        <?= $form->field($model, 'distance')->input('number') ?>
    
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-primary', 'name' => 'confirm-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    
    
     
</div>