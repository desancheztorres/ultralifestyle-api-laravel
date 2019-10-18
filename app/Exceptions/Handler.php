<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
//use MongoDB\Driver\Exception\AuthenticationException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
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
        if($request->expectsJson()) {
            if($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return response()->json([
                    'data' => [
                        'error' => 'Unauthorized.'
                    ]
                ], 403);
            }

            if($exception instanceof \Illuminate\Database\eloquent\ModelNotFoundException) {
                return response()->json([
                    'data' => [
                        'error' => explode('\\', $exception->getModel())[2] . ' not found.'
                    ]
                ], 404);
            }

            if($exception instanceof \Illuminate\Database\QueryException) {
                return response()->json([
                    'data' => [
                        'error' => $exception->getMessage()
                    ]
                ], 500);
            }
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception) {
        if($request->expectsJson()) {
            return response()->json([
                'data' => [
                    'error' => 'Unauthenticated.'
                ]
            ], 401);
        }

        return redirect()->guest('login');
    }
}
