<!DOCTYPE html>
<html lang="es">
    @php
$promoSeleccionada = request()->query('promo', '');
@endphp


<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas Cliente | Salón de Belleza</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('css/global-styles.css') }}">
</head>

<body>

    <!-- ============================================
         SIDEBAR (MENÚ LATERAL)
         ============================================ -->
    <div class="sidebar">
        <!-- Logo del Sistema -->
        <div class="sidebar-logo">
            <h3><i class="bi bi-scissors"></i> BeautySalon</h3>
            <p>Tu Salón de Belleza</p>
        </div>

        <!-- Menú de Navegación -->
        <nav class="sidebar-menu">
            
            <a href="{{ route('cliente.citasCli') }}" class="menu-item active">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('cliente.serviciosCli') }}" class="menu-item">
                <i class="bi bi-scissors"></i> Servicios
            </a>
            <a href="{{ route('cliente.promocionesCli') }}" class="menu-item">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('cliente.configCli') }}" class="menu-item">
                <i class="bi bi-gear"></i> Configuración
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Gestión de Citas</h1>
            <p>Consulta y administra tus citas programadas.</p>
        </div>

        <div class="header-actions">
            <!-- Usuario -->
            <div class="user-info">
               <div class="user-avatar" id="avatarInicial">A</div>
            <span class="user-name" id="nombreCliente">Administrador</span>
            </div>
        </div>
    </header>


    <!-- ============================================
         MAIN CONTENT (CONTENIDO PRINCIPAL)
         ============================================ -->
    <main class="main-content">

 <!-- Mensaje de Bienvenida Personalizado -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2>
                            <h2>
                                <i class="bi bi-heart-fill" style="color: var(--dorado-palido);"></i> 
                                ¡Hola {{ $cliente->nombre }}! Bienvenido de nuevo 💖
                            </h2>
                                <p>
                                    Es un placer tenerte con nosotros. Hoy es <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d \d\e F Y') }}</strong>
                                </p>
                                <p>
                                    Tienes un total de <strong style="color: var(--dorado-palido);">{{ $visitas }} visitas</strong> · 
                                    Tu última cita fue el <strong>{{ $ultimaCita ? \Carbon\Carbon::parse($ultimaCita->fecha)->translatedFormat('d \d\e F') : 'Sin historial' }}</strong>
                                </p>
                        <small>
                            <i class="bi bi-clock-history"></i> Tu próxima cita: 
                            <strong>{{ $proximaCita ? \Carbon\Carbon::parse($proximaCita->fecha)->translatedFormat('d \d\e F') : 'No programada' }}</strong>
                        </small>


                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-gold btn-lg mb-2" onclick="agendarCita()">
                                <i class="bi bi-calendar-plus"></i> Agendar Nueva Cita
                            </button>
                            <br>
                            <small style="color: var(--borgona); opacity: 0.7;">
                                <i class="bi bi-clock-history"></i> Tu próxima cita: <strong>No programada</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Sección: Mis Citas Actuales -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title-custom" style="margin: 0;">
                            <i class="bi bi-calendar-check"></i>
                            Mis Citas Actuales
                        </h5>
                        <button class="btn btn-soft btn-sm" onclick="toggleMisCitas()">
                            <i class="bi bi-chevron-down" id="iconToggleCitas"></i>
                        </button>
                    </div>

                    <div id="seccionMisCitas">
                        <!-- Filtros rápidos por estado -->
                        <div class="d-flex gap-2 flex-wrap mb-4">
                            <button class="btn btn-sm btn-gold" onclick="filtrarCitasPorEstado('todas')">
                                <i class="bi bi-list"></i> Todas (3)
                            </button>
                            <button class="btn btn-sm btn-outline-gold" onclick="filtrarCitasPorEstado('pendiente')">
                                <i class="bi bi-clock-history"></i> Pendientes (1)
                            </button>
                            <button class="btn btn-sm btn-outline-gold" onclick="filtrarCitasPorEstado('confirmada')">
                                <i class="bi bi-check-circle"></i> Confirmadas (1)
                            </button>
                            <button class="btn btn-sm btn-outline-gold" onclick="filtrarCitasPorEstado('completada')">
                                <i class="bi bi-calendar-check"></i> Completadas (1)
                            </button>
                        </div>

                        <!-- Lista de Citas -->
                        <div class="row g-4" id="listaMisCitas">

                            <!-- Cita Pendiente de Confirmación -->
                            <div class="col-lg-6">
                                <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: rgba(255, 193, 7, 0.08); border-left: 4px solid #ffc107;">
                                    <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0; font-weight: 700;">Limpieza Facial Profunda</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-calendar3"></i> Lun, 04 Nov 2024 - 10:00 AM
                                            </small>
                                        </div>
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-clock-history"></i> Pendiente
                                        </span>
                                    </div>

                                    <div class="w-100 mb-3">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-person-circle"></i> Estilista
                                                </small>
                                                <br>
                                                <strong style="color: var(--borgona);">Laura Gómez</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7;">Duración</small>
                                                <br>
                                                <strong style="color: var(--borgona);">60 min</strong>
                                            </div>
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7;">Precio</small>
                                                <br>
                                                <strong style="color: var(--dorado-palido); font-size: 1.1rem;">$31.50</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7;">Código</small>
                                                <br>
                                                <code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">BR-2024-00245</code>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert-custom w-100 mb-3" style="background: rgba(255, 193, 7, 0.1); border-left-color: #ffc107;">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        <small><strong>Acción requerida:</strong> Por favor confirma tu asistencia llamando al salón o usando el botón de abajo.</small>
                                    </div>

                                    <div class="d-flex gap-2 w-100">
                                        <button class="btn btn-gold btn-sm flex-fill" onclick="confirmarAsistenciaCita(1)">
                                            <i class="bi bi-check-circle"></i> Confirmar Asistencia
                                        </button>
                                        <button class="btn btn-outline-gold btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalleCita" onclick="verDetalleCita(1)">
                                            <i class="bi bi-eye"></i> Ver Detalles
                                        </button>
                                        <button class="btn btn-soft btn-sm" onclick="mostrarOpcionesCita(1)">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Cita Confirmada (Próxima) -->
                            <div class="col-lg-6">
                                <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: rgba(212, 175, 55, 0.08); border-left: 4px solid var(--dorado-palido);">
                                    <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0; font-weight: 700;">Corte de Cabello</h6>
                                            <small style="color: var(--dorado-palido); font-weight: 600;">
                                                <i class="bi bi-calendar-event"></i> Vie, 08 Nov 2024 - 03:00 PM
                                            </small>
                                        </div>
                                        <span class="badge bg-info">
                                            <i class="bi bi-calendar-check"></i> Confirmada
                                        </span>
                                    </div>

                                    <div class="w-100 mb-3">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-person-circle"></i> Estilista
                                                </small>
                                                <br>
                                                <strong style="color: var(--borgona);">Ana López</strong>
                                                <br>
                                                <small style="color: var(--dorado-palido);">
                                                    <i class="bi bi-star-fill"></i> Tu estilista preferida
                                                </small>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7;">Duración</small>
                                                <br>
                                                <strong style="color: var(--borgona);">30 min</strong>
                                            </div>
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7;">Precio</small>
                                                <br>
                                                <strong style="color: var(--dorado-palido); font-size: 1.1rem;">$13.50</strong>
                                                <br>
                                                <small style="color: var(--borgona); opacity: 0.6;">
                                                    <i class="bi bi-gift"></i> Descuento VIP aplicado
                                                </small>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7;">Código</small>
                                                <br>
                                                <code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">BR-2024-00278</code>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert-custom w-100 mb-3" style="background: rgba(212, 175, 55, 0.1); border-left-color: var(--dorado-palido);">
                                        <i class="bi bi-info-circle"></i>
                                        <small>Tu cita está confirmada. Te esperamos el viernes a las 3:00 PM. Recuerda llegar 5 minutos antes.</small>
                                    </div>

                                    <div class="d-flex gap-2 w-100">
                                        <button class="btn btn-outline-gold btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalDetalleCita" onclick="verDetalleCita(2)">
                                            <i class="bi bi-eye"></i> Ver Detalles
                                        </button>
                                        <button class="btn btn-soft btn-sm" onclick="agregarCalendario(2)">
                                            <i class="bi bi-calendar-plus"></i>
                                        </button>
                                        <button class="btn btn-soft btn-sm" onclick="mostrarOpcionesCita(2)">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Cita Completada (Histórica) -->
                            <div class="col-lg-6">
                                <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; opacity: 0.8;">
                                    <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0; font-weight: 700;">Manicure + Pedicure</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-calendar3"></i> Mié, 30 Oct 2024 - 11:00 AM
                                            </small>
                                        </div>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle"></i> Completada
                                        </span>
                                    </div>

                                    <div class="w-100 mb-3">
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-person-circle"></i> Estilista
                                                </small>
                                                <br>
                                                <strong style="color: var(--borgona);">Sofía Ramírez</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7;">Duración</small>
                                                <br>
                                                <strong style="color: var(--borgona);">75 min</strong>
                                            </div>
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7;">Total Pagado</small>
                                                <br>
                                                <strong style="color: var(--dorado-palido); font-size: 1.1rem;">$22.50</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7;">Código</small>
                                                <br>
                                                <code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem;">BR-2024-00189</code>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; width: 100%; margin-bottom: 1rem;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <small style="color: var(--borgona); opacity: 0.7;">Tu calificación:</small>
                                                <br>
                                                <span style="color: var(--dorado-palido); font-size: 1.1rem;">
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                    <i class="bi bi-star-fill"></i>
                                                </span>
                                            </div>
                                            <small style="color: var(--borgona); opacity: 0.7;">Hace 2 días</small>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 w-100">
                                        <button class="btn btn-gold btn-sm flex-fill" onclick="reservarOtraVez(3)">
                                            <i class="bi bi-arrow-repeat"></i> Reservar de Nuevo
                                        </button>
                                        <button class="btn btn-outline-gold btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalleCita" onclick="verDetalleCita(3)">
                                            <i class="bi bi-eye"></i> Ver Detalles
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Mensaje si no hay citas -->
                        <div id="mensajeNoCitas" style="display: none; text-align: center; padding: 3rem;">
                            <div style="font-size: 4rem; color: var(--rosa-empolvado); margin-bottom: 1rem;">
                                <i class="bi bi-calendar-x"></i>
                            </div>
                            <h5 style="color: var(--borgona);">No tienes citas programadas</h5>
                            <p style="color: var(--borgona); opacity: 0.7;">¡Es un buen momento para agendar tu próxima cita de belleza!</p>
                            <button class="btn btn-gold" onclick="scrollToReservar()">
                                <i class="bi bi-calendar-plus"></i> Agendar Nueva Cita
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Divisor Visual -->
        <div class="row mb-4">
            <div class="col-12">
                <div style="border-top: 2px solid var(--rosa-empolvado); margin: 2rem 0; position: relative;">
                    <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: var(--blanco-humo); padding: 0 1rem;">
                        <span style="color: var(--borgona); font-weight: 600; font-size: 1.1rem;">
                            <i class="bi bi-arrow-down-circle"></i> Agendar Nueva Cita
                        </span>
                    </div>
                </div>
            </div>
        </div>

