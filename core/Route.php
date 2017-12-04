<?php

namespace Core;

use App\Models\User;


class Route
{

    private $routes = [];

    public function run()
    {
        $this->setUser();

        $path = explode('?', $_SERVER["REQUEST_URI"]);
        $path = $path[0];

        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['route'] == $path && $route['method'] == $method) {
                $class = $route['action'][0];
                $action = $route['action'][1];

                $obj = new $class;

                if (isset($route['middleware'])) {
                    foreach($route['middleware'] as $middleware) {
                        $class = '\\App\\Middlewares\\' . ucfirst($middleware);
                        $ware = new $class;
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
        $this->routes[] = ['route' => $route, 'action' => $action, 'data' => $get, 'method' => 'GET'];
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
        $this->routes[] = ['route' => $route, 'action' => $action, 'data' => $post, 'method' => 'POST'];
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

    public function setUser()
    {
        if (isset($_SESSION['user'])) {
            Auth::user(User::find($_SESSION['user']['id']));
        }
    }
}