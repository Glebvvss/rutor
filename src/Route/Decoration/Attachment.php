<?php

namespace Ruter\Route\Decoration;

use Ruter\Route\Common\Match;
use Ruter\Request\RequestInterface;
use Ruter\Route\Contract\RouteInterface;
use Ruter\Route\Contract\MatchInterface;

class Attachment implements RouteInterface
{
    private $attachment;
    private RouteInterface $route;

    public function __construct($attachment, RouteInterface $route)
    {
        $this->attachment = $attachment;
        $this->route      = $route;
    }

    public function match(RequestInterface $request): MatchInterface
    {
        $match = $this->route->match($request);
        if ($match->isSuccessfull()) {
            $extra = $match->extra();
            $extra['_attachment'] = $this->attachment;
            return new Match(true, $extra);
        }

        return $match;
    }

    public function toUrl(array $params = []): string
    {
        return $this->route->toUrl($params);
    }
}