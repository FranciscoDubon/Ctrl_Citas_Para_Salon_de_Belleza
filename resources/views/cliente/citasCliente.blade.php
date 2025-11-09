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
    @forelse ($citas as $cita)
        <div class="col-lg-6 cita-item" data-estado="{{ strtolower($cita->estado) }}">
            <div class="list-item-custom"
                 style="flex-direction: column; align-items: flex-start; {{ $cita->estado == 'PENDIENTE' ? 'background: rgba(255, 193, 7, 0.08); border-left: 4px solid #ffc107;' : '' }}
                        {{ $cita->estado == 'CONFIRMADA' ? 'background: rgba(212, 175, 55, 0.08); border-left: 4px solid var(--dorado-palido);' : '' }}
                        {{ $cita->estado == 'COMPLETADA' ? 'opacity: 0.8;' : '' }}">
                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                    <div>
                        <h6 style="margin:0; font-weight:700;">{{ $cita->servicios->pluck('nombre')->join(', ') }}</h6>
                        <small style="opacity:0.7;">
                            <i class="bi bi-calendar3"></i>
                            {{ \Carbon\Carbon::parse($cita->fecha)->format('D, d M Y') }} - 
                            {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                        </small>
                    </div>
                    <span class="badge {{ $cita->estado == 'PENDIENTE' ? 'bg-warning text-dark' : ($cita->estado == 'CONFIRMADA' ? 'bg-info' : 'bg-success') }}">
                        {{ ucfirst(strtolower($cita->estado)) }}
                    </span>
                </div>

                <div class="w-100 mb-3">
                    <div class="row g-2">
                        <div class="col-6">
                            <small style="opacity:0.7;"><i class="bi bi-person-circle"></i> Estilista</small><br>
                            <strong>{{ $cita->estilista->nombre ?? 'N/A' }}</strong>
                        </div>
                        <div class="col-6 text-end">
                            <small style="opacity:0.7;">Duración</small><br>
                            <strong>{{ $cita->servicios->sum('duracionBase') }} min</strong>
                        </div>
                        <div class="col-6">
                            <small style="opacity:0.7;">Precio</small><br>
                            <strong>${{ $cita->servicios->sum('precioBase') }}</strong>
                        </div>
                        <div class="col-6 text-end">
                            <small style="opacity:0.7;">Código</small><br>
                            <code style="background: var(--rosa-empolvado); padding:0.25rem 0.5rem; border-radius:4px; font-size:0.75rem;">BR-{{ $cita->id }}</code>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 w-100">
@if($cita->estado == 'PENDIENTE')
    <button class="btn btn-gold btn-sm flex-fill" 
            onclick="confirmarAsistenciaCita({{ $cita->idCita }})">
        <i class="bi bi-check-circle"></i> Confirmar Asistencia
    </button>
@endif
<button class="btn btn-outline-gold btn-sm" 
        onclick="verDetalleCita({{ $cita->idCita }})">
    <i class="bi bi-eye"></i> Ver Detalles
</button>
                </div>
            </div>
        </div>
    @empty
        <div id="mensajeNoCitas" style="text-align:center; padding:3rem;">
            <div style="font-size:4rem; color: var(--rosa-empolvado); margin-bottom:1rem;">
                <i class="bi bi-calendar-x"></i>
            </div>
            <h5>No tienes citas programadas</h5>
            <p style="opacity:0.7;">¡Es un buen momento para agendar tu próxima cita!</p>
            <button class="btn btn-gold" onclick="scrollToReservar()">
                <i class="bi bi-calendar-plus"></i> Agendar Nueva Cita
            </button>
        </div>
    @endforelse
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
    <div class="col-lg-4 col-md-6 servicio-container" 
         data-categoria="{{ strtolower($servicio->categoria) }}"
         data-id="{{ $servicio->idServicio }}">
        <div class="list-item-custom servicio-item" 
             style="cursor: pointer; transition: all 0.3s;" 
             onclick="seleccionarServicio(event,
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
    <button type="button" 
            class="btn btn-premium" 
            id="btnCancelarCita"
            onclick="cancelarCitaModal()">
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

// Obtener CSRF token
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

// ✅ PASAR DATOS DEL COMBO DESDE BLADE A JAVASCRIPT
const comboData = @json($comboData ?? null);

// ========================================
// VARIABLES GLOBALES
// ========================================
let reservaData = {
    servicios: [],
    detalles: {},
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
// ========================================
// DEBUG: Verificar datos recibidos
// ========================================
console.log('🔍 DEBUGGING COMBO:');
console.log('- comboId desde URL:', '{{ $comboSeleccionado }}');
console.log('- comboData desde Blade:', comboData);
console.log('- reservaData.comboId:', reservaData.comboId);

if (comboData) {
    console.log('✅ Combo Data válido:');
    console.log('  - ID:', comboData.idCombo);
    console.log('  - Nombre:', comboData.nombre);
    console.log('  - Servicios:', comboData.servicios.length);
    comboData.servicios.forEach((s, i) => {
        console.log(`  ${i+1}. ${s.nombre} (ID: ${s.idServicio})`);
    });
} else {
    console.log('⚠️ No hay combo data');
}


console.log('🎯 Datos iniciales:', {
    promocion: reservaData.promocion,
    comboId: reservaData.comboId,
    comboData: comboData
});

// ========================================
// SCRIPT DE CARGA INICIAL DE CITAS
// ========================================

// ========================================
// INICIALIZACIÓN
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    console.log('📋 Inicializando vista de citas...');
    
    // 1️⃣ Cargar datos del usuario
    cargarDatosUsuario();
    
    // 2️⃣ Aplicar promoción si viene pre-aplicada
    if (reservaData.promocion) {
        const promoInput = document.getElementById('codigoPromocion');
        if (promoInput) {
            promoInput.value = reservaData.promocion;
            setTimeout(() => { validarPromocion(); }, 500);
        }
    }
    
    // 3️⃣ ✅ CARGAR COMBO Y SALTAR AL PASO 2 SI VIENE PRE-SELECCIONADO
    if (reservaData.comboId && comboData) {
        console.log('✅ Combo detectado, cargando automáticamente...');
        cargarComboAutomaticamente(comboData);
    }
    
    // 4️⃣ Inicializar fecha mínima (hoy)
    const fechaInput = document.getElementById('fechaCita');
    if (fechaInput) {
        const hoy = new Date().toISOString().split('T')[0];
        fechaInput.min = hoy;
    }
    
    console.log('✅ Inicialización completa');
});

