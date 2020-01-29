<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\RecordSearch */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;

$this->title = 'Список записей';
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2><?= $this->title ?></h2>
    <div class="btn-group" role="group">
        <?= Html::a('Список результатов вычисления', ['result/index'], [
            'class' => 'btn btn-primary',
            'role'  => 'button'
        ])?>
        <?= Html::a('Список результатов моделирования', ['result/modeling'], [
            'class' => 'btn btn-dark',
            'role'  => 'button'
        ])?>
        <?= Html::a('График результатов', ['result/chart'], [
            'class' => 'btn btn-dark',
            'role'  => 'button'
        ])?>
    </div>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'id',
            'label' => 'ID записи',
        ],
        [
            'attribute' => 'date_time',
            'label' => 'Дата и время записи',
            'format' =>  ['datetime'],
            'options' => ['width' => '350'],
            'filter' => DatePicker::widget([
                'name' => 'dateStart',
                'attribute' => 'dateStart',
                'name2' => 'dateEnd',
                'attribute2' => 'dateEnd',
                'model' => $searchModel,
                'type' => DatePicker::TYPE_RANGE,
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])

        ],
        [
            'attribute' => 'type',
            'label' => 'Тип записи',
        ],
        [
            'attribute' => 'resultDistance',
            'label' => 'Расстояние до замыкания, м.',
            'value' => 'result.distance',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['width' => '70'],
            'template' => '{view} {delete}'
        ],
    ],
]); ?>

    

