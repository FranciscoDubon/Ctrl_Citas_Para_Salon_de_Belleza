<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reportes Administrador | Salón de Belleza</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- CSS Global (SIN la barra inicial) -->
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
            <a href="{{ route('admin.dashboardAdm') }}" class="menu-item">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.usuariosAdm') }}" class="menu-item">
                <i class="bi bi-people"></i> Empleados & Usuarios
            </a>
            <a href="{{ route('admin.serviciosAdm') }}" class="menu-item">
                <i class="bi bi-scissors"></i> Servicios
            </a>
            <a href="{{ route('admin.promocionesAdm') }}" class="menu-item">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('admin.reportesAdm') }}" class="menu-item active">
                <i class="bi bi-graph-up"></i> Reportes
            </a>
            
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Gestión de Reportes</h1>
            <p>Administra reportes y estadísticas.</p>
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
        
        <!-- Botones de Acción Superior -->
        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-gold me-2" onclick="generarReportePDF()">
                    <i class="bi bi-file-pdf"></i> Generar PDF
                </button>
                <button class="btn btn-premium me-2" onclick="exportarExcel()">
                    <i class="bi bi-file-excel"></i> Exportar Excel
                </button>
                <button class="btn btn-outline-gold me-2" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                    <i class="bi bi-funnel"></i> Filtros Avanzados
                </button>
                <button class="btn btn-soft" onclick="actualizarReportes()">
                    <i class="bi bi-arrow-clockwise"></i> Actualizar
                </button>
            </div>
        </div>

        <!-- Selector de Período -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Tipo de Reporte</label>
                            <select class="form-select" id="tipoReporte" onchange="cambiarReporte()">
                                <option value="general">Reporte General</option>
                                <option value="clientes">Historial de Clientes</option>
                                <option value="servicios">Servicios Más Solicitados</option>
                                <option value="estilistas">Rendimiento de Estilistas</option>
                                <option value="financiero">Análisis Financiero</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Período</label>
                            <select class="form-select" id="periodo">
                                <option value="hoy">Hoy</option>
                                <option value="semana">Esta Semana</option>
                                <option value="mes" selected>Este Mes</option>
                                <option value="trimestre">Este Trimestre</option>
                                <option value="anio">Este Año</option>
                                <option value="personalizado">Personalizado</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Fecha Inicio</label>
                            <input type="date" class="form-control" id="fechaInicio">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Fecha Fin</label>
                            <input type="date" class="form-control" id="fechaFin">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-gold w-100" onclick="aplicarFiltros()">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards - Resumen General -->
        <div class="row g-4 mb-4">
            
            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM citas 
            WHERE MONTH(fecha_hora) = MONTH(CURDATE())
            AND estado = 'completada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">287</h3>
                    <p class="kpi-label">Citas Completadas</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +18% vs mes anterior
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
            WHERE MONTH(fecha_hora) = MONTH(CURDATE())
            AND estado = 'completada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">$8,420</h3>
                    <p class="kpi-label">Ingresos Totales</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +12.5%
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT AVG(precio_total) as promedio 
            FROM citas 
            WHERE MONTH(fecha_hora) = MONTH(CURDATE())
            AND estado = 'completada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">$29.34</h3>
                    <p class="kpi-label">Ticket Promedio</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +5.2%
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
            WHERE MONTH(fecha_hora) = MONTH(CURDATE())
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">142</h3>
                    <p class="kpi-label">Clientes Únicos</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +24 nuevos
                    </span>
                </div>
            </div>
        </div>

        <!-- ============================================
             REPORTE: HISTORIAL DE CLIENTES
             ============================================ -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-people-fill"></i>
                        Historial de Clientes - Análisis Detallado
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT u.id, u.nombre, u.apellido, u.email, u.telefono,
                           COUNT(c.id) as total_citas,
                           SUM(c.precio_total) as total_gastado,
                           MAX(c.fecha_hora) as ultima_visita,
                           MIN(c.fecha_hora) as primera_visita,
                           AVG(c.precio_total) as ticket_promedio
                    FROM usuarios u
                    INNER JOIN citas c ON u.id = c.cliente_id
                    WHERE c.estado = 'completada'
                    AND MONTH(c.fecha_hora) = MONTH(CURDATE())
                    GROUP BY u.id, u.nombre, u.apellido, u.email, u.telefono
                    ORDER BY total_gastado DESC
                    ================================================
                    -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Contacto</th>
                                    <th>Total Citas</th>
                                    <th>Total Gastado</th>
                                    <th>Ticket Promedio</th>
                                    <th>Primera Visita</th>
                                    <th>Última Visita</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">M</div>
                                            <strong>María García López</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> maria.garcia@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-1234
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.9rem;">18 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$642.00</strong>
                                    </td>
                                    <td>$35.67</td>
                                    <td>15 Ene 2024</td>
                                    <td>28 Oct 2024</td>
                                    <td><span class="badge bg-success">VIP</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" data-bs-toggle="modal" data-bs-target="#modalDetalleCliente" title="Ver historial">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">A</div>
                                            <strong>Ana Rodríguez Pérez</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> ana.rodriguez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-5678
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.9rem;">15 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$520.00</strong>
                                    </td>
                                    <td>$34.67</td>
                                    <td>22 Feb 2024</td>
                                    <td>30 Oct 2024</td>
                                    <td><span class="badge bg-success">VIP</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" title="Ver historial">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">L</div>
                                            <strong>Laura Martínez Díaz</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> laura.martinez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-9012
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.9rem;">12 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$385.00</strong>
                                    </td>
                                    <td>$32.08</td>
                                    <td>10 Mar 2024</td>
                                    <td>25 Oct 2024</td>
                                    <td><span class="badge badge-gold">Frecuente</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" title="Ver historial">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">C</div>
                                            <strong>Carla Hernández Silva</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> carla.hernandez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-3456
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.9rem;">8 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$245.00</strong>
                                    </td>
                                    <td>$30.63</td>
                                    <td>05 Jun 2024</td>
                                    <td>20 Oct 2024</td>
                                    <td><span class="badge badge-gold">Frecuente</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" title="Ver historial">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">S</div>
                                            <strong>Sofía Ramírez Castro</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> sofia.ramirez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-7890
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.9rem;">3 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$95.00</strong>
                                    </td>
                                    <td>$31.67</td>
                                    <td>15 Oct 2024</td>
                                    <td>28 Oct 2024</td>
                                    <td><span class="badge badge-soft">Nuevo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" title="Ver historial">
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

        <!-- ============================================
             REPORTE: SERVICIOS MÁS SOLICITADOS
             ============================================ -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-graph-up-arrow"></i>
                        Servicios Más Solicitados - Ranking Mensual
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT s.nombre, s.precio, s.categoria,
                           COUNT(cs.id) as total_solicitudes,
                           SUM(s.precio) as ingresos_generados,
                           AVG(s.precio) as precio_promedio
                    FROM servicios s
                    INNER JOIN cita_servicio cs ON s.id = cs.servicio_id
                    INNER JOIN citas c ON cs.cita_id = c.id
                    WHERE c.estado = 'completada'
                    AND MONTH(c.fecha_hora) = MONTH(CURDATE())
                    GROUP BY s.id, s.nombre, s.precio, s.categoria
                    ORDER BY total_solicitudes DESC
                    LIMIT 15
                    ================================================
                    -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Servicio</th>
                                    <th>Categoría</th>
                                    <th>Solicitudes</th>
                                    <th>Ingresos</th>
                                    <th>Tendencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem; background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                            <i class="bi bi-trophy-fill"></i>
                                        </div>
                                    </td>
                                    <td><strong>Corte de Cabello</strong></td>
                                    <td><span class="badge badge-luxury">CABELLO</span></td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">67</strong>
                                        <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                            <div style="width: 100%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                                        </div>
                                    </td>
                                    <td><strong style="color: var(--borgona);">$1,005.00</strong></td>
                                    <td><span class="badge badge-success"><i class="bi bi-arrow-up"></i> +22%</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                            2
                                        </div>
                                    </td>
                                    <td><strong>Manicure Básico</strong></td>
                                    <td><span class="badge badge-gold">UÑAS</span></td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">54</strong>
                                        <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                            <div style="width: 80%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                                        </div>
                                    </td>
                                    <td><strong style="color: var(--borgona);">$540.00</strong></td>
                                    <td><span class="badge badge-success"><i class="bi bi-arrow-up"></i> +15%</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem; background: linear-gradient(135deg, var(--champagne), var(--champagne-light));">
                                            3
                                        </div>
                                    </td>
                                    <td><strong>Pedicure Spa</strong></td>
                                    <td><span class="badge badge-gold">UÑAS</span></td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">48</strong>
                                        <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                            <div style="width: 72%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                                        </div>
                                    </td>
                                    <td><strong style="color: var(--borgona);">$720.00</strong></td>
                                    <td><span class="badge badge-success"><i class="bi bi-arrow-up"></i> +18%</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem;">
                                            4
                                        </div>
                                    </td>
                                    <td><strong>Tinte Completo</strong></td>
                                    <td><span class="badge badge-luxury">CABELLO</span></td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">42</strong>
                                        <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                            <div style="width: 63%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                                        </div>
                                    </td>
                                    <td><strong style="color: var(--borgona);">$1,680.00</strong></td>
                                    <td><span class="badge badge-success"><i class="bi bi-arrow-up"></i> +10%</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem;">
                                            5
                                        </div>
                                    </td>
                                    <td><strong>Peinado Especial</strong></td>
                                    <td><span class="badge badge-luxury">CABELLO</span></td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">38</strong>
                                        <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                            <div style="width: 57%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                                        </div>
                                    </td>
                                    <td><strong style="color: var(--borgona);">$1,140.00</strong></td>
                                    <td><span class="badge badge-success"><i class="bi bi-arrow-up"></i> +25%</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem;">
                                            6
                                        </div>
                                    </td>
                                    <td><strong>Tratamiento Capilar</strong></td>
                                    <td><span class="badge badge-luxury">CABELLO</span></td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">32</strong>
                                        <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                            <div style="width: 48%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                                        </div>
                                    </td>
                                    <td><strong style="color: var(--borgona);">$1,120.00</strong></td>
                                    <td><span class="badge badge-neutral"><i class="bi bi-dash"></i> 0%</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Resumen por Categoría -->
            <div class="col-lg-4">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-pie-chart-fill"></i>
                        Por Categoría
                    </h5>
                    
                    <ul class="list-custom">
                        <li class="list-item-custom">
                            <div class="list-avatar">
                                <i class="bi bi-scissors"></i>
                            </div>
                            <div class="list-content">
                                <h6>Cabello</h6>
                                <p>179 servicios</p>
                                <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 5px;">
                                    <div style="width: 75%; background: var(--borgona); height: 8px; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div class="list-badge">
                                <strong style="color: var(--borgona); font-size: 1.2rem;">45%</strong>
                            </div>
                        </li>

                        <li class="list-item-custom">
                            <div class="list-avatar">
                                <i class="bi bi-hand-index"></i>
                            </div>
                            <div class="list-content">
                                <h6>Uñas</h6>
                                <p>142 servicios</p>
                                <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 5px;">
                                    <div style="width: 60%; background: var(--dorado-palido); height: 8px; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div class="list-badge">
                                <strong style="color: var(--dorado-palido); font-size: 1.2rem;">35%</strong>
                            </div>
                        </li>

                        <li class="list-item-custom">
                            <div class="list-avatar">
                                <i class="bi bi-emoji-smile"></i>
                            </div>
                            <div class="list-content">
                                <h6>Faciales</h6>
                                <p>67 servicios</p>
                                <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 5px;">
                                    <div style="width: 35%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div class="list-badge">
                                <strong style="color: var(--rosa-empolvado); font-size: 1.2rem;">17%</strong>
                            </div>
                        </li>

                        <li class="list-item-custom">
                            <div class="list-avatar">
                                <i class="bi bi-droplet"></i>
                            </div>
                            <div class="list-content">
                                <h6>Otros</h6>
                                <p>12 servicios</p>
                                <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 5px;">
                                    <div style="width: 10%; background: var(--champagne); height: 8px; border-radius: 4px;"></div>
                                </div>
                            </div>
                            <div class="list-badge">
                                <strong style="color: var(--negro-carbon); font-size: 1.2rem; opacity: 0.6;">3%</strong>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ============================================
             REPORTE: RENDIMIENTO DE ESTILISTAS
             ============================================ -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-award-fill"></i>
                        Rendimiento de Estilistas - Análisis de Productividad
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT u.id, u.nombre, u.apellido,
                           COUNT(c.id) as total_citas,
                           SUM(c.precio_total) as ingresos_generados,
                           AVG(c.precio_total) as ticket_promedio,
                           COUNT(DISTINCT c.cliente_id) as clientes_atendidos,
                           AVG(TIMESTAMPDIFF(MINUTE, c.fecha_hora, c.fecha_fin)) as duracion_promedio
                    FROM usuarios u
                    INNER JOIN citas c ON u.id = c.estilista_id
                    WHERE u.rol = 'estilista'
                    AND c.estado = 'completada'
                    AND MONTH(c.fecha_hora) = MONTH(CURDATE())
                    GROUP BY u.id, u.nombre, u.apellido
                    ORDER BY ingresos_generados DESC
                    ================================================
                    -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Estilista</th>
                                    <th>Citas Completadas</th>
                                    <th>Clientes Atendidos</th>
                                    <th>Ingresos Generados</th>
                                    <th>Ticket Promedio</th>
                                    <th>Productividad</th>
                                    <th>Calificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">A</div>
                                            <div>
                                                <strong>Ana López García</strong>
                                                <br>
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-trophy-fill"></i> Mejor del Mes
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">78</strong> citas
                                    </td>
                                    <td>54 clientes</td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.2rem;">$2,845.00</strong>
                                    </td>
                                    <td>$36.47</td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <strong style="color: var(--borgona);">98%</strong>
                                            <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 3px;">
                                                <div style="width: 98%; background: var(--dorado-palido); height: 8px; border-radius: 4px;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="color: var(--dorado-palido); font-size: 1rem;">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <br>
                                            <small style="color: var(--negro-carbon);">4.9 / 5.0</small>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" data-bs-toggle="modal" data-bs-target="#modalDetalleEstilista" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">M</div>
                                            <div>
                                                <strong>María Torres Sánchez</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">72</strong> citas
                                    </td>
                                    <td>48 clientes</td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.2rem;">$2,520.00</strong>
                                    </td>
                                    <td>$35.00</td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <strong style="color: var(--borgona);">92%</strong>
                                            <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 3px;">
                                                <div style="width: 92%; background: var(--dorado-palido); height: 8px; border-radius: 4px;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="color: var(--dorado-palido); font-size: 1rem;">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                            <br>
                                            <small style="color: var(--negro-carbon);">4.7 / 5.0</small>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">S</div>
                                            <div>
                                                <strong>Sofía Ramírez Cruz</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">65</strong> citas
                                    </td>
                                    <td>42 clientes</td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.2rem;">$2,180.00</strong>
                                    </td>
                                    <td>$33.54</td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <strong style="color: var(--borgona);">88%</strong>
                                            <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 3px;">
                                                <div style="width: 88%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="color: var(--dorado-palido); font-size: 1rem;">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-half"></i>
                                            <br>
                                            <small style="color: var(--negro-carbon);">4.6 / 5.0</small>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">L</div>
                                            <div>
                                                <strong>Laura Gómez Ortiz</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">58</strong> citas
                                    </td>
                                    <td>38 clientes</td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.2rem;">$1,875.00</strong>
                                    </td>
                                    <td>$32.33</td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <strong style="color: var(--borgona);">82%</strong>
                                            <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 3px;">
                                                <div style="width: 82%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="color: var(--dorado-palido); font-size: 1rem;">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star"></i>
                                            <br>
                                            <small style="color: var(--negro-carbon);">4.5 / 5.0</small>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft" title="Ver detalles">
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

        <!-- Análisis Comparativo -->
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="premium-card" style="height: 100%;">
                    <h3><i class="bi bi-star-fill"></i> Mejor Desempeño</h3>
                    <div style="text-align: center; padding: 2rem 0;">
                        <div class="list-avatar" style="width: 80px; height: 80px; font-size: 2rem; margin: 0 auto 1rem;">A</div>
                        <h4 style="color: var(--dorado-palido); margin-bottom: 0.5rem;">Ana López García</h4>
                        <p style="color: var(--blanco-humo); opacity: 0.8; margin-bottom: 1rem;">Estilista del Mes</p>
                        <div style="display: flex; justify-content: center; gap: 2rem; margin-top: 1.5rem;">
                            <div>
                                <h5 style="color: var(--dorado-palido);">78</h5>
                                <p style="font-size: 0.875rem;">Citas</p>
                            </div>
                            <div>
                                <h5 style="color: var(--dorado-palido);">$2,845</h5>
                                <p style="font-size: 0.875rem;">Ingresos</p>
                            </div>
                            <div>
                                <h5 style="color: var(--dorado-palido);">4.9</h5>
                                <p style="font-size: 0.875rem;">Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-custom" style="height: 100%;">
                    <h5 class="card-title-custom">
                        <i class="bi bi-lightning-charge-fill"></i>
                        Más Productivo
                    </h5>
                    <div class="list-item-custom">
                        <div class="list-avatar">A</div>
                        <div class="list-content">
                            <h6>Ana López García</h6>
                            <p>98% de productividad</p>
                            <div style="width: 100%; background: var(--rosa-empolvado); height: 10px; border-radius: 5px; margin-top: 5px;">
                                <div style="width: 98%; background: var(--dorado-palido); height: 10px; border-radius: 5px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-custom" style="height: 100%;">
                    <h5 class="card-title-custom">
                        <i class="bi bi-heart-fill"></i>
                        Mejor Calificado
                    </h5>
                    <div class="list-item-custom">
                        <div class="list-avatar">A</div>
                        <div class="list-content">
                            <h6>Ana López García</h6>
                            <p>4.9 / 5.0 estrellas</p>
                            <div style="color: var(--dorado-palido); font-size: 1.2rem; margin-top: 5px;">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
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
        <p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer>

    <!-- ============================================
         MODAL: DETALLE CLIENTE
         ============================================ -->
    <div class="modal fade" id="modalDetalleCliente" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-person-circle" style="color: var(--dorado-palido);"></i> 
                        Historial Completo del Cliente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Información del cliente y su historial -->
                    <div class="premium-card mb-4">
                        <h3>María García López</h3>
                        <p>
                            <i class="bi bi-envelope"></i> maria.garcia@email.com | 
                            <i class="bi bi-phone"></i> (503) 7890-1234 | 
                            <span class="badge bg-success">Cliente VIP</span>
                        </p>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.75rem;">18</h3>
                                <p class="kpi-label">Total Citas</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.75rem;">$642</h3>
                                <p class="kpi-label">Total Gastado</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.75rem;">$35.67</h3>
                                <p class="kpi-label">Ticket Promedio</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.75rem;">4.8</h3>
                                <p class="kpi-label">Satisfacción</p>
                            </div>
                        </div>
                    </div>

                    <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">Últimas 10 Citas</h6>
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Servicio</th>
                                    <th>Estilista</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>28 Oct 2024</td>
                                    <td>Corte + Tinte</td>
                                    <td>Ana López</td>
                                    <td>$55.00</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                </tr>
                                <!-- Más filas... -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-gold">
                        <i class="bi bi-file-pdf"></i> Exportar Historial
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: DETALLE ESTILISTA
         ============================================ -->
    <div class="modal fade" id="modalDetalleEstilista" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-award-fill" style="color: var(--dorado-palido);"></i> 
                        Rendimiento Detallado del Estilista
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="premium-card mb-4">
                        <h3><i class="bi bi-trophy-fill"></i> Ana López García - Estilista del Mes</h3>
                        <p>Miembro desde: Enero 2024 | Especialidad: Corte y Color</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-2">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.5rem;">78</h3>
                                <p class="kpi-label">Citas</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.5rem;">54</h3>
                                <p class="kpi-label">Clientes</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.5rem;">$2,845</h3>
                                <p class="kpi-label">Ingresos</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.5rem;">98%</h3>
                                <p class="kpi-label">Productividad</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.5rem;">4.9/5</h3>
                                <p class="kpi-label">Calificación</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-gold">
                        <i class="bi bi-file-pdf"></i> Exportar Reporte
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        function cambiarReporte() {
            const tipo = document.getElementById('tipoReporte').value;
            console.log('Cambiar a reporte:', tipo);
            // TODO: Implementar cambio de vista según tipo de reporte
        }

        function aplicarFiltros() {
            console.log('Aplicar filtros');
            // TODO: Implementar filtrado de reportes
        }

        function generarReportePDF() {
            console.log('Generar PDF');
            alert('Generando reporte PDF - Conectar con backend');
        }

        function exportarExcel() {
            console.log('Exportar Excel');
            alert('Exportando a Excel - Conectar con backend');
        }

        function actualizarReportes() {
            console.log('Actualizar reportes');
            alert('Actualizando datos - Conectar con backend');
        }

        // Establecer fechas por defecto
        const hoy = new Date();
        const primerDiaMes = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        
        document.getElementById('fechaInicio').value = primerDiaMes.toISOString().split('T')[0];
        document.getElementById('fechaFin').value = hoy.toISOString().split('T')[0];

        // ========================================
        // FUNCIONES PARA CARGAR NOMBRE DE USAURIO 
        // ========================================

document.addEventListener('DOMContentLoaded', () => {
    const nombre = localStorage.getItem('clienteNombre') || 'Cliente';
    const apellido = localStorage.getItem('clienteApellido') || '';
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