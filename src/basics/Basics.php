<?php

namespace basics;

class Basics implements BasicsInterface
{
    public BasicsValidator $validator;
    
    const DIV_PARTS = 2;
    
    public function __construct(BasicsValidator $validator)
    {
        $this->validator = $validator;
    }
    
    public function getMinuteQuarter(int $minute): string
    {
        $this->validator->isMinutesException($minute);
    
        if ($minute > 0 && $minute <= 15) {
            return 'first';
        }
    
        if ($minute > 15 && $minute <= 30) {
            return 'second';
        }
    
        if ($minute > 30 && $minute <= 45) {
            return 'third';
        }
    
        return 'fourth';
    }
    
    public function isLeapYear(int $year): bool
    {
        $this->validator->isYearException($year);
    
        return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year % 400) == 0)));
    }
    
    public function isSumEqual(string $input): bool
    {
        $this->validator->isValidStringException($input);
        
        $numbers = str_split($input);
        $partsOfArray = array_chunk($numbers, count($numbers) / self::DIV_PARTS);
        
        return array_sum($partsOfArray[0]) == array_sum($partsOfArray[1]);
    }
    
}