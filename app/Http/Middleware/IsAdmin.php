<?php

namespace App\Http\Middleware;

use App\Helpers\Roles;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::user()->role_id == Roles::DEFAULT_ADMIN_ROLE || Auth::user()->role_id == Roles::DEFAULT_MODERATOR_ROLE) {
            return $next($request);
        }

        $authUser = Auth::guard('web')->user();
        Session::flush();
        Auth::guard('web')->logout($authUser);

        //return redirect(route('landingPage'));
        return redirect(route('adminLogin'));
    }
}
