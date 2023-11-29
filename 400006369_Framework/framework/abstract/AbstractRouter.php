<?php

namespace framework\abstract;

use framework\interface\InterfaceRouter;

abstract class AbstractRouter implements InterfaceRouter
{
    protected $routes = [];

    public function printRoutes()
    {
        echo "Routes:<br>";
        foreach ($this->routes as $url => $controller) {
            echo "$url => $controller<br>";
        }
        // echo parse_url($_SERVER['REQUEST_URI'])['path'];
    }

    public function addRoute($url, $controller)
    {
        $this->routes[$url] = $controller;
    }

    public function removeRoute($url)
    {
        unset($this->routes[$url]);
    }

     
    abstract public function getURI();
    
    abstract public function dispatch($route);


}