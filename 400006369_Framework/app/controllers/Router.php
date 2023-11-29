<?php
namespace app\controllers;
use framework\abstract\AbstractRouter;


class Router extends AbstractRouter
{
    protected $routes = [];
   
    public function getURI()
    {
        $url = parse_url($_SERVER['REQUEST_URI'])['path'] ?? '/';
        return $url;
    }

    public function dispatch($route)
    { 
        try {
            // $url = self::getRoute();
            $url = $route;
            if (array_key_exists($url, $this->routes)) {
                // Split the controller and method using '@'
                list($controllerName, $methodName) =  explode('@', $this->routes[$url]);
                    //change namespace slashes to directory separators.
                    $controllerName = str_replace('\\', DIRECTORY_SEPARATOR, $controllerName);
                

                // Check if the controller class exists
                if (!class_exists($controllerName)) {
                    throw new \Exception("Controller class not found: $controllerName");
                }

                // Create an instance of the controller
                $controller = new $controllerName();

                // Check if the method exists in the controller
                if (!method_exists($controller, $methodName)) {
                    throw new \Exception("Method not found in controller: $methodName");
                }

                // Call the specified method
                $controller->$methodName();
                
            } else {
                // Handle 404 Not Found
                header("HTTP/1.0 404 Not Found");
                echo '404 Not Found';
            }
        } catch (\Exception $e) {
            // Handle exceptions
            header("HTTP/1.1 500 Internal Server Error");
            echo 'Internal Server Error: ' . $e->getMessage();
        }
    }
}
