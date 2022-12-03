<?php

require __DIR__ . '/vendor/autoload.php';

use Gustavovinicius\Mkfig\Routes\Router;
use Gustavovinicius\Mkfig\DependencyInjection\Resolver;

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// print_r(json_encode([$pathInfo, $requestMethod]));
// exit;

$router = new Router($pathInfo, $requestMethod);

require __DIR__ . '/router.php';

$result = $router->run();

$data = (new Resolver)->method(
    $result['callback'],
    [
        'params' => $result['params']
    ]
);

var_dump($data);
