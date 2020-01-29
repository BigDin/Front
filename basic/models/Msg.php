<?php


namespace app\models;

use yii\base\Model;
use yii\base\Exception;

class Msg extends Model
{
    public $msg=[];
    public $num=[0,0];
    public $mes=[];
    public $byte;
    public $buff;
    public $address;


    public function rules()
    {
        return [
            [['msg','address'], 'required'],
            [['num'], 'number'],
        ];
    }
    
    public function compile()
    {
        //$this->byte = chr (0x00) . chr (0x02);
        $this->msg[0] = hex2bin($this->msg[0]);
        $byte=strlen($this->msg[0]);
        if ($this->num[0]) {
            $i = 1;
            foreach ($this->num as $num) {
                $this->msg[$i++]=strrev(pack('n*',$num));
                $byte+=2;
            }
        }
        /*if($this->num[0]){
            $this->msg[1]=strrev(pack('n*',$this->num[0]));
            //$this->msg[2]=strrev(pack('n*',$this->num[1]));
            $byte++;            
        }
        if($this->num[1]){
            $this->msg[2]=strrev(pack('n*',$this->num[1]));
            $byte++;
        }*/
        $this->byte = $byte;//pack('n*',$byte);
        
        $this->buff = chr (0x53) . chr (0x79) . chr (0x4e) . chr (0x63) . chr (0x00) . chr ($this->byte) . implode('', $this->msg);
    }
    
    public function translate($package)
    {
        /*$string = substr($content, $start, $size);
        $array = unpack($format, $string);*/
        if ($this->validatePackage($package)) {
            switch (unpack('n', substr($package, 6, 2))[1]) {
                case 0xED02:
                    $positiveLevel1 = unpack('s', substr($package, 8, 2))[1];
                    $negativeLevel1 = unpack('s', substr($package, 10, 2))[1];
                    $positiveLevel2 = unpack('s', substr($package, 12, 2))[1];
                    $negativeLevel2 = unpack('s', substr($package, 14, 2))[1];
                    return "Положительная уставка канала с фильтром: " . $positiveLevel1 . '<br>'
                        . "Отрицательная уставка канала с фильтром: " . $negativeLevel1 . '<br>'
                        . "Положительная уставка канала без фильтра: " . $positiveLevel2 . '<br>'
                        . "Отрицательная уставка канала без фильтра: " . $negativeLevel2;
                case 0xED03:
                    return "Уставки успешно записаны";
                case 0xED04:
                    return "Срабатывания разрешены";
                case 0xED05:
                    return "Срабатывания запрещены";
                case 0xED06:
                    return "Одноразовое срабатование разрешено";
                case 0xED07:
                    return "Начата принудительная запись";
                    
            }
        } else {
            throw new Exception('Ошибка чтения пакета');
        }
        
    }
    
    private function validatePackage($package)
    {
        if (!$package) {
            throw new Exception('Пустой пакет');
        }
        if (unpack('a4', substr($package, 0, 4))[1] != 'SyNc') {
            throw new Exception('Ошибка в проверочных байтах пакета');
        }
        if (unpack('n', substr($package, 4, 2))[1] != strlen(substr($package, 6))) {
            throw new Exception('Не совпадает количество байт в пакете');
        }
        return true;
    }
}
