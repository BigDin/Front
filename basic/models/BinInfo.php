<?php

namespace app\models;

use app\models\BinString;

/**
 * Description of BinInfo
 *
 * @author anton
 */
class BinInfo extends BinString
{
    public function readSeconds()
    {
        return $this->readUnsignedInteger32(12);
    }
    
    public function readSamples()
    {
        return $this->readUnsignedInteger32(16);
    }
    
    public function readDateTime()
    {
        $year = $this->readString(180, 4);
        $month = date('m',strtotime($this->readString(185, 3)));
        $day = $this->readString(189, 2);
        $hours = $this->readString(192, 2);
        $minutes = $this->readString(195, 2);
        $seconds = $this->readString(198, 2);
        return $year . '-' . $month . '-' . $day . ' ' . $hours . ':' . $minutes . ':' . $seconds;
    }
    
    public function readAddrStart()
    {
        return $this->readUnsignedInteger32(8);
    }
    
    public function readStartBlock()
    {
        return $this->readUnsignedInteger16(28);
    }
    
    public function readType()
    {
        switch ($this->readChar(1)) {
            case 0:
                return 'fast';
            case 1:
                return 'slow';
            default :
                return 'none';
        }
    }
    
    public function checkFile()
    {
        if ($this->readString(0, 1) == 'B') {
            return true;
        }
        return false;
    }
    
}
