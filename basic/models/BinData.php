<?php

namespace app\models;

/**
 * Description of BinChart
 *
 * @author anton
 */
class BinData extends BinString
{
    public function readDataArray()
    {
        $length = strlen($this->binString);
        return $this->readArrayInteger16(0, $length/2);
    }
}
