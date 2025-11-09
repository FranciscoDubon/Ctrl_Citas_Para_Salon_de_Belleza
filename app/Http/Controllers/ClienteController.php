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
public function verCita($id)
{
    try {
        \Log::info('📋 Intentando cargar cita:', [
            'id' => $id,
            'clienteId' => session('clienteId')
        ]);
        
        // Buscar la cita
        $cita = \App\Models\Cita::with(['servicios', 'estilista', 'cliente', 'promocion'])
            ->where('idCita', $id)
            ->first();
        
        if (!$cita) {
            \Log::warning('❌ Cita no encontrada:', ['id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Cita no encontrada'
            ], 404);
        }
        
        // Verificar que la cita pertenece al cliente logueado
        if ($cita->idCliente != session('clienteId')) {
            \Log::warning('🚫 Cliente sin permiso:', [
                'citaClienteId' => $cita->idCliente,
                'sessionClienteId' => session('clienteId')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para ver esta cita'
            ], 403);
        }
        
        \Log::info('✅ Cita cargada exitosamente:', ['id' => $id]);
        
        return response()->json([
            'success' => true,
            'cita' => [
                'idCita' => $cita->idCita,
                'fecha' => $cita->fecha,
                'hora' => $cita->hora,
                'estado' => $cita->estado,
                'duracion' => $cita->duracion,
                'servicios' => $cita->servicios->map(function($servicio) {
                    return [
                        'nombre' => $servicio->nombre,
                        'duracionBase' => $servicio->duracionBase,
                        'precioBase' => $servicio->precioBase
                    ];
                }),
                'estilista' => [
                    'nombre' => $cita->estilista->nombre ?? 'No asignado',
                    'apellido' => $cita->estilista->apellido ?? ''
                ],
                'promocion' => $cita->promocion ? [
                    'nombre' => $cita->promocion->nombre,
                    'codigo' => $cita->promocion->codigoPromocional,
                    'tipoDescuento' => $cita->promocion->tipoDescuento,
                    'valorDescuento' => $cita->promocion->valorDescuento
                ] : null,
                'created_at' => $cita->created_at
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('❌ Error al ver cita:', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'id' => $id
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar la cita: ' . $e->getMessage()
        ], 500);
    }
}
public function confirmarCita($id)
{
    try {
        $cita = \App\Models\Cita::findOrFail($id);
        
        // Verificar que la cita pertenece al cliente logueado
        if ($cita->idCliente != session('clienteId')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para confirmar esta cita'
            ], 403);
        }
        
        // Solo se puede confirmar si está PENDIENTE
        if ($cita->estado !== 'PENDIENTE') {
            return response()->json([
                'success' => false,
                'message' => 'Solo puedes confirmar citas en estado PENDIENTE'
            ], 400);
        }
        
        $cita->estado = 'CONFIRMADA';
        $cita->save();
        
        return response()->json([
            'success' => true,
            'message' => '¡Cita confirmada exitosamente!',
            'nuevo_estado' => 'CONFIRMADA'
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error al confirmar cita:', [
            'error' => $e->getMessage(),
            'id' => $id
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error al confirmar la cita'
        ], 500);
    }
}

public function cancelarCita($id)
{
    try {
        $cita = \App\Models\Cita::findOrFail($id);
        
        // Verificar que la cita pertenece al cliente logueado
        if ($cita->idCliente != session('clienteId')) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para cancelar esta cita'
            ], 403);
        }
        
        // No se puede cancelar si ya está COMPLETADA o CANCELADA
        if (in_array($cita->estado, ['COMPLETADA', 'CANCELADA'])) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes cancelar una cita que ya está ' . strtolower($cita->estado)
            ], 400);
        }
        
        // Verificar que la cita sea con al menos 24 horas de anticipación
        $fechaHoraCita = \Carbon\Carbon::parse($cita->fecha . ' ' . $cita->hora);
        $horasAnticipacion = \Carbon\Carbon::now()->diffInHours($fechaHoraCita, false);
        
        if ($horasAnticipacion < 24) {
            return response()->json([
                'success' => false,
                'message' => '⚠️ Debes cancelar con al menos 24 horas de anticipación.\n\n' .
                            'Por favor contacta al salón directamente:\n' .
                            '📞 Teléfono: (503) 2222-3333'
            ], 400);
        }
        
        $cita->estado = 'CANCELADA';
        $cita->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Cita cancelada exitosamente',
            'nuevo_estado' => 'CANCELADA'
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Error al cancelar cita:', [
            'error' => $e->getMessage(),
            'id' => $id
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error al cancelar la cita'
        ], 500);
    }
}
}
