<?php

namespace Test\Route\Decoration;

use Ruter\Route;
use Ruter\Request\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ruter\Route\Decoration\Attachment;
use Ruter\Route\Contract\RouteInterface;

class AttachmentTest extends TestCase
{
    public function testMatch(): void
    {
        $route = new Attachment(
            $data = [
                '_controller' => 'ClassName',
                '_method'     => 'methodName',
            ],
            $this->newMatchRouteStub()
        );

        $match      = $route->match(new Request('/enything'));
        $attachment = $match->extra()['_attachment'];
        $this->assertTrue($match->isSuccessfull());
        $this->assertEquals($data, $attachment);
    }

    public function testNoMatch(): void
    {
        $route = new Attachment(
            [
                '_controller' => 'ClassName',
                '_method'     => 'methodName',
            ],
            $this->newNoMatchRouteStub()
        );

        $match = $route->match(new Request('/enything'));
        $this->assertFalse($match->isSuccessfull());
        $this->assertTrue(
            empty($match->extra()['_attachment'])
        );
    }

    private function newMatchRouteStub(): RouteInterface
    {
        $match = true;
        return new Route\Stub($match);
    }

    private function newNoMatchRouteStub(): RouteInterface
    {
        $match = false;
        return new Route\Stub($match);
    }
}