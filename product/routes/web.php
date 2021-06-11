<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group([
    'prefix' => 'product',
], function ($router) {
    $router->post('/', ['as' => 'product.store', 'uses' => 'ProductController@store']);
    $router->get('list', ['as' => 'product.list', 'uses' => 'ProductController@listProduct']);
});