<!-- Stepper de Progreso -->
<div class="row mb-4" id="seccionReservar">
    <div class="col-12">
        <div class="card-custom" style="padding: 2rem;">
            <div class="row">
                <div class="col-md-4 text-center" id="step1">
                    <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: var(--borgona); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-scissors" style="color: white; font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="color: var(--borgona); font-weight: 700;">1. Servicios</h6>
                    <p style="margin: 0; font-size: 0.85rem; opacity: 0.7;">Selecciona los servicios</p>
                </div>
                <div class="col-md-4 text-center" id="step2" style="opacity: 0.4;">
                    <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: var(--rosa-empolvado); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-calendar3" style="color: var(--borgona); font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="color: var(--borgona); font-weight: 700;">2. Fecha, Hora y Estilista</h6>
                    <p style="margin: 0; font-size: 0.85rem; opacity: 0.7;">Elige tu horario</p>
                </div>
                <div class="col-md-4 text-center" id="step3" style="opacity: 0.4;">
                    <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: var(--rosa-empolvado); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-check-circle" style="color: var(--borgona); font-size: 1.5rem;"></i>
                    </div>
                    <h6 style="color: var(--borgona); font-weight: 700;">3. Confirmación</h6>
                    <p style="margin: 0; font-size: 0.85rem; opacity: 0.7;">Revisa y confirma</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PASO 1: SELECCIÓN DE SERVICIO -->
