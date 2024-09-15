<?php

namespace App\Http\Middleware;

use Closure;
use App\Enums\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::guard('admins')->user();

        if (!$user || $user->role->name != Roles::ADMIN->value) {
            return redirect()->route('auth.admin.login')->with('message', 'Sorry, you don\'t have access to this path');
        }
        
        return $next($request);
    }
}
