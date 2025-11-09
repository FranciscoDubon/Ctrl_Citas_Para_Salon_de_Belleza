<!DOCTYPE html>
<html lang="es">
@php
    use Carbon\Carbon;
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas Estilista | Salón de Belleza</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('css/global-styles.css') }}">
</head>
<body>
    
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <h3><i class="bi bi-scissors"></i> BeautySalon</h3>
            <p>Sistema de Gestión</p>
        </div>
        
        <nav class="sidebar-menu">
            <a href="{{ route('estilista.citasEsti') }}" class="menu-item active">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
        </nav>
    </div>

    <!-- HEADER -->
    <header class="top-header">
        <div class="header-title">
            <h1>Gestión de Citas</h1>
            <p>Administra la programación y el control de las citas del salón.</p>
        </div>
        
        <div class="header-actions">
            <div class="user-info">
                <div class="user-avatar" id="avatarInicial">E</div>
                <span class="user-name" id="nombreCliente">Estilista</span>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        
        <!-- Filtros y Acciones -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card-custom" style="padding: 1rem;">
                    <form method="GET" action="{{ route('estilista.citasEsti') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <label class="form-label" style="margin-bottom: 0.5rem;">
                                    <i class="bi bi-calendar-range"></i> Seleccionar Fecha
                                </label>
                                <input 
                                    type="date" 
                                    class="form-control" 
                                    name="fecha" 
                                    id="fechaAgenda" 
                                    value="{{ $fechaSeleccionada }}"
                                >
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-gold w-100">
                                    <i class="bi bi-search"></i> Buscar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="d-grid gap-2" style="margin-top: 1.8rem;">
                    <button class="btn btn-premium" onclick="actualizarAgenda()">
                        <i class="bi bi-arrow-clockwise"></i> Actualizar Agenda
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtros por Estado 
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <strong style="color: var(--borgona); margin-right: 0.5rem;">
                            <i class="bi bi-funnel"></i> Filtrar por estado:
                        </strong>
                        <button class="btn btn-sm btn-gold" onclick="filtrarPorEstado('todas')">
                            <i class="bi bi-calendar-check"></i> Todas ({{ $contadores['todas'] }})
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorEstado('pendientes')">
                            <i class="bi bi-clock-history"></i> Pendientes ({{ $contadores['pendientes'] }})
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorEstado('completadas')">
                            <i class="bi bi-check-circle"></i> Completadas ({{ $contadores['completadas'] }})
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorEstado('en_proceso')">
                            <i class="bi bi-hourglass-split"></i> En Proceso ({{ $contadores['en_proceso'] }})
                        </button>
                    </div>
                </div>
            </div>
        </div>-->

        <!-- KPI Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-4 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $totalCitasHoy }}</h3>
                    <p class="kpi-label">Total Citas Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-calendar-day"></i> {{ Carbon::parse($fechaSeleccionada)->locale('es')->isoFormat('dddd, D MMM') }}
                    </span>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $citasCompletadas }}</h3>
                    <p class="kpi-label">Completadas</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> 
                        {{ $totalCitasHoy > 0 ? round(($citasCompletadas / $totalCitasHoy) * 100) : 0 }}%
                    </span>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $horasTrabajo }}h</h3>
                    <p class="kpi-label">Horas de Trabajo</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-alarm"></i> Estimadas
                    </span>
                </div>
            </div>
        </div>

