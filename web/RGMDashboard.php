<?php
namespace web;

require_once '/wamp64/400006369_Framework/config/Autoloader.php';

use app\controllers\Router;

$router = new Router();

//url search
$router->addRoute('/web/RGMDashboard', 'web\\RGMDashboardResponse@index');

//redirect to dashboard
$router->addRoute('/web/RGMDashboard.php', 'web\\RGMDashboardResponse@index');

$route = $router->getURI();
$router->dispatch($route);