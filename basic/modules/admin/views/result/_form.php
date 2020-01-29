<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
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

    <?= $form->field($model, 'front')->input('number') ?>

    <?= $form->field($model, 'distance')->input('number') ?>
    <?php if($model->record_id): ?>
    <?= $form->field($model, 'error')->input('number') ?>

    <?= $form->field($model, 'confirmed')->checkbox(array('value'=>1, 'uncheckValue'=>0))?>
    <?php endif; ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

