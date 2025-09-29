<?php

namespace App\Providers;

use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class EmpresaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Aplica solo a las vistas del dashboard
        View::composer('*', function ($view) {
            // si no hay usuario logueado, no hacemos nada
            if (!Auth::check()) {
                return;
            }

            // si ya hay empresa en sesión, no mostrar modal
            if (session()->has('empresa_id')) {
                $view->with('mostrarModalEmpresa', false);
                $view->with('empresas', []);
                return;
            }

            // si no hay empresa en sesión, cargamos empresas
            $view->with('mostrarModalEmpresa', true);
            $view->with('empresas', Empresa::all());
        });
    }
}
