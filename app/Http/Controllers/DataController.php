<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;


class DataController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $userRep;

    public function __construct(UserRepository $userRep)
    {
        $this->userRep = $userRep;
    }

    /**
     * 初始化数据
     * @return int
     */
    public function initData()
    {
        $res = $this->userRep->initCategory();
        return intval($res);
    }
}
