<?php

namespace Test\Route\Common;

use PHPUnit\Framework\TestCase;
use Ruter\Route\Common\Template;

class TemplateTest extends TestCase
{
    public function testWithoutParams(): void
    {
        $template = new Template('/uri');
        $this->assertEquals('~^/uri$~ui', $template->toRegExp());
        $this->assertEquals([], $template->params());
    }

    public function testWithoutSlashAtStart(): void
    {
        $template = new Template('uri');
        $this->assertEquals('~^/uri$~ui', $template->toRegExp());
        $this->assertEquals([], $template->params());
    }
    
    public function testWithSingleParam(): void
    {
        $template = new Template('/uri/{foo}');
        $this->assertEquals('~^/uri/(?<foo>[^/]+)$~ui', $template->toRegExp());
        $this->assertEquals(['foo'], $template->params());
    }

    public function testWithManyParams(): void
    {
        $template = new Template('/uri/{foo}/{bar}');
        $this->assertEquals('~^/uri/(?<foo>[^/]+)/(?<bar>[^/]+)$~ui', $template->toRegExp());
        $this->assertEquals(['foo', 'bar'], $template->params());
    }
}