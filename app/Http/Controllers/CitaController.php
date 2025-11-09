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
   /* public function store(Request $request)
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
    }*/

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
        
        // ✅ CALCULAR DURACIÓN TOTAL CON AJUSTES
        $duracionTotal = $servicio->duracionBase;
        $tiempoAdicional = 0;
        
        // Largo de cabello
        if ($request->filled('largo_cabello') && $request->largo_cabello === 'largo') {
            $tiempoAdicional += $servicio->tiempo_adicional_largo ?? 0;
        }
        
        // Tinturado previo
        if ($request->filled('tinturado_previo') && $request->tinturado_previo == 1) {
            $tiempoAdicional += $servicio->tiempo_adicional_tinturado ?? 0;
        }
        
        // Retiro de esmalte
        if ($request->filled('retiro_esmalte') && $request->retiro_esmalte == 1) {
            $tiempoAdicional += $servicio->tiempo_adicional_esmalte ?? 0;
        }
        
        // Con estilizado
        if ($request->filled('con_estilizado') && $request->con_estilizado == 1) {
            $tiempoAdicional += $servicio->tiempo_adicional_estilizado ?? 0;
        }
        
        $duracionTotal += $tiempoAdicional;

        // Crear la cita
        $cita = Cita::create([
            'idCliente' => $request->cliente_id,
            'idEstilista' => $request->estilista_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'PENDIENTE',
            'duracion' => $duracionTotal
        ]);
        
        // ✅ GUARDAR DETALLES ADICIONALES
        DB::table('cita_detalles')->insert([
            'idCita' => $cita->idCita,
            'largo_cabello' => $request->largo_cabello ?? null,
            'tinturado_previo' => $request->tinturado_previo ?? 0,
            'retiro_esmalte' => $request->retiro_esmalte ?? 0,
            'con_estilizado' => $request->con_estilizado ?? 0,
            'tiempo_adicional_total' => $tiempoAdicional
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
                $promocion->increment('usosActuales');
            }
        }
        
        $cita->servicios()->attach($servicio->idServicio);

        DB::commit();

        return response()->json([
            'success' => true, 
            'message' => 'Cita agendada correctamente',
            'duracion_total' => $duracionTotal,
            'tiempo_adicional' => $tiempoAdicional
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false, 
            'message' => 'Error al agendar cita', 
            'error' => $e->getMessage()
        ], 500);
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

    // ✅ TRAER SERVICIOS CON SUS CONFIGURACIONES
    $servicios = Servicio::select(
        'idServicio',
        'nombre',
        'descripcion',
        'precioBase',
        'duracionBase',
        'categoria',
        'requiere_largo_cabello',
        'requiere_tinturado_previo',
        'requiere_retiro_esmalte',
        'requiere_estilizado',
        'tiempo_adicional_largo',
        'tiempo_adicional_tinturado',
        'tiempo_adicional_esmalte',
        'tiempo_adicional_estilizado'
    )
    ->where('activo', 1)
    ->get();

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
/*public function agendaSemana()
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
}*/

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
    $dia = strtolower(now()->locale('es')->dayName); // "viernes"
    $horaActual = now()->format('H:i:s');

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

$promocionesHoy = Promocion::where('activo', 1)
    ->whereDate('fechaInicio', '<=', $hoy)
    ->whereDate('fechaFin', '>=', $hoy)
    ->whereColumn('usosActuales', '<', 'usosMaximos')
    ->limit(5)
    ->get();


    // Últimas citas
    $ultimasCitas = Cita::orderBy('fecha', 'desc')
        ->orderBy('hora', 'desc')
        ->limit(5)
        ->get();

    // Citas del día con relaciones
    $citasDelDia = Cita::with(['cliente', 'estilista', 'servicios', 'promocion'])
    ->whereDate('fecha', $hoy)
    ->orderBy('hora', 'asc')
    ->get();

