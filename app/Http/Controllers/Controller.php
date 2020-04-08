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
}
