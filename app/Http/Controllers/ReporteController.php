<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\Empleado;
use App\Models\Promocion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    // ========================================
    // VISTA PRINCIPAL DE REPORTES
    // ========================================
    public function index(Request $request)
    {
        // Obtener parámetros de filtro
        $tipoReporte = $request->input('tipo', 'general');
        $periodo = $request->input('periodo', 'mes');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Calcular fechas según período
        [$fechaInicio, $fechaFin] = $this->calcularFechas($periodo, $fechaInicio, $fechaFin);

        // Obtener KPIs generales
        $kpis = $this->obtenerKPIsGenerales($fechaInicio, $fechaFin);

        // Obtener datos según tipo de reporte
        $historialClientes = $this->obtenerHistorialClientes($fechaInicio, $fechaFin);
        $serviciosMasSolicitados = $this->obtenerServiciosMasSolicitados($fechaInicio, $fechaFin);
        $categorias = $this->obtenerCategoriasServicios($fechaInicio, $fechaFin);
        $rendimientoEstilistas = $this->obtenerRendimientoEstilistas($fechaInicio, $fechaFin);
        $mejorEstilista = $this->obtenerMejorEstilista($fechaInicio, $fechaFin);

        return view('admin.reportesAdmin', compact(
            'kpis',
            'historialClientes',
            'serviciosMasSolicitados',
            'categorias',
            'rendimientoEstilistas',
            'mejorEstilista',
            'tipoReporte',
            'periodo',
            'fechaInicio',
            'fechaFin'
        ));
    }

    // ========================================
    // CALCULAR FECHAS SEGÚN PERÍODO
    // ========================================
    private function calcularFechas($periodo, $fechaInicio = null, $fechaFin = null)
    {
        if ($periodo === 'personalizado' && $fechaInicio && $fechaFin) {
            return [$fechaInicio, $fechaFin];
        }

        $fin = Carbon::now();

        switch ($periodo) {
            case 'hoy':
                $inicio = Carbon::today();
                break;
            case 'semana':
                $inicio = Carbon::now()->startOfWeek();
                break;
            case 'mes':
                $inicio = Carbon::now()->startOfMonth();
                break;
            case 'trimestre':
                $inicio = Carbon::now()->startOfQuarter();
                break;
            case 'anio':
                $inicio = Carbon::now()->startOfYear();
                break;
            default:
                $inicio = Carbon::now()->startOfMonth();
        }

        return [$inicio->toDateString(), $fin->toDateString()];
    }

    // ========================================
    // KPIs GENERALES
    // ========================================
    private function obtenerKPIsGenerales($fechaInicio, $fechaFin)
    {
        $mesAnterior = Carbon::parse($fechaInicio)->subMonth();
        $mesAnteriorFin = Carbon::parse($fechaFin)->subMonth();

        // Citas completadas del período
        $citasCompletadas = Cita::where('estado', 'COMPLETADA')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->count();

        // Citas del período anterior
        $citasCompletadasAnterior = Cita::where('estado', 'COMPLETADA')
            ->whereBetween('fecha', [$mesAnterior, $mesAnteriorFin])
            ->count();

        // Calcular porcentaje de crecimiento de citas
        $porcentajeCitas = $citasCompletadasAnterior > 0 
            ? (($citasCompletadas - $citasCompletadasAnterior) / $citasCompletadasAnterior) * 100 
            : 0;

        // Ingresos totales
        $ingresosTotales = DB::table('cita')
            ->join('citaservicio', 'cita.idCita', '=', 'citaservicio.idCita')
            ->join('servicio', 'citaservicio.idServicio', '=', 'servicio.idServicio')
            ->where('cita.estado', 'COMPLETADA')
            ->whereBetween('cita.fecha', [$fechaInicio, $fechaFin])
            ->sum('servicio.precioBase');

        // Ingresos del período anterior
        $ingresosAnteriores = DB::table('cita')
            ->join('citaservicio', 'cita.idCita', '=', 'citaservicio.idCita')
            ->join('servicio', 'citaservicio.idServicio', '=', 'servicio.idServicio')
            ->where('cita.estado', 'COMPLETADA')
            ->whereBetween('cita.fecha', [$mesAnterior, $mesAnteriorFin])
            ->sum('servicio.precioBase');

        // Calcular porcentaje de crecimiento de ingresos
        $porcentajeIngresos = $ingresosAnteriores > 0 
            ? (($ingresosTotales - $ingresosAnteriores) / $ingresosAnteriores) * 100 
            : 0;

        // Ticket promedio
        $ticketPromedio = $citasCompletadas > 0 ? $ingresosTotales / $citasCompletadas : 0;

        // Ticket promedio anterior
        $ticketPromedioAnterior = $citasCompletadasAnterior > 0 
            ? $ingresosAnteriores / $citasCompletadasAnterior 
            : 0;

        // Porcentaje de crecimiento del ticket promedio
        $porcentajeTicket = $ticketPromedioAnterior > 0 
            ? (($ticketPromedio - $ticketPromedioAnterior) / $ticketPromedioAnterior) * 100 
            : 0;

        // Clientes únicos
        $clientesUnicos = Cita::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->distinct('idCliente')
            ->count('idCliente');

        // Clientes nuevos (primera cita en el período)
        $clientesNuevos = DB::table('cliente')
            ->whereBetween('fechaRegistro', [$fechaInicio, $fechaFin])
            ->count();

        return [
            'citas_completadas' => $citasCompletadas,
            'porcentaje_citas' => round($porcentajeCitas, 1),
            'ingresos_totales' => number_format($ingresosTotales, 2),
            'porcentaje_ingresos' => round($porcentajeIngresos, 1),
            'ticket_promedio' => number_format($ticketPromedio, 2),
            'porcentaje_ticket' => round($porcentajeTicket, 1),
            'clientes_unicos' => $clientesUnicos,
            'clientes_nuevos' => $clientesNuevos
        ];
    }

    // ========================================
    // HISTORIAL DE CLIENTES
    // ========================================
    private function obtenerHistorialClientes($fechaInicio, $fechaFin)
    {
        return DB::table('cliente as c')
            ->join('cita as ci', 'c.idCliente', '=', 'ci.idCliente')
            ->join('citaservicio as cs', 'ci.idCita', '=', 'cs.idCita')
            ->join('servicio as s', 'cs.idServicio', '=', 's.idServicio')
            ->select(
                'c.idCliente',
                'c.nombre',
                'c.apellido',
                'c.correoElectronico',
                'c.telefono',
                DB::raw('COUNT(DISTINCT ci.idCita) as total_citas'),
                DB::raw('SUM(s.precioBase) as total_gastado'),
                DB::raw('AVG(s.precioBase) as ticket_promedio'),
                DB::raw('MIN(ci.fecha) as primera_visita'),
                DB::raw('MAX(ci.fecha) as ultima_visita')
            )
            ->where('ci.estado', 'COMPLETADA')
            ->whereBetween('ci.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('c.idCliente', 'c.nombre', 'c.apellido', 'c.correoElectronico', 'c.telefono')
            ->orderByDesc('total_gastado')
            ->limit(10)
            ->get()
            ->map(function($cliente) {
                $cliente->total_gastado = number_format($cliente->total_gastado, 2);
                $cliente->ticket_promedio = number_format($cliente->ticket_promedio, 2);
                $cliente->primera_visita = Carbon::parse($cliente->primera_visita)->format('d M Y');
                $cliente->ultima_visita = Carbon::parse($cliente->ultima_visita)->format('d M Y');
                
                // Determinar estado del cliente
                if ($cliente->total_citas >= 15) {
                    $cliente->estado = 'VIP';
                    $cliente->badge_class = 'bg-success';
                } elseif ($cliente->total_citas >= 8) {
                    $cliente->estado = 'Frecuente';
                    $cliente->badge_class = 'badge-gold';
                } else {
                    $cliente->estado = 'Nuevo';
                    $cliente->badge_class = 'badge-soft';
                }
                
                return $cliente;
            });
    }

    // ========================================
    // SERVICIOS MÁS SOLICITADOS
    // ========================================
    private function obtenerServiciosMasSolicitados($fechaInicio, $fechaFin)
    {
        $servicios = DB::table('servicio as s')
            ->join('citaservicio as cs', 's.idServicio', '=', 'cs.idServicio')
            ->join('cita as c', 'cs.idCita', '=', 'c.idCita')
            ->select(
                's.idServicio',
                's.nombre',
                's.categoria',
                's.precioBase',
                DB::raw('COUNT(cs.idServicio) as total_solicitudes'),
                DB::raw('SUM(s.precioBase) as ingresos_generados')
            )
            ->where('c.estado', 'COMPLETADA')
            ->whereBetween('c.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('s.idServicio', 's.nombre', 's.categoria', 's.precioBase')
            ->orderByDesc('total_solicitudes')
            ->limit(10)
            ->get();

        // Calcular el máximo para porcentajes
        $maxSolicitudes = $servicios->max('total_solicitudes');

        return $servicios->map(function($servicio, $index) use ($maxSolicitudes) {
            $servicio->ranking = $index + 1;
            $servicio->porcentaje = $maxSolicitudes > 0 
                ? round(($servicio->total_solicitudes / $maxSolicitudes) * 100, 0) 
                : 0;
            $servicio->ingresos_generados = number_format($servicio->ingresos_generados, 2);
            
            // Calcular tendencia (simulada por ahora)
            $servicio->tendencia = rand(5, 30);
            $servicio->tendencia_positiva = rand(0, 1) == 1;
            
            return $servicio;
        });
    }

    // ========================================
    // CATEGORÍAS DE SERVICIOS
    // ========================================
    private function obtenerCategoriasServicios($fechaInicio, $fechaFin)
    {
        $categorias = DB::table('servicio as s')
            ->join('citaservicio as cs', 's.idServicio', '=', 'cs.idServicio')
            ->join('cita as c', 'cs.idCita', '=', 'c.idCita')
            ->select(
                's.categoria',
                DB::raw('COUNT(cs.idServicio) as total_servicios')
            )
            ->where('c.estado', 'COMPLETADA')
            ->whereBetween('c.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('s.categoria')
            ->get();

        $totalGeneral = $categorias->sum('total_servicios');

        return $categorias->map(function($categoria) use ($totalGeneral) {
            $categoria->porcentaje = $totalGeneral > 0 
                ? round(($categoria->total_servicios / $totalGeneral) * 100, 0) 
                : 0;
            
            // Asignar icono según categoría
            $categoria->icono = $this->obtenerIconoCategoria($categoria->categoria);
            
            return $categoria;
        });
    }

    // ========================================
    // RENDIMIENTO DE ESTILISTAS
    // ========================================
    private function obtenerRendimientoEstilistas($fechaInicio, $fechaFin)
    {
        return DB::table('empleado as e')
            ->join('cita as c', 'e.idEmpleado', '=', 'c.idEstilista')
            ->join('citaservicio as cs', 'c.idCita', '=', 'cs.idCita')
            ->join('servicio as s', 'cs.idServicio', '=', 's.idServicio')
            ->select(
                'e.idEmpleado',
                'e.nombre',
                'e.apellido',
                DB::raw('COUNT(DISTINCT c.idCita) as total_citas'),
                DB::raw('COUNT(DISTINCT c.idCliente) as clientes_atendidos'),
                DB::raw('SUM(s.precioBase) as ingresos_generados'),
                DB::raw('AVG(s.precioBase) as ticket_promedio')
            )
            ->where('e.idRol', 1) // Solo estilistas
            ->where('c.estado', 'COMPLETADA')
            ->whereBetween('c.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('e.idEmpleado', 'e.nombre', 'e.apellido')
            ->orderByDesc('ingresos_generados')
            ->get()
            ->map(function($estilista) {
                $estilista->ingresos_generados = number_format($estilista->ingresos_generados, 2);
                $estilista->ticket_promedio = number_format($estilista->ticket_promedio, 2);
                
                // Calcular productividad (simulada)
                $estilista->productividad = min(100, round(($estilista->total_citas / 80) * 100, 0));
                
                // Calificación (simulada)
                $estilista->calificacion = number_format(rand(42, 50) / 10, 1);
                
                return $estilista;
            });
    }

    // ========================================
    // MEJOR ESTILISTA DEL PERÍODO
    // ========================================
    private function obtenerMejorEstilista($fechaInicio, $fechaFin)
    {
        return DB::table('empleado as e')
            ->join('cita as c', 'e.idEmpleado', '=', 'c.idEstilista')
            ->join('citaservicio as cs', 'c.idCita', '=', 'cs.idCita')
            ->join('servicio as s', 'cs.idServicio', '=', 's.idServicio')
            ->select(
                'e.idEmpleado',
                'e.nombre',
                'e.apellido',
                DB::raw('COUNT(DISTINCT c.idCita) as total_citas'),
                DB::raw('SUM(s.precioBase) as ingresos_generados'),
                DB::raw('AVG(s.precioBase) as ticket_promedio')
            )
            ->where('e.idRol', 1)
            ->where('c.estado', 'COMPLETADA')
            ->whereBetween('c.fecha', [$fechaInicio, $fechaFin])
            ->groupBy('e.idEmpleado', 'e.nombre', 'e.apellido')
            ->orderByDesc('ingresos_generados')
            ->first();
    }

    // ========================================
    // DETALLE DE CLIENTE (MODAL)
    // ========================================
public function detalleCliente($id)
{
    try {
        $cliente = Cliente::findOrFail($id);
        
        // Obtener todas las citas del cliente
        $citas = DB::table('cita')
            ->join('citaservicio', 'cita.idCita', '=', 'citaservicio.idCita')
            ->join('servicio', 'citaservicio.idServicio', '=', 'servicio.idServicio')
            ->where('cita.idCliente', $id)
            ->where('cita.estado', 'COMPLETADA')
            ->select(
                DB::raw('COUNT(DISTINCT cita.idCita) as total_citas'),
                DB::raw('SUM(servicio.precioBase) as total_gastado')
            )
            ->first();
        
        $estadisticas = [
            'total_citas' => $citas->total_citas ?? 0,
            'total_gastado' => $citas->total_gastado ?? 0,
            'ticket_promedio' => $citas->total_citas > 0 
                ? ($citas->total_gastado / $citas->total_citas) 
                : 0,
            'satisfaccion' => 4.8 // Simulado por ahora
        ];
        
        // Formatear números
        $estadisticas['total_gastado'] = number_format($estadisticas['total_gastado'], 2);
        $estadisticas['ticket_promedio'] = number_format($estadisticas['ticket_promedio'], 2);
        
        // Obtener últimas 10 citas con todos los datos necesarios
        $ultimasCitas = DB::table('cita')
            ->join('citaservicio', 'cita.idCita', '=', 'citaservicio.idCita')
            ->join('servicio', 'citaservicio.idServicio', '=', 'servicio.idServicio')
            ->leftJoin('empleado', 'cita.idEstilista', '=', 'empleado.idEmpleado')
            ->where('cita.idCliente', $id)
            ->select(
                'cita.idCita',
                'cita.fecha',
                'cita.hora',
                'cita.estado',
                'servicio.nombre as servicio_nombre',
                'servicio.precioBase',
                'empleado.nombre as estilista_nombre',
                'empleado.apellido as estilista_apellido'
            )
            ->orderBy('cita.fecha', 'desc')
            ->orderBy('cita.hora', 'desc')
            ->limit(10)
            ->get()
            ->groupBy('idCita')
            ->map(function($citaGroup) {
                $primera = $citaGroup->first();
                return [
                    'idCita' => $primera->idCita,
                    'fecha' => $primera->fecha,
                    'hora' => $primera->hora,
                    'estado' => $primera->estado,
                    'servicios' => $citaGroup->pluck('servicio_nombre')->implode(', '),
                    'monto' => $citaGroup->sum('precioBase'),
                    'estilista_nombre' => $primera->estilista_nombre,
                    'estilista_apellido' => $primera->estilista_apellido
                ];
            })
            ->values();
        
        return response()->json([
            'success' => true,
            'cliente' => $cliente,
            'estadisticas' => $estadisticas,
            'ultimas_citas' => $ultimasCitas
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al cargar información del cliente: ' . $e->getMessage()
        ], 500);
    }
}
    // ========================================
    // DETALLE DE ESTILISTA (MODAL)
    // ========================================
    public function detalleEstilista($id, Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', Carbon::now()->startOfMonth()->toDateString());
        $fechaFin = $request->input('fecha_fin', Carbon::now()->toDateString());
        
        $estilista = Empleado::findOrFail($id);
        
        $estadisticas = DB::table('cita as c')
            ->join('citaservicio as cs', 'c.idCita', '=', 'cs.idCita')
            ->join('servicio as s', 'cs.idServicio', '=', 's.idServicio')
            ->select(
                DB::raw('COUNT(DISTINCT c.idCita) as total_citas'),
                DB::raw('COUNT(DISTINCT c.idCliente) as clientes_atendidos'),
                DB::raw('SUM(s.precioBase) as ingresos_generados')
            )
            ->where('c.idEstilista', $id)
            ->where('c.estado', 'COMPLETADA')
            ->whereBetween('c.fecha', [$fechaInicio, $fechaFin])
            ->first();
        
        return response()->json([
            'estilista' => $estilista,
            'estadisticas' => $estadisticas
        ]);
    }

    // ========================================
    // EXPORTAR A PDF
    // ========================================
// EXPORTAR A PDF
public function exportarPDF(Request $request)
{
    try {
        $tipoReporte = $request->input('tipo', 'general');
        $periodo = $request->input('periodo', 'mes');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Calcular fechas según período
        [$fechaInicio, $fechaFin] = $this->calcularFechas($periodo, $fechaInicio, $fechaFin);

        // Obtener KPIs generales (siempre se incluyen)
        $kpis = $this->obtenerKPIsGenerales($fechaInicio, $fechaFin);

        // Variables para cada tipo de reporte
        $data = [
            'tipoReporte' => $tipoReporte,
            'periodo' => $periodo,
            'fechaInicio' => Carbon::parse($fechaInicio)->format('d/m/Y'),
            'fechaFin' => Carbon::parse($fechaFin)->format('d/m/Y'),
            'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
            'kpis' => $kpis
        ];

        // Cargar datos específicos según el tipo de reporte
        switch ($tipoReporte) {
            case 'clientes':
                $data['historialClientes'] = $this->obtenerHistorialClientes($fechaInicio, $fechaFin);
                $vista = 'pdf.reporte-clientes';
                $nombreArchivo = 'Reporte_Clientes_' . date('Y-m-d') . '.pdf';
                break;

            case 'servicios':
                $data['serviciosMasSolicitados'] = $this->obtenerServiciosMasSolicitados($fechaInicio, $fechaFin);
                $data['categorias'] = $this->obtenerCategoriasServicios($fechaInicio, $fechaFin);
                $vista = 'pdf.reporte-servicios';
                $nombreArchivo = 'Reporte_Servicios_' . date('Y-m-d') . '.pdf';
                break;

            case 'estilistas':
                $data['rendimientoEstilistas'] = $this->obtenerRendimientoEstilistas($fechaInicio, $fechaFin);
                $data['mejorEstilista'] = $this->obtenerMejorEstilista($fechaInicio, $fechaFin);
                $vista = 'pdf.reporte-estilistas';
                $nombreArchivo = 'Reporte_Estilistas_' . date('Y-m-d') . '.pdf';
                break;

            case 'financiero':
                $data['serviciosMasSolicitados'] = $this->obtenerServiciosMasSolicitados($fechaInicio, $fechaFin);
                $data['categorias'] = $this->obtenerCategoriasServicios($fechaInicio, $fechaFin);
                $vista = 'pdf.reporte-financiero';
                $nombreArchivo = 'Reporte_Financiero_' . date('Y-m-d') . '.pdf';
                break;

            case 'general':
            default:
                $data['historialClientes'] = $this->obtenerHistorialClientes($fechaInicio, $fechaFin)->take(5);
                $data['serviciosMasSolicitados'] = $this->obtenerServiciosMasSolicitados($fechaInicio, $fechaFin)->take(5);
                $data['rendimientoEstilistas'] = $this->obtenerRendimientoEstilistas($fechaInicio, $fechaFin)->take(5);
                $vista = 'pdf.reporte-general';
                $nombreArchivo = 'Reporte_General_' . date('Y-m-d') . '.pdf';
                break;
        }

        // Generar PDF
        $pdf = Pdf::loadView($vista, $data)
            ->setPaper('letter', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        // Descargar PDF
        return $pdf->download($nombreArchivo);

    } catch (\Exception $e) {
        // Si hay error, redirigir con mensaje
        return redirect()->back()->with('error', 'Error al generar PDF: ' . $e->getMessage());
    }
}

    // ========================================
    // EXPORTAR A EXCEL
    // ========================================
    public function exportarExcel(Request $request)
    {
        // TODO: Implementar exportación a Excel con Maatwebsite/Excel
        return response()->json([
            'success' => true,
            'message' => 'Funcionalidad de Excel en desarrollo'
        ]);
    }

    // ========================================
    // HELPER: OBTENER ICONO POR CATEGORÍA
    // ========================================
    private function obtenerIconoCategoria($categoria)
    {
        $iconos = [
            'cabello' => 'bi-scissors',
            'unas' => 'bi-hand-index',
            'facial' => 'bi-emoji-smile',
            'corporal' => 'bi-person',
            'depilacion' => 'bi-droplet',
            'maquillaje' => 'bi-palette'
        ];
        
        return $iconos[strtolower($categoria)] ?? 'bi-star';
    }
}