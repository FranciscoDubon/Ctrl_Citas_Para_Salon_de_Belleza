<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\Empleado;

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

    return view('recepcionista.citasRecepcionista', compact(
        'clientes', 'estilistas', 'servicios', 'citas'
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


}
