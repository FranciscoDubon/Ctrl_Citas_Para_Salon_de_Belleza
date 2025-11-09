<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'idEmpleado';

    protected $fillable = [
        'nombre', 
        'apellido', 
        'telefono', 
        'correoElectronico', 
        'clave', 
        'direccion', 
        'idRol',
        'activo'
    ];

     protected $hidden = [
        'clave',
    ];

    public $timestamps = false; // quitar si tu tabla NO usa created_at / updated_at

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'idRol');
    }
        public function citas()
    {
        return $this->hasMany(Cita::class, 'idEstilista', 'idEmpleado');
    }
}
