<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Редактирование пользователя';

$this->params['breadcrumbs'][] = [
                                    'label' => 'Админка', 
                                    'url' => [Url::to(['admin/index'])] 
                                 ];
$this->params['breadcrumbs'][] = [
                                    'label' => 'Список пользователей', 
                                    'url' => [Url::to(['user/index'])] 
                                 ];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>


