<?php

namespace App\Http\Middleware;

use App\Models\Branch;
use App\Models\State;
use Closure;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Session;

class SetUserLocation
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->routeIs('location') || $request->routeIs('location.store')|| $request->routeIs('location.update') || $request->routeIs('admin.*'))  {
            return $next($request);
        }
        if (!Session::has('branch_id')) {
            $ip = $request->ip();
            $ip = $ip != '127.0.0.1' ? trim($ip) : '8.8.8.8'; // Use real IP unless local machine, then fallback
            if (empty($ip)) {
                return [
                    'country' => 'United States',
                    'countryCode' => 'USD',
                    'location' => ['country' => ['name' => 'United States', 'code' => 'USD']]
                ];
            };
            $url = env('IP_REG_SERVICE', false) ? "https://api.ipregistry.co/$ip?key=2rlvhidta7b5cmcg" : "http://ip-api.com/json/$ip"; // API URL selection
            $response = (new Client())->get($url);
            $response = json_decode($response->getBody(), true); // Decode the JSON response
            $state = State::where('name', $response['region'])->first(); // Find state by name

            if ($state) {
                $branch = Branch::where('state_id', $state->id)->first(); // Find branch by state ID

                if ($branch) {
                    Session::put('branch_id', $branch->id); // Store branch ID in session
                } else {
                    // If branch not found, redirect to location page
                    return redirect()->route('location');
                }
            } else {
                return redirect()->route('location'); // Redirect if state not found
            }
        }
        return $next($request);
    }
}
