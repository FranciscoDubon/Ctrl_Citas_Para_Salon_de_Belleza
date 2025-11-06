<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class ServicioController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Datos recibidos:', $request->all());

        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:servicio,nombre',
            'descripcion' => 'nullable|string|max:500',
            'precioBase' => 'required|numeric|min:0.01',
            'duracionBase' => 'required|integer|min:5',
            'categoria' => 'required|string|max:50',
            'ajustes_especiales' => 'nullable|string|max:500',
            'permite_promociones' => 'nullable|boolean',
            'activo' => 'required|boolean',
        ]);

        $validated['permite_promociones'] = $request->has('permite_promociones');
        $servicio = new Servicio();
        $servicio->fill($validated);
        $servicio->save();
    return response()->json(['success' => true]);

    }
     public function index()
{
    $servicios = Servicio::orderBy('nombre')->get();

    $totalActivos = Servicio::where('activo', true)->count();
    $precioPromedio = Servicio::where('activo', true)->avg('precioBase');
    $totalCategorias = Servicio::distinct('categoria')->count('categoria');

    return view('recepcionista.serviciosRecepcionista', compact(
        'servicios',
        'totalActivos',
        'precioPromedio',
        'totalCategorias'
    ));
}

public function show($id)
{
    try {
        $servicio = Servicio::findOrFail($id);
        return response()->json($servicio);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Servicio no encontrado'], 404);
    }
}   

public function update(Request $request, $id)
{
    try {
        $servicio = Servicio::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:servicio,nombre,' . $id . ',idServicio',
            'descripcion' => 'nullable|string|max:500',
            'precioBase' => 'required|numeric|min:0.01',
            'duracionBase' => 'required|integer|min:5',
            'categoria' => 'required|string|max:50',
            'ajustes_especiales' => 'nullable|string|max:500',
            'permite_promociones' => 'nullable|boolean',
            'activo' => 'required|boolean',
        ]);

        $validated['permite_promociones'] = $request->has('permite_promociones');

        $servicio->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
            'precioBase' => $validated['precioBase'],
            'duracionBase' => $validated['duracionBase'],
            'categoria' => $validated['categoria'],
            'ajustes_especiales' => $validated['ajustes_especiales'],
            'permite_promociones' => $validated['permite_promociones'],
            'activo' => $validated['activo'],
        ]);

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function toggleEstado($id)
{
    try {
        $servicio = Servicio::findOrFail($id);
        $servicio->activo = !$servicio->activo;
        $servicio->save();

        return response()->json([
            'success' => true,
            'nuevo_estado' => $servicio->activo
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'No se pudo cambiar el estado'], 500);
    }
}

}


