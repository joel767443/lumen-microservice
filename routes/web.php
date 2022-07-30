<?php

/** @var Router $router */

use Laravel\Lumen\Routing\Router;

$router->group(['prefix' => 'api/'], function() use ($router) {

    $router->post('login/','UsersController@authenticate');
    $router->post('register/','UsersController@register');

    $router->group(['middleware' => 'auth:api'], function() use ($router) {

        /** Client routes */
        $router->post('client/', 'ClientController@store');
        $router->get('client/', 'ClientController@index');
        $router->get('client/{id}/', 'ClientController@show');
        $router->put('client/{id}/', 'ClientController@update');
        $router->delete('client/{id}/', 'ClientController@destroy');

        /** Project routes */
        $router->post('project/', 'ProjectController@store');
        $router->get('project/', 'ProjectController@index');
        $router->get('project/{id}/', 'ProjectController@show');
        $router->put('project/{id}/', 'ProjectController@update');
        $router->delete('project/{id}/', 'ProjectController@destroy');

        /** Modules routes */
        $router->post('module/', 'ModuleController@store');
        $router->get('module/', 'ModuleController@index');
        $router->get('module/{id}/', 'ModuleController@show');
        $router->put('module/{id}/', 'ModuleController@update');
        $router->delete('module/{id}/', 'ModuleController@destroy');

    });
});
