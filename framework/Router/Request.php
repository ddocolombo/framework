<?php

namespace Framework\Router;

class Request
{
    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public static function getHttpVerbs(): array
    {
        return ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];
    }

    public static function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}