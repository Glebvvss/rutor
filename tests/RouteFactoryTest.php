<?php

namespace Test;

use Ruter\Route;
use Ruter\Route\Stub;
use Ruter\Route\Group;
use Ruter\RouteFactory;
use Ruter\Route\Pattern;
use Ruter\Request\Request;
use PHPUnit\Framework\TestCase;
use Ruter\Route\Decoration\Method;
use Ruter\Route\Decoration\Callback;
use Ruter\Route\Contract\RouteInterface;

class RouteFactoryTest extends TestCase
{
    public function testAny(): void
    {
        $uri      = '/anything';
        $callback = function() {};
        $this->assertEquals(
            new Route(
                new Callback(
                    $callback,
                    new Pattern($uri)
                )
            ),
            RouteFactory::any($uri, $callback)
        );
    }

    public function testOf(): void
    {
        $uri          = '/anything';
        $callback     = function() {};
        $matchMethods = [Request::METHOD_GET];
        $this->assertEquals(
            $this->makeRoute($matchMethods, $uri, $callback),
            RouteFactory::of($matchMethods, $uri, $callback)
        );
    }

    public function testGroup(): void
    {
        $prefix = '/anything';
        $routes = [
            'route1' => new Stub(),
            'route2' => new Stub()
        ];

        $this->assertEquals(
            new Route(new Group($prefix, $routes)),
            RouteFactory::group($prefix, $routes)
        );
    }

    public function testGet(): void
    {
        $uri      = '/anything';
        $callback = function() {};
        $this->assertEquals(
            $this->makeRoute([Request::METHOD_GET], $uri, $callback),
            RouteFactory::get($uri, $callback)
        );
    }

    public function testPost(): void
    {
        $uri      = '/anything';
        $callback = function() {};
        $this->assertEquals(
            $this->makeRoute([Request::METHOD_POST], $uri, $callback),
            RouteFactory::post($uri, $callback)
        );
    }

    public function testPatch(): void
    {
        $uri      = '/anything';
        $callback = function() {};
        $this->assertEquals(
            $this->makeRoute([Request::METHOD_PATCH], $uri, $callback),
            RouteFactory::patch($uri, $callback)
        );
    }

    public function testPut(): void
    {
        $uri      = '/anything';
        $callback = function() {};
        $this->assertEquals(
            $this->makeRoute([Request::METHOD_PUT], $uri, $callback),
            RouteFactory::put($uri, $callback)
        );
    }

    public function testDelete(): void
    {
        $uri      = '/anything';
        $callback = function() {};
        $this->assertEquals(
            $this->makeRoute([Request::METHOD_DELETE], $uri, $callback),
            RouteFactory::delete($uri, $callback)
        );
    }

    private function makeRoute(array $matchMethods, string $uri, callable $callback): RouteInterface
    {
        return 
            new Route(
                new Callback($callback,
                    new Method($matchMethods,new Pattern($uri))
                )
            )
        ;
    }
}