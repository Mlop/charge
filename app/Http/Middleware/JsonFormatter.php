<?php

namespace App\Http\Middleware;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class JsonFormatter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle($request, \Closure $next, $guard = null)
    {
        $response = $next($request);

        if($response instanceof JsonResponse) {
            $data = $response->getOriginalContent();
            if (!isset($data['code']) || !isset($data['msg'])) {
                $ret = [
                    'code' => 0,
                    'data' => [],
                    'msg' => 'ok'
                ];
                if (!empty($data)) {
                    $ret['data'] = $data;
                }
                $response->setData($ret);
            }
        } else if($response instanceof Response) {
            $data = $response->getOriginalContent();//dd($data);
            if (!isset($data['code'])) {
                $ret = [
                    'code' => 0,
                    'data' => [],
                    'msg' => 'ok'
                ];
                if (isset($data['pagination'])) {
                    $ret['pagination'] = $data['pagination'];
                    $ret['data'] = $data['data'];
                } else {
                    if (!empty($data)) {
                        $ret['data'] = $data;
                    }
                }
// dd($ret);
                $response->setContent($ret);
            }
        }
        
        return $response;
    }
}