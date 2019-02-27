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
    return 'charge '.$router->app->version();
});
//不需要登录接口
$router->group(['middleware' => ['json_formatter']], function ($router) {//'json_formatter'
    //用户登录、注册、获取基本信息
    $router->post('/login', 'UserController@login');
    $router->post('/register', 'UserController@register');
    //初始化数据
    $router->post('/init', 'DataController@initData');

});
// 使用 auth:api 中间件，需要登录的接口
$router->group(['middleware' => ['json_formatter', 'auth:api']], function($router) {//'json_formatter',
    //用户信息
    $router->get('/user', 'UserController@getUser');
    //添加账本
    $router->post('/book', 'BookController@add');
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
	//收入
// 	$router->group(['prefix'=>'income'], function ($router){
// 		//添加收入记录
// 		$router->post('/', 'IncomeController@add');
// 		//编辑收入记录
// 		$router->put('/{id}', 'IncomeController@edit');
// 		//删除
// 		$router->delete('/{id}', 'IncomeController@delete');
// 		//获取收入记录
// 		$router->get('/{id}', 'IncomeController@get');
// 	});
    //分类列表
    $router->get('/categories', 'CategoryController@getList');
	//单一分类管理
    $router->group(['prefix'=>'category'], function ($router){
        //设置页面
        $router->get('/favorites', 'CategoryController@getFavoriteList');
        $router->put('/{id}', 'CategoryController@edit');
        $router->delete('/{id}', 'CategoryController@del');
    });
    //支出
//     $router->group(['prefix'=>'outgo'], function ($router){
//         //添加
//         $router->post('/', 'OutgoController@add');
// 		//修改
//         $router->put('/{id}', 'OutgoController@edit');
// 		//删除
//         $router->delete('/{id}', 'OutgoController@delete');
// 		//获取支出记录
// 		$router->get('/{id}', 'OutgoController@get');
//     });
	//借贷
// 	$router->group(['prefix'=>'loan'], function($router){
// 		//添加借贷记录
// 		$router->post('/', 'LoanController@add');
// 		$router->put('/{id}', 'LoanController@edit');
// 		$router->delete('/{id}', 'LoanController@delete');
// 		//获取借贷记录
// 		$router->get('/{id}', 'LoanController@get');
// 	});
	
	//报表
    $router->get('/report', 'ReportController@index');
    //按月概要
    $router->get('/summary', 'ReportController@getSummaryList');
    //某月详细
    $router->get('/monthly', 'ReportController@getMonthList');
});
