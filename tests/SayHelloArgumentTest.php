<?php

use functions\Functions;
use PHPUnit\Framework\TestCase;

class SayHelloArgumentTest extends TestCase
{
    protected Functions $functions;
    
    public function setUp(): void
    {
        $this->functions = new Functions();
    }
    
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($arg, $expected)
    {
        $this->assertEquals($expected, $this->functions->sayHelloArgument($arg));
    }
    
    public function positiveDataProvider(): array
    {
        return [
            ['Pasha', 'Hello Pasha'],
            [2022, 'Hello 2022'],
            [true, 'Hello 1'],
        ];
    }
}
