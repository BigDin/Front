<?php

/* @var $this yii\web\View */
/* @var $chart app\models\Chart */

use yii\helpers\Url;

$this->title = 'Запись просмотор записи';
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Список записей',
    'url' => [Url::to(['record/index'])]
];
$this->params['breadcrumbs'][] = $this->title;

//var_dump($czoRec->chart[0]);

?>


<div class="site-index">

    <div class="card">
        <h1><?= $this->title ?></h1>
        <p>Запись эпюры тока протекающего через защитный резистор при однофазном замыкании на землю и растояние
            до места повреждения.</p>
        <b>Дата: <?= $chart->dateTime?></b>
    </div>
    <div class="chart">
        <?= $this->render('_chart', [
            'chart' => $chart,
        ]) ?>
    </div>
</div>