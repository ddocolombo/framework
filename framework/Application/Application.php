<?php

namespace Framework\Application;

use Framework\Router\Router;
use Framework\Router\Route;
use Framework\Router\Response;

class Application
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router;
    }

    public function run()
    {
        $router = $this->router;        
        include('../app/routes.php');
        $route = $router->dispatch()['body'];
        $response = $this->completeRequest($route);

        $this->sendResponse($response);
    }

    private function sendResponse($response)
    {        
        switch (gettype($response)) {
            case 'array' : {
                Response::success(true, $response);
                break;
            }
            case 'object' : {
                if (get_class($response) == 'Framework\\View\\View') {
                    $response->create();
                }
                break;
            }
            default : {
                if ($response)
                    var_dump($response);
            }
        }
    }

    public function invoke($callback, $method = null, $params = [])
    {
        try{
            if (!$method) {
                return call_user_func_array($callback, $params);
            } else {
                return call_user_func_array([$callback, $method], $params);    
            }
        } catch(\TypeError $e) {
            Response::BadRequest();
        }
    }

    private function completeRequest(Route $route)
    {
        $callback = $route->getCallback();
        $params = array_values($route->getParams());

        if (is_callable($callback))
            return $this->invoke($callback, null, $params);
        
        list($controller, $method) = (is_array($callback)) ? $callback : explode('@', $callback);        
        
        $controller = '\\App\\Controller\\' . $controller;
        $obj = new $controller;

        if (!class_exists($controller))
            throw new \Exception("Controller [{$controller}] not found.");

        if (!method_exists($obj, $method))
            Response::BadRequest();
                    
        return $this->invoke($obj, $method, $params);
    }
}