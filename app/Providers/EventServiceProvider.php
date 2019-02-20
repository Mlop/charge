<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
//        'App\Events\RegisterEvent' => [
//            'App\Listeners\ExampleListener',
//        ],
    ];
    /**
     * 订阅者类
     * @var array
     */
    protected $subscribe = [
        'App\Events\EventSubscriber',
    ];
}
