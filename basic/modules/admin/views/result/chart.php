<?php

use yii\helpers\Url;
use miloschuman\highcharts\Highcharts;

$this->title = 'График результатов';
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Список записей',
    'url' => [Url::to(['record/index'])]
];
$this->params['breadcrumbs'][] = $this->title;


echo Highcharts::widget([
    'options' => [
        'title' => ['text' => $this->title],
        'chart'=>[
            'height'=>'400px',
            'panning'=> 'true',
            'panKey'=> 'shift',
            'zoomType'=> 'xy',
        ],
        'yAxis' => [
           'title' => ['text' => 'ADC_code']
        ],
        'xAxis' => [
           'title' => ['text' => 'samples']
        ],
        'series' => [
            [
                'name' => 'Результаты вычислений', 
                'color' => 'red', 
                'lineWidth' => '0.5',
                'data' => $result
            ],
            [
                'name' => 'Результаты моделирования',
                'color' => 'blue', 
                'lineWidth' => '0.5', 
                'data' => $modeling
            ]
        ]
    ]
]);