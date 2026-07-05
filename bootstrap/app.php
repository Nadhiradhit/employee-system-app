<?php

use App\Helpers\ApiResponseHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders([
        \App\Providers\AuthProvider::class,
        \App\Providers\EmployeeProvider::class,
    ])
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->statefulApi();

        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('api/*')) {
                return null;
            }

            return route('login');
        });

        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdminRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            if ($request->is('api/*')) {
                return true;
            }
            return $request->expectsJson();
        });

        $exceptions->respond(function ($response, Throwable $e, Request $request) {
            // 404 Not Found
            if ($request->is('api/*') && $e instanceof NotFoundHttpException) {
                return ApiResponseHelper::notFoundResponse();
            }
            // 401 Unauthorized
            if ($request->is('api/*') && $e instanceof AuthenticationException) {
                return ApiResponseHelper::unauthorizedResponse();
            }
            // 403 Forbidden
            if ($request->is('api/*') && $e instanceof AccessDeniedHttpException) {
                return ApiResponseHelper::forbiddenResponse();
            }
            // 422 Unprocessable Entity
            if ($request->is('api/*') && $e instanceof ValidationException) {
                return ApiResponseHelper::validationErrorResponse($e->errors(), $e->getMessage());
            }
            // 500 Internal Server Error
            if ($request->is('api/*')) {
                return ApiResponseHelper::serverErrorResponse($e->getMessage());
            }

            return $response;
        });
    })->create();
