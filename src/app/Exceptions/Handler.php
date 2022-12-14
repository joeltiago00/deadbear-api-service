<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use ReflectionException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
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
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if (!env('APP_DEBUG')) {
            if ($exception instanceof NotFoundHttpException)
                return response()->json(['error' => 'router.does-not-match'], 404);

            if ($exception instanceof ModelNotFoundException)
                return response()->json(['error' => 'model.not-found'], 404);

            if ($exception instanceof MethodNotAllowedHttpException)
                return response()->json(['error' => 'router.does-not-allowed'], 403);

            if ($exception instanceof ReflectionException)
                return response()->json(['error' => 'reflection.error'], 404);

            if ($exception instanceof ValidationException)
                return response()->json(['message' => $exception->getMessage(), 'errors' => $exception->errors()], 400);

            return response()->json(['message' => $exception->getMessage()], $exception->getCode());
        }

        return parent::render($request, $exception);
    }
}
