<?php

namespace App\Exceptions;

use App\Models\Branch;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException|ModelNotFoundException $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            return $this->redirectForMissingPage($request);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            if ($request->expectsJson()) {
                return null;
            }

            return $this->redirectForMissingPage($request);
        });
    }

    private function redirectForMissingPage($request)
    {
        $segments = array_filter(explode('/', trim($request->path(), '/')));
        $firstSegment = array_shift($segments) ?? '';

        if ($firstSegment && $firstSegment !== 'admin') {
            $branch = Branch::where('slug', $firstSegment)->first();

            if ($branch) {
                $remainingPath = implode('/', $segments);
                $destination = str_contains($remainingPath, 'menu')
                    ? "/{$branch->slug}/categories"
                    : "/{$branch->slug}/";

                return redirect($destination, 301);
            }
        }

        return redirect()->route('location', [], 301);
    }
}
