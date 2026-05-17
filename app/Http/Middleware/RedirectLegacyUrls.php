<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectLegacyUrls
{
    public function handle(Request $request, Closure $next)
    {
        $path = trim($request->path(), '/');

        // Define legacy or SEO-ghost URLs you want to redirect
        $legacyUrls = [
            'comments/feed',
            'feed',
            'public/menu/frankie',
            'tag',
            'rss',
            'xmlrpc.php',
            'wp-login.php',
            'wp-content',
            'wp-includes',
        ];
        foreach ($legacyUrls as $legacy) {
            if (stripos($path, $legacy) !== false) {
                return redirect('/locations', 301);
            }
        }
        
        if (str_starts_with($path, 'public/')) {
            $newPath = substr($path, strlen('public/'));
            return redirect('/' . ltrim($newPath, '/'), 301);
        }

        return $next($request);
    }
}