// ✅ FUNCIÓN PARA CARGAR COMBO AUTOMÁTICAMENTE
// ✅ FUNCIÓN PARA CARGAR COMBO AUTOMÁTICAMENTE
function cargarComboAutomaticamente(combo) {
    if (!combo || !combo.servicios) {
        console.error('❌ Combo inválido:', combo);
        return;
    }
    
    console.log('🎁 Cargando combo:', combo.nombre);
    console.log('📦 Servicios a cargar:', combo.servicios);
    
    // Limpiar selección previa
    reservaData.servicios = [];
    reservaData.detalles = {};
    reservaData.comboId = combo.idCombo;
    
    let serviciosMarcados = 0;
    
    // Agregar servicios del combo a reservaData
    combo.servicios.forEach(servicio => {
        console.log('➕ Procesando servicio:', servicio.nombre, 'ID:', servicio.idServicio);
        
        // Agregar al array de servicios
        reservaData.servicios.push({
            id: servicio.idServicio,
            nombre: servicio.nombre,
            duracion: servicio.duracionBase,
            precio: servicio.precioBase
        });
        
        // Marcar visualmente en la UI
        const contenedor = document.querySelector(`.servicio-container[data-id="${servicio.idServicio}"]`);
        console.log('🔍 Buscando contenedor para servicio ID:', servicio.idServicio, '→', contenedor ? 'Encontrado ✅' : 'No encontrado ❌');
        
        if (contenedor) {
            contenedor.classList.add('seleccionado');
            const item = contenedor.querySelector('.list-item-custom');
            if (item) {
                item.classList.add('selected');
            }
            serviciosMarcados++;
            console.log('✅ Servicio marcado visualmente:', servicio.nombre);
        } else {
            console.warn('⚠️ No se encontró contenedor para servicio ID:', servicio.idServicio);
        }
    });
    
    console.log(`📊 Servicios agregados a reservaData: ${reservaData.servicios.length}`);
    console.log(`✨ Servicios marcados visualmente: ${serviciosMarcados}`);
    
    // ✅ BLOQUEAR TODOS LOS SERVICIOS NO SELECCIONADOS
    bloquearServiciosNoSeleccionados();
    
    // Actualizar resumen y calcular totales
    actualizarResumenServicios();
    calcularTotales();
    
    // Mostrar alerta informativa
    const serviciosNombres = combo.servicios.map(s => '• ' + s.nombre).join('\n');
    alert(`✨ Combo Seleccionado: ${combo.nombre}\n\n` +
          `📦 Incluye:\n${serviciosNombres}\n\n` +
          `💰 Precio Combo: $${combo.precioCombo}\n` +
          `💎 Precio Regular: $${combo.precioRegular}\n` +
          `🎉 Ahorro: $${combo.ahorro}\n\n` +
          `⚠️ Los servicios del combo no pueden modificarse.\n` +
          `Continúa al siguiente paso cuando estés listo.`);
    
    console.log('✅ Combo cargado completamente');
}

