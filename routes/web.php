<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\PromocionController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PromocionClienteController;

// Ruta Dashboard Admin
Route::get('/', function () {
    return view('login');
})->name('logn');

// Ruta Gestión de Usuarios Admin
Route::get('/admin/usuariosAdm', function () {
    return view('admin.usuariosAdmin');
})->name('admin.usuariosAdm');

// Ruta Gestión de Servicios Admin
Route::get('/admin/serviciosAdm', function () {
    return view('admin.serviciosAdmin'); 
})->name('admin.serviciosAdm');

// Ruta Gestión de Promociones Admin
Route::get('/admin/promocionesAdm', function () {
    return view('admin.promocionesAdmin'); 
})->name('admin.promocionesAdm');

// Ruta Gestión de Reportes Admin
Route::get('/admin/reportesAdm', function () {
    return view('admin.reportesAdmin'); 
})->name('admin.reportesAdm');


// Ruta Gestión de Dashboard Recepcionista
Route::get('/recepcionista/dashboardRecep', function () {
     return view('recepcionista.dashboardRecepcionista');
})->name('recepcionista.dashboardRecep');

//Ruta Gestión de Servicios Recepcionista
/*Route::get('/recepcionista/serviciosRecep', function () {
    return view('recepcionista.serviciosRecepcionista');
})->name('recepcionista.serviciosRecep');*/

//Ruta Gestión de Citas Recepcionista
Route::get('/recepcionista/citasRecep', function () {
    return view('recepcionista.citasRecepcionista');
})->name('recepcionista.citasRecep');

//Ruta Gestión de Citas Recepcionista
Route::get('/recepcionista/clientesRecep', function () {
    return view('recepcionista.clientesRecepcionista');
})->name('recepcionista.clientesRecep');

//Ruta Gestión de Citas Recepcionista
Route::get('/recepcionista/promocionesRecep', function () {
    return view('recepcionista.promocionesRecepcionista');
})->name('recepcionista.promocionesRecep');

//Ruta Gestión de Configuracion Estilista
Route::get('/recepcionista/configRecep', function () {
    return view('recepcionista.configRecepcionista');
})->name('recepcionista.configRecep');

//Ruta Gestión de Dashboard Estilista
Route::get('/estilista/dashboardEsti', function () {
    return view('estilista.dashboardEstilista');
})->name('estilista.dashboardEsti');

//Ruta Gestión de Citas Estilista
Route::get('/estilista/citasEsti', function () {
    return view('estilista.citasEstilista');
})->name('estilista.citasEsti');

//Ruta Gestión de Configuracion Estilista
Route::get('/estilista/configEsti', function () {
    return view('estilista.configEstilista');
})->name('estilista.configEsti');

//Ruta Gestión de Dashboard Cliente
Route::get('/cliente/dashboardCli', function () {
    return view('cliente.dashboardCliente');
})->name('cliente.dashboardCli');

//Ruta Gestión de servicios Cliente
Route::get('/cliente/serviciosCli', function () {
    return view('cliente.serviciosCliente');
})->name('cliente.serviciosCli');

//Ruta Gestión de citas Cliente
Route::get('/cliente/citasCli', function () {
    return view('cliente.citasCliente');
})->name('cliente.citasCli');

//Ruta Gestión de Promociones Cliente
Route::get('/cliente/promocionesCli', function () {
    return view('cliente.promocionesCliente');
})->name('cliente.promocionesCli');

//Ruta Gestión de Configuracion Cliente
Route::get('/cliente/configCli', function () {
    return view('cliente.configCliente');
})->name('cliente.configCli');

//Ruta Gestión de Login
Route::get('login', function () {
    return view('login');
})->name('logn');


// Ruta POST para registrar cliente
Route::post('/registro', [ClienteController::class, 'registrar'])->name('registro');
Route::post('/login', [ClienteController::class, 'login'])->name('login.post');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboardAdmin');
})->name('dashboardAdm');

Route::get('/cliente/dashboard', function () {
    return view('cliente.dashboardCliente');
})->name('dashboardCliente');

