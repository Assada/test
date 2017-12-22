<?php

use Core\Http\Request\Request;

require_once __DIR__ . '/../Core/Autoloader.php';

$loader = new \Core\Autoloader();
$loader->register();
$loader->addNamespace('Core', 'Core');
$loader->addNamespace('App', 'App');

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$router = include __DIR__ . '/../App/Router.php';

$request = Request::create();
$router->dispatch($request);