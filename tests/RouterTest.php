<?php

namespace Test;

use Ruter\Router;
use Ruter\Route\Stub;
use Ruter\Request\Request;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testMatch(): void
    {
        $routes = [
            'route-name' => new Stub(),
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