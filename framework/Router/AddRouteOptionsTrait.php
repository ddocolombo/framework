<?php

namespace Framework\Router;

use Framework\Router\Request;

trait AddRouteOptionsTrait
{
    private function isValidVerbs(array $verbs): bool
    {
        $notAllowedVerbs = array_diff($verbs, Request::getHttpVerbs());                

        if (count($notAllowedVerbs) > 0)
            throw new \Exception(sprintf('Http verb [%s] not allowed.', implode(', ', $notAllowedVerbs)));

        return true;
    }

    public function get(string $uri, $callback): Route
    {
        return $this->addRoute(new Route(['GET'], $uri, $callback));
    }

    public function post(string $uri, $callback): Route
    {
        return $this->addRoute(new Route(['POST'], $uri, $callback));
    }

    public function put(string $uri, $callback): Route
    {
        return $this->addRoute(new Route(['PUT'], $uri, $callback));
    }

    public function patch(string $uri, $callback): Route
    {
        return $this->addRoute(new Route(['PATCH'], $uri, $callback));
    }

    public function delete(string $uri, $callback): Route
    {
        return $this->addRoute(new Route(['DELETE'], $uri, $callback));
    }

    public function any(string $uri, $callback): Route
    {
        return $this->addRoute(new Route(Request::getHttpVerbs(), $uri, $callback));
    }

    public function match(array $verbs, string $uri, $callback): Route
    {
        if ($this->isValidVerbs($verbs))        
            return $this->addRoute(new Route($verbs, $uri, $callback));
    }

    public function crud(string $uri, string $controller)
    {
        /** ------------------------------------------------------------ */
        $this->api($uri, $controller);
        /** ------------------------------------------------------------ */
        $this->get($uri . '/create', [$controller, 'create']);
        /** ------------------------------------------------------------ */
        $this->get($uri . '/{id}/edit', [$controller, 'edit']);
        /** ------------------------------------------------------------ */
    }

    public function api(string $uri, string $controller)
    {
        /** ------------------------------------------------------------ */
        $this->get($uri, [$controller, 'index']);
        /** ------------------------------------------------------------ */
        $this->post($uri, [$controller, 'store']);
        /** ------------------------------------------------------------ */
        $this->get($uri . '/{id}', [$controller, 'show']);
        /** ------------------------------------------------------------ */
        $this->put($uri . '/{id}', [$controller, 'update']);
        /** ------------------------------------------------------------ */
        $this->patch($uri . '/{id}', [$controller, 'update']);
        /** ------------------------------------------------------------ */
        $this->delete($uri . '/{id}', [$controller, 'destroy']);
        /** ------------------------------------------------------------ */
    }
}