<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Carbon\Carbon;
use App\Models\Empleado;
use App\Models\Cita;
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
        // ✅ GUARDAR EN SESIÓN
        session([
            'clienteId' => $empleado->idEmpleado,  // Lo guardamos como clienteId para que funcione igual
            'clienteNombre' => $empleado->nombre,
            'clienteApellido' => $empleado->apellido,
            'tipoUsuario' => 'empleado'
        ]);

        return response()->json([
            'success' => true,
            'rol' => $rolNombre,
            'nombre' => $empleado->nombre,
            'apellido' => $empleado->apellido,
            'id' => $empleado->idEmpleado,
            'tipoUsuario' => 'empleado'
        ]);
    }

    // Intentar login como Cliente
    $cliente = Cliente::where('correoElectronico', $request->correoElectronico)->first();

    if ($cliente && Hash::check($request->clave, $cliente->clave)) {
        // ✅ GUARDAR EN SESIÓN
        session([
            'clienteId' => $cliente->idCliente,
            'clienteNombre' => $cliente->nombre,
            'clienteApellido' => $cliente->apellido,
            'tipoUsuario' => 'cliente',
            'rol' => $cliente->rol
        ]);
        return response()->json([
            'success' => true,
            'rol' => $cliente->rol, // campo enum directo
            'nombre' => $cliente->nombre,
            'apellido' => $cliente->apellido,
            'Id' => $cliente->idCliente,
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

public function clientesRecepcionista()
{
   $clientes = Cliente::with(['citas.servicios'])->withCount('citas')->get();
    return view('recepcionista.clientesRecepcionista', compact('clientes'));
}

public function editarCliente($id)
{
    $cliente = Cliente::findOrFail($id);

    return response()->json([
        'idCliente' => $cliente->idCliente,
        'nombre' => $cliente->nombre,
        'apellido' => $cliente->apellido,
        'fechaNacimiento' => $cliente->fechaNacimiento,
        'telefono' => $cliente->telefono,
        'correoElectronico' => $cliente->correoElectronico,
        'fuente_conocimiento' => $cliente->comoConocio,
        'acepta_promociones' => $cliente->suscripcionNewsletter,
    ]);
}

public function mostrarConfigCliente()
{
    if (session('rol') !== 'CLIENTE') {
        abort(403, 'Acceso no autorizado');
    }

    $clienteId = session('clienteId');
    $cliente = Cliente::findOrFail($clienteId);

    return view('cliente.configCliente', compact('cliente'));
}


public function actualizarConfiguracion(Request $request)
{
   

    if (session('rol') !== 'CLIENTE') {
        abort(403, 'Acceso no autorizado');
    }

    $cliente = Cliente::findOrFail(session('clienteId'));

    $request->validate([
        'nombre' => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
        'correoElectronico' => 'required|email|unique:cliente,correoElectronico,' . $cliente->idCliente . ',idCliente',
        'telefono' => 'nullable|string|max:20',
        'fechaNacimiento' => 'nullable|date',
        'genero' => 'nullable|string|max:20',
        'clave' => 'nullable|string|min:8|confirmed',
        'comoConocio' => 'nullable|string|max:255',
        'suscripcionNewsletter' => 'nullable|boolean'

    ]);

    $cliente->update([
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'correoElectronico' => $request->correoElectronico,
        'telefono' => $request->telefono,
        'fechaNacimiento' => $request->fechaNacimiento,
        'genero' => $request->genero,
        
        'comoConocio' => $request->comoConocio,
        'suscripcionNewsletter' => $request->has('suscripcionNewsletter')

    ]);

    if ($request->filled('clave')) {
        $cliente->clave = Hash::make($request->clave);
        $cliente->save();
    }

    return view('cliente.configCliente', compact('cliente'));
}

public function mostrarCitasCliente()
{
    if (session('rol') !== 'CLIENTE') {
        abort(403, 'Acceso no autorizado');
    }

    $clienteId = session('clienteId');
    $cliente = Cliente::findOrFail($clienteId);

    $visitas = Cita::where('idCliente', $clienteId)->count();

    $ultimaCita = Cita::where('idCliente', $clienteId)
        ->where('fecha', '<=', now())
        ->orderByDesc('fecha')
        ->first();

    $proximaCita = Cita::where('idCliente', $clienteId)
        ->where('fecha', '>', now())
        ->orderBy('fecha')
        ->first();

    return view('cliente.citasCliente', compact('cliente', 'visitas', 'ultimaCita', 'proximaCita'));
}


}
