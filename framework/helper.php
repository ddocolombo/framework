<?php

ini_set('xdebug.var_display_max_depth', 10);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);

set_error_handler(function ($severity, $message, $file, $line) {
    throw new \ErrorException($message, $severity, $severity, $file, $line);
});

$timezones = [
    'AC' => 'America/Rio_branco',   'AL' => 'America/Maceio',
    'AP' => 'America/Belem',        'AM' => 'America/Manaus',
    'BA' => 'America/Bahia',        'CE' => 'America/Fortaleza',
    'DF' => 'America/Sao_Paulo',    'ES' => 'America/Sao_Paulo',
    'GO' => 'America/Sao_Paulo',    'MA' => 'America/Fortaleza',
    'MT' => 'America/Cuiaba',       'MS' => 'America/Campo_Grande',
    'MG' => 'America/Sao_Paulo',    'PR' => 'America/Sao_Paulo',
    'PB' => 'America/Fortaleza',    'PA' => 'America/Belem',
    'PE' => 'America/Recife',       'PI' => 'America/Fortaleza',
    'RJ' => 'America/Sao_Paulo',    'RN' => 'America/Fortaleza',
    'RS' => 'America/Sao_Paulo',    'RO' => 'America/Porto_Velho',
    'RR' => 'America/Boa_Vista',    'SC' => 'America/Sao_Paulo',
    'SE' => 'America/Maceio',       'SP' => 'America/Sao_Paulo',
    'TO' => 'America/Araguaia',    
];

date_default_timezone_set($timezones['RS']);

function T($text) {
    return $text;
}

function dump($str) {
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
}

function dd($str) {
    dump($str);
    exit;
}

function config($path) {
    $segments = explode('.', $path);
    $config = [];

    foreach ($segments as $key => $segment) {
        if ($key === 0) {
            $config = require("../config/{$segment}.php");
            continue;
        }
        $config = $config[$segment];
    }
    
    return $config;
}

function view(string $path, array $params = []) {
    return new \Components\View\View($path, $params);
}

function template($path)
{
    require '../app/view/templates/' . $path . '.php';
}

function method_spoofing(string $method)
{
    echo "<input type=\"hidden\" name=\"_method\" value=\"$method\" />";
}