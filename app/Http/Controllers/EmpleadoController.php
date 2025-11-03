<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'correoElectronico' => $request->email,
            'clave' => $request->password,
            'clave_confirmation' => $request->password_confirmation
        ]);

        // Validar datos
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'correoElectronico' => 'required|email|unique:empleado,correoElectronico',
            'clave' => 'required|min:8|confirmed',
            'direccion' => 'nullable|string',
            'idRol' => 'required|string',
            'activo' => 'required|boolean'
        ]);

        // Guardar empleado
        $empleado = Empleado::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'correoElectronico' => $request->correoElectronico,
            'clave' => Hash::make($request->clave),
            'direccion' => $request->direccion,
            'idRol' => $request->idRol,
            'activo' => $request->activo
        ]);

         return response()->json(['success' => true, 'empleado' => $empleado]);
    }
}
