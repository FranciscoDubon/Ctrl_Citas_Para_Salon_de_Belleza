<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'cita';
    protected $primaryKey = 'idCita';
    public $timestamps = false;

    protected $fillable = [
        'idCliente',
        'idEstilista',
        'fecha',
        'hora',
        'idPromocion',
        'estado',
        'duracion'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }

    public function estilista()
    {
        return $this->belongsTo(Empleado::class, 'idEstilista');
    }

public function servicios()
{
    return $this->belongsToMany(Servicio::class, 'citaservicio', 'idCita', 'idServicio');
}

    public function promocion()
{
    return $this->belongsTo(Promocion::class, 'idPromocion');
}

    
}
