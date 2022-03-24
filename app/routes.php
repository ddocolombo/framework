<?php

$router->get('/', function() { echo 'welcome'; });
$router->crud('/category', CategoryController::class);
