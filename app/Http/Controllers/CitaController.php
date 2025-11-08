<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\Empleado;
use Carbon\Carbon; 
use App\Models\Promocion;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:cliente,idCliente',
            'estilista_id' => 'required|exists:empleado,idEmpleado',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'servicio_id' => 'required|exists:servicio,idServicio',
            'codigo_promocional' => 'nullable|string'
        ]);

        DB::beginTransaction();

        try {
            $servicio = Servicio::findOrFail($request->servicio_id);

            $cita = Cita::create([
                'idCliente' => $request->cliente_id,
                'idEstilista' => $request->estilista_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => 'PENDIENTE',
                'duracion' => $servicio->duracionBase
                
            ]);
            // Asignar promoción si se envió un código válido
        if ($request->filled('codigo_promocional')) {
            $promocion = Promocion::where('codigoPromocional', $request->codigo_promocional)
                ->where('activo', true)
                ->whereDate('fechaInicio', '<=', now())
                ->whereDate('fechaFin', '>=', now())
                ->first();

            if ($promocion && $promocion->puedeUsarse()) {
                $cita->idPromocion = $promocion->idPromocion;
                $cita->save();

                // Opcional: incrementar contador de usos
                $promocion->increment('usosActuales');
            }
        }
            $cita->servicios()->attach($servicio->idServicio);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Cita agendada correctamente']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al agendar cita', 'error' => $e->getMessage()], 500);
        }
    }

public function crear()
{
    $clientes = Cliente::all();

    $estilistas = Empleado::whereHas('rol', function ($query) {
        $query->where('nombre', 'estilista');
    })->where('activo', 1)->get();

    $servicios = Servicio::where('activo', 1)->get();
    

    return view('recepcionista.citasRecepcionista', compact('clientes', 'estilistas', 'servicios'));
}

public function agendaSemana()
{
    $clientes = Cliente::all();

    $estilistas = Empleado::whereHas('rol', function ($query) {
        $query->where('nombre', 'estilista');
    })->where('activo', 1)->get();

    $servicios = Servicio::where('activo', 1)->get();

    $citas = Cita::with(['cliente', 'estilista', 'servicios', 'promocion'])
        ->orderBy('fecha')
        ->orderBy('hora')
        ->get();

    // KPIs
    $hoy = Carbon::today();
    $manana = Carbon::tomorrow();

    $kpiCitas = [
        'totalHoy' => Cita::whereDate('fecha', $hoy)->count(),
        'completadasHoy' => Cita::whereDate('fecha', $hoy)->where('estado', 'COMPLETADA')->count(),
        'pendientesHoy' => Cita::whereDate('fecha', $hoy)->where('estado', 'PENDIENTE')->count(),
        'canceladasHoy' => Cita::whereDate('fecha', $hoy)->where('estado', 'CANCELADA')->count(),
        'totalManana' => Cita::whereDate('fecha', $manana)->count(),
    ];

    return view('recepcionista.citasRecepcionista', compact(
        'clientes', 'estilistas', 'servicios', 'citas', 'kpiCitas', 'manana'
    ));
}

public function filtrarTabla(Request $request)
{
    $fecha = $request->input('fecha') ?? now()->toDateString();
    $idEstilista = $request->input('estilista');
    $estado = $request->input('estado');

    $citas = Cita::with(['cliente', 'servicios', 'promocion', 'estilista'])
        ->whereDate('fecha', $fecha)
        ->when($idEstilista, fn($q) => $q->where('idEstilista', $idEstilista))
        ->when($estado, fn($q) => $q->where('estado', $estado))
        ->orderBy('hora')
        ->get();

    return view('recepcionista.partials.filas-citas', compact('citas'))->render();
}


