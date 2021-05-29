<?php

namespace core\routing;
use Exception;

class Router
{
    private array $routes = [];
    private array $params = [];

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function add(string $route, array $params = []): void
    {
        //ha van az útvonalban / jel
        $route = preg_replace('/\//', '\\/', $route);
        //ha van az útvonalban {tag}
        $route = preg_replace('/{([a-z-]+)}/', '(?P<\1>[a-z-]+)', $route);
        //ha van az útvonalban szám (pl egy id)
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }

    private function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key))
                        $this->params[$key] = $match;
                }
                if (empty($this->params))
                    $this->params = $params;
                if (array_key_exists('namespace', $params)) {
                    $this->params['namespace'] = $params['namespace'];

                }
            }
        }
        return !empty($this->params);
    }

    public function dispatch($url): void
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controllerObject = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {
                    $controllerObject->$action();
                } else {
                    throw new Exception("Method $action in controller $controller cannot be called directly - remove the Action suffix to call this method");
                }
            } else {
                throw new Exception("Controller class $controller not found");
            }
        } else {
            throw new Exception("No route found for URL $url", 404);
        }
    }

    private function convertToStudlyCaps($controller): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $controller)));
    }

    private function convertToCamelCase($action): string
    {
        return lcfirst($this->convertToStudlyCaps($action));
    }

    private function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = "";
            }
        }
        return $url;
    }

    private function getNamespace()
    {
        $namespace = "controllers\\";

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}