<!-- Próxima Cita o Mensaje -->
@if($proximaCita)
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido); background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(232, 180, 184, 0.05));">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">
                        <i class="bi bi-bell-fill"></i> Próxima Cita Programada
                    </h5>
                    <div style="font-size: 1.1rem;">
                        @php
                            $horaInicio = Carbon::parse($proximaCita->hora);
                            $duracion = $proximaCita->servicios && $proximaCita->servicios->isNotEmpty() ? $proximaCita->servicios->first()->duracionBase : 0;
                            $horaFin = $horaInicio->copy()->addMinutes($duracion);
                        @endphp
                        <strong style="color: var(--dorado-palido); font-size: 1.5rem;">
                            {{ $horaInicio->format('h:i A') }} - {{ $horaFin->format('h:i A') }}
                        </strong>
                        <br>
                        <strong style="color: var(--borgona); font-size: 1.2rem;">
                            <i class="bi bi-person-circle"></i> {{ $proximaCita->cliente->nombre }} {{ $proximaCita->cliente->apellido }}
                        </strong>
                        <br>
                        <i class="bi bi-scissors"></i> 
                        <strong>{{ $proximaCita->servicios && $proximaCita->servicios->isNotEmpty() ? $proximaCita->servicios->first()->nombre : 'Sin servicio' }}</strong> 
                        ({{ $duracion }} min) | 
                        <i class="bi bi-phone"></i> {{ $proximaCita->cliente->telefono }}
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <button class="btn btn-outline-gold w-100" onclick="verDetalleCita({{ $proximaCita->idCita }})">
                        <i class="bi bi-eye"></i> Ver Detalles
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<!-- Mensaje cuando no hay próxima cita -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="alert-custom" style="border-left: 5px solid var(--rosa-empolvado); background: linear-gradient(135deg, rgba(232, 180, 184, 0.1), rgba(250, 248, 246, 0.5));">
            <div class="text-center py-3">
                <i class="bi bi-calendar-check" style="font-size: 3rem; color: var(--borgona); opacity: 0.3;"></i>
                <h5 style="color: var(--borgona); margin-top: 1rem;">
                    No hay más citas pendientes por el momento
                </h5>
                <p style="color: var(--borgona); opacity: 0.7; margin: 0;">
                    ¡Buen trabajo! Todas las citas han sido atendidas o están en proceso.
                </p>
            </div>
        </div>
    </div>
