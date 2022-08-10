<?php

namespace arrays;

class Arrays implements ArraysInterface
{
    public function repeatArrayValues(array $input): array
    {
        $newArray = [];
        foreach ($input as $value) {
            for ($i = 0; $i < $value; $i++) {
                $newArray[] = $value;
            }
        }
        
        return $newArray;
    }
    
    public function getUniqueValue(array $input): int
    {
        $arr = [];
        $newArr = array_count_values($input);
    
        foreach ($newArr as $key => $value) {
            if ($value == 1) {
                $arr[] = $key;
            }
        }
    
        if (empty($arr)) {
            return 0;
        }
    
        return min($arr);
    }
    
    public function groupByTag(array $input): array
    {
        $arrGrouped = [];
    
        foreach ($input as $subArr) {
            foreach ($subArr['tags'] as $tag) {
                $arrGrouped[$tag][] = $subArr['name'];
                array_multisort($arrGrouped[$tag]);
            }
        }
        
        return $arrGrouped;
    }
}