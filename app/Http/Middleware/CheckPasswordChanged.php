<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckPasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !is_null($user->password_changed_at)) {
            return $next($request);
        }

        if ($request->routeIs('password.change*') || $request->routeIs('logout') || $request->routeIs('api.password.change*') || $request->routeIs('api.logout')) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'You must change your password before continuing.',
                'actions' => [
                'change_password' => route('api.password.change')
            ]
            ], 403);
        }

        return redirect()->route('password.change');
    }
}
