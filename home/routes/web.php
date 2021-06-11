<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'middleware' => \App\Http\Middleware\CheckTokenMiddleware::class,
], function ($router) {
    $router->get('get-product-list', 'HomeController@getProductList');
});
