<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticateAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->routeIs('admin.home') || $request->routeIs('admin.change-password') || $request->routeIs('admin.logout')) {
            try {
                $hasUsers = DB::table('staff_users')->exists();
            } catch (\Throwable) {
                $hasUsers = false;
            }

            if ($hasUsers && ! Auth::guard('web')->check()) {
                return redirect()->route('login');
            }
        }

        return $next($request);
    }
}
