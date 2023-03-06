<?php

namespace App\Exceptions;

use Illuminate\Support\Arr;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Validation\ValidationException;

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

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'status'  => "failed",
            'message' => $exception->getMessage(),
            'data'  => $exception->errors(),

        ], $exception->status);
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json([
                "status" => "failed",
                "message" => "Mehod Not Allowed",
            ], 405);
        }
        if ($e instanceof NotFoundHttpException) {
            return response()->json([
                "status" => "failed",
                "message" => "Record not found",
            ], 404);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                "status" => "failed",
                "message" => "Record not found",
            ], 404);
        }
        if ($request->header("accept") != "application/json") {
            return response()->json([
                "status" => "failed",
                "message" => "You must send the 'accept' key in the request header with 'application/json'  ",
            ], 400);
        }

        return parent::render($request, $e);
    }
}
