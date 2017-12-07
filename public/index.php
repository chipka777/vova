<?php

session_start();

require_once '../vendor/autoload.php';

$route = new Core\Route;


$route->get('/login', 'AuthController@show');
$route->post('/login', 'AuthController@login');


$route->group(['middleware' => ['auth']], function () use ($route) {
    $route->get('/', 'HomeController@index');

    $route->get('/department/create', 'DepartmentController@showCreate');
    $route->post('/department/create', 'DepartmentController@addNew');

    $route->get('/department/list', 'DepartmentController@showList');

    $route->post('/department/edit', 'DepartmentController@edit');

    $route->post('/department/delete', 'DepartmentController@delete');

    $route->post('/logout', 'AuthController@logout');
});


$route->run();

