<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'idRol';

    protected $fillable = [
        'rol',
        'nombre',
        'descripcion'
];

    public $timestamps = false;

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'idRol');
    }
}
