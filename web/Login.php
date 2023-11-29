<?php
namespace web;

require_once '/wamp64/400006369_Framework/config/Autoloader.php';

use app\controllers\Router;

//Create class objects
$router = new Router();

//original route
$router->addRoute('/web/Login', 'web\\LoginResponse@index');

//Redirect to login page (for errors)  
$router->addRoute('/web/Login.php', 'web\\LoginResponse@index');

$route = $router->getURI();
$router->dispatch($route);