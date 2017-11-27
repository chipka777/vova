 <?php

namespace Core;

class Route
{

    private $routes = [];

    public function run()
    {
        $path = explode('?', $_SERVER["REQUEST_URI"]);
        $path = $path[0];
        foreach ($this->routes as $route) {
            if ($route['route'] == $path ) {
                $class = $route['action'][0];
                $action = $route['action'][1];

                $obj = new $class;

                if (isset($route['middleware'])) {
                    $wares = [];

                    foreach($route['middleware'] as $middleware) {
                        $class = '\\App\\Middlewares\\' . ucfirst($middleware);
                        $ware = new $class;
                        $wares[] = $ware;
                        $ware->before();
                    }
                }

                $obj->$action($route['data']);

            }
        }

    }

    public function get($route, $action)
    {
        $action = $this->parse($action);
        $action[0] = "\\App\\Controllers\\" . $action[0];

        $get = [];
        foreach ($_GET as $key => $value) {
            $get[$key] = htmlspecialchars(trim($value));
        }
        $this->routes[] = ['route' => $route, 'action' => $action, 'data' => $get];
    }

    public function post($route, $action)
    {
        $action = $this->parse($action);
        $action[0] = "\\App\\Controllers\\" . $action[0];

        $post = [];
        foreach ($_POST as $key => $value) {
            if(is_array($value)) {
                foreach($value as $k=>$v) {
                    $post[$key][$v['name']] = htmlspecialchars(trim($v['value']));
                }
            } else {
                $post[$key] = htmlspecialchars(trim($value));
            }

        }
        $this->routes[] = ['route' => $route, 'action' => $action, 'data' => $post];
    }

    public function group($args = [], $callback)
    {
        $routes = $this->routes;

        $this->routes = [];

        $callback();

        foreach($this->routes as $key => $route) {
            if (is_array($args['middleware']))$route['middleware'] = $args['middleware'];

            else $route['middleware'][] = $args['middleware'];

            $this->routes[$key] = $route;
        }

        $this->routes = array_merge($routes, $this->routes);

    }


    public function parse($action)
    {
        return explode('@', $action);
    }
}