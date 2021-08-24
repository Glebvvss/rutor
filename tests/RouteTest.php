<?php

namespace Test;

use Ruter\Route;
use Ruter\Route\Stub;
use Ruter\Request\Request;
use PHPUnit\Framework\TestCase;
use Ruter\Route\Contract\RouteInterface;

class RouteTest extends TestCase
{
    public function testMatch(): void
    {
        $success = true;
        $extra   = ['foo' => 'bar'];

        $route = new Route(new Stub($success, $extra));
        $match = $route->match(new Request('/anything'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals($extra, $match->extra());
    }

    public function testToUrl(): void
    {
        $success = true;
        $extra   = ['foo' => 'bar'];
        $url     = '/enything';

        $route = new Route(new Stub($success, $extra, $url));
        $this->assertEquals($url, $route->toUrl());
    }
}