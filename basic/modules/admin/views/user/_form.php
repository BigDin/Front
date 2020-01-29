<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

    
<?php $form = ActiveForm::begin(); ?>

    
    <?= $form->field($model, 'username')->label('Логин') ?>

    <?= $form->field($model, 'firstname')->label('Имя') ?>
  
    <?= $form->field($model, 'lastname')->label('Фамилия') ?>

    <?= $form->field($model, 'email')->label('E-mail') ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
