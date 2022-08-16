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
        $reverseString = implode(array_reverse(mb_str_split($input)));
        
        return implode(' ',array_reverse(explode(' ', $reverseString)));
    }
    
    public function getBrandName(string $noun): string
    {
        if (substr($noun, 0, 1) === substr($noun, -1)) {
            return ucwords($noun . substr($noun, 1));
        }
        
        return 'The ' . ucwords($noun);
    }
    
}