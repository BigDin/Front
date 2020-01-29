<?php

use yii\helpers\Html;
use yii\helpers\Url;



$this->title = 'Добавление результатьов моделирования';
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Резульаты моделирования',
    'url' => [Url::to(['result/modeling'])]
];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="result-add">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>