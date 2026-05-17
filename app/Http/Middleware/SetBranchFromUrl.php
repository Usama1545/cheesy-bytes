<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class SetBranchFromUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $branchName = $request->route('branch');
//       dd($branchName);
//        dd($request->route('branch'));

        if ($branchName && !Session::has('branch_id')) {
            $branch = Branch::where('name', $branchName)->first();

            if ($branch) {
                Session::put('branch_id', $branch->id);
            } else {
                return redirect()->to('/location');
            }
        }

        return $next($request);
    }
}
