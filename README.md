# My Framework

This framework is a route system.

```
php -S 0.0.0.0:8000
```

Created by: Gustavo Vinicius

### ./app.php
```php
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
```

### ./src/Routes/Router.php
```php
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
            $urlParams = $this->getUrlParams($routePath, $this->path);

            $callback = $routeCallBack;
            if ($urlParams['result']) {
                break;
            }
        }

        if (!$urlParams['result']) {
            $callback = null;
        }

        return [
            'params' => $urlParams['params'],
            'callback' => $callback
        ];
    }

    public function getUrlParams(string $routePath, $requestPath)
    {
        preg_match_all('/\{\w*\}/', $routePath, $routeParams);

        $regex = str_replace('/', '\/', $routePath);

        $regex = preg_replace('/{([a-zA-Z]+)}/', '([a-zA-Z0-9]+)', $regex);

        $result = preg_match('/^' . $regex . '$/', $requestPath, $params);

        return compact('result', 'params');
    }
}
```

### ./src/Routes/RouterCollection.php
```php
namespace Gustavovinicius\Mkfig\Routes;

use Illuminate\Support\Collection;

class RouterCollection
{
    protected $collection = [];

    public function add(string $method, string $path, $callback)
    {
        if (!isset($this->collection[$method])) {
            $this->collection[$method] = new Collection();
        }
    
        $this->collection[$method]->put($path, $callback);
    }

    public function filter($method)
    {
        if (!isset($this->collection[$method])) {
            $this->collection[$method] = new Collection();
        }
    
        return $this->collection[$method];
    }
}
```

![TDD](/imgs/routeExample.png)
