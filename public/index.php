<?php

use core\Router;
require __DIR__ . '\..\core\Router.php';
//echo $_SERVER['QUERY_STRING'];

$router = new Router();
//echo get_class($router);

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->add('posts/new', ['controller' => 'Posts', 'action' => 'new']);

echo '<pre>';
var_dump($router->getRoutes());
echo '</pre>';