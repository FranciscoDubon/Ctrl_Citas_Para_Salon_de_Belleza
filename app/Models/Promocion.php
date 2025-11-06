<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = 'promocion';
    protected $primaryKey = 'idPromocion';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipoDescuento',
        'valorDescuento',
        'fechaInicio',
        'fechaFin',
        'codigoPromocional',
        'usosMaximos',
        'usosActuales',
        'usosPorCliente',
        'diasAplicables',
        'activo'
    ];

    protected $casts = [
        'diasAplicables' => 'array',
        'activo' => 'boolean',
        'fechaInicio' => 'date',
        'fechaFin' => 'date',
    ];

    // Verificar si la promoción está vigente
    public function estaVigente()
    {
        $hoy = now();
        return $this->activo 
            && $this->fechaInicio <= $hoy 
            && $this->fechaFin >= $hoy
            && ($this->usosMaximos === null || $this->usosActuales < $this->usosMaximos);
    }

    // Verificar si puede ser usada
    public function puedeUsarse()
    {
        return $this->usosMaximos === null || $this->usosActuales < $this->usosMaximos;
    }
}