// ✅ BLOQUEAR SERVICIOS NO SELECCIONADOS (MODO COMBO)
function bloquearServiciosNoSeleccionados() {
    console.log('🔒 Bloqueando servicios no incluidos en el combo...');
    
    const todosContenedores = document.querySelectorAll('.servicio-container');
    
    todosContenedores.forEach(contenedor => {
        const servicioId = parseInt(contenedor.dataset.id);
        const estaEnCombo = reservaData.servicios.some(s => s.id === servicioId);
        
        if (!estaEnCombo) {
            // No está en el combo, bloquear
            contenedor.classList.add('bloqueado');
            const item = contenedor.querySelector('.list-item-custom');
            if (item) {
                item.style.opacity = '0.4';
                item.style.cursor = 'not-allowed';
                item.style.pointerEvents = 'none';
            }
        } else {
            // Está en el combo, marcar como bloqueado pero visible
            contenedor.classList.add('combo-fijo');
            const item = contenedor.querySelector('.list-item-custom');
            if (item) {
                item.style.cursor = 'not-allowed';
                item.style.pointerEvents = 'none';
            }
        }
    });
    
    // Deshabilitar búsqueda y filtros
    const busqueda = document.getElementById('buscarServicioReserva');
    if (busqueda) {
        busqueda.disabled = true;
        busqueda.placeholder = '🔒 Combo preseleccionado - Búsqueda deshabilitada';
    }
    
    // Deshabilitar botones de filtro
    const botonesFiltro = document.querySelectorAll('[onclick^="filtrarPorCategoria"]');
    botonesFiltro.forEach(btn => {
        btn.disabled = true;
        btn.classList.add('disabled');
    });
    
    console.log('✅ Servicios bloqueados');
}

// Función para cargar combo automáticamente
function precargarCombo(comboId) {
    // Buscar combo en la variable que Blade ya pasa a la vista
    // serviciosCombo viene de tu controlador: collection de servicios del combo
const combo = combos.find(c => c.idCombo == comboId); // o usa $serviciosCombo directamente
    if (!combo) return;

    // Limpiar selección anterior
    reservaData.servicios = [];

    // Recorrer servicios del combo y agregarlos a reservaData.servicios
    combo.servicios.forEach(servicio => {
        reservaData.servicios.push({
            id: servicio.idServicio,
            nombre: servicio.nombre,
            duracion: servicio.duracionBase,
            precio: servicio.precioBase
        });

        // Marcar visualmente como seleccionado en la lista de servicios
        const contenedor = document.querySelector(`.servicio-container[data-id='${servicio.idServicio}']`);
        if (contenedor) {
            contenedor.classList.add('seleccionado');
            const item = contenedor.querySelector('.list-item-custom');
            if (item) item.classList.add('selected');
        }
    });

    // Actualizar resumen y totales
    actualizarResumenServicios();
    calcularTotales();

    // Avanzar al paso 2 automáticamente
    continuarAFechaHora();
}

