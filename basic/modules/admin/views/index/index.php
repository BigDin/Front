<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Админка';
?>

<div class="admin-index">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-link">
                <?= Html::a(Html::img(Url::to(['@web/images/users.png'])) . 'Пользователи', Url::to(['user/index']))?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-link">
                <?= Html::a(Html::img(Url::to(['@web/images/records.png'])) . 'Записи тока РЗ', Url::to(['record/index']))?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-link">
                <?= Html::a(Html::img(Url::to(['@web/images/ftp.png'])) . 'FTP', Url::to(['index/ftp']))?>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-link">
                <?= Html::a(Html::img(Url::to(['@web/images/tcp.png'])) . 'TCP', Url::to(['index/tcp']))?>
            </div>
        </div>
    </div>
</div>


