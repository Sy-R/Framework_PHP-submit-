<?php
namespace web;

require_once '/wamp64/400006369_Framework/config/Autoloader.php';

use framework\Session;
use app\controllers\Router;

//Delete session
$session = Session::getInstance();
$session->unset_destroy();

//Redirect to login page  
$router = new Router();
$router->addRoute('/web/Login', 'web\\LoginResponse@index');

$router->dispatch('/web/Login');
