<?php 
namespace App;

use App\Middleware\AuthMiddleware;

class Router {
    protected $routes = [];
    protected $container = [];
    protected $groupPrefix = '';

    public function __construct($container = null){
        $this->container = $container;
    }

    private function addRoute($route, $controller, $action, $method, $middleware = null){
        $route = $this->groupPrefix . $route;

        // Ubah route menjadi ekspresi reguler jika ada parameter dinamis
        $routeRegex = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
        $this->routes[$method][$routeRegex] = [
            'controller' => $controller,
            'action' => $action,
            'middleware' => $middleware
        ];
    }
    
    public function get($route, $controller, $action, $middleware = null) {
        $this->addRoute($route, $controller, $action, "GET", $middleware);
    }

    public function post($route, $controller, $action, $middleware = null) {
        $this->addRoute($route, $controller, $action, "POST", $middleware);
    }

    public function pu($route, $controller, $action, $middleware = null){
        $this->addRoute($route, $controller, $action, "PUT", $middleware);
    }

    public function delete($route, $controller, $action, $middleware = null){
        $this->addRoute($route, $controller, $action, "DELETE", $middleware);
    }

    public function group($prefix, $callback){
        $previousGroup = $this->groupPrefix;
        $this->groupPrefix = $previousGroup . $prefix;

        $callback($this);
        $this->groupPrefix = $previousGroup;
    }

    public function dispatch() {
        $uri = strtok($_SERVER['REQUEST_URI'], '?');
        $method = $_SERVER['REQUEST_METHOD'];

        $matchedRoute = null;
        $params = [];

        // Cek setiap route untuk mencocokkan URI
        foreach($this->routes[$method] as $routePattern => $route){
            if(preg_match('#^' . $routePattern . '$#', $uri, $matches)){
                $matchedRoute = $route;
                $params = array_slice($matches, 1); // Ambil parameter dari hasil preg_match
                break;
            }
        }

        if ($matchedRoute) {
            if ($matchedRoute['middleware']) {
                $middlewareResult = $this->handleMiddleware($matchedRoute['middleware']);
                // if ($middlewareResult !== true) {
                //     // Alih-alih melakukan echo, kita bisa mengirimkan respon error yang lebih jelas
                //     $this->sendErrorResponse(403, 'Forbidden: ' . json_encode($middlewareResult));
                //     return;
                // }
            }
            $this->callAction($matchedRoute['controller'], $matchedRoute['action'], $params);
        } else {
            $this->sendNotFound();
        }
    }

    private function handleMiddleware($middleware) {
        if (is_array($middleware) && isset($middleware['role'])) {
            return call_user_func([$middleware['class'], 'checkAuth'], $middleware['role']);
        } else {
            return call_user_func([$middleware, 'checkAuth']);
        }
    }

    private function callAction($controller, $action, $params = []){
        if(class_exists($controller)){
            $controllerInstance = $this->container ? $this->container->get($controller) : new $controller();
            if(method_exists($controllerInstance, $action)){
                call_user_func_array([$controllerInstance, $action], $params);
            }else{
                throw new \Exception("Method $action not found in $controller");
            }
        }else{
            throw new \Exception("Controller $controller not found");
        }
    }

    private function sendNotFound() {
        http_response_code(404);
        echo json_encode([
            'error' => 'Route not found'
        ], JSON_PRETTY_PRINT);
    }

    private function sendErrorResponse($statusCode, $message){
        http_response_code($statusCode);
        echo json_encode([
            'status' => 'error',
            'message' => $message
        ], JSON_PRETTY_PRINT);
        exit;
    }
}
