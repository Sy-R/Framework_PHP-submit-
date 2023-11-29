<?php
namespace web;

require_once '/wamp64/400006369_Framework/config/Autoloader.php';

use app\controllers\Router;

$router = new Router();

//url search
$router->addRoute('/web/RDashboard', 'web\\RDashboardResponse@index');

//redirect to dashboard
$router->addRoute('/web/RDashboard.php', 'web\\RDashboardResponse@index');

$route = $router->getURI();
$router->dispatch($route);