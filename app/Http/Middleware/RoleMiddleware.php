<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (Auth::guest()) {
            return abort(401);
        }
        $roles = is_array($role) ? $role : explode(':', $role);
        if (! in_array(Auth::user()->role_id, $roles)) {
            return redirect('/');
        }
        return $next($request);
    }
}
