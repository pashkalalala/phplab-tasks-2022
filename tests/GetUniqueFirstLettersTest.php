<?php

use PHPUnit\Framework\TestCase;

class GetUniqueFirstLettersTest extends TestCase
{
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($input, $expected)
    {
        $this->assertEquals($expected, getUniqueFirstLetters($input));
    }
    
    public function positiveDataProvider(): array
    {
        return [[
            [
                ["name" => "Chicago Midway Airport"],
                ["name" => "Ontario International Airport"],
                ["name" => "Providence T.F. Green Airport"],
                ["name" => "Atlantic City Airport"],
                ["name" => "Minneapolis/St Paul Intl Airport"],
                ["name" => "Phoenix-Mesa Gateway Airport"],
            ],
                ['A', 'C', 'M', 'O', 'P']
        ]];
    }
}