public function dashboardRecepcionista()
{
    $hoy = now()->toDateString();

    // KPIs
    $totalCitasHoy = Cita::whereDate('fecha', $hoy)->count();
    $citasCompletadas = Cita::where('estado', 'COMPLETADA')->whereDate('fecha', $hoy)->count();
    $citasPendientes = Cita::where('estado', 'PENDIENTE')->whereDate('fecha', $hoy)->count();
    $totalClientes = Cliente::count();
    $totalEmpleados = Empleado::where('activo', 1)->count();
    $totalDescuento = \App\Models\Promocion::sum('valorDescuento');

    // Promociones activas y desactivadas
    $promocionesActivas = Promocion::where('usosActuales', '>', 0)->count();
    $promosDesactivadas = Promocion::where('activo', 0)->count();
    $promocionesAplicadas = Promocion::where('usosActuales', '>', 0)->count();

    // 🔹 NUEVO: lista de promociones activas del día
    $promocionesHoy = Promocion::select('idPromocion', 'nombre', 'codigoPromocional', 'tipoDescuento', 'valorDescuento', 'usosMaximos', 'usosActuales')
        ->where('activo', 1)
        ->whereDate('fechaInicio', '<=', $hoy)
        ->whereDate('fechaFin', '>=', $hoy)
        ->where(function ($query) {
            $dia = strtolower(now()->locale('es')->dayName);
            $query->whereNull('diasAplicables')
                  ->orWhereRaw("json_contains(diasAplicables, '\"$dia\"')");
        })
        ->limit(5)
        ->get();

    // Últimas citas
    $ultimasCitas = Cita::orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->limit(5)
        ->get();

    return view('recepcionista.dashboardRecepcionista', compact(
        'totalCitasHoy',
        'citasCompletadas',
        'citasPendientes',
        'totalClientes',
        'totalEmpleados',
        'promocionesActivas',
        'promosDesactivadas',
        'promocionesAplicadas',
        'totalDescuento',
        'promocionesHoy', // ✅ ya definida antes del compact
        'ultimasCitas'
    ));
}

// ========================================
// MÉTODOS PARA ESTILISTA
// ========================================

// VISTA ESTILISTA - GESTIÓN DE CITAS
public function indexEstilista(Request $request)
{
    // Obtener el ID del estilista desde la sesión
    $estilistaId = session('clienteId');

    if (!$estilistaId) {
        return redirect()->route('login')->with('error', 'Debes iniciar sesión');
    }
    
    $fechaSeleccionada = $request->input('fecha', Carbon::today()->toDateString());
    
    // Obtener citas del día para el estilista
    $citas = Cita::with(['cliente', 'servicios', 'promocion'])
        ->where('idEstilista', $estilistaId)
        ->whereDate('fecha', $fechaSeleccionada)
        ->orderBy('hora', 'asc')
        ->get();
    
    // KPIs del día
    $totalCitasHoy = $citas->count();
    $citasCompletadas = $citas->where('estado', 'COMPLETADA')->count();
    
    // Calcular horas de trabajo
    $horasTrabajo = 0;
    foreach ($citas as $cita) {
        if ($cita->servicios && $cita->servicios->isNotEmpty()) {
            $horasTrabajo += $cita->servicios->first()->duracionBase ?? 0;
        }
    }
    $horasTrabajo = round($horasTrabajo / 60, 1);
    
// Próxima cita (solo PENDIENTE o CONFIRMADA que aún no han pasado)
$horaActual = Carbon::now()->format('H:i:s');
$fechaActual = Carbon::today()->toDateString();

$proximaCita = Cita::with(['cliente', 'servicios'])
    ->where('idEstilista', $estilistaId)
    ->whereIn('estado', ['PENDIENTE', 'CONFIRMADA']) // ✅ Solo citas pendientes o confirmadas
    ->where(function($query) use ($fechaActual, $horaActual) {
        $query->where('fecha', '>', $fechaActual)
              ->orWhere(function($q) use ($fechaActual, $horaActual) {
                  $q->where('fecha', '=', $fechaActual)
                    ->where('hora', '>', $horaActual);
              });
    })
    ->orderBy('fecha', 'asc')
    ->orderBy('hora', 'asc')
    ->first();
    
    // Cita en proceso
    $citaEnProceso = Cita::with(['cliente', 'servicios'])
        ->where('idEstilista', $estilistaId)
        ->where('estado', 'EN_PROCESO')
        ->whereDate('fecha', $fechaSeleccionada)
        ->first();
    
    // Contadores por estado
    $contadores = [
        'todas' => $totalCitasHoy,
        'pendientes' => $citas->whereIn('estado', ['PENDIENTE', 'CONFIRMADA'])->count(),
        'completadas' => $citasCompletadas,
        'en_proceso' => $citas->where('estado', 'EN_PROCESO')->count(),
    ];
    
    return view('estilista.citasEstilista', compact(
        'citas',
        'totalCitasHoy',
        'citasCompletadas',
        'horasTrabajo',
        'proximaCita',
        'citaEnProceso',
        'fechaSeleccionada',
        'contadores',
        'estilistaId'
    ));
}

