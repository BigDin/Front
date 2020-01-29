<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use Yii;
use app\models\Record;
use app\models\Result;


class CronController extends Controller
{
    
    public function actionIndex()
    {
        if (Record::findModelRecord() == null) {
            $modelRecord = new Record();
            $modelRecord->saveModelRecord();
            unset($modelRecord);
        }
        $list = Yii::$app->fs->listContents('');
        foreach ($list as $file){
            $content = Yii::$app->fs->read($file['path']);
            $record = new Record();
            $record->saveRecord($content);
            Yii::$app->fs->delete($file['path']);
            $result = new Result();
            $result->autoSaveResult($record);
            unset($record);
            unset($result);
            
        }
        return ExitCode::OK;
    }
    
}
