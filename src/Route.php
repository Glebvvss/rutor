<?php

namespace Ruter;

use Ruter\Request\RequestInterface;
use Ruter\Route\Contract\MatchInterface;
use Ruter\Route\Contract\RouteInterface;

class Route implements RouteInterface
{
    private RouteInterface $route;

    public function __construct(RouteInterface $route)
    {
        $this->route = $route;
    }

    public function match(RequestInterface $request): MatchInterface
    {
        return $this->route->match($request);
    }

    public function toUrl(array $params = []): string
    {
        return $this->route->toUrl($params);
    }
}