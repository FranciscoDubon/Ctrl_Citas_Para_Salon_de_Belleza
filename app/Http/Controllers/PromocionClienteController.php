<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promocion;
use App\Models\Combo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PromocionClienteController extends Controller
{
    // ========================================
    // VISTA PRINCIPAL DE PROMOCIONES CLIENTE
    // ========================================
    public function index(Request $request)
    {
        $busqueda = $request->input('buscar');
        $orden = $request->input('orden', 'destacadas');
        $categoria = $request->input('categoria', 'todas');
        
        $hoy = Carbon::now();
        
        // Obtener promociones activas y vigentes
        $promocionesQuery = Promocion::with(['servicios', 'combos'])
            ->where('activo', 1)
            ->whereDate('fechaInicio', '<=', $hoy)
            ->whereDate('fechaFin', '>=', $hoy)
            ->whereColumn('usosActuales', '<', 'usosMaximos');
        
        // Aplicar búsqueda
        if ($busqueda) {
            $promocionesQuery->where(function($query) use ($busqueda) {
                $query->where('nombre', 'like', '%' . $busqueda . '%')
                      ->orWhere('codigoPromocional', 'like', '%' . $busqueda . '%')
                      ->orWhere('descripcion', 'like', '%' . $busqueda . '%');
            });
        }
        
        // Aplicar filtros por categoría
        if ($categoria !== 'todas') {
            switch ($categoria) {
                case 'porcentaje':
                    $promocionesQuery->where('tipoDescuento', 'porcentaje');
                    break;
                case '2x1':
                    $promocionesQuery->where('descripcion', 'like', '%2x1%');
                    break;
                case 'vip':
                    $promocionesQuery->where('nombre', 'like', '%VIP%');
                    break;
            }
        }
        
        // Aplicar ordenamiento
        switch ($orden) {
            case 'descuento':
                $promocionesQuery->orderBy('valorDescuento', 'desc');
                break;
            case 'vigencia':
                $promocionesQuery->orderBy('fechaFin', 'asc');
                break;
            case 'nuevas':
                $promocionesQuery->orderBy('created_at', 'desc');
                break;
            case 'destacadas':
            default:
                $promocionesQuery->orderBy('usosActuales', 'desc');
                break;
        }
        
        $promociones = $promocionesQuery->get();
        
        // Obtener combos activos
        $combos = Combo::with('servicios')
            ->where('activo', 1)
            ->get();
        
        // Clasificar promociones
        $promocionesDestacadas = $promociones->where('usosActuales', '>', 5)->take(3);
        $promocionesTemporada = $promociones->where('nombre', 'like', '%temporada%')
            ->merge($promociones->where('nombre', 'like', '%verano%'))
            ->merge($promociones->where('nombre', 'like', '%navidad%'))
            ->take(3);
        
        // Contadores por categoría
        $contadores = [
            'todas' => $promociones->count() + $combos->count(),
            'porcentaje' => $promociones->where('tipoDescuento', 'porcentaje')->count(),
            'combos' => $combos->count(),
            '2x1' => $promociones->filter(function($p) {
                return stripos($p->descripcion, '2x1') !== false;
            })->count(),
            'vip' => $promociones->filter(function($p) {
                return stripos($p->nombre, 'VIP') !== false;
            })->count(),
        ];
        
        return view('cliente.promocionesCliente', compact(
            'promociones',
            'combos',
            'promocionesDestacadas',
            'promocionesTemporada',
            'contadores',
            'busqueda',
            'orden',
            'categoria'
        ));
    }
    
    // ========================================
    // VALIDAR CÓDIGO PROMOCIONAL (AJAX)
    // ========================================
    public function validarCodigo(Request $request)
    {
        try {
            $codigo = $request->input('codigo');
            
            if (!$codigo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código promocional requerido'
                ], 400);
            }
            
            $promocion = Promocion::where('codigoPromocional', $codigo)
                ->where('activo', 1)
                ->whereDate('fechaInicio', '<=', Carbon::now())
                ->whereDate('fechaFin', '>=', Carbon::now())
                ->first();
            
            if (!$promocion) {
                return response()->json([
                    'success' => false,
                    'message' => 'Código no válido o expirado'
                ], 404);
            }
            
            if (!$promocion->puedeUsarse()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta promoción ha alcanzado su límite de usos'
                ], 400);
            }
            
            return response()->json([
                'success' => true,
                'message' => '¡Código válido!',
                'promocion' => [
                    'nombre' => $promocion->nombre,
                    'descripcion' => $promocion->descripcion,
                    'tipo' => $promocion->tipoDescuento,
                    'valor' => $promocion->valorDescuento,
                    'codigo' => $promocion->codigoPromocional,
                    'fechaFin' => Carbon::parse($promocion->fechaFin)->format('d/m/Y')
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al validar código: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // ========================================
    // OBTENER DETALLE DE COMBO (AJAX)
    // ========================================
public function detalleCombo($id)
{
    try {
        $combo = Combo::with('servicios')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'combo' => [
                'idCombo' => $combo->idCombo,
                'nombre' => $combo->nombre,
                'descripcion' => $combo->descripcion,
                'precioCombo' => $combo->precioCombo,
                'precioRegular' => $combo->precioRegular,
                'ahorro' => $combo->ahorro,
                'servicios' => $combo->servicios->map(function($servicio) {
                    return [
                        'idServicio' => $servicio->idServicio,
                        'nombre' => $servicio->nombre,
                        'duracionBase' => $servicio->duracionBase,
                        'precioBase' => $servicio->precioBase
                    ];
                })
            ]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Combo no encontrado'
        ], 404);
    }
}

    
}