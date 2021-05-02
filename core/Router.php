<?php

namespace core;
class Router
{
    private array $routes = [];

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function add(string $route, array $params) :void
    {
        $this->routes[$route] = $params;
    }
}