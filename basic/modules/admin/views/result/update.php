<?php

use yii\helpers\Html;
use yii\helpers\Url;



$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Список записей',
    'url' => [Url::to(['record/index'])]
];
if ($model->record_id) {
    $this->title = 'Редактирование результатов вычисления';
    $this->params['breadcrumbs'][] = [
        'label' => 'Список резульатов вычислений',
        'url' => [Url::to(['result/index'])]
    ];
} else {
    $this->title = 'Редактирование результатов моделирования';
    $this->params['breadcrumbs'][] = [
        'label' => 'Список резульатов моделирования',
        'url' => [Url::to(['result/modeling'])]
    ];
}

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="result-update">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>

