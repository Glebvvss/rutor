<?php

namespace Test\Route\Decorations;

use Ruter\Route;
use Ruter\Request\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ruter\Route\Decorations\Callback;

class CallbackTest extends TestCase
{
    public function testClosure(): void
    {
        $called   = false;
        $callback = function() use (&$called): void {
            $called = true;
        };

        $route = new Callback(
            $callback,
            new Route\Stub()
        );

        $match = $route->match(new Request('/enything'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertTrue($called);
    }

    public function testCallableClass(): void
    {
        $controller = new class() {
            public bool $called = false;
            public function action(): void
            {
                $this->called = true;
            }
        };

        $route = new Callback(
            [$controller, 'action'],
            new Route\Stub()
        );

        $match = $route->match(new Request('/enything'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertTrue($controller->called);
    }

    public function testNoCallWhenNoMatch(): void
    {
        $called   = false;
        $callback = function() use (&$called) {
            $called = true;
        };

        $route = new Callback(
            $callback,
            new Route\Stub($successMatch = false)
        );

        $match = $route->match(new Request('/enything'));
        $this->assertFalse($match->isSuccessfull());
        $this->assertFalse($called);
    }
}