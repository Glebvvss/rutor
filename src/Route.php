<?php

namespace Ruter;

use Ruter\Route\Group;
use Ruter\Route\Pattern;
use Ruter\Request\RequestInterface;
use Ruter\Route\Decorations\Method;
use Ruter\Route\Decorations\Callback;
use Ruter\Route\Contracts\RouteInterface;

class Route
{
    public static function get(string $url, callable $callback): RouteInterface
    {
        return self::of(
            [RequestInterface::METHOD_GET],
            $url,
            $callback
        );
    }

    public static function post(string $url, callable $callback): RouteInterface
    {
        return self::of(
            [RequestInterface::METHOD_POST],
            $url,
            $callback
        );
    }

    public static function patch(string $url, callable $callback): RouteInterface
    {
        return self::of(
            [RequestInterface::METHOD_PATCH], 
            $url, 
            $callback
        );
    }

    public static function put(string $url, callable $callback): RouteInterface
    {
        return self::of(
            [RequestInterface::METHOD_PUT], 
            $url, 
            $callback
        );
    }

    public static function delete(string $url, callable $callback): RouteInterface
    {
        return self::of(
            [RequestInterface::METHOD_DELETE], 
            $url, 
            $callback
        );
    }

    public static function group(string $prefix, array $routes): RouteInterface
    {
        return new Group($prefix, $routes);
    }

    public static function any(string $template, callable $callback): RouteInterface
    {
        return new Callback(
            $callback,
            new Pattern($template)
        );
    }

    public static function of(array $matchMethods, string $template, callable $callback): RouteInterface
    {
        return new Callback($callback,
            new Method(
                $matchMethods,
                new Pattern($template)
            )
        );
    }
}