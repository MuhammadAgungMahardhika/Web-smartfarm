<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role1 = null, $role2 = null, $role3 = null)
    {

        if ($role1 != null  && Auth::user()->id_role == $role1) {
            return $next($request);
        }

        if ($role2 != null && Auth::user()->id_role == $role2) {
            return $next($request);
        }

        if ($role3 != null && Auth::user()->id_role == $role3) {
            return $next($request);
        }


        return redirect('error-403')->with('error', 'you dont have access to this URI');
    }
}
