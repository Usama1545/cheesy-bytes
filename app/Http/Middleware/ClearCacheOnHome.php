<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Session;

class ClearCacheOnHome
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
