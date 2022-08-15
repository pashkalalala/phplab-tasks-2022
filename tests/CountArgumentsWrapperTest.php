<?php

use functions\Functions;
use PHPUnit\Framework\TestCase;

class CountArgumentsWrapperTest extends TestCase
{
    protected Functions $functions;
    
    public function setUp(): void
    {
        $this->functions = new Functions();
    }
    
    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);
        
        $this->functions->countArgumentsWrapper(2022, 'hello', [1, 2, 3], false);
    }
}