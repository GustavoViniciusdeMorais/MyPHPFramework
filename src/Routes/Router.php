<?php

namespace Gustavovinicius\Mkfig\Routes;

class Router
{
    private $collection;
    private $path;
    private $method;

    public function __construct(string $path, string $method)
    {
        $this->collection = new RouterCollection();
        $this->path = $path;
        $this->method = $method;
    }

    public function get($path, $callback)
    {
        $this->request('GET', $path, $callback);
    }

    public function request($method, $path, $callback)
    {
        $this->collection->add($method, $path, $callback);
    }

    public function run()
    {
        $verbRoutes = $this->collection->filter($this->method);

        foreach ($verbRoutes as $routePath => $routeCallBack) {
            $result = $this->checkUrl($routePath, $this->path);

            $callback = $routeCallBack;
            if ($result['result']) {
                break;
            }
        }

        if (!$result['result']) {
            $callback = null;
        }

        return [
            'params' => $result['params'],
            'callback' => $callback
        ];
    }

    public function checkUrl(string $routePath, $requestPath)
    {
        preg_match_all('/\{\w*\}/', $routePath, $routeParams);

        $regex = str_replace('/', '\/', $routePath);

        $regex = preg_replace('/{([a-zA-Z]+)}/', '([a-zA-Z0-9]+)', $regex);

        $result = preg_match('/^' . $regex . '$/', $requestPath, $params);

        return compact('result', 'params');
    }
}
