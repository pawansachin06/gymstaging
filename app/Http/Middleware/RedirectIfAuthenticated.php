<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$guards)
    {
        if (Auth::guard($guard)->check()) {
            $user = $request->user();
            $url = '/';
            if($user->role_id == User::ROLE_ADMIN){
                $url = '/admin/home';
            }

            return redirect($url);
        }

        return $next($request);
    }
}
