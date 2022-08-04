<?php

namespace strings;

class Strings implements StringsInterface
{
    
    public function snakeCaseToCamelCase(string $input): string
    {
        $upperWords = ucwords($input, "_");
    
        return lcfirst(str_replace('_', '', $upperWords));
    }
    
    public function mirrorMultibyteString(string $input): string
    {
        $explodedArr = explode(' ', $input);
        $reverseArr = [];
        
        foreach ($explodedArr as $value) {
            $reverseArr[] = implode(array_reverse(mb_str_split($value)));
        }
        
        return implode(' ',$reverseArr);
    }
    
    public function getBrandName(string $noun): string
    {
        if (substr($noun, 0, 1) === substr($noun, -1)) {
            $newBrandName = ucwords($noun . substr($noun, 1));
        } else {
            $newBrandName = 'The ' . ucwords($noun);
        }
        
        return $newBrandName;
    }
    
}