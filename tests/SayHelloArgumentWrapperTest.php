<?php

use functions\Functions;
use PHPUnit\Framework\TestCase;

class SayHelloArgumentWrapperTest extends TestCase
{
    protected Functions $functions;
    
    public function setUp(): void
    {
        $this->functions = new Functions();
    }
    
    public function testNegative()
    {
        $this->expectException(InvalidArgumentException::class);
        
        $this->functions->sayHelloArgumentWrapper([1, 2, 3]);
    }
}