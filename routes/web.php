<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api/'], function() use ($router) {
    $router->get('login/','UsersController@authenticate');
    $router->post('client/','ClientController@store');
    $router->get('client/', 'ClientController@index');
    $router->get('client/{id}/', 'ClientController@show');
    $router->put('client/{id}/', 'ClientController@update');
    $router->delete('client/{id}/', 'ClientController@destroy');
});
