<?php

namespace Ruter\Route\Decorations;

use Ruter\Route\Common\Match;
use Ruter\Request\RequestInterface;
use Ruter\Route\Contracts\RouteInterface;
use Ruter\Route\Contracts\MatchInterface;

class Attachment implements RouteInterface
{
    private array          $attachment;
    private RouteInterface $route;

    public function __construct(callable $attachment, RouteInterface $route)
    {
        $this->attachment = $attachment;
        $this->route      = $route;
    }

    public function match(RequestInterface $request): MatchInterface
    {
        $match = $this->route->match($request);
        $extra = $match->extra();
        $extra['_attachment'] = $this->attachment;
        return new Match(
            $match->isSuccessfull(),
            $extra
        );
    }

    public function toUrl(array $params = []): string
    {
        return $this->route->toUrl($params);
    }
}