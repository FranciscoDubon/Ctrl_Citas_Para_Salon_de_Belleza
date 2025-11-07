<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocion;
use App\Models\Combo;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class PromocionController extends Controller
{
    // Mostrar vista de promociones (Admin)
    public function indexAdmin()
    {
        $promociones = Promocion::orderBy('activo', 'desc')
            ->orderBy('fechaInicio', 'desc')
            ->get();

        $combos = Combo::with('servicios')->orderBy('activo', 'desc')->get();
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();

        // KPIs
        $promocionesActivas = Promocion::where('activo', true)
            ->where('fechaFin', '>=', Carbon::now())
            ->count();

        $combosDisponibles = Combo::where('activo', true)->count();

        // Usos este mes (esto dependerá de tu tabla de citas cuando la implementes)
        $usosEsteMes = 87; // Valor temporal

        // Descuentos otorgados (esto dependerá de tu tabla de citas)
        $descuentosOtorgados = 342; // Valor temporal

        return view('admin.promocionesAdmin', compact(
            'promociones',
            'combos',
            'servicios',
            'promocionesActivas',
            'combosDisponibles',
            'usosEsteMes',
            'descuentosOtorgados'
        ));
    }

    // Mostrar vista de promociones (Recepcionista)
public function indexRecepcionista()
{
    $promociones = Promocion::orderBy('activo', 'desc')
        ->orderBy('fechaInicio', 'desc')
        ->get();

    $combos = Combo::with('servicios')->orderBy('activo', 'desc')->get();
    $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();

    // KPIs
    $promocionesActivas = Promocion::where('activo', true)
        ->where('fechaFin', '>=', Carbon::now())
        ->count();

    $combosDisponibles = Combo::where('activo', true)->count();

    $usosEsteMes = Promocion::where('usosActuales', '>', 0)
        ->whereMonth('updated_at', Carbon::now()->month)
        ->sum('usosActuales');

    $descuentosOtorgados = Promocion::where('tipoDescuento', 'fijo')
        ->where('activo', true)
        ->whereMonth('updated_at', Carbon::now()->month)
        ->sum(\DB::raw('valorDescuento * usosActuales'));
    
    $descuentosOtorgados = round($descuentosOtorgados, 2);

    return view('recepcionista.promocionesRecepcionista', compact(
        'promociones',
        'combos',
        'servicios',
        'promocionesActivas',
        'combosDisponibles',
        'usosEsteMes',
        'descuentosOtorgados'
    ));
}

    // Crear promoción
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'tipoDescuento' => 'required|in:porcentaje,fijo',
            'valorDescuento' => 'required|numeric|min:0',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
            'codigoPromocional' => 'required|string|max:50|unique:promocion,codigoPromocional',
            'usosMaximos' => 'nullable|integer|min:1',
            'usosPorCliente' => 'required|integer|min:1',
            'dias' => 'nullable|array',
            'activo' => 'nullable|boolean'
        ]);

        $validated['codigoPromocional'] = strtoupper($validated['codigoPromocional']);
        $validated['diasAplicables'] = $request->has('dias') ? json_encode($request->dias) : null;
        $validated['activo'] = $request->has('activo') ? 1 : 0;
        $validated['usosActuales'] = 0;

        $promocion = Promocion::create($validated);

        return response()->json(['success' => true, 'promocion' => $promocion]);
    }

    // Mostrar promoción individual
    public function show($id)
    {
        try {
            $promocion = Promocion::findOrFail($id);
            return response()->json($promocion);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Promoción no encontrada'], 404);
        }
    }

    // Actualizar promoción
public function update(Request $request, $id)
{
    try {
        $promocion = Promocion::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'tipoDescuento' => 'required|in:porcentaje,fijo',
            'valorDescuento' => 'required|numeric|min:0',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date|after_or_equal:fechaInicio',
            'codigoPromocional' => 'required|string|max:50|unique:promocion,codigoPromocional,' . $id . ',idPromocion',
            'usosMaximos' => 'nullable|integer|min:1',
            'usosPorCliente' => 'required|integer|min:1',
            'dias' => 'nullable|array',
            'activo' => 'nullable|boolean'
        ]);

        $validated['codigoPromocional'] = strtoupper($validated['codigoPromocional']);
        $validated['diasAplicables'] = $request->has('dias') ? json_encode($request->dias) : null;
        $validated['activo'] = $request->input('activo', 0);

        $promocion->update($validated);

        return response()->json(['success' => true, 'promocion' => $promocion]);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    // Toggle estado promoción
    public function toggleEstado(Request $request, $id)
    {
        try {
            $promocion = Promocion::findOrFail($id);
            $promocion->activo = !$promocion->activo;
            $promocion->save();

            return response()->json([
                'success' => true,
                'nuevo_estado' => $promocion->activo
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo cambiar el estado'], 500);
        }
    }

    // Crear combo
    public function storeCombo(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precioCombo' => 'required|numeric|min:0.01',
            'servicios' => 'required|array|min:2',
            'servicios.*' => 'exists:servicio,idServicio',
            'activo' => 'required|boolean'
        ]);

        // Calcular precio regular
        $servicios = Servicio::whereIn('idServicio', $validated['servicios'])->get();
        $precioRegular = $servicios->sum('precioBase');
        $ahorro = $precioRegular - $validated['precioCombo'];

        $combo = Combo::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'precioCombo' => $validated['precioCombo'],
            'precioRegular' => $precioRegular,
            'ahorro' => $ahorro,
            'activo' => $validated['activo']
        ]);

        // Asociar servicios
        $combo->servicios()->attach($validated['servicios']);

        return response()->json(['success' => true, 'combo' => $combo]);
    }

    // Mostrar combo individual
    public function showCombo($id)
    {
        try {
            $combo = Combo::with('servicios')->findOrFail($id);
            return response()->json($combo);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Combo no encontrado'], 404);
        }
    }

    // Actualizar combo
    public function updateCombo(Request $request, $id)
    {
        try {
            $combo = Combo::findOrFail($id);

            $validated = $request->validate([
                'nombre' => 'required|string|max:100',
                'descripcion' => 'nullable|string',
                'precioCombo' => 'required|numeric|min:0.01',
                'servicios' => 'required|array|min:2',
                'servicios.*' => 'exists:servicio,idServicio',
                'activo' => 'required|boolean'
            ]);

            // Recalcular precio regular
            $servicios = Servicio::whereIn('idServicio', $validated['servicios'])->get();
            $precioRegular = $servicios->sum('precioBase');
            $ahorro = $precioRegular - $validated['precioCombo'];

            $combo->update([
                'nombre' => $validated['nombre'],
                'descripcion' => $validated['descripcion'],
                'precioCombo' => $validated['precioCombo'],
                'precioRegular' => $precioRegular,
                'ahorro' => $ahorro,
                'activo' => $validated['activo']
            ]);

            // Actualizar servicios asociados
            $combo->servicios()->sync($validated['servicios']);

            return response()->json(['success' => true, 'combo' => $combo]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Toggle estado combo
    public function toggleEstadoCombo(Request $request, $id)
    {
        try {
            $combo = Combo::findOrFail($id);
            $combo->activo = !$combo->activo;
            $combo->save();

            return response()->json([
                'success' => true,
                'nuevo_estado' => $combo->activo
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo cambiar el estado'], 500);
        }
    }
}