// ==========================================
// DISPONIBILIDAD DE ESTILISTAS
// ==========================================
$estilistas = Empleado::withCount(['citas as citas_hoy' => function ($query) use ($hoy) {
        $query->whereDate('fecha', $hoy);
    }])
    ->with(['citas' => function ($query) use ($hoy) {
        $query->whereDate('fecha', $hoy)->orderBy('hora', 'desc');
    }])
    ->where('idRol', 1) // 1 = estilistas
    ->where('activo', 1)
    ->get()
    ->map(function ($estilista) use ($horaActual) { // 👈 se agregó "use ($horaActual)"
        $ultimaCita = $estilista->citas->first();

        // Verificar si tiene cita actual (en curso)
        $citaActual = $estilista->citas
            ->where('hora', '<=', $horaActual)
            ->sortByDesc('hora')
            ->first();

        // Estado según si tiene cita en curso
        $estado = $citaActual ? 'Atendiendo cliente' : ($ultimaCita ? 'Ocupado' : 'Disponible');

        return [
            'id' => $estilista->idEmpleado,
            'nombre' => $estilista->nombre . ' ' . $estilista->apellido,
            'citas_hoy' => $estilista->citas_hoy,
            'ultima_cita' => $ultimaCita ? $ultimaCita->hora : null,
            'estado' => $estado,
        ];
    });

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
        'citasDelDia',
        'estilistas',
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


/*public function actualizarEstado(Request $request, $id)
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
}*/