<div class="row g-4 mb-4" id="pasoServicio">
    <div class="col-12">
        <div class="card-custom">
            <h5 class="card-title-custom">
                <i class="bi bi-scissors"></i>
                Paso 1: Selecciona el Servicio
            </h5>

            <!-- Búsqueda Rápida -->
            <div class="mb-4">
                <input
                    type="text"
                    class="form-control"
                    id="buscarServicioReserva"
                    placeholder="🔍 Buscar servicio..."
                    onkeyup="filtrarServicios()">
            </div>

            <!-- Filtros por Categoría -->
            <div class="d-flex gap-2 flex-wrap mb-4">
                <button class="btn btn-sm btn-gold" onclick="filtrarPorCategoria('todos')">Todos</button>
                <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorCategoria('cabello')">Cabello</button>
                <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorCategoria('uñas')">Uñas</button>
                <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorCategoria('facial')">Facial</button>
                <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorCategoria('corporal')">Corporal</button>
            </div>

            <div class="row g-3" id="listaServicios">
                @forelse($servicios as $servicio)
                <!-- Servicio Seleccionable {{ $loop->iteration }} -->
                <div class="col-lg-4 col-md-6 servicio-container" data-categoria="{{ strtolower($servicio->categoria) }}">
                    <div class="list-item-custom servicio-item" 
                         style="cursor: pointer; transition: all 0.3s;" 
                         onclick="seleccionarServicio(
                             {{ $servicio->idServicio }}, 
                             '{{ $servicio->nombre }}', 
                             {{ $servicio->duracionBase }}, 
                             {{ $servicio->precioBase }},
                             {{ $servicio->requiere_largo_cabello ? 'true' : 'false' }},
                             {{ $servicio->requiere_tinturado_previo ? 'true' : 'false' }},
                             {{ $servicio->requiere_retiro_esmalte ? 'true' : 'false' }},
                             {{ $servicio->requiere_estilizado ? 'true' : 'false' }}
                         )">
                        <div class="list-avatar" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                            @if(stripos($servicio->categoria, 'cabello') !== false)
                                <i class="bi bi-scissors"></i>
                            @elseif(stripos($servicio->categoria, 'uña') !== false)
                                <i class="bi bi-hand-index-thumb"></i>
                            @elseif(stripos($servicio->categoria, 'facial') !== false)
                                <i class="bi bi-emoji-smile"></i>
                            @elseif(stripos($servicio->categoria, 'maquillaje') !== false)
                                <i class="bi bi-palette"></i>
                            @else
                                <i class="bi bi-stars"></i>
                            @endif
                        </div>
                        <div class="list-content">
                            <h6>{{ $servicio->nombre }}</h6>
                            <p>
                                <i class="bi bi-clock"></i> {{ $servicio->duracionBase }} min | 
                                <strong style="color: var(--dorado-palido);">${{ number_format($servicio->precioBase, 2) }}</strong>
                            </p>
                            @if($servicio->descripcion)
                            <small class="text-muted">{{ Str::limit($servicio->descripcion, 50) }}</small>
                            @endif
                        </div>
                        <div class="list-badge">
                            <span class="badge badge-soft">{{ ucfirst($servicio->categoria) }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay servicios disponibles en este momento.
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Resumen temporal y botón continuar -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card-custom" style="background: var(--rosa-empolvado-light);">
                        <h6 style="color: var(--borgona);">
                            <i class="bi bi-check-circle"></i> Servicios Seleccionados:
                        </h6>
                        <div id="resumenServiciosTemp">
                            <p class="text-muted">No has seleccionado ningún servicio</p>
                        </div>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1"><strong>Duración estimada:</strong></p>
                                    <h4 style="color: var(--borgona);" id="duracionTemporal">0 min</h4>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p class="mb-1"><strong>Precio estimado:</strong></p>
                                    <h4 style="color: var(--dorado-palido);" id="precioTemporal">$0.00</h4>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-gold w-100 mt-3" onclick="continuarAFechaHora()">
                            Continuar con la Reserva <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- RESTO DE PASOS (Paso 2, 3, 4, 5) - MANTENER IGUAL QUE ANTES -->
<!-- PASO 2: SELECCIÓN DE FECHA Y HORA -->
<div class="row g-4 mb-4" id="pasoFechaHora" style="display: none;">
    <div class="col-12">
        <div class="card-custom">
            <h5 class="card-title-custom">
                <i class="bi bi-calendar3"></i>
                Paso 2: Selecciona Fecha y Hora
            </h5>

            <div class="row g-4">
                <!-- Primero: Seleccionar Estilista -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-person-circle"></i> Selecciona tu Estilista
                    </label>
                    <select class="form-select" id="estilistaSeleccionado" onchange="cargarHorariosDisponibles()">
                        <option value="">-- Selecciona un estilista --</option>
                        @foreach($estilistas as $estilista)
                        <option value="{{ $estilista->idEmpleado }}">
                            {{ $estilista->nombre }} {{ $estilista->apellido }}
                        </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Selecciona primero el estilista para ver disponibilidad</small>
                </div>

                <!-- Selección de Fecha -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-calendar-event"></i> Fecha de la Cita
                    </label>
                    <input type="date" 
                           class="form-control" 
                           id="fechaCita" 
                           onchange="cargarHorariosDisponibles()">
                    <small class="text-muted">Selecciona el día que deseas agendar</small>
                </div>

                <!-- Horarios Disponibles -->
                <div class="col-12">
                    <label class="form-label">
                        <i class="bi bi-clock"></i> Horarios Disponibles
                    </label>
                    <div id="estadoHorarios" class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        Selecciona un estilista y una fecha para ver los horarios disponibles
                    </div>
                    <div id="horariosDisponibles" style="display: none;"></div>
                </div>

                <!-- Confirmación de fecha y hora -->
                <div class="col-12" id="confirmacionFechaHora"></div>
            </div>

<div class="d-flex gap-2 mt-4">
    <button class="btn btn-soft" onclick="volverAServicios()">
        <i class="bi bi-arrow-left"></i> Volver
    </button>
    <button class="btn btn-secondary flex-fill" 
            id="btnContinuarEstilista" 
            onclick="continuarAConfirmacion()" 
            disabled>
        Continuar <i class="bi bi-arrow-right"></i>
    </button>
</div>
        </div>
    </div>
</div>

<!-- PASO 3: CONFIRMACIÓN -->
<div class="row g-4 mb-4" id="pasoConfirmacion" style="display: none;">
    <div class="col-12">
        <div class="card-custom">
            <h5 class="card-title-custom">
                <i class="bi bi-check-circle"></i>
                Paso 3: Confirma tu Reserva
            </h5>

            <!-- Resumen de servicios seleccionados -->
            <div class="row mb-4">
                <div class="col-12">
                    <h6 style="color: var(--borgona);">
                        <i class="bi bi-scissors"></i> Servicios Seleccionados:
                    </h6>
                    <div id="resumenServicios" class="mb-3"></div>
                </div>
            </div>

            <!-- Resumen Final -->
            <div id="resumenFinal"></div>

            <!-- Código Promocional -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-gift"></i> ¿Tienes un código promocional?
                    </label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               id="codigoPromocion" 
                               placeholder="Ingresa tu código"
                               value="{{ $promoSeleccionada }}">
                        <button class="btn btn-gold" onclick="validarPromocion()">
                            <i class="bi bi-check-circle"></i> Aplicar
                        </button>
                        <button class="btn btn-outline-danger" onclick="quitarPromocion()">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <small class="text-muted">Aplica tu código de descuento aquí</small>
                </div>
            </div>

            <!-- Notas adicionales -->
            <div class="row mb-4">
                <div class="col-12">
                    <label class="form-label">
                        <i class="bi bi-chat-left-text"></i> Notas adicionales (opcional)
                    </label>
                    <textarea class="form-control" 
                              rows="3" 
                              placeholder="¿Alguna preferencia o comentario adicional?"
                              onchange="reservaData.notas = this.value"></textarea>
                </div>
            </div>

            <!-- Resumen de precios -->
            <div class="premium-card mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <h5 style="color: var(--borgona);">
                            <i class="bi bi-clock-fill"></i> Duración Total:
                        </h5>
                        <h3 style="color: var(--borgona);" id="duracionTotal">0 min</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5 style="color: var(--borgona);">
                            <i class="bi bi-cash-stack"></i> Total a Pagar:
                        </h5>
                        <h2 style="color: var(--dorado-palido);" id="precioTotal">$0.00</h2>
                        <div id="descuentoTotal"></div>
                    </div>
                </div>
            </div>

            <!-- Política de cancelación -->
            <div class="alert-custom mb-4">
                <i class="bi bi-info-circle-fill"></i>
                <small>
                    <strong>Política de cancelación:</strong> 
                    Puedes cancelar o modificar tu cita sin costo hasta 24 horas antes de la fecha programada.
                </small>
            </div>

            <!-- Términos y condiciones -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="aceptarTerminos">
                <label class="form-check-label" for="aceptarTerminos">
                    Acepto los <a href="#" style="color: var(--dorado-palido);">términos y condiciones</a> 
                    y la <a href="#" style="color: var(--dorado-palido);">política de privacidad</a>
                </label>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-soft" onclick="volverAFechaHora()">
                    <i class="bi bi-arrow-left"></i> Volver
                </button>
                <button class="btn btn-gold flex-fill" onclick="confirmarReserva()">
                    <i class="bi bi-check-circle-fill"></i> Confirmar Reserva
                </button>
            </div>
        </div>
    </div>
</div>
        <!-- ... (el código de los pasos 2-5 permanece exactamente igual) ... -->

    </main>

    <!-- ============================================
         MODAL: DETALLE DE CITA
         ============================================ -->
    <div class="modal fade" id="modalDetalleCita" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-calendar-check" style="color: var(--dorado-palido);"></i>
                        Detalle de la Cita
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="premium-card mb-3">
                        <div class="row">
                            <div class="col-md-8">
                                <h4 style="color: var(--borgona); margin-bottom: 0.5rem;" id="modalServicioNombre">Limpieza Facial Profunda</h4>
                                <p style="margin: 0;">
                                    <span class="badge bg-warning text-dark" id="modalEstadoBadge">Pendiente</span>
                                    <span class="badge badge-soft ms-2" id="modalCodigoCita">BR-2024-00245</span>
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <h3 style="color: var(--dorado-palido); margin: 0;" id="modalPrecio">$31.50</h3>
                                <small style="color: var(--borgona); opacity: 0.7;">Precio VIP</small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar">
                                    <i class="bi bi-calendar-event"></i>
                                </div>
                                <div class="list-content">
                                    <small style="opacity: 0.7;">Fecha y Hora</small>
                                    <h6 id="modalFechaHora">Lun, 04 Nov 2024 - 10:00 AM</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="list-content">
                                    <small style="opacity: 0.7;">Duración Estimada</small>
                                    <h6 id="modalDuracion">60 minutos</h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                                <div class="list-content">
                                    <small style="opacity: 0.7;">Estilista Asignada</small>
                                    <h6 id="modalEstilista">Laura Gómez Ortiz</h6>
                                    <small style="color: var(--dorado-palido);">
                                        <i class="bi bi-stars"></i> Especialidad: Tratamientos faciales
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-custom">
                        <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                            <i class="bi bi-info-circle"></i> Información Adicional
                        </h6>
                        <p style="margin: 0.5rem 0;"><strong>Dirección:</strong> Calle Principal #123, Col. Escalón, San Salvador</p>
                        <p style="margin: 0.5rem 0;"><strong>Teléfono del salón:</strong> (503) 2222-3333</p>
                        <p style="margin: 0.5rem 0;"><strong>Reservado el:</strong> 28 Oct 2024</p>
                    </div>

                    <div class="alert-custom mt-3">
                        <i class="bi bi-info-circle"></i>
                        <small><strong>Política de cancelación:</strong> Puedes cancelar o modificar sin costo hasta 24 horas antes.</small>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-gold" onclick="modificarCitaModal()">
                        <i class="bi bi-pencil"></i> Modificar
                    </button>
                    <button type="button" class="btn btn-premium" onclick="cancelarCitaModal()">
                        <i class="bi bi-x-circle"></i> Cancelar Cita
                    </button>
                </div>
                
            </div>
        </div>
    </div>

     <!-- ============================================
         FOOTER
         ============================================ -->
 
  <footer class="main-footer">
        <p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer> 

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
<script>
    // ========================================
    // VARIABLES GLOBALES
    // ========================================
    let reservaData = {
        servicios: [], // Array de servicios seleccionados
        detalles: {}, // Detalles adicionales por servicio
        fecha: '',
        hora: '',
        estilistaId: null,
        estilista: '',
        promocion: '{{ $promoSeleccionada }}',
        comboId: '{{ $comboSeleccionado }}',
        notas: '',
        duracionTotal: 0,
        precioBase: 0,
        descuento: 0,
        precioFinal: 0
    };

    // Obtener CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ========================================
    // INICIALIZACIÓN
    // ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Cargar nombre de usuario
    cargarDatosUsuario();
    
    // Si viene con promoción pre-aplicada
    if (reservaData.promocion) {
        document.getElementById('codigoPromocion').value = reservaData.promocion;
        setTimeout(() => {
            validarPromocion();
        }, 500);
    }
    
    // Si viene con combo pre-seleccionado
    if (reservaData.comboId) {
        cargarCombo(reservaData.comboId);
    }
    
    // Inicializar fecha mínima (hoy)
    const fechaInput = document.getElementById('fechaCita');
    if (fechaInput) {
        const hoy = new Date().toISOString().split('T')[0];
        fechaInput.min = hoy;
    }
});

