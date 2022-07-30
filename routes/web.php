<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->group([
    'prefix' => 'api'
], function ($router) {
    $router->post('login', 'Api\AuthController@login');
    $router->post('register', 'Api\AuthController@register');
    $router->post('logout', 'Api\AuthController@logout');
    $router->post('refresh', 'Api\AuthController@refresh');
    $router->post('user-profile', 'Api\AuthController@me');

});

