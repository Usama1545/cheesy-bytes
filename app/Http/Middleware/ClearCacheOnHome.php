<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class ClearCacheOnHome
{
    public function handle($request, Closure $next)
    {
        if ($request->is('/')) { // Only Home Page Py Thappar 😏
            Cache::store('redis')->flush();
        }

        return $next($request);
    }
}
