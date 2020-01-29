<?php

namespace app\models;

/**
 * Description of Chart
 *
 * @author anton
 */
class Chart {
    
    public $id;
    public $dateTime;
    public $type;
    public $data = [];
    private $record;


    public function __construct($record) 
    {
        $this->record = $record;
        $this->id = $record->id;
        $this->dateTime = $record->date_time;
        $this->type = $record->type;
        $this->readChartData();
    }
    
    private function readChartData()
    {
        
        switch ($this->record->type) {
            case 'fast':
                $this->readFastChartData();
                break;
            case 'slow':
                $this->readSlowChartData();
                break;
            default :
                throw new Exception('Неизвестный тип записи');
        }
        
    }
    
    private function readFastChartData()
    {
        $binData = new BinData($this->record->data);
        $data = $binData->readDataArray();
        $length = count($data);
        $chartData = [];
        for ($i = 0; $i < $length-1; $i+=2) {
            $chartData['unfiltered'][$i/2] = $data[$i+1];
            $chartData['filtered'][$i/2] = $data[$i+2];
        }
        $this->data['unfiltered'] = $this->cutAndUnite($chartData['unfiltered']);
        $this->data['filtered'] = $this->cutAndUnite($chartData['filtered']);
    }
    
    private function readSlowChartData()
    {
        $binData = new BinData($this->record->data);
        $data = $binData->readDataArray();
        $length = count($data);
        for ($i = 0; $i < $length-1; $i+=4) {
            $this->data[$i/4] = $data[$i+2];
        }
    }

    /**
     * Вычисляет начало осциллограммы и ставит его в начало записи.
     *
     * Из-за особенности записи осциллограммы в память удаленного цифрового 
     * датчика, начало  осциллограммы находится не в начале записи. Метод 
     * cutAndUnite вычисляет, по параметрам info['addrStart'] и 
     * info['start_block'], начало осциллограммы и ставит его в начало записи.
     *
     * @param $inputArray
     * @return array
     */
    private function cutAndUnite($inputArray)
    {
        $info = new BinInfo($this->record->info);
        $start = $info->readAddrStart() - $info->readStartBlock() * 0x1000;
        $tmpBuff = array_slice($inputArray, $start);
        return array_merge($tmpBuff, array_slice($inputArray, 0, $start));
    }
    
}
