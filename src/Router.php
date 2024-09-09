<?php 
namespace App;

use App\Middleware\AuthMiddleware;

class Router {
    protected $routes = [];
    
    private function addRoute($route, $controller, $action, $method, $middleware = null) {
        $this->routes[$method][$route] = ['controller' => $controller, 'action' => $action, 'middleware' => $middleware];
    }

    public function get($route, $controller, $action, $middleware = null) {
        $this->addRoute($route, $controller, $action, "GET", $middleware);
    }

    public function post($route, $controller, $action, $middleware = null) {
        $this->addRoute($route, $controller, $action, "POST", $middleware);
    }

    public function dispatch() {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        $route = $this->routes[$method][$uri] ?? null;

        if ($route) {
            // Handle middleware if it exists
            if ($route['middleware']) {
                // Middleware could be a string (class name) or an array with role checks
                $middleware = $route['middleware'];
                
                // Check if middleware requires role-based authentication
                if (is_array($middleware) && isset($middleware['role'])) {
                    // Middleware with role check
                    call_user_func([$middleware['class'], 'checkAuth'], $middleware['role']);
                } else {
                    // Middleware without role check
                    call_user_func([$middleware, 'checkAuth']);
                }
            }
            
            $this->callAction($route['controller'], $route['action']);
        } else {
            $this->sendNotFound();
        }
    }

    private function callAction($controller, $action) {
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

    private function sendNotFound() {
        http_response_code(404);
        echo "404 - Route not found!";
    }
}
