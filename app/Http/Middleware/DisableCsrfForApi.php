<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Http\Request;

class DisableCsrfForApi extends Middleware
{
    public function handle($request, \Closure $next)
    {
        // Desactivar CSRF para rutas API
        if ($request->is('api/*')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
