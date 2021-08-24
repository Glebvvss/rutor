<?php

use Ruter\RouteFactory;
use App\Controllers\{HomeController, NotFoundController};

return [
    'home'      => RouteFactory::get('/',      [new HomeController(), 'index']),
    'not_found' => RouteFactory::any('/{url}', [new NotFoundController(), 'index']),
];