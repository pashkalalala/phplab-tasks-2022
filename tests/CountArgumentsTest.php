<?php

use functions\Functions;
use PHPUnit\Framework\TestCase;

class CountArgumentsTest extends TestCase
{
    protected Functions $functions;
    
    public function setUp(): void
    {
        $this->functions = new Functions();
    }
    
    /**
     * @dataProvider positiveDataProvider
     */
    public function testPositive($expected, ...$arg)
    {
        $this->assertEquals($expected, $this->functions->countArguments(...$arg));
    }
    
    public function positiveDataProvider(): array
    {
        return [
            [
                ['argument_count' => 0, 'argument_values' => []],
            ],
            [
                ['argument_count' => 1, 'argument_values' => [0 => 'hello']],
                'hello'
            ],
            [
                ['argument_count' => 2, 'argument_values' => [0 => 'hello', 1 => 'world']],
                'hello', 'world'
            ],
        ];
    }
}