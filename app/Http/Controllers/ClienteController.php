<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();

        // Filtrar por DNI
        if ($request->filled('dni')) {
            $query->where('num_doc', 'LIKE', '%' . $request->dni . '%');
        }

        // Filtrar por nombres
        if ($request->filled('nombres')) {
            $query->where('nombres', 'LIKE', '%' . $request->nombres . '%');
        }

        // Filtrar por rango de fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [
                $request->fecha_inicio . ' 00:00:00',
                $request->fecha_fin . ' 23:59:59'
            ]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Ordenar y paginar
        $clientes = $query->orderBy('id', 'desc')->paginate(15);

        // Retornar vista con filtros aplicados
        return view('clientes', compact('clientes'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_doc' => 'required|in:RUC,DNI,CEDULA',
            'nombres' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'num_doc' => 'required|unique:clientes,num_doc|max:15',
        ]);
        //dd($request->all());


        $data['estado'] = 'ACTIVO'; 
        Cliente::create($data);
        return redirect()->back()->with('success', 'Cliente creado exitosamente.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'tipo_doc' => 'nullable|string|max:50',
            'num_doc' => 'nullable|string|max:15',
            'estado' => 'nullable|in:ACTIVO,INACTIVO',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->back()->with('success', 'Cliente actualizado exitosamente.');
    }
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json(['success' => 'Cliente eliminado exitosamente.']);
    }
}