// Función para cargar combo automáticamente
async function cargarCombo(comboId) {
    try {
        const response = await fetch(`/cliente/promociones/combo/${comboId}`);
        const data = await response.json();
        
        if (data.success) {
            const combo = data.combo;
            
            // Mostrar alerta con información del combo
            alert(`✨ Combo Seleccionado: ${combo.nombre}\n\n` +
                  `Precio: $${combo.precioCombo}\n` +
                  `Ahorro: $${combo.ahorro}\n\n` +
                  `Los servicios del combo se agregarán automáticamente.`);
            
            // Continuar con el flujo
            continuarAFechaHora();
        }
    } catch (error) {
        console.error('Error al cargar combo:', error);
    }
}

    function cargarDatosUsuario() {
        const nombre = localStorage.getItem('clienteNombre') || 'Cliente';
        const apellido = localStorage.getItem('clienteApellido') || '';
        const inicial = nombre.charAt(0).toUpperCase();

        const nombreSpan = document.getElementById('nombreCliente');
        if (nombreSpan) {
            nombreSpan.textContent = `${nombre} ${apellido}`;
        }

        const avatarDiv = document.getElementById('avatarInicial');
        if (avatarDiv) {
            avatarDiv.textContent = inicial;
        }
    }

    // ========================================
    // PASO 1: SELECCIÓN DE SERVICIO(S)
    // ========================================
