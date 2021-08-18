<?php

namespace Test\Request;

use Ruter\Request\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testUri(): void
    {
        $request = new Request('/uri');
        $this->assertSame('/uri', $request->uri());
    }

    public function testWithUri(): void
    {
        $request = new Request($uri = '/uri');
        $this->assertEquals($uri, $request->path());

        $anotherRequest = $request->withUri($anotherUri = '/another/uri');
        $this->assertEquals($anotherUri, $anotherRequest->path());
    }

    public function testDefaultMethod(): void
    {
        $request = new Request('/uri');
        $this->assertEquals(Request::METHOD_GET, $request->method());
    }

    public function testNoDefaultMethod(): void
    {
        $request = new Request('/uri', Request::METHOD_POST);
        $this->assertEquals(Request::METHOD_POST, $request->method());
    }

    public function testUnsupportedMethod(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Request('/uri', 'NOT_SUPPORTED_METHOD');
    }
}