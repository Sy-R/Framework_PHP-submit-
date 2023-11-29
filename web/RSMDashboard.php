<?php
namespace web;

require_once '/wamp64/400006369_Framework/config/Autoloader.php';

use app\controllers\Router;

$router = new Router();

//url search
$router->addRoute('/web/RSMDashboard', 'web\\RSMDashboardResponse@index');

//redirect to dashboard
$router->addRoute('/web/RSMDashboard.php', 'web\\RSMDashboardResponse@index');

$route = $router->getURI();
$router->dispatch($route);