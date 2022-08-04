<?php

namespace basics;

class Basics implements BasicsInterface
{
    public BasicsValidator $validator;
    
    public function __construct(BasicsValidator $validator)
    {
        $this->validator = $validator;
    }
    
    public function getMinuteQuarter(int $minute): string
    {
        $this->validator->isMinutesException($minute);
        
        if ($minute >= 1 && $minute <= 15 ) {
            return "first";
        } elseif ($minute > 15 && $minute <= 30) {
            return "second";
        } elseif ($minute > 30 && $minute <= 45) {
            return "third";
        } else {
            return "fourth";
        }
    }
    
    public function isLeapYear(int $year): bool
    {
        $this->validator->isYearException($year);
    
        if ($year % 4 !== 0) {
            return false;
        } elseif ($year % 100 !== 0) {
            return true;
        } elseif ($year % 400 !== 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function isSumEqual(string $input): bool
    {
        $this->validator->isYearException($input);
        
        $arr = str_split($input);
        $sum1 = array_sum(array_slice($arr, 0, 3));
        $sum2 = array_sum(array_slice($arr, 3));
        
        return $sum1 == $sum2;
    }
    
}