<?php

use App\Helpers\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (\Illuminate\Foundation\Configuration\Middleware $middleware) {
        // Middleware bisa ditambahkan di sini jika diperlukan
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Logging setiap error
        $exceptions->report(function (Throwable $e) {
            Log::error($e->getMessage());
        });
        
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });
        
        // Menangani model tidak ditemukan
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
                if ($request->is('api/*')) {
                    return Api::response(null ,'Resource Not Found', Response::HTTP_NOT_FOUND, [] , 'error');
                }
                return redirect()->back()->with('error', 'Resource not found.');
            }
        });
        
        // Menangani user tidak terautentikasi
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*')) {
                return Api::response(null,'Unauthorized access', Response::HTTP_UNAUTHORIZED, [], 'error');
            }
            return redirect()->guest(route('login'))->with('error', 'Anda harus login terlebih dahulu.');
        });
        
        // Menangani user tidak memiliki izin
        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->is('api/*')) {
                return Api::response(null, 'Forbidden: You do not have permission', Response::HTTP_FORBIDDEN, [], 'error');
            }
            return redirect(route('dashboard'))->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        });
        
        // Menangani validasi gagal
        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return Api::response(
                    null,
                    'Validation failed',
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    $e->errors(),
                    'error'
                );
            }
            return redirect()->back()->withErrors($e->errors())->withInput();
        });
        
        // Menangani terlalu banyak permintaan (rate limiting)
        $exceptions->render(function (TooManyRequestsHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return Api::response(null, 'Too many requests, please slow down', Response::HTTP_TOO_MANY_REQUESTS, [], 'error');
            }
            return redirect()->back()->with('error', 'Too many requests, please slow down.');
        });
        
        // Menangani error lainnya
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return Api::response(
                    null,
                    'Something went wrong',
                    Response::HTTP_INTERNAL_SERVER_ERROR,
                    env('APP_DEBUG') ? ['error' => $e->getMessage(), 'trace' => $e->getTrace()] : null,
                    'error'
                );
            }
            return redirect()->back()->withErrors( ['message' => env('APP_DEBUG') ? $e->getMessage() : 'Something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
        });        
    })
    ->create();
