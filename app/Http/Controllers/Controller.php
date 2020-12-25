<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Controller extends BaseController
{
    public function getUser()
    {
        $user = Auth::user();
        if (!$user) {
            throw new UnauthorizedHttpException('jwt-auth','请先登录');
        }
        return $user;
    }

    /**
     * 成功返回
     * @param array $data
     * @param string $msg
     * @return array
     */
    public function successResult($data = [], $msg = 'ok')
    {
        return ['code'=>0, 'msg'=>$msg, 'data' => $data,];
    }

    /**
     * 失败返回
     * @param string $msg
     * @return array
     */
    public function failResult($msg = 'fail')
    {
        return ['code'=>1, 'msg'=>$msg];
    }
}
