<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Para login
use Illuminate\Notifications\Notifiable;

class Cliente extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'cliente';
    protected $primaryKey = 'idCliente';
    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'correoElectronico',
        'clave',
        'rol',
        'fechaNacimiento',
        'genero',
        'comoConocio',
        'suscripcionNewsletter',
        'fechaRegistro'
    ];

    protected $hidden = [
        'clave', // no mostrar la contraseña
    ];

    protected $casts = [
        'suscripcionNewsletter' => 'boolean',
    ];

    // Para usar la contraseña con Auth
    public function getAuthPassword()
    {
        return $this->clave;
    }

    public function citas()
{
    return $this->hasMany(Cita::class, 'idCliente');
}

}
