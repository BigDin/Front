<?php

use yii\helpers\Url;

$this->title = 'Поздравляем!';

$this->params['breadcrumbs'][] = [
                                    'label' => 'Последняя запись', 
                                    'url' => [Url::to(['site/index'])] 
                                 ];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="success">
    <div class="card">
        <h1><?= $this->title ?></h1>
        <p><?= $message ?></p>
    </div>
</div>