<?php

namespace Ruter\Route\Contracts;

use Ruter\Request\RequestInterface;

interface RouteInterface
{
    public function match(RequestInterface $request): MatchInterface;
}