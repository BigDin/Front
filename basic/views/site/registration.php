<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$this->title = 'Регистрация нового пользователя';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-reg">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Заполните следующие поля для того чтобы зарегистрироваться:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'reg-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8 danger\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>
    
        <?= $form->field($model, 'firstname')->textInput()->label('Имя') ?>
    
        <?= $form->field($model, 'lastname')->textInput()->label('Фамилия') ?>
    
        <?= $form->field($model, 'email')->textInput()->label('E-mail') ?>
    
        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
        

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    
    
     
</div>

