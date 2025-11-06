<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

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
   public function index()
{
    $roles = \App\Models\Rol::all();

    $estilistas = Empleado::whereHas('rol', function ($query) {
        $query->where('nombre', 'estilista');
    })->where('activo', 1)->count();

    $recepcionistas = Empleado::whereHas('rol', function ($query) {
        $query->where('nombre', 'recepcionistas');
    })->where('activo', 1)->count();

    $inactivos = Empleado::where('activo', 0)->count();

    $empleados = Empleado::with('rol')->get(); 
    $clientes = Cliente::all();
    $clientesRecientes = \App\Models\Cliente::where('fechaRegistro', '>=', Carbon::now()->subDays(30))->count();

    return view('admin.usuariosAdmin', compact('roles', 'empleados', 'clientes','estilistas', 'recepcionistas', 'inactivos','clientesRecientes'));
}

public function update(Request $request, $id)
{
    $empleado = Empleado::findOrFail($id);

    // Validar datos
    $request->merge([
        'clave' => $request->password,
        'clave_confirmation' => $request->password_confirmation,
        'correoElectronico' => $request->email,
    ]);

    $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'telefono' => 'required|string|max:20',
        'correoElectronico' => [
            'required',
            'email',
            Rule::unique('empleado', 'correoElectronico')->ignore($empleado->idEmpleado, 'idEmpleado')
        ],
        'direccion' => 'nullable|string',
        'idRol' => 'required|exists:rol,idRol',
        'activo' => 'required|boolean',
        'clave' => 'nullable|min:8|confirmed'
    ]);

    // Actualizar campos
    $empleado->nombre = $request->nombre;
    $empleado->apellido = $request->apellido;
    $empleado->telefono = $request->telefono;
    $empleado->correoElectronico = $request->correoElectronico;
    $empleado->idRol = $request->idRol;
    $empleado->activo = $request->activo;
    $empleado->direccion = $request->direccion;

    if ($request->filled('clave')) {
        $empleado->clave = Hash::make($request->clave);
    }

    $empleado->save();

    return response()->json(['success' => true, 'empleado' => $empleado]);
}

public function cambiarEstado(Request $request, $id)
{
    $empleado = Empleado::findOrFail($id);
    $empleado->activo = !$empleado->activo;
    $empleado->save();

    return response()->json([
        'success' => true,
        'nuevoEstado' => $empleado->activo
    ]);
}


}

