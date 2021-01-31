<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Passport\Exceptions\MissingScopeException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

use function PHPUnit\Framework\isInstanceOf;

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });

        $this->renderable(function (MissingScopeException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'You are Unauthorized',
                ], 403);
            }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Method not allowed.',
                ], 405);
            }
        });

        $this->renderable(function (HttpException $e, Request $request) {
            if ($request->expectsJson() && $e->getStatusCode() == 403) {
                return response()->json([
                    'error' => 'You are Unauthorized',
                ], 403);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($e->getPrevious() instanceof ModelNotFoundException && $request->expectsJson()) {
                return response()->json([
                    'error' => str_replace('App\\Models\\', '', $e->getPrevious()->getModel())  . ' not found.',
                ], 404);
            }
            return response()->json([
                'error' => 'This url not found.',
            ], 404);
        });


        $this->renderable(function (AuthorizationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'You are Unauthorized',
                ], 403);
            }
        });
    }
}
