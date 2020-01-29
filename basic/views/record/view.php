<?php

/* @var $this yii\web\View */
/* @var $fastChart app\models\Chart */
/* @var $slowChart app\models\Chart */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Запись №' . $fastChart->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Список записей',
    'url' => [Url::to(['index'])]
];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $info->readSeconds();?> : <?= $infoSlow->readSeconds();?><br>
<?=$info->readSamples();?> : <?=$infoSlow->readSamples();?>
<div class="site-index">

    <div class="card">
        <h1><?= $this->title ?></h1>
        <p>Запись эпюры тока протекающего через защитный резистор при однофазном замыкании на землю и растояние
            до места повреждения.</p>
        <b>Дата: <?= $fastChart->dateTime?></b>
    </div>
    <div class="row">
        <div class="col-lg-8">
    <?php
    if ($slowChart) {
        echo $this->render('_chart', [
                'chart' => $slowChart
        ]); 
    }
    
    echo $this->render('_chart', [
        'chart' => $fastChart
    ]); 
    ?>
        </div>
        <div class="col-lg-4 calc">
            <?php if($result): ?>
                <?php if($result->confirmed): ?>
            <div class="card confirmed">
                <div class="header">Растояние до места повреждения(м):</div>
                <p><?= $result->distance ?></p>
            </div>
                <?php else: ?>
            <div class="card">
                <div class="header">Растояние до места повреждения(м):</div>
                <p><?= $result->distance ?></p>
                <?= Html::a('Подтвердить', ['result/confirm', 'id' => $result->id], [
                    'class' => 'btn btn-primary',
                    'role'  => 'button'
                ])?>
            </div>
                <?php endif; ?>
            <?php else: ?>
            <div class="card">
                <div class="header">Растояние до места повреждения невычисленно</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>