<?php

namespace app\models;

/**
 * Description of Calculations
 *
 * @author anton
 */
class Calculations {
    
    private $data = [];
    private $sample;


    public function __construct($data, $sample = 0.1)
    {
        $this->data = $data;
        $this->sample = $sample;
        $this->smooth(20);
    }
    
    public function calcDistance()
    {
        $front = $this->calcLengthOfFront();
        $resultLeft = Result::findLeftPoint($front);
        $resultRight = Result::findRightPoint($front);
        if (!$resultLeft) {
            $resultLeft = $resultRight;
            $resultRight = Result::findRightPoint($resultLeft->front);
        }
        if (!$resultRight) {
            $resultRight = $resultLeft;
            $resultLeft = Result::findLeftPoint($resultRight->front);
        }
        $x = $front;
        $x1 = $resultLeft->front;
        $x2 = $resultRight->front;
        $y1 = $resultLeft->distance;
        $y2 = $resultRight->distance;
        return intval(($x - $x1) * ($y2 - $y1) / ($x2 - $x1) + $y1);
    }

    public function calcLengthOfFront()
    {
        $start = $this->findStartOfFront();
        $peak = $this->findPeak($start);
        return intval(($peak - $start) * $this->sample);
    }

    public function findStartOfFront()
    {
        return $this->findBend();
    }
    
    public function findPeak($start)
    {
        return $this->findBend(true, $start);
    }
    
    private function findBend($negative = false, $start = 0, $size = 0, $part = 10)
    {
        if (!$size) {
            $size = count($this->data) - $start;
        }
        if ($size < 10) {
            return $start;
        }
        $data = array_slice($this->data, $start, $size);
        $sizeOfPart = intval($size/$part);
        if (($sizeOfPart % 2) != 0) {
            $sizeOfPart++;
        }
        for ($i = 0; $i < $size - $sizeOfPart; $i++) {
            $ratio = $this->calcRatio($data, $i, $sizeOfPart);
            if ($ratio < 0.5 && !$negative) {
                return $this->findBend($negative, $i + $start, $sizeOfPart);
            }
            if ($ratio > 0.99 && $negative) {
               return $this->findBend($negative, $i + $start, $sizeOfPart);
            }
        }
        return $start;
    }

    private function calcRatio($data, $start, $size)
    {
        $partOfData = array_slice($data, $start, $size);
        $firstHalf = array_slice($partOfData, 0, $size/2);
        $secondHalf = array_slice($partOfData, $size/2);
        $firstSum = array_sum($firstHalf);
        $secondSum = array_sum($secondHalf);
        if (!$secondSum) {
            return 0;
        }
        return $firstSum/$secondSum;
    }
    
    private function calcAverage($start, $quantity)
    {
        $sum =0;
        for ($i = $start; $i < $start + $quantity; $i++) {
            $sum = $sum + $this->data[$i];
        }
        return intval($sum/$quantity);
    }
    
    private function smooth($depth)
    {
        for ($i = 0; $i < count($this->data) - $depth; $i++) {
            $this->data[$i] = $this->calcAverage($i, $depth);
        }
    }
    
}
