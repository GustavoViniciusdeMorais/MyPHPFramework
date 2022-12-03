<?php

require __DIR__ . '/vendor/autoload.php';

use Gustavovinicius\Mkfig\Routes\Router;

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

$router = new Router($pathInfo, $requestMethod);

$router->get('/gustavo/{id}', function ($params) {
    return 'called route gustavo, with data = ' . $params[1];
});

$result = $router->run();
var_dump($result['callback']($result['params']));
