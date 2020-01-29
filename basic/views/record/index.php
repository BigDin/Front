<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\RecordSearch */

use yii\helpers\Url;
use yii\grid\GridView;
use kartik\date\DatePicker;

$this->title = 'Список записей';
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
            'label' => 'ID записи',
        ],
        [
            'attribute' => 'date_time',
            'label' => 'Дата и время записи',
            'format' =>  ['datetime'],
            'options' => ['width' => '400'],
            'filter' => DatePicker::widget([
                'name' => 'dateStart',
                //'value' => $searchModel->date_time,
                'attribute' => 'dateStart',
                'name2' => 'dateEnd',
                'attribute2' => 'dateEnd',
                'model' => $searchModel,
                'type' => DatePicker::TYPE_RANGE,
                //'value' => '1980-01-05',
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ]
            ])

        ],
        [
            'attribute' => 'resultDistance',
            'label' => 'Растояние до замыкания',
            'value' => 'result.distance',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}'
        ],
    ],
]); ?>
