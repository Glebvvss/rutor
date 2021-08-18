<?php

namespace Ruter\Route\Decorations;

use Closure;
use InvalidArgumentException;
use Ruter\Route\Common\Match;
use Ruter\Request\RequestInterface;
use Ruter\Route\Contracts\RouteInterface;
use Ruter\Route\Contracts\MatchInterface;

class Callback implements RouteInterface
{
    private $callback;
    private RouteInterface $route;

    public function __construct(callable $callback, RouteInterface $route)
    {
        $this->callback = $callback;
        $this->route    = $route;
    }

    public function match(RequestInterface $request): MatchInterface
    {
        $match = $this->route->match($request);
        if (!$match->isSuccessfull()) {
            return new Match(false);    
        }

        if ($this->callback instanceof Closure) {
            $callback = $this->callback;
            $callback($request, $match);
        } else {
            [$class, $method] = $this->callback;
            $class->$method($request, $match);
        }

        return $match;
    }

    public function toUrl(array $params = []): string
    {
        return $this->route->toUrl($params);
    }
}