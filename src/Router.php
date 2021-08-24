<?php

namespace Ruter;

use Ruter\Route\Group;
use InvalidArgumentException;

class Router extends Group
{
    private const ROOT_PREFIX = '';

    public function __construct(array $routes)
    {
        foreach ($routes as $route) {
            if (!$route instanceof Route) {
                trigger_error('Each route should be instance of ' . Route::class, E_USER_NOTICE);
            }
        }

        parent::__construct(static::ROOT_PREFIX, $routes);
    }    
}