<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\RecordSearch */

use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2><?= $this->title ?></h2>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'id',
            'label' => 'ID',
            'options' => ['width' => '100'],
        ],
        [
            'attribute' => 'username',
            'label' => 'Логин',
        ],
        [
            'attribute' => 'firstname',
            'label' => 'Имя',
        ],
        [
            'attribute' => 'lastname',
            'label' => 'Фамилия',
        ],
        [
            'attribute' => 'email',
            'label' => 'E-mail',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['width' => '90'],
            'template' => '{view} {update} {delete}'
        ],
    ],
]); ?>