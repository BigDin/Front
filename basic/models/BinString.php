<?php

namespace app\models;

use app\models\Record;

/**
 * Description of BinString
 *
 * @author anton
 */
class BinString 
{
    protected $binString;
    
    /**
     * {@inheritdoc}
     */
    public function __construct($binString) 
    {
        $this->binString = $binString;
    }
    
    public function readChar($start)
    {
        $char = $this->readData($start, 1, 1, 'c');
        return $char[1];
    }
    
    public function readUnsignedChar($start)
    {
        $uchar = $this->readData($start, 1, 1, 'C');
        return $uchar[1];
    }

    public function readInteger16($start)
    {
        $int16 = $this->readData($start, 2, 1, 's');
        return $int16[1];
    }
    
    public function readArrayInteger16($start, $length)
    {
        return $this->readData($start, 2, $length, 's');
    }
    
    public function readUnsignedInteger16($start)
    {
        $int16 = $this->readData($start, 2, 1, 'S');
        return $int16[1];
    }
    
    public function readInteger32($start)
    {
        $int16 = $this->readData($start, 4, 1, 'l');
        return $int16[1];
    }
    
    public function readUnsignedInteger32($start)
    {
        $int16 = $this->readData($start, 4, 1, 'L');
        return $int16[1];
    }
    
    public function readString($start, $length)
    {
        $arrStr = $this->readData($start, 1, $length, 'a');
        return $arrStr[1];
    }

    private function readData($start, $numByte, $size, $format)
    {
        $string = substr($this->binString, $start, $size * $numByte);
        $array = unpack($format . $size, $string);
        return $array;
    }
}
