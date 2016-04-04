<?php

namespace suo\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use suo\Repositories\UserRepository;
use suo\Repositories\RoomRepository;

class Authenticate
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
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                $user_repo = new UserRepository();
                $user_id = $user_repo->forAuth($request->ip());
                Auth::loginUsingId($user_id);

                if (Auth::user()->isOperator()) {
                    $room_repo = new RoomRepository();
                    $rooms = $room_repo->forOperator($user_id);
                    session(['rooms' => $rooms->pluck('id')->all()]);

                    return redirect()->intended('/operator');
                }

                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
