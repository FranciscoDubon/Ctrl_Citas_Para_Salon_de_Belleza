<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combo extends Model
{
    protected $table = 'combo';
    protected $primaryKey = 'idCombo';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'precioCombo',
        'precioRegular',
        'ahorro',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relación con servicios
    public function servicios()
    {
        return $this->belongsToMany(
            Servicio::class,
            'combo_servicio',
            'idCombo',
            'idServicio'
        );
    }

    // Calcular precio regular basado en servicios
    public function calcularPrecioRegular()
    {
        return $this->servicios()->sum('precioBase');
    }
}