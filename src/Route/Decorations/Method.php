<?php

namespace Ruter\Route\Decorations;

use InvalidArgumentException;
use Ruter\Route\Common\Match;
use Ruter\Request\RequestInterface;
use Ruter\Route\Contracts\RouteInterface;
use Ruter\Route\Contracts\MatchInterface;

class Method implements RouteInterface
{
    private array $methods;
    private RouteInterface $route;

    public function __construct(array $methods, RouteInterface $route)
    {
        if (empty($methods)) {
            throw new InvalidArgumentException(
                'Param "methods" must not be empty'
            );
        }

        foreach($methods as $method) {
            if (!in_array($method, RequestInterface::SUPPORTED_METHODS)) {
                throw new InvalidArgumentException(
                    'Provided method "' . $method . '" is not supported'
                );
            }
        }

        $this->methods = $methods;
        $this->route   = $route;
    }

    public function match(RequestInterface $request): MatchInterface
    {
        if (in_array($request->method(), $this->methods)) {
            return $this->route->match($request);
        }

        return new Match(false);
    }

    public function toUrl(array $params = []): string
    {
        return $this->route->toUrl($params);
    }
}