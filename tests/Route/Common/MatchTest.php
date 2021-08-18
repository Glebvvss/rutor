<?php

use Test\Route\Common;

use Ruter\Route\Common\Match;
use PHPUnit\Framework\TestCase;

class MatchTest extends TestCase
{
    public function testIsSuccessfullTruthy(): void
    {
        $match = new Match(true);
        $this->assertTrue($match->isSuccessfull());
    }

    public function testIsSuccessfullFalsy(): void
    {
        $match = new Match(false);
        $this->assertFalse($match->isSuccessfull());
    }

    public function testExtra(): void
    {
        $match = new Match(true, $extra = ['foo' => 'bar']);
        $this->assertEquals($extra, $match->extra());
    }
}