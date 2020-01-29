<?php

use miloschuman\highcharts\Highcharts;

switch ($chart->type) {
    case 'fast':
        $title = 'Ток через защитный резистор, частота дискретизации 10 МГц';
        $subtitle = 'sampel = 100ns';
        $series = [
            [
                'name' => 'Ток РЗ до фильтра', 
                'color' => 'red', 
                'lineWidth' => '0.5', 
                'boostThreshold' => '1', 
                'data' => $chart->data['unfiltered']
            ],
            [
                'name' => 'Ток РЗ после фильтра',
                'color' => 'blue', 
                'lineWidth' => '0.5', 
                'boostThreshold' => '1', 
                'data' => $chart->data['filtered']
            ]
        ];
        break;
    case 'slow':
        $title = 'Ток через защитный резистор, частота дискретизации 8 кГц';
        $subtitle = 'sampel = 125us';
        $series = [
            [
                'name' => 'Ток РЗ до фильтра', 
                'color' => 'red', 
                'lineWidth' => '0.5', 
                'boostThreshold' => '1', 
                'data' => $chart->data
            ]
        ];
        break;
    default :
        throw new Exception('Неизвестный тип записи');
}
//var_dump($series);
echo Highcharts::widget([
    'options' => [
        'title' => ['text' => $title],
        'subtitle' => ['text' => $subtitle],
        'boost' => ['useGPUTranslations' => true],
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
        'series' => $series
    ]
]);
