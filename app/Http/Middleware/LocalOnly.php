<?php

namespace suo\Http\Middleware;

use Closure;

class LocalOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (false !== filter_var($request->ip(), FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE)) {
            return redirect('');
        }

        return $next($request);
    }
}
