<?php

use Core\Http\Request\Request;

$router = new Core\Router();

$router->add('/posts/{id:\d+}', ['controller' => 'Post', 'action' => 'view', 'methods' => [Request::METHOD_GET]]);
$router->add('/posts', ['controller' => 'Post', 'action' => 'list', 'methods' => [Request::METHOD_GET]]);
$router->add('/posts', ['controller' => 'Post', 'action' => 'create', 'methods' => [Request::METHOD_POST]]);
$router->add('/posts/{id:\d+}', ['controller' => 'Post', 'action' => 'update', 'methods' => [Request::METHOD_PUT, Request::METHOD_PATCH]]);
$router->add('/posts/{id:\d+}', ['controller' => 'Post', 'action' => 'delete', 'methods' => [Request::METHOD_DELETE]]);

$router->add('/auth/token', ['controller' => 'Auth', 'action' => 'token', 'methods' => [Request::METHOD_POST]]);

return $router;