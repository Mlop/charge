<?php

/**
 * 用户登录、注册、获取用户信息
 */
namespace App\Http\Controllers;

use App\Facades\MyFun;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Events\RegisterEvent;
//use Vera\JWT\Exception\TokenInvalidException;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $jwt;
    protected $userRep;

//    public function __construct(UserRepository $userRep)
//    {
//        $this->userRep = $userRep;
//    }
    public function __construct(JWTAuth $jwt, UserRepository $userRep)
    {
        $this->jwt = $jwt;
        $this->userRep = $userRep;
    }

//    public function login(Request $request)
//    {
//        //从请求取出证书,也就是邮件密码
//        $credentials = $request->only('name', 'password');
//        $token = Auth::attempt($credentials);
//        $user = Auth::user();
//        $user->token = $token;
//        return [
//            'id' => $user->id,
//            'name'=>$user->name,
//            'token'=>$token
//        ];
//    }

    public function test(Request $request)
    {
        $token = Auth::getToken();
        if (!$token) {
            throw new TokenInvalidException("refresh failed");
        }
        return response()->json(['token' => $token]);
        $obj = Auth::user();
        return response()->json(['user' => $obj]);
    }

    public function login(Request $request)
    {
        $account = $request->input('account');
        $password = $request->input('password');
        //默认使用邮箱登录
        $key = "email";
        //手机号登录
        if (preg_match('/^\d+$/', $account)) {
            $key = "phone";
        }
        if (!$token = $this->jwt->attempt([$key=>$account, "password"=>$password])) {
			if (!$token = $this->jwt->attempt(["name"=>$account, "password"=>$password])) {
				return ['code' => 404, 'msg' => 'user_not_found'];
			}
        }
		$user = Auth::user();
        $user->login_at = MyFun::now();
        $user->save();
		$user->token = $token;

        return $user;
    }

    public function register(Request $request)
    {
        //由于被人恶意注册，取消注册功能
        return ['code'=>1, 'msg'=>'注册失败'];
        $data = $request->all();
        extract($data);
        //验证
        if (!preg_match('/^\d+$/', $account) && strpos($account, '@') == false) {
            return ['code'=>1, 'msg'=>'账号格式不正确'];
        }
        $rules = ['password'=>'required|min:4|max:20', 'name'=>'unique:user,name'];
        //手机号注册
        if (preg_match('/^\d+$/', $account)) {
            $key = 'phone';
            $rules['account'] = 'required|unique:user,phone|max:11';
        } else {
            $key = 'email';
            $rules['account'] = 'required|email|unique:user,email';
        }
        $data[$key] = $account;
        $messages = [
            'account.required'=>'请输入账号',
            'account.unique'=>'账号已存在，换个手机或邮箱再试试吧',
            'account.max'=>'账号最长11位',
            'account.email'=>'账号格式不正确',
            'password.required'=>'请输入密码',
			'name.unique'=>'账号已存在，换个名称再试试吧',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return ['code'=>1, 'msg'=>$validator->errors()->first()];
        }
        $data['password'] = Hash::make($password);
		if (!$name) {
			$data['name'] = str_random(6);
		}
        $user = $this->userRep->create($data);
        if (!$user) {
            return ['code'=>1, 'msg'=>'注册失败'];
        }
        //为新用户添加通用分类
        event(new RegisterEvent($this->userRep, $user));
        if (!$token = $this->jwt->attempt([$key=>$account, "password"=>$password])) {
            return ['code' => 404, 'msg' => 'user_not_found'];
        }
		$user = Auth::user();
        $user->login_at = MyFun::now();
        $user->save();
		$user->token = $token;
        return $user;
    }

    public function getUser()
    {
        $user = Auth::user();
		if (!$user->phone) {
			$user->phone = "";
		}
		if (!$user->email) {
			$user->email = "";
		}
		return $user;
    }
}
