<?php
/**
 * 全局可调用函数门面
 * User: Vera.Zhang
 * Date: 2020/4/7
 * Time: 16:51
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class MyFun extends Facade
{
    public static function getFacadeAccessor() {
        return 'myfun';
    }
}
