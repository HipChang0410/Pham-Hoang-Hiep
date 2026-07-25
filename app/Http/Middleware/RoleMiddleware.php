<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, mixed ...$roles): mixed
    {
        $user = Auth::user();

        if (! $user) {
            return $next($request);
        }

        if (! in_array((int) $user->role, $roles, true)) {
            abort(403, 'Bạn không có quyền truy cập');
        }

        return $next($request);
    }
}
