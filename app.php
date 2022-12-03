<?php

require __DIR__ . '/vendor/autoload.php';

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// print_r(json_encode([$pathInfo, $requestMethod]));
// exit;

$router = new Gustavovinicius\Mkfig\Routes\Router($pathInfo, $requestMethod);

$router->get('/test/{id}', function ($params) {
    return ' asdfasdfasd ddd ' . $params[1];
});

$result = $router->run();
var_dump($result['callback']($result['params']));
