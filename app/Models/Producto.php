<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = ['nombre', 'precio', 'sku', 'stock', 'imagen', 'descripcion', 'estado', 'tipo', 'empresa_id'];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    public function cotizacionDetalles()
    {
        return $this->hasMany(CotizacionDetalle::class);
    }


    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // El método when() solo ejecuta la función si el primer argumento es verdadero.
        // Es una forma más limpia de escribir un if.
        $query->when($filters['sku'] ?? null, function ($query, $sku) {
            $query->where('sku', 'like', '%' . $sku . '%');
        });

        $query->when($filters['nombre'] ?? null, function ($query, $nombre) {
            $query->where('nombre', 'like', '%' . $nombre . '%');
        });
        $query->when($filters['tipo'] ?? null, function ($query, $tipo) {
            $query->where('tipo', $tipo);
        });
        $query->when($filters['estado'] ?? null, function ($query, $estado) {
            $query->where('estado', $estado);
        });

        return $query;
    }
}
