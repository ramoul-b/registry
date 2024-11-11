<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use App\Services\ApiService;
use Symfony\Component\HttpFoundation\Response;

$exceptionsHandler = function (Exceptions $exceptions) {
    return function (Throwable $exception, Request $request) use ($exceptions) {
        Log::error($exception);

        $exception = $exceptions->prepare($exception);

        if ($exception instanceof AuthenticationException) {
            $response = $exceptions->unauthenticated($request, $exception);
            return ApiService::response([
                'message' => 'Unauthenticated',
                'errors' => []
            ], $response->getStatusCode());
        }

        if ($exception instanceof ValidationException) {
            return ApiService::response([
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ], $exception->status);
        }

        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
        $message = method_exists($exception, 'getMessage') ? $exception->getMessage() : Response::$statusTexts[$statusCode] ?? 'Unknown error';

        return ApiService::response([
            'message' => $message,
            'errors' => []
        ], $statusCode);
    };
};

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api_v1.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        // Middleware configurations can be placed here.
    })
    ->withExceptions(function (Exceptions $exceptions) use ($exceptionsHandler) {
        $exceptions->render($exceptionsHandler);
    })
    ->create();