use App\Http\Controllers\EmpleadoController;
Route::post('/admin/usuariosAdm', [EmpleadoController::class, 'store'])->name('empleado.store');

/*
Route::get('/admin/usuariosAdm', function () {$roles = \App\Models\Rol::all();return view('admin.usuariosAdmin', compact('roles'));})->name('admin.usuariosAdm');
*/

Route::get('/admin/usuariosAdm', [EmpleadoController::class, 'index'])->name('admin.usuariosAdm');
Route::put('/admin/usuariosAdm/{id}', [EmpleadoController::class, 'update'])->name('empleado.update');
Route::post('/admin/usuariosAdm/{id}/estado', [EmpleadoController::class, 'cambiarEstado'])->name('empleado.estado');


Route::get('/recepcionista/dashboard', function () {
    return redirect()->route('recepcionista.dashboardRecep');
});


// Rutas de Admin
Route::prefix('admin')->name('admin.')->group(function () {
    // ... otras rutas de admin ...
    
    // Vista de promociones admin
    Route::get('/promocionesAdm', [PromocionController::class, 'indexAdmin'])->name('promocionesAdm');
    
    // CRUD Promociones
    Route::post('/promociones', [PromocionController::class, 'store'])->name('promocion.store');
    Route::get('/promociones/{id}', [PromocionController::class, 'show'])->name('promocion.show');
    Route::put('/promociones/{id}', [PromocionController::class, 'update'])->name('promocion.update');
    Route::post('/promociones/{id}/estado', [PromocionController::class, 'toggleEstado'])->name('promocion.toggleEstado');
    
    // CRUD Combos
    Route::post('/combos', [PromocionController::class, 'storeCombo'])->name('combo.store');
    Route::get('/combos/{id}', [PromocionController::class, 'showCombo'])->name('combo.show');
    Route::put('/combos/{id}', [PromocionController::class, 'updateCombo'])->name('combo.update');
    Route::post('/combos/{id}/estado', [PromocionController::class, 'toggleEstadoCombo'])->name('combo.toggleEstado');
});

// Rutas de Recepcionista
Route::prefix('recepcionista')->name('recepcionista.')->group(function () {
    // ... otras rutas de recepcionista ...
    Route::get('/serviciosRecep', [ServicioController::class, 'indexRecep'])->name('serviciosRecep');
        // ✅ RUTAS DE CITAS (AGREGAR ESTAS)
    Route::get('/citas/{id}/editar', [CitaController::class, 'editarCita'])->name('citas.editar');
    Route::put('/citas/{id}/actualizar', [CitaController::class, 'actualizarCita'])->name('citas.actualizar');
    Route::put('/citas/{id}/estado', [CitaController::class, 'actualizarEstado'])->name('citas.estado');

    Route::post('/promocion/validar', [CitaController::class, 'validarPromocion'])->name('promocion.validar');
    // Vista de dashboard recepcionista
    Route::get('/dashboardRecep', [CitaController::class, 'dashboardRecepcionista'])->name('dashboardRecep');

    // Vista de promociones recepcionista
    Route::get('/promocionesRecep', [PromocionController::class, 'indexRecepcionista'])->name('promocionesRecep');
});

Route::post('/recepcionista/servicios', [ServicioController::class, 'store'])->name('servicios.store');
//Route::get('/recepcionista/serviciosRecep', [ServicioController::class, 'index'])->name('recepcionista.serviciosRecep');
Route::put('/servicios/{id}/actualizar', [ServicioController::class, 'update'])->name('servicios.update');
Route::get('/servicios/{id}', [ServicioController::class, 'show'])->name('servicios.show');
Route::put('/servicios/{id}/toggle-estado', [ServicioController::class, 'toggleEstado'])->name('servicios.toggleEstado');

//clientes 
Route::get('/cliente/clientes/dashboard', [ClienteController::class, 'index'])->name('clientes.dashboard');
Route::get('/recepcionista/clientesRecep', [ClienteController::class, 'dashboardRecepcionista'])->name('recepcionista.clientesRecep');
Route::get('/recepcionista/clientes/{id}/editar', [ClienteController::class, 'editarCliente']);

//citas

