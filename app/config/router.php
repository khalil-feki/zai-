<?php
class Router {
    private $routes = [];
    
    public function addRoute($path, $controller, $method) {
        $this->routes[] = [
            'path' => $path,
            'controller' => $controller,
            'method' => $method
        ];
    }
    
    public function dispatch() {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestPath = parse_url($requestUri, PHP_URL_PATH);
        
        // Remove leading slash and trailing slash
        $requestPath = trim($requestPath, '/');
        
        foreach ($this->routes as $route) {
            if ($this->matchRoute($route['path'], $requestPath)) {
                $this->callController($route['controller'], $route['method'], $requestPath, $route['path']);
                return;
            }
        }
        
        // No route found - 404
        http_response_code(404);
        echo "404 - Page Not Found";
    }
    
    private function matchRoute($routePath, $requestPath) {
        // Handle empty routes
        if ($routePath === '' && $requestPath === '') {
            return true;
        }
        
        // Convert route path to regex pattern
        $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';
        
        return preg_match($pattern, $requestPath);
    }
    
    private function callController($controllerName, $methodName, $requestPath, $routePath) {
        // Extract parameters from URL
        $params = $this->extractParams($routePath, $requestPath);
        
        // Include controller file
        $controllerFile = 'controllers/' . $controllerName . '.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        }
        
        // Check if controller class exists
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            
            // Check if method exists
            if (method_exists($controller, $methodName)) {
                // Call the method with parameters
                call_user_func_array([$controller, $methodName], $params);
            } else {
                http_response_code(500);
                echo "Method $methodName not found in $controllerName";
            }
        } else {
            http_response_code(500);
            echo "Controller $controllerName not found";
        }
    }
    
    private function extractParams($routePath, $requestPath) {
        $params = [];
        
        // Convert route path to regex with named groups
        $routeParts = explode('/', $routePath);
        $requestParts = explode('/', $requestPath);
        
        for ($i = 0; $i < count($routeParts); $i++) {
            if (isset($routeParts[$i]) && preg_match('/\{([^}]+)\}/', $routeParts[$i])) {
                if (isset($requestParts[$i])) {
                    $params[] = $requestParts[$i];
                }
            }
        }
        
        return $params;
    }
}
?>