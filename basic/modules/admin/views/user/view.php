<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Пользователь #' . $model->__get('id');
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Список пользователей',
    'url' => [Url::to(['user/index'])]
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->__get('id')], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->__get('id')], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'firstname',
            'lastname',
            'email',
        ],
    ]) ?>

</div>