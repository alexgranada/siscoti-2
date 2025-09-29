<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function creando()
    {
        $clientes = Cliente::where('estado', 'activo')->orderBy('id', 'desc')->get();
        $productos = Producto::where('estado', 'activo')->orderBy('id', 'desc')->get();
        return view('crear-cotizacion', compact('clientes', 'productos'));
    }
}
