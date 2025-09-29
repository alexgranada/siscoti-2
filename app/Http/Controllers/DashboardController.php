<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\Empresa;
use App\Models\Producto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $empresaId = session('empresa_id');
        $cotizaciones = Cotizacion::count();
        $servicios = Producto::where('tipo', 'servicio')->where('empresa_id', $empresaId)->count();
        $productos = Producto::where('tipo', 'producto')->where('empresa_id', $empresaId)->count();
        $clientes = Cliente::count();
        $produ = Producto::orderBy('id', 'desc')->where('empresa_id', $empresaId)->take(10)->get();
        

        return view('dashboard', compact('cotizaciones', 'servicios', 'productos', 'clientes', 'produ'));
    }
}
