<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $fillable = ['razon_social', 'nombre_comercial', 'ruc', 'email', 'telefono', 'direccion', 'logo', 'firma', 'estado'];

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class);
    }

    
}
