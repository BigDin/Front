<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Управление удаленным датчиком по TCP';
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <h2>Запрос блоку:</h2>
    <p><?= bin2hex($send); ?></p>
</div>
<div class="card">
    <h2>Ответ от блока:</h2>
    <p><?= $answer ?></p>
    <p><?= bin2hex($msg); ?></p>
</div>

    
<?php $form = ActiveForm::begin([
    'action' => 'tcp',
]); ?>
    
    <?= $form->field($model, 'msg[0]')->radioList([
            bin2hex(chr (0xed) . chr (0x04) . chr (0x01)) => "Разрешить срабатывания канала с фильтром",
            bin2hex(chr (0xed) . chr (0x04) . chr (0x02)) => "Разрешить срабатывания канала без фильтра",
            bin2hex(chr (0xed) . chr (0x04) . chr (0x03)) => "Разрешить срабатывания обоих каналов",
            bin2hex(chr (0xed) . chr (0x05) . chr (0x01)) => "Запретить срабатывания канала с фильтром",
            bin2hex(chr (0xed) . chr (0x05) . chr (0x02)) => "Запретить срабатывания канала без фильтра",
            bin2hex(chr (0xed) . chr (0x05) . chr (0x03)) => "Запретить срабатывания обоих каналов",
            bin2hex(chr (0xed) . chr (0x06)) => "Одноразовое срабатывание", 
            bin2hex(chr (0xed) . chr (0x07)) => "Принудительная запись",
            bin2hex(chr (0xed) . chr (0x02)) => "Прочитать порог срабатывания",
            bin2hex(chr (0xed) . chr (0x03)) => "Записать порог срабатывания",
        ], 
        $options = [
            'class' => 'row',
            'item' => function($index,$label,$name,$checked,$value)
            {
                return Html::radio($name, $checked, [
                    'label' => $label,
                    'value' => $value,
                    'id' => $value,
                    'labelOptions' => ['class' => 'col-6']
                ]);
            }
        ])->label('Выберите команду') ?>
    <div class="row">
        
    <?= $form->field($model, 'num[0]', [
            'options'=> [
                'id' => 'H1',
                'class'=>'col-6',
                'style' => 'display: none;'
            ],
            'template'=>"{label}\n{input}"
        ])->input('number', [
                'min' => '-30000', 
                'max' => '30000'
            ])->label('Положительная уставка канала с фильтром:'); ?>
        
    <?= $form->field($model, 'num[1]', [
            'options'=> [
                'id' => 'L1', 
                'class'=>'col-6', 
                'style' => 'display: none;'
            ],
            'template'=>"{label}\n{input}"
        ])->input('number', [
                'min' => '-30000',
                'max' => '30000'
            ])->label('Отрицательная уставка канала с фильтром:'); ?>
        
    <?= $form->field($model, 'num[2]', [
            'options'=> [
                'id' => 'H2', 
                'class'=>'col-6', 
                'style' => 'display: none;'
            ],
            'template'=>"{label}\n{input}"
        ])->input('number', [
                'min' => '-30000',
                'max' => '30000'
            ])->label('Положительная уставка канала без фильтра:'); ?>
        
    <?= $form->field($model, 'num[3]', [
            'options'=> [
                'id' => 'L2', 
                'class'=>'col-6', 
                'style' => 'display: none;'
            ],
            'template'=>"{label}\n{input}"
        ])->input('number', [
                'min' => '-30000',
                'max' => '30000'
            ])->label('Отрицательная уставка канала без фильтра: '); ?>
        
    </div>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>


<script>
    $(document).ready(function(){
        /*var a;*/
        $("input[type='radio']").click(function() {
            if($("input[type='radio']:checked").attr('id') === 'ed03'){
                $("#H1").attr('style', 'display: block');
                $("#L1").attr('style', 'display: block');
                $("#H2").attr('style', 'display: block');
                $("#L2").attr('style', 'display: block');
                //alert('Hi bro!');
            }else{
                $("#H1").attr('style', 'display: none');
                $("#msg-num-0").val('0');
                $("#L1").attr('style', 'display: none');
                $("#msg-num-1").val('0');
                $("#H2").attr('style', 'display: none');
                $("#msg-num-2").val('0');
                $("#L2").attr('style', 'display: none');
                $("#msg-num-3").val('0');
            }
            //alert($("input[type='radio']").attr('id'));
            
            //$(".container").append("<input id='H'>");
            
        });/*
        $("#send").click(function() {
            a=$("#53794E640002ED03").val();
            b=+$("#H").val();
            alert(b.toString(16));
            //$("#53794E640002ED03").attr('value', a + b.toString(16));
        });*/
            
        
    });
</script>