function seleccionarServicio(id, nombre, duracion, precio) {
    // Verificar si ya está seleccionado
    const index = reservaData.servicios.findIndex(s => s.id === id);
    
    const elemento = event.target.closest('.list-item-custom');
    
    if (index > -1) {
        // Ya está seleccionado, removerlo
        reservaData.servicios.splice(index, 1);
        delete reservaData.detalles[id];
        elemento.classList.remove('selected');
    } else {
        // Agregar nuevo servicio
        reservaData.servicios.push({
            id: id,
            nombre: nombre,
            duracion: duracion,
            precio: precio
        });
        elemento.classList.add('selected');
    }
    
    // Actualizar resumen
    actualizarResumenServicios();
    calcularTotales();
}
function actualizarResumenServicios() {
    // Actualizar resumen en el paso 1
    const contenedorTemp = document.getElementById('resumenServiciosTemp');
    
    if (contenedorTemp) {
        if (reservaData.servicios.length === 0) {
            contenedorTemp.innerHTML = '<p class="text-muted">No has seleccionado ningún servicio</p>';
        } else {
            let html = '<ul class="list-unstyled mb-0">';
            
            reservaData.servicios.forEach(servicio => {
                html += `
                    <li class="d-flex justify-content-between align-items-center mb-2 p-2" 
                        style="background: white; border-radius: 8px; border-left: 3px solid var(--dorado-palido);">
                        <div>
                            <strong>${servicio.nombre}</strong>
                            <br>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> ${servicio.duracion} min | 
                                <i class="bi bi-cash"></i> $${servicio.precio.toFixed(2)}
                            </small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger" onclick="removerServicio(${servicio.id})">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </li>
                `;
            });
            html += '</ul>';
            contenedorTemp.innerHTML = html;
        }
    }
    
    // Actualizar resumen en confirmación
    const contenedor = document.getElementById('resumenServicios');
    if (contenedor) {
        if (reservaData.servicios.length === 0) {
            contenedor.innerHTML = '<p class="text-muted">No hay servicios seleccionados</p>';
        } else {
            let html = '<div class="list-group">';
            reservaData.servicios.forEach(servicio => {
                html += `
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">${servicio.nombre}</h6>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i> ${servicio.duracion} min | 
                                <i class="bi bi-cash"></i> $${servicio.precio.toFixed(2)}
                            </small>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            contenedor.innerHTML = html;
        }
    }
    
    console.log('📋 Resumen actualizado, calculando totales...');
}
function removerServicio(id) {
    console.log('🗑️ Removiendo servicio:', id);
    
    const index = reservaData.servicios.findIndex(s => s.id === id);
    if (index > -1) {
        reservaData.servicios.splice(index, 1);
        delete reservaData.detalles[id];
        
        // Actualizar UI - buscar el elemento correcto
        const elementos = document.querySelectorAll('.servicio-item');
        elementos.forEach(elem => {
            const onclick = elem.getAttribute('onclick');
            if (onclick && onclick.includes(`seleccionarServicio(${id},`)) {
                elem.classList.remove('selected');
            }
        });
        
        console.log('✅ Servicio removido. Servicios restantes:', reservaData.servicios.length);
        
        // Actualizar resumen y recalcular
        actualizarResumenServicios();
        calcularTotales();
    }
}
    function continuarAFechaHora() {
        if (reservaData.servicios.length === 0 && !reservaData.comboId) {
            alert('⚠️ Por favor selecciona al menos un servicio');
            return;
        }
        
        // Ocultar paso 1, mostrar paso 2
        document.getElementById('pasoServicio').style.display = 'none';
        document.getElementById('pasoFechaHora').style.display = 'block';
        
        // Actualizar stepper
        actualizarStepper(2);
        
        // Scroll al inicio
        document.getElementById('seccionReservar').scrollIntoView({ behavior: 'smooth' });
    }

    // ========================================
    // PASO 2: FECHA Y HORA
    // ========================================
    async function cambiarFecha() {
        const fecha = document.getElementById('fechaCita').value;
        const estilistaId = document.getElementById('estilistaSeleccionado')?.value;
        
        if (!fecha || !estilistaId) {
            return;
        }
        
        reservaData.fecha = fecha;
        
        // Cargar horarios disponibles
        await cargarHorariosDisponibles();
    }

async function cargarHorariosDisponibles() {
    const estilistaId = document.getElementById('estilistaSeleccionado')?.value;
    const fecha = document.getElementById('fechaCita')?.value;
    
    console.log('🔍 Cargando horarios:', { estilistaId, fecha }); // DEBUG
    
    const estadoHorarios = document.getElementById('estadoHorarios');
    const contenedorHorarios = document.getElementById('horariosDisponibles');
    const btnContinuar = document.getElementById('btnContinuarEstilista');
    
    // Validar que estén ambos campos
    if (!estilistaId || !fecha) {
        if (estadoHorarios) {
            estadoHorarios.style.display = 'block';
            estadoHorarios.className = 'alert alert-info';
            estadoHorarios.innerHTML = '<i class="bi bi-info-circle"></i> Selecciona un estilista y una fecha para ver los horarios disponibles';
        }
        if (contenedorHorarios) contenedorHorarios.style.display = 'none';
        if (btnContinuar) btnContinuar.disabled = true;
        return;
    }
    
    // Guardar datos
    reservaData.estilistaId = estilistaId;
    reservaData.fecha = fecha;
    
    // Mostrar loading
    if (estadoHorarios) {
        estadoHorarios.style.display = 'block';
        estadoHorarios.className = 'alert alert-warning';
        estadoHorarios.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Cargando horarios disponibles...';
    }
    
    try {
        const url = '{{ route("cliente.citas.horarios") }}';
        console.log('📡 Enviando petición a:', url); // DEBUG
        
        const body = {
            fecha: fecha,
            estilista_id: parseInt(estilistaId),
            duracion: reservaData.duracionTotal || 60
        };
        console.log('📦 Datos enviados:', body); // DEBUG
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(body)
        });
        
        console.log('📥 Respuesta recibida:', response.status); // DEBUG
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('❌ Error en respuesta:', errorText);
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        console.log('✅ Datos recibidos:', data); // DEBUG
        
        if (data.success) {
            if (estadoHorarios) estadoHorarios.style.display = 'none';
            
            if (data.horarios.length === 0) {
                if (contenedorHorarios) {
                    contenedorHorarios.style.display = 'block';
                    contenedorHorarios.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> 
                            No hay horarios disponibles para esta fecha. Por favor selecciona otra fecha.
                        </div>
                    `;
                }
                if (btnContinuar) btnContinuar.disabled = true;
                return;
            }
            
            // Mostrar horarios
            let html = '<div class="row g-2">';
            data.horarios.forEach(horario => {
                html += `
                    <div class="col-6 col-md-3">
                        <button class="btn btn-outline-gold w-100 btn-horario" 
                                data-hora="${horario.hora}"
                                onclick="seleccionarHora('${horario.hora}', '${horario.hora_formateada}')">
                            <i class="bi bi-clock"></i> ${horario.hora_formateada}
                        </button>
                    </div>
                `;
            });
            html += '</div>';
            
            if (contenedorHorarios) {
                contenedorHorarios.innerHTML = html;
                contenedorHorarios.style.display = 'block';
            }
            
            console.log('✅ Horarios renderizados exitosamente'); // DEBUG
        } else {
            throw new Error(data.message || 'Error al cargar horarios');
        }
    } catch (error) {
        console.error('❌ Error completo:', error); // DEBUG
        if (estadoHorarios) {
            estadoHorarios.style.display = 'block';
            estadoHorarios.className = 'alert alert-danger';
            estadoHorarios.innerHTML = `
                <i class="bi bi-x-circle"></i> 
                <strong>Error al cargar horarios:</strong><br>
                ${error.message}<br>
                <small>Revisa la consola del navegador para más detalles</small>
            `;
        }
        if (contenedorHorarios) contenedorHorarios.style.display = 'none';
        if (btnContinuar) btnContinuar.disabled = true;
    }
}

function seleccionarHora(hora, horaFormateada) {
    reservaData.hora = hora;
    
    console.log('⏰ Hora seleccionada:', hora, horaFormateada);
    
    // Marcar como seleccionado en UI
    document.querySelectorAll('.btn-horario').forEach(btn => {
        btn.classList.remove('btn-gold');
        btn.classList.add('btn-outline-gold');
    });
    
    event.target.classList.remove('btn-outline-gold');
    event.target.classList.add('btn-gold');
    
    // Mostrar confirmación
    const confirmacion = document.getElementById('confirmacionFechaHora');
    if (confirmacion) {
        const fechaFormateada = new Date(reservaData.fecha + 'T00:00:00').toLocaleDateString('es-SV', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        confirmacion.innerHTML = `
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i> 
                <strong>Fecha y hora confirmada:</strong><br>
                ${fechaFormateada.charAt(0).toUpperCase() + fechaFormateada.slice(1)} a las ${horaFormateada}
            </div>
        `;
    }
    
    // ✅ HABILITAR BOTÓN CONTINUAR
    const btnContinuar = document.getElementById('btnContinuarEstilista');
    if (btnContinuar) {
        btnContinuar.disabled = false;
        btnContinuar.classList.remove('btn-secondary');
        btnContinuar.classList.add('btn-gold');
        console.log('✅ Botón continuar habilitado');
    } else {
        console.error('❌ No se encontró el botón continuar');
    }
}
    function continuarAEstilista() {
        if (!reservaData.fecha || !reservaData.hora) {
            alert('⚠️ Por favor selecciona fecha y hora');
            return;
        }
        
        document.getElementById('pasoFechaHora').style.display = 'none';
        document.getElementById('pasoEstilista').style.display = 'block';
        
        actualizarStepper(3);
        document.getElementById('seccionReservar').scrollIntoView({ behavior: 'smooth' });
    }

    function volverAServicios() {
        document.getElementById('pasoFechaHora').style.display = 'none';
        document.getElementById('pasoServicio').style.display = 'block';
        actualizarStepper(1);
    }

    // ========================================
    // PASO 3: SELECCIÓN DE ESTILISTA
    // ========================================
    function seleccionarEstilista(id, nombre) {
        reservaData.estilistaId = id;
        reservaData.estilista = nombre;
        
        // Actualizar UI
        document.querySelectorAll('.estilista-item').forEach(item => {
            item.classList.remove('selected');
        });
        
        event.target.closest('.estilista-item').classList.add('selected');
        
        // Si hay fecha, cargar horarios
        if (reservaData.fecha) {
            cargarHorariosDisponibles();
        }
    }

function continuarAConfirmacion() {
    console.log('🔄 Continuando a confirmación...', {
        fecha: reservaData.fecha,
        hora: reservaData.hora,
        estilistaId: reservaData.estilistaId,
        servicios: reservaData.servicios.length
    });
    
    if (!reservaData.fecha || !reservaData.hora || !reservaData.estilistaId) {
        alert('⚠️ Por favor completa todos los campos:\n' +
              `- Fecha: ${reservaData.fecha ? '✓' : '✗'}\n` +
              `- Hora: ${reservaData.hora ? '✓' : '✗'}\n` +
              `- Estilista: ${reservaData.estilistaId ? '✓' : '✗'}`);
        return;
    }
    
    // Obtener nombre del estilista
    const selectEstilista = document.getElementById('estilistaSeleccionado');
    if (selectEstilista && selectEstilista.selectedIndex > 0) {
        reservaData.estilista = selectEstilista.options[selectEstilista.selectedIndex].text;
    } else {
        console.error('❌ No se pudo obtener el nombre del estilista');
    }
    
    // Verificar que existan los elementos antes de manipularlos
    const pasoFechaHora = document.getElementById('pasoFechaHora');
    const pasoConfirmacion = document.getElementById('pasoConfirmacion');
    
    if (!pasoFechaHora || !pasoConfirmacion) {
        console.error('❌ No se encontraron los elementos del paso:', {
            pasoFechaHora: !!pasoFechaHora,
            pasoConfirmacion: !!pasoConfirmacion
        });
        alert('Error: No se pueden mostrar los pasos. Recarga la página.');
        return;
    }
    
    // Ocultar paso 2, mostrar paso 3
    pasoFechaHora.style.display = 'none';
    pasoConfirmacion.style.display = 'block';
    
    // Actualizar stepper
    actualizarStepper(3);
    
    // Mostrar resumen final
    mostrarResumenFinal();
    
    // Scroll al inicio de la sección
    const seccionReservar = document.getElementById('seccionReservar');
    if (seccionReservar) {
        seccionReservar.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    
    console.log('✅ Paso de confirmación mostrado');
}

function volverAFechaHora() {
    const pasoConfirmacion = document.getElementById('pasoConfirmacion');
    const pasoFechaHora = document.getElementById('pasoFechaHora');
    
    if (pasoConfirmacion) pasoConfirmacion.style.display = 'none';
    if (pasoFechaHora) pasoFechaHora.style.display = 'block';
    
    actualizarStepper(2);
    
    const seccionReservar = document.getElementById('seccionReservar');
    if (seccionReservar) {
        seccionReservar.scrollIntoView({ behavior: 'smooth' });
    }
}

    // ========================================
    // PASO 4: CONFIRMACIÓN
    // ========================================
function mostrarResumenFinal() {
    console.log('📋 Mostrando resumen final...');
    
    const contenedor = document.getElementById('resumenFinal');
    if (!contenedor) {
        console.error('❌ No se encontró el contenedor del resumen final');
        return;
    }
    
    // Formatear fecha
    const fechaObj = new Date(reservaData.fecha + 'T00:00:00');
    const fechaFormateada = fechaObj.toLocaleDateString('es-SV', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
    
    // Formatear hora
    const horaObj = new Date('2000-01-01T' + reservaData.hora);
    const horaFormateada = horaObj.toLocaleTimeString('es-SV', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
    
    let html = `
        <div class="card-custom" style="background: linear-gradient(135deg, var(--rosa-empolvado-light), white);">
            <h5 style="color: var(--borgona); margin-bottom: 1.5rem;">
                <i class="bi bi-calendar-check-fill"></i> Resumen de tu Cita
            </h5>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-calendar-event"></i> Fecha
                        </small>
                        <strong style="color: var(--borgona); font-size: 1.1rem;">
                            ${fechaFormateada.charAt(0).toUpperCase() + fechaFormateada.slice(1)}
                        </strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-clock"></i> Hora
                        </small>
                        <strong style="color: var(--borgona); font-size: 1.1rem;">${horaFormateada}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-person-circle"></i> Estilista
                        </small>
                        <strong style="color: var(--borgona); font-size: 1.1rem;">${reservaData.estilista}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-hourglass-split"></i> Duración Total
                        </small>
                        <strong style="color: var(--borgona); font-size: 1.1rem;">
                            ${reservaData.duracionTotal} minutos (${Math.floor(reservaData.duracionTotal / 60)}h ${reservaData.duracionTotal % 60}min)
                        </strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-cash"></i> Precio Base
                        </small>
                        <strong style="color: var(--borgona); font-size: 1.1rem;">$${reservaData.precioBase.toFixed(2)}</strong>
                    </div>
                    ${reservaData.descuento > 0 ? `
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-tag-fill"></i> Descuento
                        </small>
                        <strong style="color: #28a745; font-size: 1.1rem;">-$${reservaData.descuento.toFixed(2)}</strong>
                    </div>
                    ` : ''}
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">
                            <i class="bi bi-cash-stack"></i> Total a Pagar
                        </small>
                        <h3 style="color: var(--dorado-palido); margin: 0;">$${reservaData.precioFinal.toFixed(2)}</h3>
                    </div>
                </div>
            </div>
            <hr style="border-color: var(--rosa-empolvado);">
            <h6 style="color: var(--borgona);">
                <i class="bi bi-list-check"></i> Servicios Incluidos:
            </h6>
            <ul style="margin: 0; padding-left: 1.5rem;">
    `;
    
    reservaData.servicios.forEach(servicio => {
        html += `
            <li style="margin-bottom: 0.5rem;">
                <strong>${servicio.nombre}</strong> 
                <span class="text-muted">- ${servicio.duracion} min - $${servicio.precio.toFixed(2)}</span>
            </li>
        `;
    });
    
    html += `
            </ul>
        </div>
    `;
    
    contenedor.innerHTML = html;
    
    // Actualizar también los displays de totales
    actualizarDisplayTotales();
    
    console.log('✅ Resumen final mostrado');
}
async function confirmarReserva() {
    console.log('🎯 Confirmando reserva...');
    
    // Validar términos
    const aceptarTerminos = document.getElementById('aceptarTerminos');
    if (aceptarTerminos && !aceptarTerminos.checked) {
        alert('⚠️ Debes aceptar los términos y condiciones para continuar');
        return;
    }
    
    if (!reservaData.servicios.length && !reservaData.comboId) {
        alert('⚠️ Error: No hay servicios seleccionados');
        return;
    }
    
    if (!reservaData.fecha || !reservaData.hora || !reservaData.estilistaId) {
        alert('⚠️ Error: Datos incompletos\n' +
              `Fecha: ${reservaData.fecha}\n` +
              `Hora: ${reservaData.hora}\n` +
              `Estilista: ${reservaData.estilistaId}`);
        return;
    }
    
    // Deshabilitar botón
    const btnConfirmar = event.target;
    btnConfirmar.disabled = true;
    btnConfirmar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Agendando cita...';
    
    try {
        console.log('📤 Enviando datos:', {
            servicios: reservaData.servicios.map(s => s.id),
            fecha: reservaData.fecha,
            hora: reservaData.hora,
            estilista_id: reservaData.estilistaId
        });
        
        const response = await fetch('{{ route("cliente.citas.agendar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                servicios: reservaData.servicios.map(s => s.id),
                detalles: reservaData.detalles,
                fecha: reservaData.fecha,
                hora: reservaData.hora,
                estilista_id: reservaData.estilistaId,
                codigo_promocional: reservaData.promocion,
                combo_id: reservaData.comboId,
                notas: reservaData.notas
            })
        });
        
        const data = await response.json();
        console.log('📥 Respuesta recibida:', data);
        
        if (data.success) {
            alert(`✅ ${data.message}\n\n` +
                  `📋 Código de cita: #${data.cita.id}\n` +
                  `📅 Fecha: ${data.cita.fecha}\n` +
                  `⏰ Hora: ${data.cita.hora}\n` +
                  `⏱️ Duración: ${data.cita.duracion_total} minutos\n` +
                  `💰 Total: $${data.cita.precio_final}\n\n` +
                  `Te esperamos! 🎉`);
            
            // Recargar página después de 2 segundos
            setTimeout(() => {
                location.reload();
            }, 2000);
        } else {
            alert('❌ Error: ' + data.message);
            btnConfirmar.disabled = false;
            btnConfirmar.innerHTML = '<i class="bi bi-check-circle-fill"></i> Confirmar Reserva';
        }
    } catch (error) {
        console.error('❌ Error completo:', error);
        alert('❌ Error al agendar la cita. Por favor intenta de nuevo.\n\nError: ' + error.message);
        btnConfirmar.disabled = false;
        btnConfirmar.innerHTML = '<i class="bi bi-check-circle-fill"></i> Confirmar Reserva';
    }
}
    function volverAEstilistas() {
        document.getElementById('pasoConfirmacion').style.display = 'none';
        document.getElementById('pasoEstilista').style.display = 'block';
        actualizarStepper(3);
    }

    // ========================================
    // PROMOCIONES
    // ========================================
    async function validarPromocion() {
        const codigo = document.getElementById('codigoPromocion').value;
        
        if (!codigo) {
            alert('⚠️ Por favor ingresa un código promocional');
            return;
        }
        
        try {
            const response = await fetch('{{ route("cliente.promociones.validar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ codigo: codigo })
            });
            
            const data = await response.json();
            
            if (data.success) {
                reservaData.promocion = codigo;
                alert(`✅ ${data.message}\n\n${data.promocion.nombre}\n${data.promocion.descripcion}`);
                calcularTotales();
            } else {
                alert('❌ ' + data.message);
                reservaData.promocion = '';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al validar promoción');
        }
    }

    function quitarPromocion() {
        reservaData.promocion = '';
        document.getElementById('codigoPromocion').value = '';
        calcularTotales();
        alert('Promoción removida');
    }

// ========================================
// CALCULAR TOTALES
// ========================================
async function calcularTotales() {
    if (reservaData.servicios.length === 0 && !reservaData.comboId) {
        // Resetear valores si no hay servicios
        reservaData.duracionTotal = 0;
        reservaData.precioBase = 0;
        reservaData.descuento = 0;
        reservaData.precioFinal = 0;
        actualizarDisplayTotales();
        return;
    }
    
    try {
        const url = '{{ route("cliente.citas.calcular") }}';
        console.log('💰 Calculando totales...', {
            servicios: reservaData.servicios.map(s => s.id),
            detalles: reservaData.detalles,
            promocion: reservaData.promocion
        });
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                servicios: reservaData.servicios.map(s => s.id),
                detalles: reservaData.detalles,
                codigo_promocional: reservaData.promocion,
                combo_id: reservaData.comboId
            })
        });
        
        if (!response.ok) {
            throw new Error('Error en la petición');
        }
        
        const data = await response.json();
        console.log('✅ Totales calculados:', data);
        
        if (data.success) {
            reservaData.duracionTotal = data.duracion_total;
            reservaData.precioBase = parseFloat(data.precio_base.replace(',', ''));
            reservaData.descuento = parseFloat(data.descuento.replace(',', ''));
            reservaData.precioFinal = parseFloat(data.precio_final.replace(',', ''));
            
            // Actualizar UI
            actualizarDisplayTotales();
        }
    } catch (error) {
        console.error('❌ Error al calcular totales:', error);
        
        // Calcular totales de forma local como fallback
        let duracionTotal = 0;
        let precioTotal = 0;
        
        reservaData.servicios.forEach(servicio => {
            duracionTotal += servicio.duracion;
            precioTotal += servicio.precio;
        });
        
        reservaData.duracionTotal = duracionTotal;
        reservaData.precioBase = precioTotal;
        reservaData.descuento = 0;
        reservaData.precioFinal = precioTotal;
        
        actualizarDisplayTotales();
    }
}

