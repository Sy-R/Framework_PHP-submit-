<?php

namespace framework\interface;

interface InterfaceRouter
{
    public function getURI();

    public function addRoute($url, $controller);

    public function removeRoute($url);

    public function printRoutes();

    public function dispatch($route);
}
