<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class ExcludeApiRoutesFromCsrf extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     */
    protected static $except = [
        'api/*',
        'sanctum/*',
        'api/ventas-publico'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        // Excluir todas las rutas API y sanctum de CSRF
        if ($request->is('api/*') || $request->is('sanctum/*')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
