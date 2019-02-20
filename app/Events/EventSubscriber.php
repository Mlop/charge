<?php
/**
 * 积分监听事件处理，注册/登陆/支付成功后等累加积分
 * User: Vera.Zhang
 * Date: 2018/12/27
 * Time: 11:27
 */

namespace App\Events;

use Log;
use Auth;

class EventSubscriber
{
    /**
     * 处理用户登录事件，增加积分(一天内登陆多次只增加一次积分)
     * @param $event
     */
    public function onAfterLogin(LoginEvent $event)
    {
    }
    /**
     * 处理用户注册事件
     * @param $event
     */
    public function onAfterRegister(RegisterEvent $event)
    {
        $user = $event->user;
        if (!$user) {
            Log::error("Register event failed! need login first.");
        }
		//添加通用类别
        $event->userRep->addCommonCategory($user->id);
		//添加通用账本
		$event->userRep->addCommonBook($user->id);
    }

    public function subscribe($events)
    {
        //登录
//        $events->listen(
//            'App\Events\LoginEvent',
//            'App\Events\PointEventSubscriber@onAfterLogin'
//        );
        //注册
        $events->listen(
            'App\Events\RegisterEvent',
            'App\Events\EventSubscriber@onAfterRegister'
        );
    }
}