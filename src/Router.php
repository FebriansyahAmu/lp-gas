<?php 
namespace App;

use App\Middleware\AuthMiddleware;

class Router{
    protected $routes = [];
    
    private function addRoute($route, $controller, $action, $method, $middleware = null){
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action, 'middleware' => $middleware];
    }

    public function get($route, $controller, $action, $middleware = null){
        $this->addRoute($route, $controller, $action, "GET", $middleware);
    }

    public function post($route, $controller, $action, $middleware = null){
        $this->addRoute($route, $controller, $action, "POST", $middleware);
    }

    public function dispatch(){
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        $route = $this->routes[$method][$uri] ?? null;

        if ($route) {
            if($route['middleware']){
                call_user_func([$route['middleware'], 'checkAuth']);
            }
            $this->callAction($route['controller'], $route['action']);
        } else {
            $this->sendNotFound();
        }
    }

    private function callAction($controller, $action){
        if (class_exists($controller)) {
            $controllerInstance = new $controller();
            if (method_exists($controllerInstance, $action)) {
                $controllerInstance->$action();
            } else {
                throw new \Exception("Method $action not found in $controller");
            }
        } else {
            throw new \Exception("Controller $controller not found");
        }
    }

    private function sendNotFound(){
        http_response_code(404);
        echo "404 - Route not found!";
    }
}
