<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user(); // Get the authenticated user

        if (!$user) {
            return redirect()->route('landing')->with('error', 'Anda tidak memiliki akses.');
        }

        // Determine the guard dynamically based on user role
        $guard = strtolower($user->role);

        if (!in_array($user->role, $roles)) {
            return redirect()->route('landing')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}