function actualizarDisplayTotales() {
    // Actualizar en el paso 1 (resumen temporal)
    const duracionTemp = document.getElementById('duracionTemporal');
    const precioTemp = document.getElementById('precioTemporal');
    
    if (duracionTemp) {
        duracionTemp.textContent = `${reservaData.duracionTotal} min`;
    }
    
    if (precioTemp) {
        precioTemp.textContent = `$${reservaData.precioFinal.toFixed(2)}`;
    }
    
    // Actualizar en el paso de confirmación
    const duracionDisplay = document.getElementById('duracionTotal');
    const precioDisplay = document.getElementById('precioTotal');
    const descuentoDisplay = document.getElementById('descuentoTotal');
    
    if (duracionDisplay) {
        duracionDisplay.textContent = `${reservaData.duracionTotal} min`;
    }
    
    if (precioDisplay) {
        precioDisplay.textContent = `$${reservaData.precioFinal.toFixed(2)}`;
    }
    
    if (descuentoDisplay) {
        if (reservaData.descuento > 0) {
            descuentoDisplay.innerHTML = `
                <small class="text-success">
                    <i class="bi bi-tag-fill"></i> Descuento aplicado: -$${reservaData.descuento.toFixed(2)}
                </small>
            `;
        } else {
            descuentoDisplay.innerHTML = '';
        }
    }
    
    console.log('📊 Display actualizado:', {
        duracion: reservaData.duracionTotal,
        precio: reservaData.precioFinal
    });
}

    // ========================================
    // STEPPER
    // ========================================