Route::post('/citas/crear', [CitaController::class, 'store'])->name('citas.store');


Route::get('/recepcionista/citasRecep', [CitaController::class, 'crear'])->name('recepcionista.citasRecep');
Route::post('/citas/crear', [CitaController::class, 'store'])->name('citas.store');
Route::get('/recepcionista/citasRecep', [CitaController::class, 'agendaSemana'])->name('recepcionista.citasRecep');
Route::get('/filtrar-citas', [CitaController::class, 'filtrarTabla'])->name('recepcionista.citasRecep');
Route::get('/recepcionista/citas/{id}/editar', [CitaController::class, 'editarCita']);


// Ruta Gestión de Servicios Admin
Route::get('/admin/serviciosAdm', [ServicioController::class, 'indexAdmin'])->name('admin.serviciosAdm');

Route::prefix('admin')->name('admin.')->group(function () {
    // ... tus otras rutas existentes ...
    Route::get('/dashboard', [CitaController::class, 'dashboardAdmin'])->name('dashboardAdm');

    // Gestión de Promociones
    Route::get('/promocionesAdm', [PromocionController::class, 'indexAdmin'])->name('promocionesAdm');

    // CRUD Promociones
    Route::post('/promociones', [PromocionController::class, 'store'])->name('promocion.store');
    Route::get('/promociones/{id}', [PromocionController::class, 'show'])->name('promocion.show');
    Route::put('/promociones/{id}', [PromocionController::class, 'update'])->name('promocion.update');
    Route::post('/promociones/{id}/estado', [PromocionController::class, 'toggleEstado'])->name('promocion.toggleEstado');

    // CRUD Combos
    Route::post('/combos', [PromocionController::class, 'storeCombo'])->name('combo.store');
    Route::get('/combos/{id}', [PromocionController::class, 'showCombo'])->name('combo.show');
    Route::put('/combos/{id}', [PromocionController::class, 'updateCombo'])->name('combo.update');
    Route::post('/combos/{id}/estado', [PromocionController::class, 'toggleEstadoCombo'])->name('combo.toggleEstado');

    Route::get('/reportesAdm', [ReporteController::class, 'index'])->name('reportesAdm');
    Route::get('/reportes/cliente/{id}', [ReporteController::class, 'detalleCliente'])->name('reportes.cliente');
    Route::get('/reportes/estilista/{id}', [ReporteController::class, 'detalleEstilista'])->name('reportes.estilista');
    Route::get('/reportes/exportar-pdf', [ReporteController::class, 'exportarPDF'])->name('reportes.pdf');
    Route::post('/reportes/exportar-excel', [ReporteController::class, 'exportarExcel'])->name('reportes.excel');
});  
// ========================================
// RUTAS DE ESTILISTA
// ========================================
Route::prefix('estilista')->name('estilista.')->group(function () {
    // Dashboard redirige a citas
    Route::get('/dashboardEsti', function () {
        return redirect()->route('estilista.citasEsti');
    })->name('dashboardEsti');
    
    // Gestión de Citas (VISTA PRINCIPAL)
    Route::get('/citasEsti', [CitaController::class, 'indexEstilista'])->name('citasEsti');
    Route::get('/citas/{id}/detalle', [CitaController::class, 'showCitaEstilista'])->name('cita.detalle');
    Route::post('/citas/{id}/iniciar', [CitaController::class, 'iniciarCita'])->name('cita.iniciar');
    Route::post('/citas/{id}/finalizar', [CitaController::class, 'finalizarCita'])->name('cita.finalizar');
    Route::post('/citas/{id}/confirmar', [CitaController::class, 'confirmarAsistencia'])->name('cita.confirmar');
    Route::get('/citas/filtrar', [CitaController::class, 'filtrarPorEstado'])->name('citas.filtrar');
});
Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::post('/promociones/validar-codigo', [PromocionClienteController::class, 'validarCodigo'])->name('promociones.validar');
    Route::get('/promociones/combo/{id}', [PromocionClienteController::class, 'detalleCombo'])->name('promociones.combo');
});

Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/promocionesCli', [PromocionClienteController::class, 'index'])->name('promocionesCli');
});