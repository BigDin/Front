<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Список результатов моделирования';
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Список записей',
    'url' => [Url::to(['record/index'])]
];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2><?= $this->title ?></h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'front',
        'distance',
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['width' => '100'],
            'template' => '{update} {delete}'
        ],
    ],
]); ?>
    <?= Html::a('Добавить результат', ['result/add'], [
        'class' => 'btn btn-primary',
        'role'  => 'button'
    ])?>