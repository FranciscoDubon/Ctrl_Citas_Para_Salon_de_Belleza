<!DOCTYPE html>
<html lang="es">
    @php
$promoSeleccionada = request()->query('promo', '');
@endphp


<head>
    <meta charset="UTF-8">
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
            <a href="{{ route('cliente.dashboardCli') }}" class="menu-item">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
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
                <div class="user-avatar">M</div>
                <span class="user-name">María García - Cliente</span>
            </div>
        </div>
    </header>


    <!-- ============================================
         MAIN CONTENT (CONTENIDO PRINCIPAL)
         ============================================ -->
    <main class="main-content">

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
                        <div class="col-md-3 text-center" id="step1">
                            <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: var(--borgona); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-scissors" style="color: white; font-size: 1.5rem;"></i>
                            </div>
                            <h6 style="color: var(--borgona); font-weight: 700;">1. Servicio</h6>
                            <p style="margin: 0; font-size: 0.85rem; opacity: 0.7;">Selecciona el servicio</p>
                        </div>
                        <div class="col-md-3 text-center" id="step2" style="opacity: 0.4;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: var(--rosa-empolvado); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calendar3" style="color: var(--borgona); font-size: 1.5rem;"></i>
                            </div>
                            <h6 style="color: var(--borgona); font-weight: 700;">2. Fecha y Hora</h6>
                            <p style="margin: 0; font-size: 0.85rem; opacity: 0.7;">Elige tu horario</p>
                        </div>
                        <div class="col-md-3 text-center" id="step3" style="opacity: 0.4;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: var(--rosa-empolvado); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-circle" style="color: var(--borgona); font-size: 1.5rem;"></i>
                            </div>
                            <h6 style="color: var(--borgona); font-weight: 700;">3. Estilista</h6>
                            <p style="margin: 0; font-size: 0.85rem; opacity: 0.7;">Selecciona tu estilista</p>
                        </div>
                        <div class="col-md-3 text-center" id="step4" style="opacity: 0.4;">
                            <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: var(--rosa-empolvado); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-check-circle" style="color: var(--borgona); font-size: 1.5rem;"></i>
                            </div>
                            <h6 style="color: var(--borgona); font-weight: 700;">4. Confirmación</h6>
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
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorCategoria('unas')">Uñas</button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorCategoria('facial')">Facial</button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorCategoria('combos')">Combos</button>
                    </div>

                    <div class="row g-3" id="listaServicios">

                        <!-- Servicio Seleccionable 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom servicio-item" style="cursor: pointer; transition: all 0.3s;" onclick="seleccionarServicio(1, 'Corte de Cabello', 30, 15.00)">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                    <i class="bi bi-scissors"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Corte de Cabello</h6>
                                    <p><i class="bi bi-clock"></i> 30 min | <strong style="color: var(--dorado-palido);">$15.00</strong></p>
                                    <small style="color: var(--dorado-palido);">Tu precio VIP: $13.50</small>
                                </div>
                            </div>
                        </div>

                        <!-- Servicio Seleccionable 2 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom servicio-item" style="cursor: pointer; transition: all 0.3s;" onclick="seleccionarServicio(2, 'Tinte Completo', 90, 40.00)">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                    <i class="bi bi-palette"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Tinte Completo</h6>
                                    <p><i class="bi bi-clock"></i> 90 min | <strong style="color: var(--dorado-palido);">$40.00</strong></p>
                                    <small style="color: var(--dorado-palido);">Tu precio VIP: $36.00</small>
                                </div>
                            </div>
                        </div>

                        <!-- Servicio Seleccionable 3 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom servicio-item" style="cursor: pointer; transition: all 0.3s;" onclick="seleccionarServicio(3, 'Manicure + Pedicure', 75, 25.00)">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                    <i class="bi bi-hand-index-thumb"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Manicure + Pedicure</h6>
                                    <p><i class="bi bi-clock"></i> 75 min | <strong style="color: var(--dorado-palido);">$25.00</strong></p>
                                    <small style="color: var(--dorado-palido);">Tu precio VIP: $22.50</small>
                                </div>
                            </div>
                        </div>

                        <!-- Servicio Seleccionable 4 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom servicio-item" style="cursor: pointer; transition: all 0.3s;" onclick="seleccionarServicio(4, 'Tratamiento Capilar', 50, 50.00)">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--champagne), var(--champagne-light));">
                                    <i class="bi bi-stars"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Tratamiento Capilar</h6>
                                    <p><i class="bi bi-clock"></i> 50 min | <strong style="color: var(--dorado-palido);">$50.00</strong></p>
                                    <small style="color: var(--dorado-palido);">Tu precio VIP: $45.00</small>
                                </div>
                            </div>
                        </div>

                        <!-- Servicio Seleccionable 5 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom servicio-item" style="cursor: pointer; transition: all 0.3s;" onclick="seleccionarServicio(5, 'Limpieza Facial', 60, 35.00)">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                    <i class="bi bi-brilliance"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Limpieza Facial</h6>
                                    <p><i class="bi bi-clock"></i> 60 min | <strong style="color: var(--dorado-palido);">$35.00</strong></p>
                                    <small style="color: var(--dorado-palido);">Tu precio VIP: $31.50</small>
                                </div>
                            </div>
                        </div>

                        <!-- Servicio Seleccionable 6 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom servicio-item" style="cursor: pointer; transition: all 0.3s;" onclick="seleccionarServicio(6, 'Peinado Especial', 60, 30.00)">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                    <i class="bi bi-gem"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Peinado Especial</h6>
                                    <p><i class="bi bi-clock"></i> 60 min | <strong style="color: var(--dorado-palido);">$30.00</strong></p>
                                    <small style="color: var(--dorado-palido);">Tu precio VIP: $27.00</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- RESTO DE PASOS (Paso 2, 3, 4, 5) - MANTENER IGUAL QUE ANTES -->
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
        // FUNCIONES PARA MIS CITAS ACTUALES
        // ========================================

        // Toggle mostrar/ocultar sección de citas
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

        // Filtrar citas por estado
        function filtrarCitasPorEstado(estado) {
            console.log('Filtrar citas por estado:', estado);
            // TODO: En producción, filtrar dinámicamente las citas mostradas
            alert('Filtrando citas por: ' + estado);
        }

        // Ver detalle de cita en modal
        function verDetalleCita(citaId) {
            console.log('Ver detalle de cita:', citaId);
            // TODO: Cargar datos específicos de la cita desde array o backend simulado

            // Simulación de datos por citaId
            const citas = {
                1: {
                    nombre: 'Limpieza Facial Profunda',
                    estado: 'Pendiente',
                    codigo: 'BR-2024-00245',
                    precio: '$31.50',
                    fechaHora: 'Lun, 04 Nov 2024 - 10:00 AM',
                    duracion: '60 minutos',
                    estilista: 'Laura Gómez Ortiz'
                },
                2: {
                    nombre: 'Corte de Cabello',
                    estado: 'Confirmada',
                    codigo: 'BR-2024-00278',
                    precio: '$13.50',
                    fechaHora: 'Vie, 08 Nov 2024 - 03:00 PM',
                    duracion: '30 minutos',
                    estilista: 'Ana López García'
                },
                3: {
                    nombre: 'Manicure + Pedicure',
                    estado: 'Completada',
                    codigo: 'BR-2024-00189',
                    precio: '$22.50',
                    fechaHora: 'Mié, 30 Oct 2024 - 11:00 AM',
                    duracion: '75 minutos',
                    estilista: 'Sofía Ramírez Cruz'
                }
            };

            const cita = citas[citaId];
            if (cita) {
                document.getElementById('modalServicioNombre').textContent = cita.nombre;
                document.getElementById('modalEstadoBadge').textContent = cita.estado;
                document.getElementById('modalCodigoCita').textContent = cita.codigo;
                document.getElementById('modalPrecio').textContent = cita.precio;
                document.getElementById('modalFechaHora').textContent = cita.fechaHora;
                document.getElementById('modalDuracion').textContent = cita.duracion;
                document.getElementById('modalEstilista').textContent = cita.estilista;
            }
        }

        // Confirmar asistencia a cita
        function confirmarAsistenciaCita(citaId) {
            console.log('Confirmar asistencia cita:', citaId);
            if (confirm('¿Confirmas tu asistencia a esta cita?')) {
                alert('✓ Asistencia confirmada exitosamente.\n\nTe hemos enviado un recordatorio por correo.');
                // TODO: Actualizar estado de la cita
                location.reload();
            }
        }

        // Mostrar opciones adicionales de cita
        function mostrarOpcionesCita(citaId) {
            console.log('Opciones de cita:', citaId);
            const opciones = confirm('¿Qué deseas hacer?\n\nOK = Modificar\nCancelar = Cancelar Cita');

            if (opciones) {
                modificarCita(citaId);
            } else {
                cancelarCita(citaId);
            }
        }

        // Agregar al calendario
        function agregarCalendario(citaId) {
            console.log('Agregar al calendario:', citaId);
            alert('✓ Función: Descargar archivo .ics para agregar a Google Calendar, Outlook, etc.');
            // TODO: Generar archivo .ics y descargar
        }

        // Reservar otra vez (usar misma configuración)
        function reservarOtraVez(citaId) {
            console.log('Reservar otra vez:', citaId);
            alert('Redirigiendo al formulario de reserva con los mismos datos de esta cita...');
            // TODO: Pre-llenar formulario con datos de la cita anterior
            scrollToReservar();
        }

        // Modificar cita desde modal
        function modificarCitaModal() {
            alert('Función: Modificar cita\n\nPermite cambiar fecha, hora o estilista.');
            // TODO: Abrir formulario de modificación
        }

        // Cancelar cita desde modal
        function cancelarCitaModal() {
            if (confirm('¿Estás segura de que deseas cancelar esta cita?\n\nEsta acción no se puede deshacer.')) {
                alert('✓ Cita cancelada exitosamente.\n\nTe hemos enviado un correo de confirmación.');
                // TODO: Actualizar estado de la cita a "cancelada"
                location.reload();
            }
        }

        // Modificar cita
        function modificarCita(citaId) {
            console.log('Modificar cita:', citaId);
            alert('Función: Modificar cita ' + citaId + '\n\nAbrirá formulario para cambiar fecha, hora o estilista.');
            // TODO: Abrir modal o vista de modificación
        }

        // Cancelar cita
        function cancelarCita(citaId) {
            console.log('Cancelar cita:', citaId);
            if (confirm('¿Estás segura de que deseas cancelar esta cita?')) {
                alert('✓ Cita cancelada exitosamente.');
                // TODO: Actualizar estado en backend
                location.reload();
            }
        }

        // Scroll suave a sección de reservar
        function scrollToReservar() {
            document.getElementById('seccionReservar').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        // ========================================
        // RESTO DE FUNCIONES DEL SISTEMA DE RESERVAS
        // (Mantener todas las funciones anteriores)
        // ========================================

        // Variables globales
        let reservaData = {
            servicioId: null,
            servicioNombre: '',
            duracion: 0,
            precio: 0,
            precioVIP: 0,
            fecha: '',
            hora: '',
            estilistaId: null,
            estilista: '',
            promocion: '',
            descuentoPromocion: 0,
            notas: ''
        };

        // (Resto del código JavaScript anterior permanece igual)
        // ... todas las demás funciones de reserva ...
    </script>
</body>

</html>