<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\BinInfo;
use yii\base\Exception;

/**
 * Record класс для работы с таблицей record
 *
 * @package app\models
 */
class Record  extends ActiveRecord
{
    /**
     * Размер информационного блока расположенного в начале файла
     */
    const SIZE_INFO_BLOCK = 0x200;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return "record";
    }

    /**
     * Разбирает содержимое файла по полям и загружает в базу даных
     *
     * @param string $content содержимое файла полученого от удаленого датчика
     * @param string $expansion
     * @throws Exception если параметр $content пустой
     */
    
    public function saveModelRecord()
    {
        $this->info = null;
        $this->data = null;
        $this->type = 'model';
        $this->date_time = null;
        $this->seconds = null;
        $this->samples = null;
        self::save();
    }
    
    public function saveRecord($content)
    {
        if (!$content) {
            throw new Exception('Пустой файл');
        }
        //$size = strlen($content);
        /*Читаем иформационый блок файла*/
        $this->info = substr($content, 0, self::SIZE_INFO_BLOCK);
        $info = new BinInfo($this->info);
        if (!$info->checkFile()) {
            throw new Exception('Это не наш файл');
        }
        /*Читаем часть файла которая содержит эпюры токов*/
        $this->data = substr($content, self::SIZE_INFO_BLOCK+4);
        $this->type = $info->readType();
        $this->date_time = $info->readDateTime();
        $this->seconds = $info->readSeconds();
        $this->samples = $info->readSamples();
        self::save();
    }
    
    public static function findById($id)
    {
        return static::findOne($id);
    }

    public static function findTypeById($id)
    {
        $record = static::find()
            ->select('type')
            ->where(['id' => $id])
            ->limit(1)
            ->one();
        return $record->type;
    }
    
    public static function findModelRecord()
    {
        return static::find()
            ->where(['type' => 'model'])
            ->limit(1)
            ->one();
    }
    
    public static function findLastRecord($type = 'fast')
    {
        return static::find()
            ->where(['type' => $type])
            ->orderBy(['id' => SORT_DESC])
            ->limit(1)
            ->one();
    }
    
    public static function findMatched($seconds, $samples)
    {
        return static::find()
            ->where([
                'seconds' => $seconds, 
                'type' => 'slow'
            ])
            ->andWhere("samples <= '" . $samples . "'")            
            ->andWhere("samples >= '" . ($samples - 800000) . "'")
            ->limit(1)
            ->one();
    }
    
    public function getResult()
    {
        return $this->hasOne(Result::classname(), ['record_id' => 'id']);
    }
}
