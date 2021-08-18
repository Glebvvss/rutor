<?php

namespace Test\Route\Decorations;

use Ruter\Route;
use Ruter\Request\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ruter\Route\Decorations\Method;

class MethodTest extends TestCase
{
    public function testSingleAllowedMethod(): void
    {
        $route = new Method(
            [Request::METHOD_GET],
            new Route\Stub()
        );

        $match = $route->match(
            new Request(
                '/anything', 
                Request::METHOD_GET
            )
        );

        $this->assertTrue($match->isSuccessfull());
    }

    public function testNoCatchMethod(): void
    {
        $route = new Method(
            [Request::METHOD_GET],
            new Route\Stub()
        );

        $match = $route->match(
            new Request(
                '/anything', 
                Request::METHOD_POST
            )
        );

        $this->assertFalse($match->isSuccessfull());
    }

    public function testEmptyMethodList(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $allowedMethods = [];
        new Method(
            $allowedMethods,
            new Route\Stub()
        );
    }

    public function testNoSupportedMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Method(
            ['NO_SUPPORTED_METHOD_NAME'],
            new Route\Stub()
        );
    }
}