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

$router->group(['middleware' => ['json_formatter']], function ($router) {
    $router->post('/login', 'UserController@login');
    $router->post('/register', 'UserController@register');
    $router->post('/init', 'DataController@initData');
});
// 使用 auth:api 中间件，需要登录的接口
$router->group(['middleware' => ['auth:api']], function($router) {
    //用户信息
    $router->get('/user', 'UserController@getUser');
});