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

public function dashboardAdmin()
{
    $hoy = now()->toDateString();
    $ayer = now()->subDay()->toDateString();
    $año = date('Y');
    $mes = date('m');
    $mesAnterior = date('m', strtotime('-1 month'));
    $anioAnterior = date('Y', strtotime('-1 month'));
    $fechaActual = Carbon::now();
    $fechaLimite = Carbon::now()->subMonths(6);

    // Obtener los 5 clientes más frecuentes
    $clientesFrecuentes = DB::table('cliente as u')
        ->join('cita as c', 'u.idCliente', '=', 'c.idCliente')
        ->where('c.estado', 'completada')
        ->where('c.fecha', '>=', $fechaLimite)
        ->select('u.idCliente', 'u.nombre', 'u.apellido', DB::raw('COUNT(c.idCita) as visitas'))
        ->groupBy('u.idCliente', 'u.nombre', 'u.apellido')
        ->orderByDesc('visitas')
        ->limit(5)
        ->get();

    $ultimasCitas = DB::table('cita as c')
    ->join('cliente as cli', 'c.idCliente', '=', 'cli.idCliente')
    ->join('empleado as e', 'c.idEstilista', '=', 'e.idEmpleado')
    ->join('citaservicio as cs', 'c.idCita', '=', 'cs.idCita')
    ->join('servicio as s', 'cs.idServicio', '=', 's.idServicio')
    ->select(
        'c.idCita',
        'cli.nombre as cliente_nombre',
        'cli.apellido as cliente_apellido',
        's.nombre as servicio',
        'e.nombre as estilista_nombre',
        'e.apellido as estilista_apellido',
        'c.fecha',
        'c.hora',
        'c.estado'
    )
    ->orderByDesc('c.fecha')
    ->limit(10)
    ->get();


    // =======================================
    // Servicios más solicitados del mes actual
    // =======================================
    $serviciosMasSolicitados = DB::table('servicio as s')
        ->join('citaservicio as cs', 's.idServicio', '=', 'cs.idServicio')
        ->join('cita as c', 'cs.idCita', '=', 'c.idCita')
        ->select(
            's.nombre as nombre',
            DB::raw('COUNT(cs.idServicio) as cantidad'),
            DB::raw('SUM(s.precioBase) as ingresos')
        )
        ->where('c.estado', '=', 'completada')
        ->whereYear('c.fecha', $fechaActual->year)
        ->whereMonth('c.fecha', $fechaActual->month)
        ->groupBy('s.idServicio', 's.nombre')
        ->orderByDesc('cantidad')
        ->limit(10)
        ->get();


    // INGRESOS POR SERVICIOS (sin combos)
    $ingresosServicios = DB::table('cita')
        ->join('citaservicio', 'cita.idCita', '=', 'citaservicio.idCita')
        ->join('servicio', 'citaservicio.idServicio', '=', 'servicio.idServicio')
        ->whereYear('cita.fecha', $año)
        ->whereMonth('cita.fecha', $mes)
        ->sum('servicio.precioBase');

    // INGRESOS POR COMBOS
    $ingresosCombos = DB::table('combo')
        ->join('combo_servicio', 'combo.idCombo', '=', 'combo_servicio.idCombo')
        ->join('servicio', 'combo_servicio.idServicio', '=', 'servicio.idServicio')
        ->sum('combo.precioCombo');

    // DESCUENTOS POR PROMOCIONES A SERVICIOS
    $descuentoServicios = DB::table('promocion')
        ->join('promocionservicio', 'promocion.idPromocion', '=', 'promocionservicio.idPromocion')
        ->join('servicio', 'promocionservicio.idServicio', '=', 'servicio.idServicio')
        ->where('promocion.activo', 1)
        ->select(DB::raw("
            SUM(
                CASE 
                    WHEN promocion.tipoDescuento = 'porcentaje' THEN servicio.precioBase * (promocion.valorDescuento / 100)
                    ELSE promocion.valorDescuento
                END
            ) AS totalDescuento
        "))
        ->value('totalDescuento');

    // DESCUENTOS POR PROMOCIONES A COMBOS
    $descuentoCombos = DB::table('promocion')
        ->join('promocioncombo', 'promocion.idPromocion', '=', 'promocioncombo.idPromocion')
        ->join('combo', 'promocioncombo.idCombo', '=', 'combo.idCombo')
        ->where('promocion.activo', 1)
        ->select(DB::raw("
            SUM(
                CASE 
                    WHEN promocion.tipoDescuento = 'porcentaje' THEN combo.precioCombo * (promocion.valorDescuento / 100)
                    ELSE promocion.valorDescuento
                END
            ) AS totalDescuento
        "))
        ->value('totalDescuento');

    $ingresosTotales = ($ingresosServicios + $ingresosCombos) - (($descuentoServicios ?? 0) + ($descuentoCombos ?? 0));
    $ingresosTotales = number_format($ingresosTotales, 2, '.', '');

    // Ingresos del mes anterior
$ingresosMesAnterior = \DB::table('cita')
    ->join('citaservicio', 'cita.idCita', '=', 'citaservicio.idCita')
    ->join('servicio', 'citaservicio.idServicio', '=', 'servicio.idServicio')
    ->whereYear('cita.fecha', $anioAnterior)
    ->whereMonth('cita.fecha', $mesAnterior)
    ->sum('servicio.precioBase');

// Calcular el cambio porcentual
if ($ingresosMesAnterior > 0) {
    $porcentajeIngresos = (($ingresosTotales - $ingresosMesAnterior) / $ingresosMesAnterior) * 100;
} else {
    $porcentajeIngresos = 0;
}


    // KPIs
    $totalCitasHoy = Cita::whereDate('fecha', $hoy)->count();
    // Total de citas de ayer
    $citasAyer = \DB::table('cita')->whereDate('fecha', $ayer)->count();
    // Calcular porcentaje de crecimiento
if ($citasAyer > 0) {
    $porcentajeCitas = (($totalCitasHoy - $citasAyer) / $citasAyer) * 100;
} else {
    $porcentajeCitas = 0;
}

    $totalClientes = Cliente::count();
    $clientesNuevos = \DB::table('cliente')
    ->whereYear('fechaRegistro', $año)
    ->whereMonth('fechaRegistro', $mes)
    ->count();

   // $totalEmpleados = Empleado::where('activo', 1)->count();
    //$totalDescuento = \App\Models\Promocion::sum('valorDescuento');

    // Promociones activas y desactivadas
    $promocionesActivas = Promocion::where('activo', 1)->count();
    $promosDesactivadas = Promocion::where('activo', 0)->count();
    $promocionesAplicadas = Promocion::where('usosActuales', '>', 0)->count();

    return view('admin.dashboardAdmin', compact(
        'totalCitasHoy',
        'totalClientes',
        'promocionesActivas',
        'ingresosTotales',
        'porcentajeCitas',
        'porcentajeIngresos',
        'clientesNuevos',
        'serviciosMasSolicitados',
        'clientesFrecuentes',
        'ultimasCitas'
    ));
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


public function actualizarEstado(Request $request, $id)
{
    $cita = Cita::findOrFail($id);
    $nuevoEstado = $request->estado;

    // Validar estado permitido
    $estadosValidos = ['pendiente', 'confirmada', 'en proceso', 'completada', 'cancelada'];
    if (!in_array($nuevoEstado, $estadosValidos)) {
        return response()->json(['error' => 'Estado inválido'], 400);
    }

    $cita->estado = $nuevoEstado;
    $cita->save();

    return response()->json(['mensaje' => 'Estado actualizado', 'estado' => $nuevoEstado]);
}

public function editarCita($id)
{
    $cita = Cita::with(['cliente', 'servicios', 'estilista'])->findOrFail($id);

    return response()->json([
        'idCita' => $cita->idCita,
        'fecha' => $cita->fecha,
        'hora' => $cita->hora,
        'cliente_id' => $cita->cliente->idCliente,
        'cliente_nombre' => $cita->cliente->nombre,
        'cliente_apellido' => $cita->cliente->apellido,
        'estilista_id' => $cita->estilista->idEstilista,
        'servicio_id' => $cita->servicio->idServicio,
        'notas' => $cita->notas,
        'estado' => $cita->estado
    ]);
}


}