</div>
@endif

        <!-- Agenda Completa -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-list-check"></i>
                        Mi Agenda Completa - {{ Carbon::parse($fechaSeleccionada)->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
                    </h5>
                    
                    <div class="row g-4" id="listaCitas">
                        @forelse($citas as $cita)
                        <div class="col-lg-6">
                            <div class="list-item-custom cita-item" 
                                 data-estado="{{ $cita->estado }}"
                                 style="flex-direction: column; align-items: flex-start; 
                                 @if($cita->estado == 'COMPLETADA') background: rgba(212, 175, 55, 0.05); @endif
                                 @if($cita->estado == 'EN_PROCESO') background: rgba(128, 0, 32, 0.08); border: 3px solid var(--borgona); @endif
                                 @if($cita->estado == 'CONFIRMADA' && $proximaCita && $cita->idCita == $proximaCita->idCita) border: 2px solid var(--dorado-palido); @endif
                                 @if($cita->estado == 'PENDIENTE') background: rgba(232, 180, 184, 0.1); @endif">
                                 
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">
                                            {{ substr($cita->cliente->nombre, 0, 1) }}
                                        </div>
                                        <div>
                                            <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">
                                                {{ $cita->cliente->nombre }} {{ $cita->cliente->apellido }}
                                            </h5>
                                            <p style="margin: 0; font-size: 0.9rem; color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-heart-fill"></i> Cliente
                                            </p>
                                        </div>
                                    </div>
                                    <span class="badge 
                                        @if($cita->estado == 'COMPLETADA') bg-success
                                        @elseif($cita->estado == 'EN_PROCESO') bg-primary
                                        @elseif($cita->estado == 'CONFIRMADA') bg-info
                                        @elseif($cita->estado == 'PENDIENTE') bg-warning text-dark
                                        @else bg-secondary
                                        @endif" style="font-size: 0.9rem;">
                                        @if($cita->estado == 'COMPLETADA') <i class="bi bi-check-circle"></i> Completada
                                        @elseif($cita->estado == 'EN_PROCESO') <i class="bi bi-hourglass-split"></i> En Proceso
                                        @elseif($cita->estado == 'CONFIRMADA') <i class="bi bi-calendar-check"></i> Confirmada
                                        @elseif($cita->estado == 'PENDIENTE') <i class="bi bi-question-circle"></i> Pendiente
                                        @else {{ ucfirst($cita->estado) }}
                                        @endif
                                    </span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Horario
                                                </small>
                                                @php
                                                    $horaInicioCita = Carbon::parse($cita->hora);
                                                    $duracionCita = $cita->servicios && $cita->servicios->isNotEmpty() ? $cita->servicios->first()->duracionBase : 0;
                                                    $horaFinCita = $horaInicioCita->copy()->addMinutes($duracionCita);
                                                @endphp
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">
                                                    {{ $horaInicioCita->format('h:i A') }} - {{ $horaFinCita->format('h:i A') }}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-scissors"></i> Servicio
                                                </small>
                                                <strong style="color: var(--borgona);">
                                                    {{ $cita->servicios && $cita->servicios->isNotEmpty() ? $cita->servicios->first()->nombre : 'Sin servicio' }}
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-phone"></i> Teléfono
                                                </small>
                                                <strong style="color: var(--borgona);">{{ $cita->cliente->telefono }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-currency-dollar"></i> Precio
                                                </small>
                                                @php
                                                    $precioTotal = $cita->servicios && $cita->servicios->isNotEmpty() ? $cita->servicios->first()->precioBase : 0;
                                                @endphp
                                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">${{ number_format($precioTotal, 2) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($cita->notas)
                                <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                    <i class="bi bi-journal-text"></i>
                                    <strong>Notas:</strong><br>
                                    {{ $cita->notas }}
                                </div>
                                @endif

                                <div class="d-flex gap-2 w-100">
                                    @if($cita->estado == 'EN_PROCESO')
                                        <button class="btn btn-premium btn-sm flex-fill" onclick="finalizarCita({{ $cita->idCita }})">
                                            <i class="bi bi-check-circle-fill"></i> Finalizar Servicio
                                        </button>
                                    @elseif($cita->estado == 'PENDIENTE')
                                        <button class="btn btn-premium btn-sm flex-fill" onclick="confirmarAsistencia({{ $cita->idCita }})">
                                            <i class="bi bi-telephone-fill"></i> Confirmar
                                        </button>
                                    @elseif(in_array($cita->estado, ['CONFIRMADA', 'PENDIENTE']))
                                        <button class="btn btn-gold btn-sm flex-fill" onclick="iniciarCita({{ $cita->idCita }})">
                                            <i class="bi bi-play-circle-fill"></i> Iniciar Servicio
                                        </button>
                                    @endif
                                    
                                    <button class="btn btn-outline-gold btn-sm" onclick="verDetalleCita({{ $cita->idCita }})">
                                        <i class="bi bi-eye"></i> Detalles
                                    </button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert-custom">
                                <i class="bi bi-info-circle"></i>
                                No hay citas programadas para esta fecha.
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="main-footer">
        <p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer>

    <!-- MODAL: DETALLE DE CITA -->
    <div class="modal fade" id="modalDetalleCita" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-calendar-check-fill" style="color: var(--dorado-palido);"></i> 
                        Detalle Completo de la Cita
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="contenidoDetalleCita">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Actualizar agenda
        function actualizarAgenda() {
            location.reload();
        }

        // Filtrar por estado
        function filtrarPorEstado(estado) {
            const citas = document.querySelectorAll('.cita-item');
            
            citas.forEach(cita => {
                const estadoCita = cita.dataset.estado;
                
                if (estado === 'todas') {
                    cita.closest('.col-lg-6').style.display = '';
                } else if (estado === 'pendientes') {
                    cita.closest('.col-lg-6').style.display = (estadoCita === 'PENDIENTE' || estadoCita === 'CONFIRMADA') ? '' : 'none';
                } else if (estado === 'completadas') {
                    cita.closest('.col-lg-6').style.display = (estadoCita === 'COMPLETADA') ? '' : 'none';
                } else if (estado === 'en_proceso') {
                    cita.closest('.col-lg-6').style.display = (estadoCita === 'EN_PROCESO') ? '' : 'none';
                }
            });
        }

        // Iniciar cita
        function iniciarCita(citaId) {
            Swal.fire({
                title: '¿Iniciar servicio?',
                text: '¿Deseas marcar esta cita como "En Proceso"?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, iniciar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#800020'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/estilista/citas/${citaId}/iniciar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Servicio iniciado',
                                text: data.mensaje,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            throw new Error(data.error || 'Error desconocido');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'No se pudo iniciar la cita'
                        });
                    });
                }
            });
        }

        // Finalizar cita
        function finalizarCita(citaId) {
            Swal.fire({
                title: '¿Finalizar servicio?',
                text: '¿La cita ha sido completada exitosamente?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, finalizar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/estilista/citas/${citaId}/finalizar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Servicio completado',
                                text: data.mensaje,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            throw new Error(data.error || 'Error desconocido');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'No se pudo finalizar la cita'
                        });
                    });
                }
            });
        }

        // Confirmar asistencia
        function confirmarAsistencia(citaId) {
            Swal.fire({
                title: 'Confirmar asistencia',
                text: '¿El cliente confirmó su asistencia?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#17a2b8'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/estilista/citas/${citaId}/confirmar`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Asistencia confirmada',
                                text: data.mensaje,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 2000);
                        } else {
                            throw new Error(data.error || 'Error desconocido');
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'No se pudo confirmar la asistencia'
                        });
                    });
                }
            });
        }

        // Ver detalle de cita
        function verDetalleCita(citaId) {
            const modal = new bootstrap.Modal(document.getElementById('modalDetalleCita'));
            modal.show();

            fetch(`/estilista/citas/${citaId}/detalle`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(cita => {
                // Combinar fecha y hora
                const fechaHora = new Date(cita.fecha + ' ' + cita.hora);
                const duracion = cita.servicios && cita.servicios.length > 0 ? cita.servicios[0].duracionBase : 0;
                const fechaFin = new Date(fechaHora.getTime() + duracion * 60000);
                const servicio = cita.servicios && cita.servicios.length > 0 ? cita.servicios[0] : null;

                let historialHTML = '';
                if (cita.historial && cita.historial.length > 0) {
                    historialHTML = cita.historial.map(h => {
                        const servicioHistorial = h.servicios && h.servicios.length > 0 ? h.servicios[0] : null;
                        return `
                            <tr>
                                <td>${new Date(h.fecha).toLocaleDateString('es-ES')}</td>
                                <td>${servicioHistorial ? servicioHistorial.nombre : 'N/A'}</td>
                                <td>${servicioHistorial ? servicioHistorial.duracionBase : 0} min</td>
                                <td>$${servicioHistorial ? parseFloat(servicioHistorial.precioBase).toFixed(2) : '0.00'}</td>
                            </tr>
                        `;
                    }).join('');
                } else {
                    historialHTML = '<tr><td colspan="4" class="text-center">No hay historial previo</td></tr>';
                }

                document.getElementById('contenidoDetalleCita').innerHTML = `
                    <!-- Información del Cliente -->
                    <div class="premium-card mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="list-avatar me-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                        ${cita.cliente.nombre.charAt(0)}
                                    </div>
                                    <div>
                                        <h3 style="margin: 0;">${cita.cliente.nombre} ${cita.cliente.apellido}</h3>
                                        <p style="margin: 0.5rem 0;">
                                            <span class="badge badge-soft">${cita.historial.length + 1} visitas</span>
                                        </p>
                                        <p style="margin: 0; opacity: 0.9;">
                                            <i class="bi bi-phone"></i> ${cita.cliente.telefono} | 
                                            <i class="bi bi-envelope"></i> ${cita.cliente.email}
                                        </p>
                                        ${cita.cliente.direccion ? `
                                        <p style="margin: 0.25rem 0 0 0; opacity: 0.8;">
                                            <i class="bi bi-geo-alt"></i> ${cita.cliente.direccion}
                                        </p>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="tel:${cita.cliente.telefono}" class="btn btn-outline-gold btn-sm w-100">
                                    <i class="bi bi-telephone"></i> Llamar Cliente
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Detalles de la Cita -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="kpi-card">
                                <div class="kpi-header">
                                    <div class="kpi-icon primary" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                </div>
                                <h3 class="kpi-value" style="font-size: 1.3rem;">${fechaHora.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})}</h3>
                                <p class="kpi-label">Hora de Inicio</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="kpi-card">
                                <div class="kpi-header">
                                    <div class="kpi-icon success" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        <i class="bi bi-hourglass-split"></i>
                                    </div>
                                </div>
                                <h3 class="kpi-value" style="font-size: 1.3rem;">${duracion} min</h3>
                                <p class="kpi-label">Duración</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="kpi-card">
                                <div class="kpi-header">
                                    <div class="kpi-icon info" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        <i class="bi bi-scissors"></i>
                                    </div>
                                </div>
                                <h3 class="kpi-value" style="font-size: 1rem;">${servicio ? servicio.nombre : 'N/A'}</h3>
                                <p class="kpi-label">Servicio</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="kpi-card">
                                <div class="kpi-header">
                                    <div class="kpi-icon warning" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                </div>
                                <h3 class="kpi-value" style="font-size: 1.5rem; color: var(--dorado-palido);">$${servicio ? parseFloat(servicio.precioBase).toFixed(2) : '0.00'}</h3>
                                <p class="kpi-label">Precio Total</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notas e Información -->
                    <div class="row g-4">
                        ${cita.notas ? `
                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-journal-text"></i> Notas de la Cita
                                </h6>
                                <div class="alert-custom">
                                    <i class="bi bi-exclamation-circle"></i>
                                    ${cita.notas}
                                </div>
                            </div>
                        </div>
                        ` : ''}

                        <div class="col-md-${cita.notas ? '6' : '12'}">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-info-circle"></i> Información de la Cita
                                </h6>
                                <p><strong>Estado:</strong> 
                                    <span class="badge ${
                                        cita.estado === 'COMPLETADA' ? 'bg-success' :
                                        cita.estado === 'EN_PROCESO' ? 'bg-primary' :
                                        cita.estado === 'CONFIRMADA' ? 'bg-info' :
                                        cita.estado === 'PENDIENTE' ? 'bg-warning text-dark' : 'bg-secondary'
                                    }">
                                        ${cita.estado}
                                    </span>
                                </p>
                                <p><strong>Fecha:</strong> ${fechaHora.toLocaleDateString('es-ES', {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'})}</p>
                                <p><strong>Hora de finalización:</strong> ${fechaFin.toLocaleTimeString('es-ES', {hour: '2-digit', minute: '2-digit'})}</p>
                                <p><strong>Duración:</strong> ${duracion} minutos</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-clock-history"></i> Historial con este Cliente
                                </h6>
                                <div class="table-responsive">
                                    <table class="table-custom">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Servicio</th>
                                                <th>Duración</th>
                                                <th>Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${historialHTML}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                document.getElementById('contenidoDetalleCita').innerHTML = `
                    <div class="alert-custom" style="border-left-color: #dc3545;">
                        <i class="bi bi-exclamation-triangle"></i>
                        Error al cargar los detalles de la cita.
                    </div>
                `;
            });
        }

document.addEventListener('DOMContentLoaded', () => {
    const nombre = localStorage.getItem('clienteNombre') || 'Cliente';
    const apellido = localStorage.getItem('clienteApellido') || '';
    const id = localStorage.getItem('clienteId') || '';
    const inicial = nombre.charAt(0).toUpperCase();

    // Insertar nombre completo
    const nombreSpan = document.getElementById('nombreCliente');
    if (nombreSpan) {
        nombreSpan.textContent = `${nombre} ${apellido}`;
    }

    // Insertar inicial como avatar
    const avatarDiv = document.getElementById('avatarInicial');
    if (avatarDiv) {
        avatarDiv.textContent = inicial;
    }
});
    </script>
    
</body>
</html>