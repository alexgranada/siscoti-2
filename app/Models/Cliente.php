<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nombres', 'telefono', 'correo', 'direccion', 'tipo_doc', 'num_doc', 'estado'];
}
