<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/product', "ProductController@index");
$router->get('/select/{name}', "MidtransController@create_transaction_view");

$router->get('/product', 'ProductController@index');
$router->get('/product/{id}', 'ProductController@show');
$router->post('/product', 'ProductController@create');
$router->put('/product/{id}', 'ProductController@update');
$router->delete('/product/{id}', 'ProductController@delete');

$router->group([ "middleware" => "midtrans" ], function () use ($router) {
    $router->get('/tx/status/{id}', "MidtransController@get_tx_status");
    $router->post('/tx/cancel/{id}', "MidtransController@cancel_tx");
    $router->post('/tx/create', "MidtransController@create_transaction");

    $router->get('/midtrans', function () {
        return config("app.midtrans");
    });
});
