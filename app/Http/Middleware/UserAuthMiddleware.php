<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('users')->user();

        if (!$user || $user->role->name != Roles::USER->value) {
            return redirect()->route('auth.user.login')->with('message', 'Sorry, you don\'t have access to this path');
        }
        
        return $next($request);
    }
}
