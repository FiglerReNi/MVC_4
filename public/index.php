<?php

use core\database\PdoConnect;
use core\routing\Router;

require __DIR__ . '\..\vendor\autoload.php';
require __DIR__ . '\..\config\config.php';

error_reporting(E_ALL);
set_error_handler('core\handler\Error::errorHandler');
set_exception_handler('core\handler\Error::exceptionHandler');

$router = new Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('admin/{controller}/{action}', ["namespace" => "admin"]);
$router->add('{controller}/{id:\d+}/{action}');

$router->dispatch($_SERVER['QUERY_STRING']);

