<?php

namespace Vera\JWT\Provider;


use Illuminate\Support\ServiceProvider;
use Vera\JWT\Auth\JWTGuard;
use Vera\JWT\Middleware\Authenticate;
use Vera\JWT\Middleware\RefreshToken;

class LumenServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //从应用根目录的config文件夹中加载用户的jwt配置文件
        $this->app->configure('jwt');

        //获取扩展包配置文件的真实路径
        $path = realpath(__DIR__ . '/../../config/jwt.php');

        //将扩展包的配置文件merge进用户的配置文件中
        $this->mergeConfigFrom($path, 'jwt');

        $this->app->routeMiddleware([
            'jwt.auth' => Authenticate::class,
            'jwt.refresh' => RefreshToken::class,
        ]);

        $this->app['auth']->extend('jwt', function ($app, $name, array $config) {
            $guard = new JWTGuard($app['auth']->createUserProvider($config['provider']), $app['request']);

            return $guard;
        });
    }
    public function register()
    {
        $this->registerAliases();
    }
    protected function registerAliases()
    {
        $this->app->alias('vera.jwt.auth', JWTGuard::class);
    }
}
