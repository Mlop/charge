<?php
/**
 * Created by PhpStorm.
 * User: EDZ
 * Date: 2020/3/16
 * Time: 15:40
 */
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Vera\JWT\Facades\JWTAuth as Auth;

class CustomerController extends Controller
{

    public function login2(Request $request)
    {
        //从请求取出证书,也就是邮件密码
//        $credentials = $request->only('email', 'password');
        $credentials = $request->only('name', 'password');

        $token = Auth::attempt($credentials);var_dump($credentials,$token);exit;
        return response()->json(['token' => $token]);
    }

    public function login(Request $request)
    {
        //或者通过user返回一个Token
        $credentials = $request->only('email', 'name');
        $user = Customer::where('email', $credentials['email'])->where('name', $credentials['name'])->first();
//        var_dump($user);exit;
        $token = Auth::newToken($user);
        return response()->json(['token' => $token]);
    }
}
