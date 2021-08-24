<?php

namespace Test;

use Ruter\Route;
use Ruter\Router;
use Ruter\Route\Stub;
use Ruter\Request\Request;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testInstance(): void
    {
        $this->expectNotice();

        $routes = [
            'not_instance_of_Ruter\Route::class' => new Stub(),
        ];

        new Router($routes);
    }

    public function testMatch(): void
    {
        $routes = [
            'route-name' => new Route(new Stub()),
        ];

        $router = new Router($routes);
        $match  = $router->match(new Request('/uri'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals(
            [
                '_route' => 'route-name',
                '_extra' => [],
            ],
            $match->extra()
        );
    }
}