<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Session;

class SetUserLocation
{
    public function handle(Request $request, Closure $next)
    {
        // Bypass routes that shouldn’t use branch logic
        if (
            $request->routeIs('location') ||
            $request->routeIs('location.store') ||
            $request->routeIs('location.update') ||
            $request->routeIs('admin.*')
        ) {
            return $next($request);
        }

        // Extract the first URL segment (potential branch slug)
        $urlSegments = $request->segments();
        $branchSlug = $urlSegments[0] ?? null;

        // 🟢 CASE 1: URL includes a potential branch slug
        if ($branchSlug) {
            $branch = Branch::where('slug', $branchSlug)->first();

            if ($branch) {
                // Valid branch → store it in session
                Session::put('branch_id', $branch->id);
                return $next($request);
            } else {
                // Invalid branch → redirect to locations page (301)
                return redirect()->route('location', [], 301);
            }
        }

        // 🟡 CASE 2: No branch slug in URL
        // If the session already has a branch, we could redirect to that branch’s slug
        if (Session::has('branch_id')) {
            $branch = Branch::find(Session::get('branch_id'));
            if ($branch) {
                $newUrl = url("{$branch->slug}/" . ltrim($request->getRequestUri(), '/'));
                return redirect($newUrl, 301);
            }
        }

        // 🚫 Otherwise, no branch found → redirect to location selector
        return redirect()->route('location', [], 301);
    }
}
