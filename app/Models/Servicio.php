<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';
    protected $primaryKey = 'idServicio';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precioBase',
        'duracionBase',
        'categoria',
        'ajustes_especiales',
        'permite_promociones',
        'activo',
    ];
}
