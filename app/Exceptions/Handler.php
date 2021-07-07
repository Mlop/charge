<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->getMethod() == 'OPTIONS') {
            return response(['code' => 0, 'msg' => ''], 200);
        }
//         return parent::render($request, $exception);
//		if ($exception instanceof ValidationException) {
//           $msg = $this->handleValidationException($exception);
//           return response(['code' => 1, 'msg' => $msg], 200);
//		}
 		if ($exception instanceof UnauthorizedHttpException) {
//            return response($exception->getMessage(), 401);
            return response(['code' => 401, 'msg' => $exception->getMessage()], 200);
 		}
 		//数据库连接失败
        if ($exception instanceof QueryException) {
            return response(['code' => 405, 'msg' => "DB connect exception"], 200);
        }
		return response(['code' => 1, 'msg' => $exception->getMessage()], 200);
    }
}
