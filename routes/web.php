<?php
$router->get('/', function () use ($router) {
    return 'charge '.$router->app->version();
});
//发布代码钩子
$router->post('/deploy', function () use ($router) {
    system("cd /opt/www/charge;git pull origin master;git log -1;", $status);
    echo '<br />';
    echo 'git pull finished';
    echo '11112';
});
//不需要登录接口
$router->group(['middleware' => ['json_formatter']], function ($router) {
    //用户登录、注册、获取基本信息
    $router->post('/login', 'UserController@login');
    $router->post('/register', 'UserController@register');
    //初始化数据
    $router->post('/init', 'DataController@initData');

    // 使用 auth:api 中间件，需要登录的接口
    $router->group(['middleware' => ['auth:api']], function($router) {
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
            //删除分类
            $router->delete('/{id}', 'CategoryController@del');
            //添加收藏分类
            $router->post('/{id}/favorite', 'CategoryController@addFavorite');
            //删除收藏分类
            $router->delete('/{id}/favorite', 'CategoryController@removeFavorite');
        });

        //报表
        $router->get('/report', 'ReportController@index');
        //按月概要
        $router->get('/summary', 'ReportController@getSummaryList');
        //某月详细
        $router->get('/monthly', 'ReportController@getMonthList');
        //年度top2账单
        $router->get('/yearly', 'ReportController@getYearSummary');
    });
});

