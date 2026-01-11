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
        // Skip middleware for these routes
        if (
            $request->routeIs('location*') ||
            $request->routeIs('admin.*')
        ) {
            return $next($request);
        }

        // 1️⃣ If route has branch slug → validate & store
        $branchSlug = $request->route('branch');

        if ($branchSlug) {
            $branch = Branch::where('slug', $branchSlug)->first();

            if (! $branch) {
                abort(404);
            }

            Session::put('branch_id', $branch->id);

            return $next($request);
        }

        // 2️⃣ If NO branch in route but session has branch
        if (Session::has('branch_id')) {
            $branch = Branch::find(Session::get('branch_id'));

            if ($branch) {
                return redirect()->route('home', [
                    'branch' => $branch->slug,
                ]);
            }

            // Session is stale → clean it
            Session::forget('branch_id');
        }

        // 3️⃣ No branch in route AND no session → force location selection
        return redirect()->route('location');
    }
}
