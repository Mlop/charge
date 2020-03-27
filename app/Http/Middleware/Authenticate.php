<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Manager;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Exception;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    protected $jwt;
    protected $manager;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth, JWTAuth $jwt, Manager $manager)
    {
        $this->auth = $auth;
        $this->jwt = $jwt;
        $this->manager = $manager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        try {
            if ($this->jwt->parseToken()->authenticate()) {
                return $next($request);
            }
            if ($this->auth->guard($guard)->guest()) {
                return ['code'=>401, 'msg'=>'Unauthorized.'];
            }
        } catch (Exception $exception) {
            try {
                //token过期，自动刷新token返回数据
                if ($exception instanceof TokenExpiredException) {
                    $token = $this->manager->refresh($this->jwt->getToken())->get();
                    return ['code' => 402, 'msg' => 'refresh token', 'data' => $token];
//                    return $next($request)->header('Authorization', "Bearer {$token}");
                }
            } catch (\Exception $exception) {
            //catch (TokenBlacklistedException $exception) {
                return ['code'=>401, 'msg'=>'Unauthorized.'];
            }
        }
        return $next($request);
    }
}
