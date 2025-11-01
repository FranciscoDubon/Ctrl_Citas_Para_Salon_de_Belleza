<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Estilista | Salón de Belleza</title>
    
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
         ========================================') }}==== -->
    <div class="sidebar">
        <!-- Logo del Sistema -->
        <div class="sidebar-logo">
            <h3><i class="bi bi-scissors"></i> BeautySalon</h3>
            <p>Sistema de Gestión</p>
        </div>
        
        <!-- Menú de Navegación -->
        <nav class="sidebar-menu">
            <a href="{{ route('estilista.dashboardEsti') }}" class="menu-item active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('estilista.citasEsti') }}" class="menu-item">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('estilista.configEsti') }}" class="menu-item">
                <i class="bi bi-gear"></i> Configuración
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Panel de Recepción</h1>
            <p>Administra las citas y el control de la agenda diaria.</p>
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

    <!-- Botones para redirigir a las siguientes pestañas por que como trabajamos por roles, esto solo se encontraran solo en los dashboards y de ahi se van a subdividir las paginas de cada rol
     todo esto por que como solo trabaje frontend y necesitaba ver como funcionaban xd-->
        <div class="d-flex gap-3">
            <a href="{{ route('logn') }}" class="text-decoration-none" style="color: #e91e63;">Login</a>
            <a href="{{ route('dashboardAdm') }}" class="text-decoration-none" style="color: #e91e63;">Administrador</a>
            <a href="{{ route('recepcionista.dashboardRecep') }}" class="text-decoration-none" style="color: #e91e63;">Recepcionista</a>
            <a href="{{ route('estilista.dashboardEsti') }}" class="text-decoration-none" style="color: #e91e63;">Estilista</a>
            <a href="{{ route('cliente.dashboardCli') }}" class="text-decoration-none" style="color: #e91e63;">Cliente</a>
        </div>
        
        <!-- Selector de Vista -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <strong style="color: var(--borgona); margin-right: 0.5rem;">
                            <i class="bi bi-calendar-range"></i> Ver agenda de:
                        </strong>
                        <button class="btn btn-gold" id="btnHoy" onclick="cambiarVista('hoy')">
                            <i class="bi bi-calendar-day"></i> Hoy
                        </button>
                        <button class="btn btn-outline-gold" id="btnSemana" onclick="cambiarVista('semana')">
                            <i class="bi bi-calendar-week"></i> Esta Semana
                        </button>
                        <button class="btn btn-outline-gold" id="btnMes" onclick="cambiarVista('mes')">
                            <i class="bi bi-calendar-month"></i> Este Mes
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="d-grid gap-2">
                    <button class="btn btn-premium" onclick="actualizarDashboard()">
                        <i class="bi bi-arrow-clockwise"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>

        <!-- Mensaje de Bienvenida -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3><i class="bi bi-sun"></i> ¡Buenos días, Ana!</h3>
                            <p style="margin: 0; font-size: 1.1rem; opacity: 0.9;">
                                Hoy es <strong>Viernes, 31 de Octubre 2024</strong><br>
                                Tienes <strong style="color: var(--dorado-palido);">6 citas programadas</strong> para hoy. ¡Que tengas un excelente día! ✨
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div style="font-size: 3rem; opacity: 0.3;">
                                <i class="bi bi-emoji-smile"></i>
                            </div>
                        </div>
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
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">6</h3>
                    <p class="kpi-label">Mis Citas de Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> 3 completadas
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
            AND fecha_hora > NOW()
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">3</h3>
                    <p class="kpi-label">Citas Pendientes</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-hourglass-split"></i> Por atender
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT SUM(precio_total) as total 
            FROM citas 
            WHERE DATE(fecha_hora) = CURDATE()
            AND estilista_id = [ID_ESTILISTA_AUTENTICADO]
            AND estado = 'completada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">$95.00</h3>
                    <p class="kpi-label">Ingresos de Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> 3 servicios
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(DISTINCT cliente_id) as total 
            FROM citas 
            WHERE DATE(fecha_hora) = CURDATE()
            AND estilista_id = [ID_ESTILISTA_AUTENTICADO]
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">6</h3>
                    <p class="kpi-label">Clientes a Atender</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-person"></i> Únicos
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
        SELECT c.*, u.nombre, u.apellido, u.telefono, s.nombre as servicio, s.duracion_minutos
        FROM citas c
        INNER JOIN usuarios u ON c.cliente_id = u.id
        INNER JOIN servicios s ON c.servicio_id = s.id
        WHERE c.estilista_id = [ID_ESTILISTA_AUTENTICADO]
        AND c.fecha_hora >= NOW()
        AND DATE(c.fecha_hora) = CURDATE()
        ORDER BY c.fecha_hora ASC
        LIMIT 1
        ================================================
        -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido); background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(232, 180, 184, 0.05));">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">
                                <i class="bi bi-bell-fill"></i> Próxima Cita
                            </h5>
                            <div style="font-size: 1.1rem;">
                                <strong style="color: var(--dorado-palido); font-size: 1.3rem;">12:00 PM</strong> - 
                                <strong style="color: var(--borgona);">Laura Martínez</strong>
                                <br>
                                <i class="bi bi-scissors"></i> Tinte Completo (90 min) | 
                                <i class="bi bi-phone"></i> (503) 7890-9012
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-gold">
                                <i class="bi bi-arrow-right-circle"></i> Ver Detalles
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mis Citas de Hoy - Timeline -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-calendar-day"></i>
                        Mis Citas de Hoy - Viernes, 31 de Octubre 2024
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT c.id, c.fecha_hora, c.estado, c.precio_total, c.notas,
                           u.nombre as cliente_nombre, u.apellido as cliente_apellido, 
                           u.telefono, u.email,
                           s.nombre as servicio_nombre, s.duracion_minutos, s.precio,
                           p.nombre as promocion_nombre
                    FROM citas c
                    INNER JOIN usuarios u ON c.cliente_id = u.id
                    INNER JOIN servicios s ON c.servicio_id = s.id
                    LEFT JOIN promociones p ON c.promocion_id = p.id
                    WHERE c.estilista_id = [ID_ESTILISTA_AUTENTICADO]
                    AND DATE(c.fecha_hora) = CURDATE()
                    ORDER BY c.fecha_hora ASC
                    ================================================
                    -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th>Cliente</th>
                                    <th>Contacto</th>
                                    <th>Servicio</th>
                                    <th>Duración</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Cita Completada -->
                                <tr style="background: rgba(212, 175, 55, 0.05);">
                                    <td><strong style="color: var(--borgona);">09:00 AM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.85rem;">M</div>
                                            <strong>María García</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="bi bi-phone"></i> 7890-1234<br>
                                            <i class="bi bi-envelope"></i> maria.garcia@email.com
                                        </small>
                                    </td>
                                    <td>Corte de Cabello</td>
                                    <td>30 min</td>
                                    <td><strong style="color: var(--borgona);">$15.00</strong></td>
                                    <td><span class="badge bg-success"><i class="bi bi-check-circle"></i> Completada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-gold" data-bs-toggle="modal" data-bs-target="#modalVerCita" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Completada -->
                                <tr style="background: rgba(212, 175, 55, 0.05);">
                                    <td><strong style="color: var(--borgona);">10:00 AM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.85rem;">C</div>
                                            <strong>Carla Hernández</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="bi bi-phone"></i> 7890-3456<br>
                                            <i class="bi bi-envelope"></i> carla.h@email.com
                                        </small>
                                    </td>
                                    <td>Peinado Especial</td>
                                    <td>60 min</td>
                                    <td><strong style="color: var(--borgona);">$30.00</strong></td>
                                    <td><span class="badge bg-success"><i class="bi bi-check-circle"></i> Completada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita En Proceso - ACTUAL -->
                                <tr style="background: rgba(128, 0, 32, 0.08); border-left: 5px solid var(--borgona);">
                                    <td><strong style="color: var(--borgona); font-size: 1.1rem;">11:00 AM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.85rem;">A</div>
                                            <div>
                                                <strong>Ana Rodríguez</strong>
                                                <br>
                                                <span class="badge badge-gold" style="font-size: 0.7rem;">
                                                    <i class="bi bi-star-fill"></i> VIP
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="bi bi-phone"></i> 7890-5678<br>
                                            <i class="bi bi-envelope"></i> ana.r@email.com
                                        </small>
                                    </td>
                                    <td>
                                        <strong>Tratamiento Capilar</strong>
                                        <br>
                                        <small style="color: var(--borgona); opacity: 0.7;">
                                            <i class="bi bi-clock"></i> Termina: 11:50 AM
                                        </small>
                                    </td>
                                    <td>50 min</td>
                                    <td><strong style="color: var(--borgona); font-size: 1.1rem;">$50.00</strong></td>
                                    <td>
                                        <span class="badge bg-primary">
                                            <i class="bi bi-hourglass-split"></i> En Proceso
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-premium me-1" onclick="finalizarCita(3)" title="Finalizar">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Próxima Cita -->
                                <tr style="border-left: 5px solid var(--dorado-palido);">
                                    <td><strong style="color: var(--dorado-palido); font-size: 1.1rem;">12:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.85rem;">L</div>
                                            <strong>Laura Martínez</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="bi bi-phone"></i> 7890-9012<br>
                                            <i class="bi bi-envelope"></i> laura.m@email.com
                                        </small>
                                    </td>
                                    <td>
                                        <strong>Tinte Completo</strong>
                                        <br>
                                        <small style="color: var(--borgona); opacity: 0.7;">
                                            <i class="bi bi-exclamation-triangle"></i> Prueba de alergia OK
                                        </small>
                                    </td>
                                    <td>90 min</td>
                                    <td><strong style="color: var(--borgona);">$40.00</strong></td>
                                    <td><span class="badge bg-info"><i class="bi bi-calendar-check"></i> Confirmada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" onclick="iniciarCita(4)" title="Iniciar servicio">
                                            <i class="bi bi-play-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Confirmada -->
                                <tr>
                                    <td><strong style="color: var(--borgona);">02:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.85rem;">S</div>
                                            <div>
                                                <strong>Sofía Ramírez</strong>
                                                <br>
                                                <span class="badge badge-soft" style="font-size: 0.7rem;">
                                                    <i class="bi bi-star"></i> Nuevo
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="bi bi-phone"></i> 7890-7890<br>
                                            <i class="bi bi-envelope"></i> sofia.r@email.com
                                        </small>
                                    </td>
                                    <td>Corte + Peinado</td>
                                    <td>50 min</td>
                                    <td><strong style="color: var(--borgona);">$35.00</strong></td>
                                    <td><span class="badge bg-info"><i class="bi bi-calendar-check"></i> Confirmada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Iniciar servicio">
                                            <i class="bi bi-play-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Pendiente -->
                                <tr style="background: rgba(232, 180, 184, 0.1);">
                                    <td><strong style="color: var(--borgona);">04:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.85rem;">P</div>
                                            <strong>Patricia Gómez</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="bi bi-phone"></i> 7890-1111<br>
                                            <i class="bi bi-envelope"></i> patricia.g@email.com
                                        </small>
                                    </td>
                                    <td>Manicure Básico</td>
                                    <td>30 min</td>
                                    <td>
                                        <strong style="color: var(--borgona);">$10.00</strong>
                                        <br>
                                        <span class="badge badge-gold" style="font-size: 0.7rem;" title="Promoción aplicada">
                                            <i class="bi bi-gift"></i> 20% OFF
                                        </span>
                                    </td>
                                    <td><span class="badge bg-warning text-dark"><i class="bi bi-question-circle"></i> Pendiente</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-premium me-1" onclick="confirmarAsistencia(6)" title="Confirmar">
                                            <i class="bi bi-telephone"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vista Semanal (Oculta por defecto) -->
        <div class="row g-4 mb-4" id="vistaSemana" style="display: none;">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-calendar-week"></i>
                        Mi Agenda Semanal - 28 Oct al 03 Nov 2024
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT DATE(fecha_hora) as fecha, COUNT(*) as total_citas
                    FROM citas 
                    WHERE estilista_id = [ID_ESTILISTA_AUTENTICADO]
                    AND WEEK(fecha_hora) = WEEK(CURDATE())
                    AND YEAR(fecha_hora) = YEAR(CURDATE())
                    GROUP BY DATE(fecha_hora)
                    ORDER BY fecha
                    ================================================
                    -->
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table-custom">
                                    <thead>
                                        <tr>
                                            <th>Día</th>
                                            <th>Citas Programadas</th>
                                            <th>Horas de Trabajo</th>
                                            <th>Ingresos Estimados</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr style="opacity: 0.6;">
                                            <td>
                                                <strong>Lun 28 Oct</strong>
                                            </td>
                                            <td>8 citas</td>
                                            <td>7 horas</td>
                                            <td>$245.00</td>
                                            <td><span class="badge bg-success">Completado</span></td>
                                        </tr>
                                        <tr style="opacity: 0.6;">
                                            <td>
                                                <strong>Mar 29 Oct</strong>
                                            </td>
                                            <td>7 citas</td>
                                            <td>6.5 horas</td>
                                            <td>$210.00</td>
                                            <td><span class="badge bg-success">Completado</span></td>
                                        </tr>
                                        <tr style="opacity: 0.6;">
                                            <td>
                                                <strong>Mié 30 Oct</strong>
                                            </td>
                                            <td>9 citas</td>
                                            <td>8 horas</td>
                                            <td>$280.00</td>
                                            <td><span class="badge bg-success">Completado</span></td>
                                        </tr>
                                        <tr style="opacity: 0.6;">
                                            <td>
                                                <strong>Jue 31 Oct</strong>
                                            </td>
                                            <td>5 citas</td>
                                            <td>5 horas</td>
                                            <td>$175.00</td>
                                            <td><span class="badge bg-success">Completado</span></td>
                                        </tr>
                                        <tr style="background: rgba(128, 0, 32, 0.05); border-left: 4px solid var(--borgona);">
                                            <td>
                                                <strong style="color: var(--borgona);">Vie 01 Nov (HOY)</strong>
                                            </td>
                                            <td><strong style="color: var(--borgona);">6 citas</strong></td>
                                            <td><strong style="color: var(--borgona);">6.5 horas</strong></td>
                                            <td><strong style="color: var(--borgona);">$180.00</strong></td>
                                            <td><span class="badge bg-primary">En Progreso</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong style="color: var(--dorado-palido);">Sáb 02 Nov</strong>
                                            </td>
                                            <td>10 citas</td>
                                            <td>9 horas</td>
                                            <td>$320.00</td>
                                            <td><span class="badge bg-info">Programado</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Dom 03 Nov</strong>
                                            </td>
                                            <td>0 citas</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td><span class="badge bg-secondary">Descanso</span></td>
                                        </tr>
                                    </tbody>
                                    <tfoot style="background: rgba(212, 175, 55, 0.1); font-weight: 700;">
                                        <tr>
                                            <td><strong>TOTAL SEMANA</strong></td>
                                            <td><strong>45 citas</strong></td>
                                            <td><strong>42 horas</strong></td>
                                            <td><strong style="color: var(--borgona); font-size: 1.1rem;">$1,410.00</strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Personales -->
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-graph-up-arrow"></i>
                        Mi Rendimiento del Mes
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT COUNT(*) as total_citas,
                           COUNT(DISTINCT cliente_id) as total_clientes,
                           SUM(precio_total) as ingresos_totales,
                           AVG(precio_total) as ticket_promedio
                    FROM citas 
                    WHERE estilista_id = [ID_ESTILISTA_AUTENTICADO]
                    AND MONTH(fecha_hora) = MONTH(CURDATE())
                    AND estado = 'completada'
                    ================================================
                    -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Citas Completadas</h6>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--borgona); margin: 0;">78</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Ingresos Generados</h6>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--dorado-palido); margin: 0;">$2,845</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Clientes Atendidos</h6>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--borgona); margin: 0;">54</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--champagne), var(--champagne-light));">
                                    <i class="bi bi-receipt"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Ticket Promedio</h6>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--borgona); margin: 0;">$36.47</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-trophy-fill"></i>
                        Mis Logros y Reconocimientos
                    </h5>
                    
                    <div class="premium-card" style="margin-bottom: 1rem;">
                        <div class="text-center">
                            <div style="font-size: 4rem; color: var(--dorado-palido);">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <h4 style="color: var(--dorado-palido); margin: 1rem 0;">¡Estilista del Mes!</h4>
                            <p style="opacity: 0.9; margin: 0;">
                                Felicidades Ana, has sido reconocida como la estilista con mejor desempeño este mes
                            </p>
                        </div>
                    </div>

                    <ul class="list-custom">
                        <li class="list-item-custom">
                            <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="list-content">
                                <h6>Calificación Promedio</h6>
                                <div style="color: var(--dorado-palido); font-size: 1.2rem;">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <strong style="margin-left: 0.5rem; color: var(--borgona);">4.9/5.0</strong>
                                </div>
                            </div>
                        </li>

                        <li class="list-item-custom">
                            <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                <i class="bi bi-lightning-fill"></i>
                            </div>
                            <div class="list-content">
                                <h6>Productividad</h6>
                                <div style="font-size: 1.1rem; color: var(--borgona);">
                                    <strong>98%</strong>
                                    <div style="width: 100%; background: var(--rosa-empolvado); height: 10px; border-radius: 5px; margin-top: 5px;">
                                        <div style="width: 98%; background: var(--dorado-palido); height: 10px; border-radius: 5px;"></div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </main>

    <!-- ============================================
         FOOTER
         ============================================ -->
    <footer class="main-footer">
        <p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer>

    <!-- ============================================
         MODAL: VER DETALLE DE CITA
         ============================================ -->
    <div class="modal fade" id="modalVerCita" tabindex="-1">
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
                        <h3><i class="bi bi-person-circle"></i> María García López</h3>
                        <p>
                            <i class="bi bi-phone"></i> (503) 7890-1234 | 
                            <i class="bi bi-envelope"></i> maria.garcia@email.com
                        </p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Horario</h6>
                                    <p><strong>09:00 AM - 09:30 AM</strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                    <i class="bi bi-scissors"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Servicio</h6>
                                    <p><strong>Corte de Cabello</strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Precio</h6>
                                    <p><strong style="color: var(--borgona); font-size: 1.2rem;">$15.00</strong></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--champagne), var(--champagne-light));">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Estado</h6>
                                    <p><span class="badge bg-success">Completada</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert-custom">
                                <i class="bi bi-journal-text"></i>
                                <strong>Notas del cliente:</strong><br>
                                Cliente VIP. Prefiere citas por la tarde. Alérgica a productos con parabenos.
                            </div>
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
    
    <!-- Scripts -->
    <script>
        // Variables globales
        let vistaActual = 'hoy';

        // Actualizar dashboard
        function actualizarDashboard() {
            console.log('Actualizar dashboard');
            location.reload();
        }

        // Cambiar vista (hoy/semana/mes)
        function cambiarVista(vista) {
            vistaActual = vista;
            
            // Actualizar botones
            document.getElementById('btnHoy').className = vista === 'hoy' ? 'btn btn-gold' : 'btn btn-outline-gold';
            document.getElementById('btnSemana').className = vista === 'semana' ? 'btn btn-gold' : 'btn btn-outline-gold';
            document.getElementById('btnMes').className = vista === 'mes' ? 'btn btn-gold' : 'btn btn-outline-gold';
            
            // Mostrar/ocultar secciones
            if (vista === 'semana') {
                document.getElementById('vistaSemana').style.display = 'block';
            } else {
                document.getElementById('vistaSemana').style.display = 'none';
            }
            
            console.log('Vista cambiada a:', vista);
            // TODO: Cargar datos según la vista seleccionada
        }

        // Iniciar cita
        function iniciarCita(citaId) {
            console.log('Iniciar cita:', citaId);
            if (confirm('¿Deseas marcar esta cita como "En Proceso"?')) {
                alert('Cita iniciada - Conectar con backend');
                // TODO: Actualizar estado en BD
            }
        }

        // Finalizar cita
        function finalizarCita(citaId) {
            console.log('Finalizar cita:', citaId);
            if (confirm('¿La cita ha sido completada exitosamente?')) {
                alert('Cita finalizada - Conectar con backend');
                // TODO: Actualizar estado en BD y solicitar calificación
            }
        }

        // Confirmar asistencia del cliente
        function confirmarAsistencia(citaId) {
            console.log('Confirmar asistencia:', citaId);
            alert('Llamar al cliente para confirmar asistencia - Conectar con backend');
            // TODO: Actualizar estado en BD
        }

        // Obtener hora actual
        function actualizarHora() {
            const ahora = new Date();
            const hora = ahora.toLocaleTimeString('es-SV', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
            console.log('Hora actual:', hora);
        }

        // Actualizar cada minuto
        setInterval(actualizarHora, 60000);
        
        // Hora inicial
        actualizarHora();
    </script>
    
</body>
</html>