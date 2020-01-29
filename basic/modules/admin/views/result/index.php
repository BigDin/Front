<?php

use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Список результатов вычисления';
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
        'id',
        'record_id',
        'front',
        'distance',
        'error',
        [
            'attribute' => 'confirmed',
            'value'=>function($data) {
                if ($data->confirmed==1) $confirmed = 'Да';
                elseif ($data->confirmed==0) $confirmed = 'Нет';
                else $confirmed = 'Не определено';
                return $confirmed;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['width' => '100'],
            'template' => '{update} {delete}'
        ],
    ],
]); ?>
