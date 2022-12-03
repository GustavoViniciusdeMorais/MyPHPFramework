<?php

namespace Gustavovinicius\Mkfig;

use Gustavovinicius\Mkfig\Routes\Router;
use Gustavovinicius\Mkfig\DependencyInjection\Resolver;
use Gustavovinicius\Mkfig\Renderer\PHPRenderInterface;

class App
{
    private $router;
    private $render;

    public function __construct()
    {
        $pathInfo = $_SERVER['PATH_INFO'] ?? '/';
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->router = new Router($pathInfo, $requestMethod);
    }

    public function setRender($render)
    {
        $this->render = $render;
    }

    public function get($path, $callback)
    {
        $this->router->get($path, $callback);
    }

    public function post($path, $callback)
    {
        $this->router->post($path, $callback);
    }

    public function run()
    {
        $route = $this->router->run();
        $resolver = new Resolver();

        $data = $resolver->method(
            $route['callback'],
            [
                'params' => $route['params']
            ]
        );

        $this->render->setData($data);
        $this->render->run();
    }
}
