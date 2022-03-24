<?php

namespace Framework\Router;

use Framework\Router\Route;
use Framework\Router\AddRouteOptionsTrait as AddRouteOptions;
use Framework\Router\Request;
use Framework\Router\Response;

class Router
{
    use AddRouteOptions;

    private array $routes = [];

    private function addRoute(Route $route)
    {
        return $this->routes[] = $route;
    }

    public function dispatch()
    {
        $found = null; $canRespond = false;

        foreach ($this->routes as $uri => $route) {
            if (!$route->matchRequest()) continue;
            $found = $route;
            if (!$route->canRespondTo(Request::getMethod())) continue;
            $canRespond = true;
            break;
        }

        if (!$found) return Response::notFound();
        if ($found && !$canRespond) return Response::methodNotAllowed();

        return Response::success(false, $found);
    }
}