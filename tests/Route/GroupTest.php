<?php

namespace Test\Route;

use Ruter\Route;
use Ruter\Request\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    public function testMatchWithEmptyGroup(): void
    {
        $route = new Route\Group($prefix = '/prefix/uri', []);
        $match = $route->match(new Request($prefix));
        $this->assertFalse($match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testMatchWithSingleSubRoute(): void
    {
        $route = new Route\Group(
            '/prefix/uri',
            [
                'route1' => new Route\Stub(true, $extra = ['foo' => 'bar'])
            ]
        );

        $match = $route->match(new Request('/prefix/uri'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals(
            [
                '_route' => 'route1',
                '_extra' => $extra
            ], 
            $match->extra()
        );
    }

    public function testMatchWithManySubRoutes(): void
    {
        $route = new Route\Group(
            '/prefix/uri',
            [
                'route1' => new Route\Stub(true, $extra = ['foo1' => 'bar1']),
                'route2' => new Route\Stub(true, ['foo2' => 'bar2']),
            ]
        );

        $match = $route->match(new Request('/prefix/uri'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals(
            [
                '_route' => 'route1',
                '_extra' => $extra
            ],
            $match->extra()
        );
    }

    public function testMatchNestedGroup(): void
    {
        $route = new Route\Group(
            '/prefix1',
            [
                'group' => new Route\Group(
                    '/prefix2',
                    [
                        'route' => new Route\Stub()
                    ]
                )
            ]
        );

        $match = $route->match(new Request('/prefix1/prefix2'));
        $this->assertTrue($match->isSuccessfull());
    }

    public function testMatchWithPatternRoute(): void
    {
        $route = new Route\Group(
            '/prefix',
            [
                'route1' => new Route\Pattern('/{slug}')
            ]
        );

        $match = $route->match(new Request('/prefix/slug-value'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals(
            [
                '_route' => 'route1',
                '_extra' => ['slug' => 'slug-value']
            ],
            $match->extra()
        );
    }

    public function testMatchPatternWithNestedGroup(): void
    {
        $route = new Route\Group(
            '/prefix1',
            [
                'group' => new Route\Group(
                    '/prefix2',
                    [
                        'route' => new Route\Pattern('/{slug}')
                    ]
                )
            ]
        );

        $match = $route->match(new Request('/prefix1/prefix2/slug-value'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals(
            [
                '_route' => 'group',
                '_extra' => [
                    '_route' => 'route',
                    '_extra' => [
                        'slug' => 'slug-value'
                    ]
                ]
            ],
            $match->extra()
        );
    }

    public function testToUrlWithoutRouteParam(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $route = new Route\Group(
            '/prefix/uri',
            [
                'route1' => new Route\Stub(),
                'route2' => new Route\Stub(),
            ]
        );

        $route->toUrl([]);
    }

    public function testToUrlWithValidRouteParam(): void
    {
        $route = new Route\Group(
            '/prefix/uri',
            [
                'route1' => new Route\Stub(),
                'route2' => new Route\Stub(),
            ]
        );

        $this->assertEquals('/prefix/uri', $route->toUrl(['_route' => 'route1']));
        $this->assertEquals('/prefix/uri', $route->toUrl(['_route' => 'route2']));
    }

    public function testToUrlWithInvalidRouteParam(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $route = new Route\Group(
            '/prefix/uri',
            [
                'route1' => new Route\Stub(),
                'route2' => new Route\Stub(),
            ]
        );

        $route->toUrl(['_route' => 'not valid route name']);
    }
}