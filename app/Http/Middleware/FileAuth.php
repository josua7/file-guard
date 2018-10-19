<?php

namespace App\Http\Middleware;

use Closure;

class FileAuth
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
		if (auth()->guard()->validate()) {
			return $next($request);
		} else {
			abort(401, 'Invalid credentials.');
		}

        return $next($request);
    }
}
