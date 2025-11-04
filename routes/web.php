<?php

use Illuminate\Support\Facades\Route;

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

// Ruta Gestión de Citas Admin
Route::get('/admin/citasAdm', function () {
    return view('admin.citasAdmin'); 
})->name('admin.citasAdm');

//Ruta Gestión de Configuracion Cliente
Route::get('/admin/configAdm', function () {
    return view('admin.configAdmin');
})->name('admin.configAdm');

// Ruta Gestión de Dashboard Recepcionista
Route::get('/recepcionista/dashboardRecep', function () {
    return view('recepcionista.dashboardRecepcionista');
})->name('recepcionista.dashboardRecep');

//Ruta Gestión de Servicios Recepcionista
Route::get('/recepcionista/serviciosRecep', function () {
    return view('recepcionista.serviciosRecepcionista');
})->name('recepcionista.serviciosRecep');

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

use App\Http\Controllers\ClienteController;
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