// Función para cargar combo automáticamente
function cargarComboYSaltar(combo) {
    if (!combo || !combo.servicios) {
        console.warn('Combo o servicios indefinidos');
        return;
    }

    // Limpiar cualquier selección previa
    reservaData.servicios = [];
    reservaData.detalles = {};
    reservaData.comboId = combo.idCombo;

    combo.servicios.forEach(serv => {
        // Agregar al array global
        reservaData.servicios.push({
            id: serv.idServicio,
            nombre: serv.nombre,
            duracion: serv.duracionBase,
            precio: serv.precioBase,
            requiere_largo_cabello: serv.requiere_largo_cabello,
            requiere_tinturado_previo: serv.requiere_tinturado_previo,
            requiere_retiro_esmalte: serv.requiere_retiro_esmalte,
            requiere_estilizado: serv.requiere_estilizado
        });

        // Marcar visualmente como seleccionado
        const contenedor = document.querySelector(`.servicio-container[data-id='${servicio.idServicio}']`);
        contenedor?.classList.add('seleccionado');

        const item = contenedor?.querySelector('.list-item-custom');
        item?.classList.add('selected');
    });

    // Actualizar resumen y totales
    actualizarResumenServicios();
    calcularTotales();

    // Saltar al paso 2 automáticamente
    continuarAFechaHora();
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
function seleccionarServicio(event, id, nombre, duracion, precio) {
    if (!event) return;

    // ✅ BLOQUEAR SI HAY COMBO ACTIVO
    if (reservaData.comboId) {
        alert('⚠️ No puedes modificar los servicios de un combo.\n\n' +
              'Si deseas seleccionar servicios individuales, cancela el combo primero usando el botón "Cancelar Combo".');
        return;
    }

    const contenedor = event.currentTarget.closest('.servicio-container');
    if (!contenedor) {
        console.error('❌ No se encontró contenedor del servicio');
        return;
    }

    // Resto del código permanece igual...
    contenedor.classList.toggle('seleccionado');

    const index = reservaData.servicios.findIndex(s => s.id === id);

    if (contenedor.classList.contains('seleccionado')) {
        if (index === -1) {
            reservaData.servicios.push({ id, nombre, duracion, precio });
            console.log('✅ Servicio agregado:', nombre);
        }
    } else {
        if (index > -1) {
            reservaData.servicios.splice(index, 1);
            console.log('➖ Servicio removido:', nombre);
        }
    }

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
    // ✅ BLOQUEAR SI HAY COMBO ACTIVO
    if (reservaData.comboId) {
        alert('⚠️ No puedes remover servicios de un combo.\n\n' +
              'Si deseas seleccionar servicios individuales, cancela el combo primero.');
        return;
    }
    
    console.log('🗑️ Removiendo servicio:', id);
    
    const index = reservaData.servicios.findIndex(s => s.id === id);
    if (index > -1) {
        reservaData.servicios.splice(index, 1);
        delete reservaData.detalles[id];
        
        // Actualizar UI
        const contenedor = document.querySelector(`.servicio-container[data-id="${id}"]`);
        if (contenedor) {
            contenedor.classList.remove('seleccionado');
            const item = contenedor.querySelector('.list-item-custom');
            if (item) {
                item.classList.remove('selected');
            }
        }
        
        console.log('✅ Servicio removido. Servicios restantes:', reservaData.servicios.length);
        
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
              `Fecha: ${reservaData.fecha ? '✓' : '✗'}\n` +
              `Hora: ${reservaData.hora ? '✓' : '✗'}\n` +
              `Estilista: ${reservaData.estilistaId ? '✓' : '✗'}`);
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
            estilista_id: reservaData.estilistaId,
            combo_id: reservaData.comboId
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
            // Mostrar mensaje de éxito
            alert(`✅ ${data.message}\n\n` +
                  `📋 Código de cita: #${data.cita.id}\n` +
                  `📅 Fecha: ${data.cita.fecha}\n` +
                  `⏰ Hora: ${data.cita.hora}\n` +
                  `⏱️ Duración: ${data.cita.duracion_total} minutos\n` +
                  `💰 Total: $${data.cita.precio_final}\n\n` +
                  `Te esperamos! 🎉`);
            
            // ✅ LIMPIAR PARÁMETROS DE URL Y RECARGAR
            console.log('🧹 Limpiando URL y recargando...');
            
            // Opción 1: Redirigir a URL limpia (RECOMENDADO)
            window.location.href = '{{ route("cliente.citasCli") }}';
            
            // Opción 2: Si quieres usar history API (sin recargar)
            // window.history.replaceState({}, document.title, '{{ route("cliente.citasCli") }}');
            // setTimeout(() => { location.reload(); }, 1500);
            
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
    const icon = document.getElementById('iconToggleCitas');
    if (seccion.style.display === 'none' || seccion.style.display === '') {
        seccion.style.display = 'block';
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-up');
    } else {
        seccion.style.display = 'none';
        icon.classList.remove('bi-chevron-up');
        icon.classList.add('bi-chevron-down');
    }
}

function filtrarCitasPorEstado(estado) {
    const citas = document.querySelectorAll('.cita-item');
    citas.forEach(cita => {
        if (estado === 'todas' || cita.dataset.estado === estado) {
            cita.style.display = 'block';
        } else {
            cita.style.display = 'none';
        }
    });
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

// ========================================
// FUNCIONES PARA GESTIÓN DE CITAS
// ========================================

async function verDetalleCita(idCita) {
    console.log('👁️ Cargando detalle de cita:', idCita);
    
    try {
        const response = await fetch(`/cliente/cita/${idCita}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });
        
        const data = await response.json();
        console.log('📥 Datos de cita recibidos:', data);
        
        if (data.success) {
            const cita = data.cita;
            
            // === Cargar información principal ===
            document.getElementById('modalServicioNombre').textContent = 
                cita.servicios.map(s => s.nombre).join(', ');
            
            // Estado con badge dinámico
            const estadoBadge = document.getElementById('modalEstadoBadge');
            estadoBadge.textContent = cita.estado;
            estadoBadge.className = 'badge';
            
            switch(cita.estado) {
                case 'PENDIENTE':
                    estadoBadge.classList.add('bg-warning', 'text-dark');
                    break;
                case 'CONFIRMADA':
                    estadoBadge.classList.add('bg-info');
                    break;
                case 'EN_PROCESO':
                    estadoBadge.classList.add('bg-primary');
                    break;
                case 'COMPLETADA':
                    estadoBadge.classList.add('bg-success');
                    break;
                case 'CANCELADA':
                    estadoBadge.classList.add('bg-danger');
                    break;
            }
            
            document.getElementById('modalCodigoCita').textContent = `BR-${cita.idCita}`;
            
            // Calcular precio total
            const precioTotal = cita.servicios.reduce((sum, s) => sum + parseFloat(s.precioBase), 0);
            let precioFinal = precioTotal;
            
            // Si hay promoción, calcular descuento
            if (cita.promocion) {
                let descuento = 0;
                if (cita.promocion.tipoDescuento === 'porcentaje') {
                    descuento = precioTotal * (cita.promocion.valorDescuento / 100);
                } else {
                    descuento = cita.promocion.valorDescuento;
                }
                precioFinal = precioTotal - descuento;
            }
            
            document.getElementById('modalPrecio').textContent = `$${precioFinal.toFixed(2)}`;
            
            // === Fecha y hora ===
            const fecha = new Date(cita.fecha + 'T00:00:00');
            const fechaFormateada = fecha.toLocaleDateString('es-SV', { 
                weekday: 'short', 
                day: '2-digit', 
                month: 'short', 
                year: 'numeric' 
            });
            const horaFormateada = cita.hora.substring(0, 5);
            
            document.getElementById('modalFechaHora').textContent = 
                `${fechaFormateada} - ${horaFormateada}`;
            
            // === Duración total ===
            const duracionTotal = cita.servicios.reduce((sum, s) => sum + s.duracionBase, 0);
            document.getElementById('modalDuracion').textContent = `${duracionTotal} minutos`;
            
            // === Estilista ===
            document.getElementById('modalEstilista').textContent = 
                `${cita.estilista.nombre} ${cita.estilista.apellido}`;
            
            // === Configurar botones del modal según estado ===
            configurarBotonesModal(cita);
            
            // Mostrar modal
            const modal = new bootstrap.Modal(document.getElementById('modalDetalleCita'));
            modal.show();
            
        } else {
            alert('❌ Error: ' + data.message);
        }
        
    } catch (error) {
        console.error('❌ Error al cargar cita:', error);
        alert('❌ Error al cargar el detalle de la cita. Por favor intenta de nuevo.');
    }
}

function configurarBotonesModal(cita) {
    const btnCancelar = document.getElementById('btnCancelarCita');
    
    // Ocultar/mostrar botón cancelar según estado
    if (cita.estado === 'COMPLETADA' || cita.estado === 'CANCELADA') {
        btnCancelar.style.display = 'none';
    } else {
        btnCancelar.style.display = 'inline-block';
        btnCancelar.onclick = () => cancelarCitaModal(cita.idCita);
    }
}

async function confirmarAsistenciaCita(idCita) {
    console.log('✅ Confirmando asistencia a cita:', idCita);
    
    if (!confirm('¿Deseas confirmar tu asistencia a esta cita?')) {
        return;
    }
    
    try {
        const response = await fetch(`/cliente/cita/${idCita}/confirmar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        console.log('📥 Respuesta:', data);
        
        if (data.success) {
            alert('✅ ' + data.message);
            // Recargar la página para mostrar el nuevo estado
            location.reload();
        } else {
            alert('❌ ' + data.message);
        }
        
    } catch (error) {
        console.error('❌ Error:', error);
        alert('❌ Error al confirmar la cita. Por favor intenta de nuevo.');
    }
}

async function cancelarCitaModal(idCita) {
    console.log('❌ Cancelando cita:', idCita);
    
    if (!confirm('⚠️ ¿Estás seguro de que deseas cancelar esta cita?\n\n' +
                 'Recuerda que debes cancelar con al menos 24 horas de anticipación.\n\n' +
                 'Esta acción no se puede deshacer.')) {
        return;
    }
    
    try {
        const response = await fetch(`/cliente/cita/${idCita}/cancelar`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        });
        
        const data = await response.json();
        console.log('📥 Respuesta:', data);
        
        if (data.success) {
            alert('✅ ' + data.message);
            
            // Cerrar modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalDetalleCita'));
            if (modal) {
                modal.hide();
            }
            
            // Recargar la página para mostrar el nuevo estado
            setTimeout(() => {
                location.reload();
            }, 500);
        } else {
            alert('❌ ' + data.message);
        }
        
    } catch (error) {
        console.error('❌ Error:', error);
        alert('❌ Error al cancelar la cita. Por favor intenta de nuevo.');
    }
}

// Función auxiliar para modificar cita (puedes implementarla después)
function modificarCitaModal() {
    alert('⚠️ Función en desarrollo.\n\nPor favor contacta al salón para modificar tu cita:\n📞 (503) 2222-3333');

}

</script>
<style>
.servicio-container.seleccionado .list-item-custom {
    border: 3px solid var(--dorado-palido) !important;
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(255, 248, 240, 0.9)) !important;
    box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
    transform: scale(1.03);
}

.servicio-container.seleccionado::after {
    content: '✓';
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--dorado-palido);
    color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
    z-index: 10;
}

/* ✅ ESTILOS PARA SERVICIOS BLOQUEADOS */
.servicio-container.bloqueado {
    opacity: 0.4;
    pointer-events: none;
}

.servicio-container.combo-fijo::after {
    content: '🔒';
    background: var(--borgona);
}

.servicio-container.combo-fijo .list-item-custom {
    border: 3px solid var(--borgona) !important;
    background: linear-gradient(135deg, rgba(139, 64, 73, 0.15), rgba(255, 248, 240, 0.9)) !important;
}

.servicio-container {
    position: relative;
}

.servicio-item {
    transition: all 0.3s ease;
}

.servicio-item:hover:not([style*="pointer-events: none"]) {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}
</style>
</body>

</html>