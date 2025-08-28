<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'user' => \App\Http\Middleware\UserMiddleware::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle 404 errors
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if ($request->is('admin/*')) {
                // Jika error terjadi di admin area, gunakan template admin
                return response()->view('errors.admin.404', [
                    'exception' => $e,
                    'titleHeader' => 'Halaman Tidak Ditemukan - 404', // ✅ Ditambahkan
                    'pageTitle' => 'Error 404',
                    'breadcrumb' => [
                        ['name' => 'Dashboard', 'url' => route('admin.index')],
                        ['name' => '404 Error', 'url' => null]
                    ]
                ], 404);
            }

            // Untuk semua request lainnya, gunakan template public
            return response()->view('errors.404', [
                'exception' => $e
            ], 404);
        });
    })->create();
