<?php

use functions\Functions;
use PHPUnit\Framework\TestCase;

class SayHelloTest extends TestCase
{
    protected Functions $functions;
    
    public function setUp(): void
    {
        $this->functions = new Functions();
    }
    
    public function testPositive()
    {
        $this->assertEquals('Hello', $this->functions->sayHello());
    }
}