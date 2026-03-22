<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // Check if user has any of the allowed roles
        if (!in_array($user->role, $roles)) {
            // Redirect based on user's actual role
            if ($user->role === 'jefe') {
                return redirect('/admin')->with('error', 'No tienes permiso para acceder a esta página.');
            } elseif ($user->role === 'cajera') {
                return redirect('/staff')->with('error', 'No tienes permiso para acceder a esta página.');
            }
            
            return redirect('/')->with('error', 'No tienes permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
