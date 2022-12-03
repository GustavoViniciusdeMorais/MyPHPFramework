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

    public function post($path, $callback)
    {
        $this->request('POST', $path, $callback);
    }

    public function request($method, $path, $callback)
    {
        $this->collection->add($method, $path, $callback);
    }

    public function run()
    {
        $data = $this->collection->filter($this->method);

        foreach ($data as $key => $value) {
            $result = $this->checkUrl($key, $this->path);

            $callback = $value;
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

    public function checkUrl(string $needle, $subject)
    {
        preg_match_all('/\{([^\}]*)\}/', $needle, $variables);

        $regex = str_replace('/', '\/', $needle);

        foreach ($variables[1] as $key => $variable) {
            $as = explode(':', $variable);
            $replacement = $as[1] ?? '([a-zA-Z0-9\-\_\s]+)';
            $regex = str_replace($variables[$key], $replacement, $regex);
        }
        $regex = preg_replace('/{([a-zA-Z]+)}/', '([a-zA-Z0-9+])', $regex);
        $result = preg_match('/^' . $regex . '$/', $subject, $params);

        return compact('result', 'params');
    }
}