// OBTENER DETALLE DE CITA CON HISTORIAL (AJAX)
public function showCitaEstilista($id)
{
    try {
        $estilistaId = session('clienteId');
        
        $cita = Cita::with(['cliente', 'servicios', 'promocion', 'estilista'])
            ->where('idEstilista', $estilistaId)
            ->findOrFail($id);
        
        // Obtener historial del cliente con este estilista
        $historial = Cita::with('servicios')
            ->where('idCliente', $cita->idCliente)
            ->where('idEstilista', $cita->idEstilista)
            ->where('estado', 'COMPLETADA')
            ->where('idCita', '!=', $id)
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->limit(5)
            ->get();
        
        $cita->historial = $historial;
        
        return response()->json($cita);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Cita no encontrada'], 404);
    }
}


// INICIAR CITA (Cambiar a "EN_PROCESO")
public function iniciarCita(Request $request, $id)
{
    try {
        $cita = Cita::findOrFail($id);
        
        if (!in_array($cita->estado, ['PENDIENTE', 'CONFIRMADA'])) {
            return response()->json([
                'error' => 'La cita no se puede iniciar en su estado actual'
            ], 400);
        }
        
        $cita->estado = 'EN_PROCESO';
        $cita->save();
        
        return response()->json([
            'success' => true,
            'mensaje' => 'Cita iniciada correctamente',
            'nuevo_estado' => 'EN_PROCESO'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'No se pudo iniciar la cita'], 500);
    }
}

// FINALIZAR CITA (Cambiar a "COMPLETADA")
public function finalizarCita(Request $request, $id)
{
    try {
        $cita = Cita::findOrFail($id);
        
        if ($cita->estado !== 'EN_PROCESO') {
            return response()->json([
                'error' => 'La cita no está en proceso'
            ], 400);
        }
        
        $cita->estado = 'COMPLETADA';
        $cita->save();
        
        return response()->json([
            'success' => true,
            'mensaje' => 'Cita finalizada correctamente',
            'nuevo_estado' => 'COMPLETADA'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'No se pudo finalizar la cita'], 500);
    }
}

// CONFIRMAR ASISTENCIA
public function confirmarAsistencia(Request $request, $id)
{
    try {
        $cita = Cita::findOrFail($id);
        
        $cita->estado = 'CONFIRMADA';
        $cita->save();
        
        return response()->json([
            'success' => true,
            'mensaje' => 'Asistencia confirmada',
            'nuevo_estado' => 'CONFIRMADA'
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'No se pudo confirmar la asistencia'], 500);
    }
}

// FILTRAR CITAS POR ESTADO (AJAX)
public function filtrarPorEstado(Request $request)
{
    $estilistaId = session('clienteId');
    $fechaSeleccionada = $request->input('fecha', Carbon::today()->toDateString());
    $estado = $request->input('estado', 'todas');
    
    $query = Cita::with(['cliente', 'servicios', 'promocion'])
        ->where('idEstilista', $estilistaId)
        ->whereDate('fecha', $fechaSeleccionada);
    
    if ($estado !== 'todas') {
        switch ($estado) {
            case 'pendientes':
                $query->whereIn('estado', ['PENDIENTE', 'CONFIRMADA']);
                break;
            case 'completadas':
                $query->where('estado', 'COMPLETADA');
                break;
            case 'en_proceso':
                $query->where('estado', 'EN_PROCESO');
                break;
        }
    }
    
    $citas = $query->orderBy('hora', 'asc')->get();
    
    return response()->json($citas);
}


}
