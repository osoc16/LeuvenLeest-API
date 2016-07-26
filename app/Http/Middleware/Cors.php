<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('options')) {
            return response('', 200)
                ->header('Allow_Origin', '*')
              ->header('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE')
              ->header('Access-Control-Expose-Headers', 'Authorization')
              ->header('Access-Control-Allow-Headers', 'accept, content-type,x-xsrf-token, x-csrf-token, authorization, cache-control', 'X-Requested-With', 'Origin'); // Add any required headers here
        }
        return $next($request);
    }
}
