<?php

namespace basics;

class BasicsValidator implements BasicsValidatorInterface
{
    
    public function isMinutesException(int $minute): void
    {
        if ($minute < 0 || $minute > 60) {
            throw new \InvalidArgumentException;
        }
    }
    
    public function isYearException(int $year): void
    {
        if ($year < 1900) {
            throw new \InvalidArgumentException;
        }
    }
    
    public function isValidStringException(string $input): void
    {
        if (strlen($input) !== 6) {
            throw new \InvalidArgumentException;
        }
    }
    
}