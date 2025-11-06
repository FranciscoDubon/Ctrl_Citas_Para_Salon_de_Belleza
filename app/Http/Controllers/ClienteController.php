<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Carbon\Carbon;
use App\Models\Empleado;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;


class ClienteController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'correoElectronico' => 'required|email',
        'clave' => 'required'
    ]);

    // Intentar login como Empleado
    $empleado = Empleado::where('correoElectronico', $request->correoElectronico)
                        ->where('activo', 1)
                        ->with('rol')
                        ->first();

    if ($empleado && Hash::check($request->clave, $empleado->clave)) {
        $rolNombre = optional($empleado->rol)->nombre;

        if (!$rolNombre) {
            return response()->json([
                'success' => false,
                'message' => 'El empleado no tiene un rol asignado válido'
            ]);
        }

        return response()->json([
            'success' => true,
            'rol' => $rolNombre,
            'nombre' => $empleado->nombre,
            'apellido' => $empleado->apellido,
            'tipoUsuario' => 'empleado'
        ]);
    }

    // Intentar login como Cliente
    $cliente = Cliente::where('correoElectronico', $request->correoElectronico)->first();

    if ($cliente && Hash::check($request->clave, $cliente->clave)) {
        return response()->json([
            'success' => true,
            'rol' => $cliente->rol, // campo enum directo
            'nombre' => $cliente->nombre,
            'apellido' => $cliente->apellido,
            'tipoUsuario' => 'cliente'
        ]);
    }

    // Si no se encuentra en ninguna tabla
    return response()->json([
        'success' => false,
        'message' => 'Correo o contraseña incorrectos'
    ]);
}

    public function registrar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correoElectronico' => 'required|email|unique:cliente,correoElectronico',
            'telefono' => 'nullable|string|max:20',
            'fechaNacimiento' => 'nullable|date',
            'clave' => 'required|string|min:8|confirmed', // validated against clave_confirmation
            'genero' => 'nullable|string|max:20',
            'comoConocio' => 'nullable|string|max:50',
            'suscripcionNewsletter' => 'boolean'
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'correoElectronico' => $request->correoElectronico,
            'telefono' => $request->telefono,
            'clave' => Hash::make($request->clave),
            'rol' => 'CLIENTE',
            'fechaNacimiento' => $request->fechaNacimiento,
            'genero' => $request->genero,
            'comoConocio' => $request->comoConocio,
            'suscripcionNewsletter' => $request->suscripcionNewsletter ?? 1
            

        ]);

        return response()->json(['success' => 'Usuario registrado correctamente']);
    }

public function dashboardRecepcionista()
{
    $clientes = Cliente::all();
    $clientesRecientes = Cliente::where('fechaRegistro', '>=', Carbon::now()->subDays(30))->count();
    $clientesNewsletter = Cliente::where('suscripcionNewsletter', 1)->count();
    $clientesNoNewsletter = Cliente::where('suscripcionNewsletter', 0)->count();

    return view('recepcionista.clientesRecepcionista', compact(
        'clientes',
        'clientesRecientes',
        'clientesNewsletter',
        'clientesNoNewsletter'
    ));
}


}
