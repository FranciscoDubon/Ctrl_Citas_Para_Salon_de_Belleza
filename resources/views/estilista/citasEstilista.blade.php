<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
    
    <!-- ============================================
         SIDEBAR (MENÚ LATERAL)
         ============================================ -->
    <div class="sidebar">
        <!-- Logo del Sistema -->
        <div class="sidebar-logo">
            <h3><i class="bi bi-scissors"></i> BeautySalon</h3>
            <p>Sistema de Gestión</p>
        </div>
        
        <!-- Menú de Navegación -->
        <nav class="sidebar-menu">
            <a href="{{ route('estilista.dashboardEsti') }}" class="menu-item">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('estilista.citasEsti') }}" class="menu-item active">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Gestión de Citas</h1>
            <p>Administra la programación y el control de las citas del salón.</p>
        </div>
        
        <div class="header-actions">
            <!-- Usuario -->
            <div class="user-info">
                <div class="user-avatar">A</div>
                <span class="user-name">Ana López - Estilista</span>
            </div>
        </div>
    </header>

    <!-- ============================================
         MAIN CONTENT (CONTENIDO PRINCIPAL)
         ============================================ -->
    <main class="main-content">
        
        <!-- Filtros y Acciones Rápidas -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label" style="margin-bottom: 0.5rem;">
                                <i class="bi bi-calendar-range"></i> Seleccionar Fecha
                            </label>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="fechaAgenda" 
                                onchange="cargarCitasPorFecha()"
                            >
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-gold w-100" onclick="cargarCitasPorFecha()">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </div>
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

        <!-- Filtros Rápidos por Estado -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <strong style="color: var(--borgona); margin-right: 0.5rem;">
                            <i class="bi bi-funnel"></i> Filtrar por estado:
                        </strong>
                        <button class="btn btn-sm btn-gold" onclick="filtrarPorEstado('todas')">
                            <i class="bi bi-calendar-check"></i> Todas (6)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorEstado('pendientes')">
                            <i class="bi bi-clock-history"></i> Pendientes (3)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorEstado('completadas')">
                            <i class="bi bi-check-circle"></i> Completadas (3)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPorEstado('en_proceso')">
                            <i class="bi bi-hourglass-split"></i> En Proceso (0)
                        </button>
                        
                        <div style="border-left: 2px solid var(--rosa-empolvado); height: 30px; margin: 0 0.5rem;"></div>
                        
                        <button class="btn btn-sm btn-soft" onclick="verCalendario()">
                            <i class="bi bi-calendar3"></i> Ver Calendario
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards - Resumen del Día -->
        <div class="row g-4 mb-4">
            
            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM citas 
            WHERE DATE(fecha_hora) = CURDATE()
            AND estilista_id = [ID_ESTILISTA_AUTENTICADO]
            ================================================
            -->
            <div class="col-xl-4 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">6</h3>
                    <p class="kpi-label">Total Citas Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-calendar-day"></i> Viernes, 31 Oct
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM citas 
            WHERE DATE(fecha_hora) = CURDATE()
            AND estilista_id = [ID_ESTILISTA_AUTENTICADO]
            AND estado = 'completada'
            ================================================
            -->
            <div class="col-xl-4 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">3</h3>
                    <p class="kpi-label">Completadas</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> 50%
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT SUM(s.duracion_minutos) as total 
            FROM citas c
            INNER JOIN servicios s ON c.servicio_id = s.id
            WHERE DATE(c.fecha_hora) = CURDATE()
            AND c.estilista_id = [ID_ESTILISTA_AUTENTICADO]
            ================================================
            -->
            <div class="col-xl-4 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">6.5h</h3>
                    <p class="kpi-label">Horas de Trabajo</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-alarm"></i> Estimadas
                    </span>
                </div>
            </div>
        </div>

        <!-- Próxima Cita Destacada -->
        <!-- 
        ================================================
        TODO BACKEND: Conectar con BD
        ================================================
        CONSULTA SQL:
        SELECT c.*, u.nombre, u.apellido, u.telefono, u.email, s.nombre as servicio, 
               s.duracion_minutos, c.notas
        FROM citas c
        INNER JOIN usuarios u ON c.cliente_id = u.id
        INNER JOIN servicios s ON c.servicio_id = s.id
        WHERE c.estilista_id = [ID_ESTILISTA_AUTENTICADO]
        AND c.fecha_hora >= NOW()
        AND DATE(c.fecha_hora) = CURDATE()
        AND c.estado != 'cancelada'
        ORDER BY c.fecha_hora ASC
        LIMIT 1
        ================================================
        -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido); background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(232, 180, 184, 0.05));">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">
                                <i class="bi bi-bell-fill"></i> Próxima Cita Programada
                            </h5>
                            <div style="font-size: 1.1rem;">
                                <strong style="color: var(--dorado-palido); font-size: 1.5rem;">12:00 PM - 01:30 PM</strong>
                                <br>
                                <strong style="color: var(--borgona); font-size: 1.2rem;">
                                    <i class="bi bi-person-circle"></i> Laura Martínez Díaz
                                </strong>
                                <br>
                                <i class="bi bi-scissors"></i> <strong>Tinte Completo</strong> (90 min) | 
                                <i class="bi bi-phone"></i> (503) 7890-9012 | 
                                <i class="bi bi-envelope"></i> laura.martinez@email.com
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <button class="btn btn-gold mb-2 w-100" onclick="iniciarCita(4)">
                                <i class="bi bi-play-circle"></i> Iniciar Servicio
                            </button>
                            <button class="btn btn-outline-gold w-100" data-bs-toggle="modal" data-bs-target="#modalDetalleCita" onclick="cargarDetalleCita(4)">
                                <i class="bi bi-eye"></i> Ver Detalles
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agenda Completa del Día -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-list-check"></i>
                        Mi Agenda Completa - Viernes, 31 de Octubre 2024
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT c.id, c.fecha_hora, c.estado, c.precio_total, c.notas,
                           u.id as cliente_id, u.nombre as cliente_nombre, 
                           u.apellido as cliente_apellido, u.telefono, u.email, u.direccion,
                           s.id as servicio_id, s.nombre as servicio_nombre, 
                           s.duracion_minutos, s.precio,
                           p.nombre as promocion_nombre, p.codigo_promocional
                    FROM citas c
                    INNER JOIN usuarios u ON c.cliente_id = u.id
                    INNER JOIN servicios s ON c.servicio_id = s.id
                    LEFT JOIN promociones p ON c.promocion_id = p.id
                    WHERE c.estilista_id = [ID_ESTILISTA_AUTENTICADO]
                    AND DATE(c.fecha_hora) = [FECHA_SELECCIONADA]
                    ORDER BY c.fecha_hora ASC
                    ================================================
                    -->
                    <div class="row g-4" id="listaCitas">
                        
                        <!-- Cita 1 - Completada -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: rgba(212, 175, 55, 0.05);">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">M</div>
                                        <div>
                                            <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">María García López</h5>
                                            <p style="margin: 0; font-size: 0.9rem; color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-star-fill"></i> Cliente VIP
                                            </p>
                                        </div>
                                    </div>
                                    <span class="badge bg-success" style="font-size: 0.9rem;">
                                        <i class="bi bi-check-circle"></i> Completada
                                    </span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Horario
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">09:00 AM - 09:30 AM</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-scissors"></i> Servicio
                                                </small>
                                                <strong style="color: var(--borgona);">Corte de Cabello</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-phone"></i> Teléfono
                                                </small>
                                                <strong style="color: var(--borgona);">(503) 7890-1234</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-currency-dollar"></i> Precio
                                                </small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">$15.00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                    <i class="bi bi-journal-text"></i>
                                    <strong>Notas del cliente:</strong><br>
                                    Cliente VIP. Prefiere citas por la tarde. Alérgica a productos con parabenos.
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-outline-gold btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalDetalleCita" onclick="cargarDetalleCita(1)">
                                        <i class="bi bi-eye"></i> Ver Detalles Completos
                                    </button>
                                    <button class="btn btn-soft btn-sm" onclick="verPerfilCliente(1)">
                                        <i class="bi bi-person-circle"></i> Perfil
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cita 2 - Completada -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: rgba(212, 175, 55, 0.05);">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">C</div>
                                        <div>
                                            <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">Carla Hernández Silva</h5>
                                            <p style="margin: 0; font-size: 0.9rem; color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-heart-fill"></i> Cliente Frecuente
                                            </p>
                                        </div>
                                    </div>
                                    <span class="badge bg-success" style="font-size: 0.9rem;">
                                        <i class="bi bi-check-circle"></i> Completada
                                    </span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Horario
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">10:00 AM - 11:00 AM</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-scissors"></i> Servicio
                                                </small>
                                                <strong style="color: var(--borgona);">Peinado Especial</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-phone"></i> Teléfono
                                                </small>
                                                <strong style="color: var(--borgona);">(503) 7890-3456</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-currency-dollar"></i> Precio
                                                </small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">$30.00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                    <i class="bi bi-journal-text"></i>
                                    <strong>Notas:</strong><br>
                                    Cliente tiene evento en la tarde. Peinado semi-recogido estilo romántico.
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-outline-gold btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalDetalleCita">
                                        <i class="bi bi-eye"></i> Ver Detalles Completos
                                    </button>
                                    <button class="btn btn-soft btn-sm" onclick="verPerfilCliente(2)">
                                        <i class="bi bi-person-circle"></i> Perfil
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cita 3 - En Proceso (Actual) -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: rgba(128, 0, 32, 0.08); border: 3px solid var(--borgona);">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">A</div>
                                        <div>
                                            <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">Ana Rodríguez Pérez</h5>
                                            <p style="margin: 0; font-size: 0.9rem; color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-star-fill"></i> Cliente VIP
                                            </p>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary" style="font-size: 0.9rem;">
                                        <i class="bi bi-hourglass-split"></i> En Proceso
                                    </span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--borgona);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Horario
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.2rem;">11:00 AM - 11:50 AM</strong>
                                                <br>
                                                <small style="color: var(--dorado-palido); font-weight: 600;">
                                                    <i class="bi bi-alarm"></i> Termina en 15 min
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--borgona);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-scissors"></i> Servicio
                                                </small>
                                                <strong style="color: var(--borgona);">Tratamiento Capilar</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--borgona);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-phone"></i> Teléfono
                                                </small>
                                                <strong style="color: var(--borgona);">(503) 7890-5678</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--borgona);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-currency-dollar"></i> Precio
                                                </small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">$50.00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem; border-left-color: var(--borgona);">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    <strong>Importante:</strong><br>
                                    Tratamiento de keratina. No lavar cabello por 72 horas después del tratamiento.
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-premium btn-sm flex-fill" onclick="finalizarCita(3)">
                                        <i class="bi bi-check-circle-fill"></i> Finalizar Servicio
                                    </button>
                                    <button class="btn btn-outline-gold btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalleCita">
                                        <i class="bi bi-eye"></i> Detalles
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cita 4 - Próxima (Confirmada) -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; border: 2px solid var(--dorado-palido);">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">L</div>
                                        <div>
                                            <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">Laura Martínez Díaz</h5>
                                            <p style="margin: 0; font-size: 0.9rem; color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-heart-fill"></i> Cliente Frecuente
                                            </p>
                                        </div>
                                    </div>
                                    <span class="badge bg-info" style="font-size: 0.9rem;">
                                        <i class="bi bi-calendar-check"></i> Confirmada
                                    </span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; border: 1px solid var(--dorado-palido);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Horario
                                                </small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">12:00 PM - 01:30 PM</strong>
                                                <br>
                                                <small style="color: var(--borgona); font-weight: 600;">
                                                    <i class="bi bi-bell"></i> En 25 minutos
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-scissors"></i> Servicio
                                                </small>
                                                <strong style="color: var(--borgona);">Tinte Completo</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-phone"></i> Teléfono
                                                </small>
                                                <strong style="color: var(--borgona);">(503) 7890-9012</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-currency-dollar"></i> Precio
                                                </small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">$40.00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem; border-left-color: var(--dorado-palido);">
                                    <i class="bi bi-check-circle"></i>
                                    <strong>Preparación:</strong><br>
                                    Prueba de alergia realizada el 29 Oct - OK. Color: Castaño oscuro con reflejos caoba.
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-gold btn-sm flex-fill" onclick="iniciarCita(4)">
                                        <i class="bi bi-play-circle-fill"></i> Iniciar Servicio
                                    </button>
                                    <button class="btn btn-outline-gold btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalleCita">
                                        <i class="bi bi-eye"></i> Detalles
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cita 5 - Confirmada -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">S</div>
                                        <div>
                                            <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">Sofía Ramírez Castro</h5>
                                            <p style="margin: 0; font-size: 0.9rem; color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-star"></i> Cliente Nuevo
                                            </p>
                                        </div>
                                    </div>
                                    <span class="badge bg-info" style="font-size: 0.9rem;">
                                        <i class="bi bi-calendar-check"></i> Confirmada
                                    </span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Horario
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">02:00 PM - 02:50 PM</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-scissors"></i> Servicio
                                                </small>
                                                <strong style="color: var(--borgona);">Corte + Peinado</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-phone"></i> Teléfono
                                                </small>
                                                <strong style="color: var(--borgona);">(503) 7890-7890</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-currency-dollar"></i> Precio
                                                </small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">$35.00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem; background: rgba(212, 175, 55, 0.08);">
                                    <i class="bi bi-star-fill"></i>
                                    <strong>Primera visita:</strong><br>
                                    Cliente nueva. Ser especialmente atenta y ofrecer recomendaciones personalizadas.
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-outline-gold btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalDetalleCita">
                                        <i class="bi bi-eye"></i> Ver Detalles Completos
                                    </button>
                                    <button class="btn btn-soft btn-sm" onclick="verPerfilCliente(5)">
                                        <i class="bi bi-person-circle"></i> Perfil
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Cita 6 - Pendiente de Confirmación -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: rgba(232, 180, 184, 0.1);">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-3" style="width: 50px; height: 50px; font-size: 1.2rem;">P</div>
                                        <div>
                                            <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">Patricia Gómez Ortiz</h5>
                                            <p style="margin: 0; font-size: 0.9rem; color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-heart"></i> Cliente Regular
                                            </p>
                                        </div>
                                    </div>
                                    <span class="badge bg-warning text-dark" style="font-size: 0.9rem;">
                                        <i class="bi bi-question-circle"></i> Pendiente
                                    </span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Horario
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">04:00 PM - 04:30 PM</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-scissors"></i> Servicio
                                                </small>
                                                <strong style="color: var(--borgona);">Manicure Básico</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-phone"></i> Teléfono
                                                </small>
                                                <strong style="color: var(--borgona);">(503) 7890-1111</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div style="background: white; padding: 0.75rem; border-radius: 8px; border: 1px solid var(--rosa-empolvado);">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-currency-dollar"></i> Precio
                                                </small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">$10.00</strong>
                                                <br>
                                                <span class="badge badge-gold" style="font-size: 0.7rem;">
                                                    <i class="bi bi-gift"></i> 20% OFF
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                    <i class="bi bi-telephone"></i>
                                    <strong>Recordatorio:</strong><br>
                                    Cliente no ha confirmado asistencia. Llamar para confirmar.
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-premium btn-sm flex-fill" onclick="confirmarAsistencia(6)">
                                        <i class="bi bi-telephone-fill"></i> Llamar a Cliente
                                    </button>
                                    <button class="btn btn-outline-gold btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalleCita">
                                        <i class="bi bi-eye"></i> Detalles
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- ============================================
         FOOTER
         ============================================ -->
    <footer class="main-footer">
        <<p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer>

    <!-- ============================================
         MODAL: DETALLE COMPLETO DE LA CITA
         ============================================ -->
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
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Cargar datos completos de la cita
                    ================================================
                    -->
                    
                    <!-- Información del Cliente -->
                    <div class="premium-card mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="list-avatar me-3" style="width: 80px; height: 80px; font-size: 2rem;">M</div>
                                    <div>
                                        <h3 style="margin: 0;">María García López</h3>
                                        <p style="margin: 0.5rem 0;">
                                            <span class="badge bg-success"><i class="bi bi-star-fill"></i> Cliente VIP</span>
                                            <span class="badge badge-soft ms-2">18 visitas</span>
                                        </p>
                                        <p style="margin: 0; opacity: 0.9;">
                                            <i class="bi bi-phone"></i> (503) 7890-1234 | 
                                            <i class="bi bi-envelope"></i> maria.garcia@email.com
                                        </p>
                                        <p style="margin: 0.25rem 0 0 0; opacity: 0.8;">
                                            <i class="bi bi-geo-alt"></i> Col. Escalón, San Salvador
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-soft btn-sm mb-2 w-100" onclick="verPerfilCliente(1)">
                                    <i class="bi bi-person-circle"></i> Ver Perfil Completo
                                </button>
                                <button class="btn btn-outline-gold btn-sm w-100">
                                    <i class="bi bi-telephone"></i> Llamar Cliente
                                </button>
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
                                <h3 class="kpi-value" style="font-size: 1.3rem;">09:00 AM</h3>
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
                                <h3 class="kpi-value" style="font-size: 1.3rem;">30 min</h3>
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
                                <h3 class="kpi-value" style="font-size: 1rem;">Corte Cabello</h3>
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
                                <h3 class="kpi-value" style="font-size: 1.5rem; color: var(--dorado-palido);">$15.00</h3>
                                <p class="kpi-label">Precio Total</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notas e Información Adicional -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-journal-text"></i> Notas del Cliente
                                </h6>
                                <div class="alert-custom">
                                    <i class="bi bi-exclamation-circle"></i>
                                    Cliente VIP. Prefiere citas por la tarde. Alérgica a productos con parabenos. Le gusta el estilo bob clásico.
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-info-circle"></i> Información de la Cita
                                </h6>
                                <p><strong>Estado:</strong> <span class="badge bg-success">Completada</span></p>
                                <p><strong>Fecha:</strong> Viernes, 31 Octubre 2024</p>
                                <p><strong>Hora de finalización:</strong> 09:30 AM</p>
                                <p><strong>Duración real:</strong> 30 minutos</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-clock-history"></i> Historial con este Cliente (Últimas 5 citas)
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
                                            <tr>
                                                <td>15 Oct 2024</td>
                                                <td>Tinte + Tratamiento</td>
                                                <td>120 min</td>
                                                <td>$75.00</td>
                                            </tr>
                                            <tr>
                                                <td>02 Oct 2024</td>
                                                <td>Corte de Cabello</td>
                                                <td>30 min</td>
                                                <td>$15.00</td>
                                            </tr>
                                            <tr>
                                                <td>18 Sep 2024</td>
                                                <td>Corte + Peinado</td>
                                                <td>50 min</td>
                                                <td>$35.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-gold">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        // Establecer fecha actual por defecto
        document.addEventListener('DOMContentLoaded', function() {
            const hoy = new Date().toISOString().split('T')[0];
            document.getElementById('fechaAgenda').value = hoy;
        });

        // Actualizar agenda
        function actualizarAgenda() {
            console.log('Actualizar agenda');
            location.reload();
        }

        // Cargar citas por fecha
        function cargarCitasPorFecha() {
            const fecha = document.getElementById('fechaAgenda').value;
            console.log('Cargar citas para fecha:', fecha);
            alert('Cargando citas del ' + fecha + ' - Conectar con backend');
            // TODO: Hacer petición AJAX para cargar citas
        }

        // Filtrar por estado
        function filtrarPorEstado(estado) {
            console.log('Filtrar por estado:', estado);
            alert('Filtrar citas por estado: ' + estado + ' - Conectar con backend');
            // TODO: Implementar filtrado
        }

        // Ver calendario
        function verCalendario() {
            console.log('Abrir vista de calendario');
            alert('Redirigir a vista de calendario completo');
        }

        // Iniciar cita
        function iniciarCita(citaId) {
            console.log('Iniciar cita:', citaId);
            if (confirm('¿Deseas marcar esta cita como "En Proceso"?')) {
                alert('Cita iniciada - Conectar con backend');
                // TODO: Actualizar estado en BD
                location.reload();
            }
        }

        // Finalizar cita
        function finalizarCita(citaId) {
            console.log('Finalizar cita:', citaId);
            if (confirm('¿La cita ha sido completada exitosamente?')) {
                alert('Cita finalizada - Conectar con backend\nAhora puedes solicitar calificación al cliente');
                // TODO: Actualizar estado en BD
                location.reload();
            }
        }

        // Confirmar asistencia
        function confirmarAsistencia(citaId) {
            console.log('Confirmar asistencia:', citaId);
            alert('Llamar al cliente para confirmar asistencia - Conectar con backend');
            // TODO: Actualizar estado en BD
        }

        // Cargar detalle de cita en modal
        function cargarDetalleCita(citaId) {
            console.log('Cargar detalle de cita:', citaId);
            // TODO: Cargar datos completos desde BD
        }

        // Ver perfil del cliente
        function verPerfilCliente(clienteId) {
            console.log('Ver perfil del cliente:', clienteId);
            alert('Redirigir a perfil completo del cliente - Conectar con backend');
        }
    </script>
    
</body>
</html>