public function editarCita($id)
{

    try {
        $cita = Cita::with(['cliente', 'servicios', 'estilista', 'promocion'])->findOrFail($id);
        
        // Obtener el primer servicio (ya que es relación many-to-many)
        $servicio = $cita->servicios->first();

        return response()->json([
            'idCita' => $cita->idCita,
            'fecha' => $cita->fecha,
            'hora' => $cita->hora,
            'cliente_id' => $cita->idCliente,
            'cliente_nombre' => $cita->cliente->nombre,
            'cliente_apellido' => $cita->cliente->apellido,
            'estilista_id' => $cita->idEstilista,
            'servicio_id' => $servicio ? $servicio->idServicio : null,
            'notas' => $cita->notas,
            'estado' => $cita->estado,
            'codigo_promocional' => $cita->promocion ? $cita->promocion->codigoPromocional : null
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Cita no encontrada: ' . $e->getMessage()], 404);
    }
}

// ACTUALIZAR CITA COMPLETA
public function actualizarCita(Request $request, $id)
{
    try {
        // Normalizar estado
        $estadoNormalizado = strtoupper(trim($request->estado));
        $request->merge(['estado' => $estadoNormalizado]);

        // Validar datos principales
        $request->validate([
            'cliente_id' => 'required|exists:cliente,idCliente',
            'estilista_id' => 'required|exists:empleado,idEmpleado',
            'fecha' => 'required|date',
            'hora' => 'required',
            'servicio_id' => 'required|exists:servicio,idServicio',
            'estado' => 'required|in:PENDIENTE,CONFIRMADA,EN_PROCESO,COMPLETADA,CANCELADA'
        ]);

        DB::beginTransaction();

        // Buscar cita y servicio
        $cita = Cita::findOrFail($id);
        $servicio = Servicio::findOrFail($request->servicio_id);

        // Actualizar datos principales
        $cita->idCliente = $request->cliente_id;
        $cita->idEstilista = $request->estilista_id;
        $cita->fecha = $request->fecha;
        $cita->hora = $request->hora;
        $cita->estado = $estadoNormalizado;
        $cita->duracion = $servicio->duracionBase;
        $cita->save();

        // Sincronizar servicio (cita-servicio)
        $cita->servicios()->sync([$servicio->idServicio]);

        // ===============================
        // VALIDAR CÓDIGO PROMOCIONAL
        // ===============================
        $mensajePromo = null;
        $descuento = 0;
        $precioFinal = $servicio->precioBase;

        if ($request->filled('codigo_promocional')) {
            $codigo = $request->codigo_promocional;

            // Buscar promoción válida y activa
            $promocion = Promocion::where('codigoPromocional', $codigo)
                ->where('activo', true)
                ->whereDate('fechaInicio', '<=', now())
                ->whereDate('fechaFin', '>=', now())
                ->first();

            if ($promocion) {
                // Verificar si aplica al servicio
                $aplica = DB::table('promocionservicio')
                    ->where('idPromocion', $promocion->idPromocion)
                    ->where('idServicio', $servicio->idServicio)
                    ->exists();

                if ($aplica) {
                    // Calcular descuento
                    if ($promocion->tipoDescuento === 'porcentaje') {
                        $descuento = $servicio->precioBase * ($promocion->valorDescuento / 100);
                    } else {
                        $descuento = $promocion->valorDescuento;
                    }
                    $precioFinal = max(0, $servicio->precioBase - $descuento);

                    if($promocion) {
                    $promocion->usosActuales = $promocion->usosActuales + 1;
                    $promocion->save();
                    }

                    $mensajePromo = "Promoción aplicada: {$promocion->nombre} - descuento de {$promocion->valorDescuento}" .
                        ($promocion->tipoDescuento === 'porcentaje' ? '%' : '$');
                } else {
                    $mensajePromo = "El código no aplica a este servicio.";
                }
            } else {
                $mensajePromo = "Código promocional no válido o expirado.";
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Cita actualizada correctamente.',
            'promocion' => $mensajePromo,
            'precios' => [
                'base' => number_format($servicio->precioBase, 2),
                'descuento' => number_format($descuento, 2),
                'final' => number_format($precioFinal, 2)
            ]
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar cita: ' . $e->getMessage()
        ], 500);
    }
}



// ACTUALIZAR SOLO EL ESTADO
public function actualizarEstado(Request $request, $id)
{
    try {
        $cita = Cita::findOrFail($id);
        $nuevoEstado = strtoupper($request->estado);

        // Validar estado permitido
        $estadosValidos = ['PENDIENTE', 'CONFIRMADA', 'EN_PROCESO', 'COMPLETADA', 'CANCELADA'];
        if (!in_array($nuevoEstado, $estadosValidos)) {
            return response()->json(['error' => 'Estado inválido'], 400);
        }

        $cita->estado = $nuevoEstado;
        $cita->save();

        return response()->json([
            'success' => true,
            'mensaje' => 'Estado actualizado correctamente',
            'estado' => $nuevoEstado
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'No se pudo actualizar el estado: ' . $e->getMessage()
        ], 500);
    }
}

// VALIDAR CÓDIGO PROMOCIONAL
public function validarPromocion(Request $request)
{
    try {
        $codigo = $request->codigo_promocional;
        $servicioId = $request->servicio_id;
        
        if (!$codigo) {
            return response()->json([
                'success' => false,
                'message' => 'Código promocional requerido'
            ], 400);
        }
        
        // Buscar promoción válida
        $promocion = Promocion::where('codigoPromocional', $codigo)
            ->where('activo', true)
            ->whereDate('fechaInicio', '<=', now())
            ->whereDate('fechaFin', '>=', now())
            ->first();
        
        if (!$promocion) {
            return response()->json([
                'success' => false,
                'message' => 'Código promocional no válido o expirado'
            ], 404);
        }
        
        // Verificar si puede usarse
        if (!$promocion->puedeUsarse()) {
            return response()->json([
                'success' => false,
                'message' => 'Esta promoción ha alcanzado su límite de usos'
            ], 400);
        }
        
        // Obtener precio del servicio
        $servicio = Servicio::find($servicioId);
        $precioBase = $servicio ? $servicio->precioBase : 0;
        
        // Calcular descuento
        $descuento = 0;
        if ($promocion->tipoDescuento === 'porcentaje') {
            $descuento = $precioBase * ($promocion->valorDescuento / 100);
        } else {
            $descuento = $promocion->valorDescuento;
        }
        
        $precioFinal = max(0, $precioBase - $descuento);
        
        return response()->json([
            'success' => true,
            'message' => 'Código válido',
            'promocion' => [
                'nombre' => $promocion->nombre,
                'tipo' => $promocion->tipoDescuento,
                'valor' => $promocion->valorDescuento,
                'descripcion' => $promocion->descripcion
            ],
            'precios' => [
                'base' => number_format($precioBase, 2),
                'descuento' => number_format($descuento, 2),
                'final' => number_format($precioFinal, 2)
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al validar promoción: ' . $e->getMessage()
        ], 500);
    }
}

}
