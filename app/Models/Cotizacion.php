<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacions';
    protected $fillable = ['codigo', 'cliente_id', 'usuario_id', 'empresa_id', 'fecha', 'fecha_vencimiento', 'fecha_entrega', 'observaciones', 'total', 'estado'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
