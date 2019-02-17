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

$router->group(['middleware' => ['json_formatter']], function ($router) {//'json_formatter'
    $router->get('/login', 'UserController@login');
    $router->get('/register', 'UserController@register');
    //初始化数据
    $router->post('/init', 'DataController@initData');
    //分类
    $router->group(['prefix'=>'category'], function ($router){
        //设置页面
        $router->get('/list', 'CategoryController@getList');
		$router->get('/{id}/edit', 'CategoryController@edit');
		$router->get('/{id}/del', 'CategoryController@del');
    });
	$router->get('/user', 'UserController@getUser');
});
// 使用 auth:api 中间件，需要登录的接口
$router->group(['middleware' => ['json_formatter', 'auth:api']], function($router) {
    //用户信息
    // $router->get('/user', 'UserController@getUser');
    //添加账本
    $router->post('/book', 'BookController@add');
    //添加收入记录
    $router->post('/income', 'IncomeController@add');


});
