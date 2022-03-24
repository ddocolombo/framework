<?php

namespace Framework\Router;

class Response
{
    private static function sendJsonHeaders()
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-Type: application/json; charset=utf-8');
    }

    public static function success($json = true, $body = null)
    {
        return self::send('success', 200, 'OK', $body, $json);
    }

    public static function badRequest($json = true, $body = null)
    {
        return self::send('error', 400, 'Bad Request', $body, $json);
    }

    public static function notFound($json = true, $body = null)
    {
        return self::send('error', 404, 'Not Found', $body, $json);
    }

    public static function methodNotAllowed($json = true, $body = null)
    {
        return self::send('error', 405, 'Method Not Allowed', $body, $json);
    }

    public static function forbidden($json = true, $body = null)
    {
        return self::send('error', 403, 'Forbidden', $body, $json);
    }

    public static function unAuthorized($json = true, $body = null)
    {
        return self::send('error', 401, 'Method Not Allowed', $body, $json);
    }

    private static function send(string $status, int $code, string $message, $body = null, bool $json = true): array
    {
        http_response_code($code);

        $response = [
            'header' => [
                'status'  => $status,
                'code'    => $code,
                'message' => $message,    
            ],
            'body' => $body
        ];

        if ($json) {
            self::sendJsonHeaders();
            exit(json_encode($response));
        }

        return $response;
    }
}