function actualizarStepper(pasoActual) {
    for (let i = 1; i <= 3; i++) {
        const step = document.getElementById(`step${i}`);
        if (!step) continue;
        
        if (i < pasoActual) {
            step.style.opacity = '0.6';
            step.querySelector('div').style.background = 'var(--dorado-palido)';
        } else if (i === pasoActual) {
            step.style.opacity = '1';
            step.querySelector('div').style.background = 'var(--borgona)';
        } else {
            step.style.opacity = '0.4';
            step.querySelector('div').style.background = 'var(--rosa-empolvado)';
        }
    }
}
    // ========================================
    // FUNCIONES PARA MIS CITAS ACTUALES
    // ========================================
    function toggleMisCitas() {
        const seccion = document.getElementById('seccionMisCitas');
        const icono = document.getElementById('iconToggleCitas');

        if (seccion.style.display === 'none') {
            seccion.style.display = 'block';
            icono.className = 'bi bi-chevron-down';
        } else {
            seccion.style.display = 'none';
            icono.className = 'bi bi-chevron-up';
        }
    }

    function filtrarCitasPorEstado(estado) {
        console.log('Filtrar citas por estado:', estado);
        // TODO: Implementar filtrado
    }

    function agendarCita() {
        document.getElementById('seccionReservar').scrollIntoView({ behavior: 'smooth' });
    }

    function scrollToReservar() {
        document.getElementById('seccionReservar').scrollIntoView({ behavior: 'smooth' });
    }

    // Filtrar servicios
    function filtrarServicios() {
        const termino = document.getElementById('buscarServicioReserva').value.toLowerCase();
        const servicios = document.querySelectorAll('.servicio-item');
        
        servicios.forEach(servicio => {
            const texto = servicio.textContent.toLowerCase();
            if (texto.includes(termino)) {
                servicio.closest('.col-lg-4').style.display = 'block';
            } else {
                servicio.closest('.col-lg-4').style.display = 'none';
            }
        });
    }

    function filtrarPorCategoria(categoria) {
        console.log('Filtrar por categoría:', categoria);
        // TODO: Implementar filtrado por categoría
    }

    // Agregar estilos CSS para elementos seleccionados
    const style = document.createElement('style');
    style.textContent = `
        .list-item-custom.selected {
            border: 2px solid var(--dorado-palido) !important;
            background: rgba(212, 175, 55, 0.1) !important;
        }
        
        .estilista-item.selected {
            border: 2px solid var(--borgona) !important;
            background: rgba(139, 64, 73, 0.1) !important;
        }
    `;
    document.head.appendChild(style);

    function actualizarResumenServicios() {
    // Actualizar resumen en el paso 1
    const contenedorTemp = document.getElementById('resumenServiciosTemp');
    if (contenedorTemp) {
        if (reservaData.servicios.length === 0) {
            contenedorTemp.innerHTML = '<p class="text-muted">No has seleccionado ningún servicio</p>';
        } else {
            let html = '<ul class="list-unstyled mb-0">';
            reservaData.servicios.forEach(servicio => {
                html += `
                    <li class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <strong>${servicio.nombre}</strong>
                            <br>
                            <small>${servicio.duracion} min | $${servicio.precio.toFixed(2)}</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger" onclick="removerServicio(${servicio.id})">
                            <i class="bi bi-x"></i>
                        </button>
                    </li>
                `;
            });
            html += '</ul>';
            contenedorTemp.innerHTML = html;
        }
    }
    
    // Actualizar resumen en confirmación
    const contenedor = document.getElementById('resumenServicios');
    if (!contenedor) return;
    
    if (reservaData.servicios.length === 0) {
        contenedor.innerHTML = '<p class="text-muted">No hay servicios seleccionados</p>';
        return;
    }
    
    let html = '<div class="list-group">';
    reservaData.servicios.forEach(servicio => {
        html += `
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1">${servicio.nombre}</h6>
                    <small class="text-muted">${servicio.duracion} min | $${servicio.precio.toFixed(2)}</small>
                </div>
            </div>
        `;
    });
    html += '</div>';
    
    contenedor.innerHTML = html;
}

