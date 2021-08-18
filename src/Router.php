<?php

namespace Ruter;

use Ruter\Route\Group;

class Router extends Group
{
    private const ROOT_PREFIX = '';

    public function __construct(array $routes)
    {
        parent::__construct(static::ROOT_PREFIX, $routes);
    }    
}