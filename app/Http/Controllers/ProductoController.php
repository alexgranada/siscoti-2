<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // Valida que los campos sean de tipo string (opcional pero recomendado)
        $filters = $request->validate([
            'sku' => 'nullable|string',
            'nombre' => 'nullable|string',
            'tipo' => 'nullable|in:producto,servicio',
            'estado' => 'nullable|in:activo,inactivo',
        ]);

        // Llama al scope 'filter' y le pasa los filtros validados
        $productos = Producto::filter($filters) // <-- Así de simple
            ->paginate(15)
            ->appends($request->query());

        return view('productos', compact('productos'));
    }


    public function store(Request $request)
    {

        $datosValidados = $request->validate([
            'nombre'      => 'required|string|max:255',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'estado'      => 'required|in:activo,inactivo',
            'tipo'        => 'required|in:producto,servicio',
            'descripcion' => 'nullable|string',
            'imagen'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $prefix = ($datosValidados['tipo'] === 'producto') ? 'PROD' : 'SERV';

        $ultimoProducto = Producto::where('tipo', $datosValidados['tipo'])
            ->orderBy('id', 'desc')
            ->first();

        if ($ultimoProducto && $ultimoProducto->sku) {
            $numeroAnterior = (int) substr($ultimoProducto->sku, strlen($prefix) + 1);
            $nuevoNumero = $numeroAnterior + 1;
        } else {
            $nuevoNumero = 1;
        }

        $correlativoFormateado = str_pad($nuevoNumero, 5, '0', STR_PAD_LEFT);
        $skuGenerado = $prefix . '-' . $correlativoFormateado;

        $datosParaGuardar = $datosValidados;
        $datosParaGuardar['sku'] = $skuGenerado;
        $datosParaGuardar['empresa_id'] = session('empresa_id');

        if ($request->hasFile('imagen')) {
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('storage/productos'), $nombreArchivo);
            $validador['imagen'] = 'productos/' . $nombreArchivo;
            $datosParaGuardar['imagen'] = $nombreArchivo;
        }

        Producto::create($datosParaGuardar);
        return redirect()->back()->with('success', 'Producto creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $validar = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
            'tipo' => 'required|in:producto,servicio',
            'descripcion' => 'nullable|string',
        ]);
        // Encuentra el producto por ID
        $producto = Producto::findOrFail($id);
        // Actualiza los campos
        $producto->update($validar);
        return redirect()->back()->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
        if ($producto->imagen) {
            $rutaImagen = public_path('storage/productos/' . $producto->imagen);
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }

         return response()->json(['success' => 'Producto eliminado correctamente.']);
    }

    public function editarfoto(Request $request, $id)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $producto = Producto::findOrFail($id);

        if ($request->hasFile('imagen')) {
            // Elimina la imagen anterior si existe
            if ($producto->imagen) {
                $rutaImagenAnterior = public_path('storage/productos/' . $producto->imagen);
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }
            }

            // Guarda la nueva imagen
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('storage/productos'), $nombreArchivo);
            $producto->imagen = $nombreArchivo;
            $producto->save();
        }

        return redirect()->back()->with('success', 'Imagen actualizada correctamente.');
    }
}
