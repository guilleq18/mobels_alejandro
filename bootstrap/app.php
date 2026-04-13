<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\PostTooLargeException;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn (Request $request) => route('login'));
        $middleware->redirectUsersTo(fn (Request $request) => route('admin.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (PostTooLargeException $exception, Request $request) {
            $uploadLimit = ini_get('upload_max_filesize') ?: 'limitado por el servidor';
            $postLimit = ini_get('post_max_size') ?: 'limitado por el servidor';

            $message = sprintf(
                'La imagen supera el limite del servidor. Reduci el peso del archivo o aumentá upload_max_filesize (%s) y post_max_size (%s) en Hostinger.',
                $uploadLimit,
                $postLimit,
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                ], 413);
            }

            return back()
                ->withInput($request->except([
                    'brand_logo_upload',
                    'home_hero_image_upload',
                ]))
                ->withErrors([
                    'brand_logo_upload' => $message,
                    'home_hero_image_upload' => $message,
                ]);
        });
    })->create();

$sharedHostingPublicPath = dirname(__DIR__).'/../public_html';

if (is_dir($sharedHostingPublicPath)) {
    $app->usePublicPath(realpath($sharedHostingPublicPath) ?: $sharedHostingPublicPath);
}

return $app;