// Al inicializar, verificar si viene combo
document.addEventListener('DOMContentLoaded', function() {
    cargarDatosUsuario();
    
    // Si viene con promoción pre-aplicada
    if (reservaData.promocion) {
        document.getElementById('codigoPromocion').value = reservaData.promocion;
        setTimeout(() => {
            validarPromocion();
        }, 500);
    }
    
    // ✅ Si viene con combo pre-seleccionado, cargar servicios y saltar al paso 2
    if (reservaData.comboId) {
        cargarComboYSaltar(reservaData.comboId);
    }
    
    // Inicializar fecha mínima (hoy)
    const fechaInput = document.getElementById('fechaCita');
    if (fechaInput) {
        const hoy = new Date().toISOString().split('T')[0];
        fechaInput.min = hoy;
    }
});

// Nueva función para cargar combo y saltar al paso 2
async function cargarComboYSaltar(comboId) {
    try {
        console.log('🎁 Cargando combo:', comboId);
        
        const response = await fetch(`/cliente/promociones/combo/${comboId}`);
        const data = await response.json();
        
        if (data.success) {
            const combo = data.combo;
            
            console.log('✅ Combo cargado:', combo);
            
            // Cargar servicios del combo en reservaData
            reservaData.servicios = [];
            combo.servicios.forEach(servicio => {
                reservaData.servicios.push({
                    id: servicio.idServicio,
                    nombre: servicio.nombre,
                    duracion: servicio.duracionBase,
                    precio: parseFloat(servicio.precioBase)
                });
            });
            
            // Mostrar alerta informativa
            alert(`✨ Combo Seleccionado: ${combo.nombre}\n\n` +
                  `📦 Incluye:\n${combo.servicios.map(s => '• ' + s.nombre).join('\n')}\n\n` +
                  `💰 Precio: $${combo.precioCombo}\n` +
                  `💎 Ahorro: $${combo.ahorro}\n\n` +
                  `¡Ahora selecciona fecha, hora y estilista!`);
            
            // Calcular totales
            await calcularTotales();
            
            // Ocultar paso 1, mostrar paso 2
            document.getElementById('pasoServicio').style.display = 'none';
            document.getElementById('pasoFechaHora').style.display = 'block';
            
            // Actualizar stepper
            actualizarStepper(2);
            
            // Scroll a la sección
            document.getElementById('seccionReservar').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        } else {
            alert('❌ Error al cargar el combo. Por favor intenta de nuevo.');
            console.error('Error:', data.message);
        }
    } catch (error) {
        console.error('❌ Error al cargar combo:', error);
        alert('❌ Error al cargar el combo. Por favor intenta de nuevo.');
    }
}
</script>
<style>
    .list-item-custom.selected {
        border: 3px solid var(--dorado-palido) !important;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.15), rgba(255, 248, 240, 0.8)) !important;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        transform: scale(1.02);
        transition: all 0.3s ease;
    }
    
    .estilista-item.selected {
        border: 3px solid var(--borgona) !important;
        background: linear-gradient(135deg, rgba(139, 64, 73, 0.15), rgba(255, 248, 240, 0.8)) !important;
        box-shadow: 0 4px 15px rgba(139, 64, 73, 0.3);
        transform: scale(1.02);
        transition: all 0.3s ease;
    }
    
    .servicio-item {
        transition: all 0.3s ease;
    }
    
    .servicio-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    #horariosDisponibles button {
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    
    #horariosDisponibles button:hover {
        transform: scale(1.05);
    }
</style>
</body>

</html>