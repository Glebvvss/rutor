<?php

namespace Ruter\Route;

use Ruter\Route\Common\Match;
use Ruter\Request\RequestInterface;
use Ruter\Route\Contract\RouteInterface;
use Ruter\Route\Contract\MatchInterface;

class Stub implements RouteInterface
{
    private bool   $success;
    private array  $extra;
    private string $url;

    public function __construct(bool $success = true, array $extra = [], string $url = '')
    {
        $this->success = $success;
        $this->extra   = $extra;
        $this->url     = $url;
    }

    public function match(RequestInterface $request): MatchInterface
    {
        return new Match($this->success, $this->extra);
    }

    public function toUrl(array $params = []): string
    {        
        return $this->url;
    }
}