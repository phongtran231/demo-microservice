<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'auth',
], function ($router) {
    $router->post('create-user', [
        'as' => 'auth.create-user',
        'uses' => 'UserController@store',
    ]);
    $router->post('login', [
        'as' => 'auth.login',
        'uses' => 'UserController@login',
    ]);
    $router->group([
        'middleware' => 'auth',
    ], function ($router) {
        $router->get('verify-token', 'UserController@verifyToken');
    });
});
