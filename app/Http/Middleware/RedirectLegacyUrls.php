<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectLegacyUrls
{
    public function handle(Request $request, Closure $next)
    {
        $path = trim($request->path(), '/');

        // Old item/product URLs (Shopify-era) → categories
        if (str_starts_with($path, 'item/') || $path === 'item') {
            return redirect('/richmond-tx-near-grand-pkwy-99-hwy-90/categories/', 301);
        }

        // Old houston-richmond location URLs → new Richmond location
        if (str_starts_with($path, 'houston-richmond/') || $path === 'houston-richmond') {
            return redirect('/richmond-tx-near-grand-pkwy-99-hwy-90/', 301);
        }

        // Old public/location/* URLs → location page
        if (str_starts_with($path, 'public/location')) {
            return redirect('/location/', 301);
        }

        // Root-level /menu/* URLs (without branch prefix) → categories
        if (str_starts_with($path, 'menu/') || $path === 'menu') {
            return redirect('/richmond-tx-near-grand-pkwy-99-hwy-90/categories/', 301);
        }

        // Legacy/SEO-ghost URL patterns
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
                return redirect('/location/', 301);
            }
        }

        // Strip public/ prefix for remaining public/* paths
        if (str_starts_with($path, 'public/')) {
            $newPath = substr($path, strlen('public/'));
            return redirect('/' . ltrim($newPath, '/') . '/', 301);
        }

        return $next($request);
    }
}
