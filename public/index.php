<?php

session_start();

require_once '../vendor/autoload.php';

$route = new Core\Route;


$route->get('/login', 'AuthController@show');
$route->post('/login', 'AuthController@login');

$route->post('/logout', 'AuthController@logout');

$route->group(['middleware' => ['auth']], function () use ($route) {
    $route->get('/', 'HomeController@index');
    $route->get('/refresh', 'HomeController@refreshLogs');

    $route->post('/get-logs', 'HomeController@getAllLogsByOperatorIdAJAX');
    $route->post('/get-operator-info', 'HomeController@getOperatorInfoByOperatorIdAJAX');
    $route->post('/get-operators', 'HomeController@getOperatorsAJAX');
    $route->post('/edit-operator-info', 'HomeController@editOperatorInfoAJAX');

    $route->get('/logout', 'AuthController@logout');
});


$route->run();

