<?php

namespace App\Providers;

use App\MyFunction;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //注册全局使用函数
        $this->app->singleton('myfun', function($app) { return new MyFunction(); });
    }
}
