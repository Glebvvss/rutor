<?php

namespace Test\Route;

use Ruter\Request\Request;
use Ruter\Route\Stub;
use PHPUnit\Framework\TestCase;

class StubTest extends TestCase
{
    public function testMatchWithoutExtra(): void
    {
        $successMatch = true;
        $route = new Stub($successMatch);
        $match = $route->match(new Request('/any/url'));
        $this->assertEquals($successMatch, $match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testMatchWithExtra(): void
    {
        $successMatch = true;
        $route = new Stub(true, $extra = ['foo' => 'bar']);
        $match = $route->match(new Request('/any/url'));
        $this->assertEquals($successMatch, $match->isSuccessfull());
        $this->assertEquals($extra, $match->extra());
    }

    public function testToUrlInAnyWay(): void
    {
        $route = new Stub();
        $this->assertEquals('', $route->toUrl());
    }
}