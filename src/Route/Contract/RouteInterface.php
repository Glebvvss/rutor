<?php

namespace Ruter\Route\Contract;

use Ruter\Request\RequestInterface;

interface RouteInterface
{
    public function match(RequestInterface $request): MatchInterface;

    public function toUrl(array $params): string;
}