<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Chart;
use app\models\Calculations;

/**
 * Description of Result
 *
 * @author anton
 */
class Result extends ActiveRecord 
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "result";
    }
    
    public function rules()
    {
        return [
            [['front', 'distance'], 'required'],
            [['record_id', 'front', 'distance','error'], 'integer'],
            [['confirmed'], 'boolean']
            
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'record_id' => 'ID записи',
            'front' => 'Длина фронта, мкс.',
            'distance' => 'Расстояние до замыкания, м.',
            'error' => 'Ошибка вычисления, м.',
            'confirmed' => 'Подтверждён',
        ];
    }
    
    public function autoSaveResult($record)
    {
        if ($record->type == 'slow') {
            return false;
        }
        $this->record_id = $record->id;
        $chart = new Chart($record);
        $calc = new Calculations($chart->data['filtered']);
        $this->front = $calc->calcLengthOfFront(0.1);
        $this->distance = $calc->calcDistance();
        $this->confirmed = false;
        self::save();
    }
    
    public function saveResult($RecordId, $front, $distance)
    {
        $this->record_id = $RecordId;
        $this->front = $front;
        $this->distance = $distance;
        $this->confirmed = false;
        self::save();
    }

    public static function findById($id)
    {
        return static::findOne($id);
    }
    
    public static function findByRecordId($RecordId)
    {
        return static::find()
            ->where(['record_id' => $RecordId])
            ->limit(1)
            ->one();
    }
    
    public static function resultConfirm($id)
    {
        static::updateAll(['confirmed' => true], 'id = ' . $id);
    }
    
    public static function findLeftPoint($front)
    {
        $results = static::find()
            ->where(['confirmed' => true])
            ->andWhere("front < '" . $front . "'")
            ->orderBy(['front' => SORT_DESC])
            ->all();
        foreach ($results as $result) {
            if ($result->record_id && $result->confirmed) {
                return $result;
            }
        }
        return $results[0];
    }
    
    public static function findRightPoint($front)
    {
        $results = static::find()
            ->where(['confirmed' => true])
            ->andWhere("front > '" . $front . "'")
            ->orderBy(['front' => SORT_DESC])
            ->all();
        foreach ($results as $result) {
            if ($result->record_id && $result->confirmed) {
                return $result;
            }
        }
        return $results[0];
    }
    
    public function getRecord()
    {
        return $this->hasOne(Record::classname(), ['id' => 'record_id']);
    }
    
}
