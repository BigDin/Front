<?php
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'FTP';
$this->params['breadcrumbs'][] = [
    'label' => 'Админка',
    'url' => [Url::to(['index/index'])]
];
$this->params['breadcrumbs'][] = $this->title;
//var_dump($dirs)
?>
<div class="list-group">
<?php
if ($dirs) {
    if ($dirs[0]['dirname']) {
        echo Html::a(
            '..', 
            Url::to([
                'index/ftp', 
                'path' => $backPath
            ]),
            [
                'class' => 'list-group-item list-group-item-action'
            ]
        );
    }
    foreach ($dirs as $dir) {
        if ($dir['type'] == 'dir') {
            echo Html::a(
                $dir['basename'], 
                Url::to([
                    'index/ftp', 
                    'path' => $dir['path']
                ]),
                [
                    'class' => 'list-group-item list-group-item-action'
                ]
            );
        } else {
            echo Html::a(
                $dir['basename'], 
                Url::to([
                    'index/download', 
                    'path' => $dir['path']
                ]),
                [
                    'class' => 'list-group-item list-group-item-action'
                ]
            );

        }
    }
} else {
    echo Html::a(
        '..', 
        Url::to([
            'index/ftp', 
            'path' => $backPath
        ]),
        [
            'class' => 'list-group-item list-group-item-action'
        ]
    );
}
?>
</div>



