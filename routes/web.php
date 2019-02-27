<?php
$router->get('/', function () use ($router) {
    return 'charge '.$router->app->version();
});
//不需要登录接口
$router->group(['middleware' => ['json_formatter']], function ($router) {
    //用户登录、注册、获取基本信息
    $router->post('/login', 'UserController@login');
    $router->post('/register', 'UserController@register');
    //初始化数据
    $router->post('/init', 'DataController@initData');
});
// 使用 auth:api 中间件，需要登录的接口
$router->group(['middleware' => ['json_formatter', 'auth:api']], function($router) {
    //用户信息
    $router->get('/user', 'UserController@getUser');
	$router->group(['prefix'=>'book'], function ($router){
		//添加编辑账本
		$router->put('/{id}', 'BookController@edit');
		//删除
		$router->delete('/{id}', 'BookController@delete');
	});
	//账本列表
	$router->get('/books', 'BookController@getList');
	//帐目
	$router->group(['prefix'=>'account'], function ($router){
		//添加
		$router->post('/', 'AccountController@add');
		//编辑
		$router->put('/{id}', 'AccountController@edit');
		//删除
		$router->delete('/{id}', 'AccountController@delete');
		//获取
		$router->get('/{id}', 'AccountController@get');
	});
	
    //分类列表
    $router->get('/categories', 'CategoryController@getList');
	//单一分类管理
    $router->group(['prefix'=>'category'], function ($router){
        //设置页面
        $router->get('/favorites', 'CategoryController@getFavoriteList');
		//添加/编辑
        $router->put('/{id}', 'CategoryController@edit');
        $router->delete('/{id}', 'CategoryController@del');
    });
   
	//报表
    $router->get('/report', 'ReportController@index');
    //按月概要
    $router->get('/summary', 'ReportController@getSummaryList');
    //某月详细
    $router->get('/monthly', 'ReportController@getMonthList');
});
