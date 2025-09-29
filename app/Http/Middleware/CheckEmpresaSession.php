<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmpresaSession
{

    public function handle(Request $request, Closure $next)
    {
        // Si aún no hay sesión inicializada (por seguridad)
        if (!$request->hasSession()) {
            return $next($request);
        }

        // Si no hay empresa en sesión
        if (!$request->session()->has('empresa_id')) {
            view()->share('mostrarModalEmpresa', true);
            
        } else {
            view()->share('mostrarModalEmpresa', false);
        }

        return $next($request);
    }
}
