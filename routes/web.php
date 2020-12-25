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

    // 使用 auth:api 中间件，需要登录的接口
    $router->group(['middleware' => ['auth:api']], function($router) {
        //用户信息
        $router->get('/user', 'UserController@getUser');
        //账本增删改
        $router->group(['prefix'=>'book'], function ($router){
            //添加编辑账本
            $router->put('/{id}', 'BookController@edit');
            //删除
            $router->delete('/{id}', 'BookController@delete');
            //账本记录的列
            $router->get('/{id}/items', 'BookController@getItemList');
            //勾选/取消选项
            $router->put('/{id}/checkitem', 'BookController@checkItems');
        });
        //账本列表
        $router->get('/books', 'BookController@getList');
        //条目增删改
        $router->group(['prefix'=>'item'], function ($router){
            //添加编辑账本
            $router->put('/{id}', 'ItemController@edit');
            //删除
            $router->delete('/{id}', 'ItemController@delete');
        });
        $router->get('/items', 'ItemController@getList');
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

        //个人报表 开始 ------------------------------------
        $router->get('/report', 'ReportController@index');
        //按月概要
        $router->get('/report/summary', 'ReportController@getSummaryList');
        //某月详细
        $router->get('/report/monthly', 'ReportController@getMonthList');
        //年度top2账单
        $router->get('/report/yearly', 'ReportController@getYearSummary');
        //按账本统计总额
        $router->get('/report/book', 'ReportController@getBookSummary');
        $router->get('/report/book/{id}', 'ReportController@getBookDetail');
        //个人报表 结束 ------------------------------------
        //统计 开始 ------------------------------------
        $router->get('/stat', 'StatController@index');
        $router->get('/stat/filters', 'StatController@filters');//列表筛选条件，年份、账本、用户姓名
        $router->get('/stat/list', 'StatController@lists');//列表结果
        $router->get('/stat/list/detail', 'StatController@listDetail');//列表中展开的详情
        //统计 结束 ------------------------------------
        //打卡记录管理
        $router->group(['prefix'=>'workrecord'], function ($router) {
            //某月打卡记录
            $router->get('/', 'WorkRecordController@getList');
            //添加/编辑
            $router->put('/', 'WorkRecordController@edit');
        });
        //工具函数，如：任务管理
        $router->group(['prefix'=>'tool'], function ($router){
            $router->group(['prefix'=>'todo'], function ($router){
                //任务列表
                $router->get('/', 'ToolController@getTodoList');
                //添加编辑任务
                $router->put('/{id}', 'ToolController@editTodo');
                //删除
                $router->delete('/{id}', 'ToolController@deleteTodo');
            });
        });
    });
    //公共数据
    $router->get('/contacts', 'CommonController@contactList');
    //上传图片到服务器
    $router->post('/img/upload', 'CommonController@uploadFile');
    //获取最新版本
    $router->get('/apk/latest', 'CommonController@getLatestVersion');
    //下载Android安装包
    $router->get('/apk/download', 'CommonController@downloadApk');

});

