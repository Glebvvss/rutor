<?php

namespace Test\Route;

use Ruter\Route\Pattern;
use Ruter\Request\Request;
use PHPUnit\Framework\TestCase;

class PatternTest extends TestCase
{
    public function testMatchWithBlankUri(): void
    {
        $uri   = '/';
        $route = new Pattern($uri);
        $match = $route->match(new Request($uri));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testNoMatchWithBlankUri(): void
    {
        $route = new Pattern('/');
        $match = $route->match(new Request('/some-uri'));
        $this->assertFalse($match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testMatchWithoutSlashAtStartEverywhere(): void
    {
        $route = new Pattern('no-stash-at-start-uri');
        $match = $route->match(new Request('no-stash-at-start-uri'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testMatchWithoutSlashAtStartInPattern(): void
    {
        $route = new Pattern('enything');
        $match = $route->match(new Request('/enything'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testMatchWithQueryStringInUri(): void
    {
        $route = new Pattern('/uri');
        $match = $route->match(new Request('/uri?foo=bar'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testMatchWithoutPlaceholders(): void
    {
        $uri   = '/uri';
        $route = new Pattern($uri);
        $match = $route->match(new Request($uri));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testNoMatchWithoutPlaceholders(): void
    {
        $route = new Pattern('/uri');
        $match = $route->match(new Request('/another-uri'));
        $this->assertFalse($match->isSuccessfull());
        $this->assertEquals([], $match->extra());
    }

    public function testMatchWithSinglePlaceholder(): void
    {
        $route = new Pattern('/uri/{foo}');
        $match = $route->match(new Request('/uri/bar'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals(['foo' => 'bar'], $match->extra());
    }

    public function testMatchWithManyPlaceholders(): void
    {
        $route = new Pattern('/uri/{foo1}/{foo2}');
        $match = $route->match(new Request('/uri/bar1/bar2'));
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals(
            [
                'foo1' => 'bar1',
                'foo2' => 'bar2',
            ],
            $match->extra()
        );
    }

    public function testToUrlWithoutPlaceholders(): void
    {
        $route = new Pattern('/uri');
        $this->assertEquals('/uri', $route->toUrl());
    }

    public function testToUrlWithSinglePlaceholder(): void
    {
        $route = new Pattern('/uri/{foo}');
        $this->assertEquals(
            '/uri/bar', 
            $route->toUrl(['foo' => 'bar'])
        );
    }

    public function testToUrlWithManyPlaceholders(): void
    {
        $route = new Pattern('/uri/{foo1}/{foo2}');
        $this->assertEquals(
            '/uri/bar1/bar2',
            $route->toUrl([
                'foo1' => 'bar1',
                'foo2' => 'bar2'
            ])
        );
    }
}