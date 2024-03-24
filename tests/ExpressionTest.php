<?php

use src\Expression;

class ExpressionTest extends PHPUnit\Framework\TestCase
{
    public function testFindsAString()
    {
        $regex = Expression::make()->find('www');

        $this->assertTrue($regex->test('www'));

        $regex = Expression::make()->then('www');

        $this->assertTrue($regex->test('www'));

    }

    public function testChecksForAnthing()
    {
        $regex = Expression::make()->anything();

        $this->assertTrue($regex->test('foo'));
    }

    public function testMaybeHasAValue()
    {
        $regex = Expression::make()->maybe('http');

        $this->assertTrue($regex->test('http'));

        $this->assertTrue($regex->test(''));
    }

    public function testCanChainMethodCalls()
    {
        $regex = Expression::make()->find('www')->maybe('.')->then('laracasts');

        $this->assertTrue($regex->test('www.laracasts'));
        $this->assertFalse($regex->test('wwwXlaracasts'));
    }

    public function testCanExcludeValues()
    {
        $regex = Expression::make()
                            ->find('foo')
                            ->anythingBut('bar')
                            ->then('biz');

        $this->assertTrue($regex->test('foobazbiz'));

        $this->assertFalse($regex->test('foobarbiz'));
    }
}