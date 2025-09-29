<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    public function seleccionar(Request $request)
    {
        $request->validate([
            'empresa_id' => 'required|exists:empresas,id'
        ]);

        session(['empresa_id' => $request->empresa_id]);

        return redirect()->route('dashboard');
    }
}
