<?php

/* @var $this yii\web\View */
/* @var $chart app\models\Chart */

use yii\helpers\Html;

$this->title = 'Последняя запись';
?>

<div class="site-index">

    <div class="card">
        <h1>Последняя запись</h1>
        <p>Последня запись эпюры тока протекающего через защитный резистор при однофазном замыкании на землю и растояние
            до места повреждения.</p>
        <b>Дата: <?= $chart->dateTime?></b>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <?= $this->render('_chart', [
                'chart' => $chart,
            ]) ?>
        </div>
        <div class="col-lg-4 calc">
            <?php if($result): ?>
                <?php if($result->confirmed): ?>
            <div class="card confirmed">
                <?php else: ?>
            <div class="card">
                <?php endif; ?>
                <div class="header">Растояние до места повреждения(м):</div>
                <p><?= $result->distance ?></p>
            </div>
            <?php else: ?>
            <div class="card">
                <div class="header">Растояние до места повреждения невычисленно</div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?= Html::a('Подробнее...', ['record/view', 'id' => $chart->id], [
        'class' => 'btn btn-primary',
        'role'  => 'button'
    ])?>
</div>
