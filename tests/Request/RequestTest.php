<?php

namespace Test\Request;

use Ruter\Request\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testUri(): void
    {
        $request = new Request('/uri?foo=bar');
        $this->assertSame('/uri?foo=bar', $request->uri());
    }

    public function testUriWithArrayParams(): void
    {
        $params = ['foo' => 'bar'];
        $request = new Request('/uri', Request::METHOD_GET, $params);
        $this->assertSame('/uri?foo=bar', $request->uri());
    }

    public function testPath(): void
    {
        $request = new Request('/uri');
        $this->assertSame('/uri', $request->path());
    }

    public function testPathWithQueryString(): void
    {
        $request = new Request('/uri?foo=bar');
        $this->assertSame('/uri', $request->path());
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

    public function testEmptyQueryParams(): void
    {
        $request = new Request('/uri');
        $this->assertEquals([], $request->queryParams());
    }

    public function testInUriQueryParams(): void
    {
        $request = new Request('/uri?foo=bar');
        $this->assertEquals(['foo' => 'bar'], $request->queryParams());
    }

    public function testArrayQueryParams(): void
    {
        $queryParams = ['foo' => 'bar'];
        $request = new Request('/uri', Request::METHOD_GET, $queryParams);
        $this->assertEquals($queryParams, $request->queryParams());
    }

    public function testMixedQueryParams(): void
    {
        $queryParams = ['foo1' => 'bar1'];
        $request = new Request('/uri?foo2=bar2', Request::METHOD_GET, $queryParams);
        $this->assertEquals(
            [
                'foo1' => 'bar1',
                'foo2' => 'bar2',
            ],
            $request->queryParams()
        );
    }

    public function testBodyParams(): void
    {
        $request = new Request(
            '/uri', 
            Request::METHOD_POST,
            $bodyParams = ['foo' => 'bar']
        );

        $this->assertEquals(
            $bodyParams,
            $request->bodyParams()
        );
    }

    public function testIgnoreBodyParamsIfGetRequest(): void
    {
        $bodyParams = ['foo' => 'bar'];
        $request = new Request(
            '/uri', 
            Request::METHOD_GET,
            $bodyParams
        );

        $this->assertEquals(
            [],
            $request->bodyParams()
        );
    }

    public function testEmptyCookies(): void
    {
        $request = new Request(
            '/uri', 
            Request::METHOD_GET,
            [],
            $cookies = []
        );

        $this->assertEquals($cookies, $request->cookies());
    }

    public function testExistentCookies(): void
    {
        $request = new Request(
            '/uri', 
            Request::METHOD_GET,
            [],
            $cookies = ['foo' => 'bar']
        );

        $this->assertEquals($cookies, $request->cookies());
    }
}