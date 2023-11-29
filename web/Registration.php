<?php
namespace web;

require_once '/wamp64/400006369_Framework/config/Autoloader.php';

use app\controllers\Router;

//Create class objects
$router = new Router();

//original route
$router->addRoute('/web/Registration', 'web\\RegistionResponse@index');

//Redirect to Registration page(for errors)  
$router->addRoute('/web/Registration.php', 'web\\RegistrationResponse@index');

$route = $router->getURI();
$router->dispatch($route);