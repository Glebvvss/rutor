<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Ruter\Router;
use Ruter\Request\Request;

$routes = require(__DIR__ . '/config/routes.php');
$router = new Router($routes);
$router->match(Request::fromGlobals());