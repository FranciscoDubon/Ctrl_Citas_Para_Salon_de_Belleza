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
                        <a href="{{ route('logn') }}" class="menu-item">
                 Cerrar Sesión
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
    <select class="form-select" id="tipoReporte">
        <option value="general" {{ $tipoReporte == 'general' ? 'selected' : '' }}>Reporte General</option>
        <option value="clientes" {{ $tipoReporte == 'clientes' ? 'selected' : '' }}>Historial de Clientes</option>
        <option value="servicios" {{ $tipoReporte == 'servicios' ? 'selected' : '' }}>Servicios Más Solicitados</option>
        <option value="estilistas" {{ $tipoReporte == 'estilistas' ? 'selected' : '' }}>Rendimiento de Estilistas</option>
        <option value="financiero" {{ $tipoReporte == 'financiero' ? 'selected' : '' }}>Análisis Financiero</option>
    </select>
</div>
<div class="col-md-3">
    <label class="form-label">Período</label>
    <select class="form-select" id="periodo">
        <option value="hoy" {{ $periodo == 'hoy' ? 'selected' : '' }}>Hoy</option>
        <option value="semana" {{ $periodo == 'semana' ? 'selected' : '' }}>Esta Semana</option>
        <option value="mes" {{ $periodo == 'mes' ? 'selected' : '' }}>Este Mes</option>
        <option value="trimestre" {{ $periodo == 'trimestre' ? 'selected' : '' }}>Este Trimestre</option>
        <option value="anio" {{ $periodo == 'anio' ? 'selected' : '' }}>Este Año</option>
        <option value="personalizado" {{ $periodo == 'personalizado' ? 'selected' : '' }}>Personalizado</option>
    </select>
</div>
<div class="col-md-2">
    <label class="form-label">Fecha Inicio</label>
    <input type="date" class="form-control" id="fechaInicio" 
           value="{{ $fechaInicio }}" 
           {{ $periodo !== 'personalizado' ? 'disabled' : '' }}>
</div>
<div class="col-md-2">
    <label class="form-label">Fecha Fin</label>
    <input type="date" class="form-control" id="fechaFin" 
           value="{{ $fechaFin }}" 
           {{ $periodo !== 'personalizado' ? 'disabled' : '' }}>
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
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-header">
                <div class="kpi-icon primary">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
            <h3 class="kpi-value">{{ $kpis['citas_completadas'] }}</h3>
            <p class="kpi-label">Citas Completadas</p>
            <span class="kpi-badge {{ $kpis['porcentaje_citas'] >= 0 ? 'badge-success' : 'badge-danger' }}">
                <i class="bi bi-arrow-{{ $kpis['porcentaje_citas'] >= 0 ? 'up' : 'down' }}"></i> 
                {{ abs($kpis['porcentaje_citas']) }}% vs período anterior
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-header">
                <div class="kpi-icon success">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <h3 class="kpi-value">${{ $kpis['ingresos_totales'] }}</h3>
            <p class="kpi-label">Ingresos Totales</p>
            <span class="kpi-badge {{ $kpis['porcentaje_ingresos'] >= 0 ? 'badge-success' : 'badge-danger' }}">
                <i class="bi bi-arrow-{{ $kpis['porcentaje_ingresos'] >= 0 ? 'up' : 'down' }}"></i> 
                {{ abs($kpis['porcentaje_ingresos']) }}%
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-header">
                <div class="kpi-icon info">
                    <i class="bi bi-receipt"></i>
                </div>
            </div>
            <h3 class="kpi-value">${{ $kpis['ticket_promedio'] }}</h3>
            <p class="kpi-label">Ticket Promedio</p>
            <span class="kpi-badge {{ $kpis['porcentaje_ticket'] >= 0 ? 'badge-success' : 'badge-danger' }}">
                <i class="bi bi-arrow-{{ $kpis['porcentaje_ticket'] >= 0 ? 'up' : 'down' }}"></i> 
                {{ abs($kpis['porcentaje_ticket']) }}%
            </span>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-header">
                <div class="kpi-icon warning">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <h3 class="kpi-value">{{ $kpis['clientes_unicos'] }}</h3>
            <p class="kpi-label">Clientes Únicos</p>
            <span class="kpi-badge badge-success">
                <i class="bi bi-arrow-up"></i> +{{ $kpis['clientes_nuevos'] }} nuevos
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
                                </tr>
                            </thead>
<tbody>
@forelse($historialClientes as $cliente)
<tr>
    <td>
        <div class="d-flex align-items-center">
            <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">
                {{ strtoupper(substr($cliente->nombre, 0, 1)) }}
            </div>
            <strong>{{ $cliente->nombre }} {{ $cliente->apellido }}</strong>
        </div>
    </td>
    <td>
        <div style="font-size: 0.875rem;">
            <i class="bi bi-envelope"></i> {{ $cliente->correoElectronico }}<br>
            <i class="bi bi-phone"></i> {{ $cliente->telefono }}
        </div>
    </td>
    <td>
        <span class="badge badge-luxury" style="font-size: 0.9rem;">{{ $cliente->total_citas }} citas</span>
    </td>
    <td>
        <strong style="color: var(--borgona); font-size: 1.1rem;">${{ $cliente->total_gastado }}</strong>
    </td>
    <td>${{ $cliente->ticket_promedio }}</td>
    <td>{{ $cliente->primera_visita }}</td>
    <td>{{ $cliente->ultima_visita }}</td>
    <td><span class="badge {{ $cliente->badge_class }}">{{ $cliente->estado }}</span></td>
</tr>
@empty
<tr>
    <td colspan="9" class="text-center">No hay datos disponibles para el período seleccionado</td>
</tr>
@endforelse
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
@forelse($serviciosMasSolicitados as $servicio)
<tr>
    <td>
        @if($servicio->ranking == 1)
        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem; background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
            <i class="bi bi-trophy-fill"></i>
        </div>
        @elseif($servicio->ranking == 2)
        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
            {{ $servicio->ranking }}
        </div>
        @elseif($servicio->ranking == 3)
        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem; background: linear-gradient(135deg, var(--champagne), var(--champagne-light));">
            {{ $servicio->ranking }}
        </div>
        @else
        <div class="list-avatar" style="width: 35px; height: 35px; font-size: 0.85rem;">
            {{ $servicio->ranking }}
        </div>
        @endif
    </td>
    <td><strong>{{ $servicio->nombre }}</strong></td>
    <td><span class="badge badge-luxury">{{ strtoupper($servicio->categoria) }}</span></td>
    <td>
        <strong style="color: var(--borgona); font-size: 1.1rem;">{{ $servicio->total_solicitudes }}</strong>
        <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
            <div style="width: {{ $servicio->porcentaje }}%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
        </div>
    </td>
    <td><strong style="color: var(--borgona);">${{ $servicio->ingresos_generados }}</strong></td>
    <td>
        <span class="badge {{ $servicio->tendencia_positiva ? 'badge-success' : 'badge-danger' }}">
            <i class="bi bi-arrow-{{ $servicio->tendencia_positiva ? 'up' : 'down' }}"></i> 
            {{ $servicio->tendencia }}%
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">No hay datos disponibles</td>
</tr>
@endforelse
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
@foreach($categorias as $categoria)
    <li class="list-item-custom">
        <div class="list-avatar">
            <i class="{{ $categoria->icono }}"></i>
        </div>
        <div class="list-content">
            <h6>{{ ucfirst($categoria->categoria) }}</h6>
            <p>{{ $categoria->total_servicios }} servicios</p>
            <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 5px;">
                <div style="width: {{ $categoria->porcentaje }}%; background: var(--borgona); height: 8px; border-radius: 4px;"></div>
            </div>
        </div>
        <div class="list-badge">
            <strong style="color: var(--borgona); font-size: 1.2rem;">{{ $categoria->porcentaje }}%</strong>
        </div>
    </li>
@endforeach
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
@forelse($rendimientoEstilistas as $index => $estilista)
<tr>
    <td>
        <div class="d-flex align-items-center">
            <div class="list-avatar me-2" style="width: 40px; height: 40px;">
                {{ strtoupper(substr($estilista->nombre, 0, 1)) }}
            </div>
            <div>
                <strong>{{ $estilista->nombre }} {{ $estilista->apellido }}</strong>
                @if($index == 0)
                <br>
                <small style="color: var(--borgona); opacity: 0.7;">
                    <i class="bi bi-trophy-fill"></i> Mejor del Período
                </small>
                @endif
            </div>
        </div>
    </td>
    <td>
        <strong style="color: var(--borgona); font-size: 1.1rem;">{{ $estilista->total_citas }}</strong> citas
    </td>
    <td>{{ $estilista->clientes_atendidos }} clientes</td>
    <td>
        <strong style="color: var(--borgona); font-size: 1.2rem;">${{ $estilista->ingresos_generados }}</strong>
    </td>
    <td>${{ $estilista->ticket_promedio }}</td>
    <td>
        <div style="font-size: 0.875rem;">
            <strong style="color: var(--borgona);">{{ $estilista->productividad }}%</strong>
            <div style="width: 100%; background: var(--rosa-empolvado); height: 8px; border-radius: 4px; margin-top: 3px;">
                <div style="width: {{ $estilista->productividad }}%; background: var(--dorado-palido); height: 8px; border-radius: 4px;"></div>
            </div>
        </div>
    </td>
    <td>
        <div style="color: var(--dorado-palido); font-size: 1rem;">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= floor($estilista->calificacion))
                    <i class="bi bi-star-fill"></i>
                @elseif($i == ceil($estilista->calificacion) && $estilista->calificacion - floor($estilista->calificacion) >= 0.5)
                    <i class="bi bi-star-half"></i>
                @else
                    <i class="bi bi-star"></i>
                @endif
            @endfor
            <br>
            <small style="color: var(--negro-carbon);">{{ $estilista->calificacion }} / 5.0</small>
        </div>
    </td>
    <td>
        <button class="btn btn-sm btn-soft" onclick="verDetalleEstilista({{ $estilista->idEmpleado }})" title="Ver detalles">
            <i class="bi bi-eye"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center">No hay datos disponibles</td>
</tr>
@endforelse
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Análisis Comparativo -->
@if($mejorEstilista)
<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="premium-card" style="height: 100%;">
            <h3><i class="bi bi-star-fill"></i> Mejor Desempeño</h3>
            <div style="text-align: center; padding: 2rem 0;">
                <div class="list-avatar" style="width: 80px; height: 80px; font-size: 2rem; margin: 0 auto 1rem;">
                    {{ strtoupper(substr($mejorEstilista->nombre, 0, 1)) }}
                </div>
                <h4 style="color: var(--dorado-palido); margin-bottom: 0.5rem;">
                    {{ $mejorEstilista->nombre }} {{ $mejorEstilista->apellido }}
                </h4>
                <p style="color: var(--blanco-humo); opacity: 0.8; margin-bottom: 1rem;">Estilista del Período</p>
                <div style="display: flex; justify-content: center; gap: 2rem; margin-top: 1.5rem;">
                    <div>
                        <h5 style="color: var(--dorado-palido);">{{ $mejorEstilista->total_citas }}</h5>
                        <p style="font-size: 0.875rem;">Citas</p>
                    </div>
                    <div>
                        <h5 style="color: var(--dorado-palido);">${{ number_format($mejorEstilista->ingresos_generados, 0) }}</h5>
                        <p style="font-size: 0.875rem;">Ingresos</p>
                    </div>
                    <div>
                        <h5 style="color: var(--dorado-palido);">{{ number_format($mejorEstilista->ticket_promedio, 1) }}</h5>
                        <p style="font-size: 0.875rem;">Ticket Prom.</p>
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
                <div class="list-avatar">{{ strtoupper(substr($mejorEstilista->nombre, 0, 1)) }}</div>
                <div class="list-content">
                    <h6>{{ $mejorEstilista->nombre }} {{ $mejorEstilista->apellido }}</h6>
                    <p>{{ $mejorEstilista->total_citas }} citas completadas</p>
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
                Mayor Ingreso
            </h5>
            <div class="list-item-custom">
                <div class="list-avatar">{{ strtoupper(substr($mejorEstilista->nombre, 0, 1)) }}</div>
                <div class="list-content">
                    <h6>{{ $mejorEstilista->nombre }} {{ $mejorEstilista->apellido }}</h6>
                    <p>${{ number_format($mejorEstilista->ingresos_generados, 2) }} generados</p>
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
@endif

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
    // ========================================
    // VARIABLES GLOBALES
    // ========================================
    let fechaInicio = '{{ $fechaInicio }}';
    let fechaFin = '{{ $fechaFin }}';

// ========================================
// FUNCIONES DE FILTRADO
// ========================================
function cambiarReporte() {
    // No hacer nada, esperar a que el usuario presione "Buscar"
    console.log('Tipo de reporte seleccionado');
}

function aplicarFiltros() {
    const tipoReporte = document.getElementById('tipoReporte').value;
    const periodo = document.getElementById('periodo').value;
    let fechaInicio = document.getElementById('fechaInicio').value;
    let fechaFin = document.getElementById('fechaFin').value;
    
    // Validar que si es personalizado, tenga fechas
    if (periodo === 'personalizado') {
        if (!fechaInicio || !fechaFin) {
            alert('Por favor seleccione las fechas de inicio y fin');
            return;
        }
        
        if (new Date(fechaInicio) > new Date(fechaFin)) {
            alert('La fecha de inicio no puede ser mayor que la fecha fin');
            return;
        }
    }
    
    // Construir URL con parámetros
    let url = '{{ route("admin.reportesAdm") }}';
    const params = new URLSearchParams();
    
    params.append('tipo', tipoReporte);
    params.append('periodo', periodo);
    
    if (periodo === 'personalizado' && fechaInicio && fechaFin) {
        params.append('fecha_inicio', fechaInicio);
        params.append('fecha_fin', fechaFin);
    }
    
    // Redirigir con parámetros
    window.location.href = url + '?' + params.toString();
}

// Detectar cambio de período para habilitar/deshabilitar fechas
document.getElementById('periodo').addEventListener('change', function() {
    const periodo = this.value;
    const fechaInicio = document.getElementById('fechaInicio');
    const fechaFin = document.getElementById('fechaFin');
    
    if (periodo === 'personalizado') {
        fechaInicio.disabled = false;
        fechaFin.disabled = false;
        fechaInicio.required = true;
        fechaFin.required = true;
    } else {
        fechaInicio.disabled = true;
        fechaFin.disabled = true;
        fechaInicio.required = false;
        fechaFin.required = false;
    }
});

    // ========================================
    // VER DETALLE DE CLIENTE (MODAL)
    // ========================================
async function verDetalleCliente(idCliente) {
    try {
        const response = await fetch(`/admin/reportes/cliente/${idCliente}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        
        if (!response.ok) {
            throw new Error('Error al cargar los datos');
        }
        
        const result = await response.json();
        
        if (!result.success) {
            throw new Error(result.message);
        }
        
        const data = result;
        
        // Actualizar contenido del modal
        const modal = document.getElementById('modalDetalleCliente');
        
        // Actualizar título y datos del cliente
        modal.querySelector('.premium-card h3').textContent = 
            `${data.cliente.nombre} ${data.cliente.apellido}`;
        modal.querySelector('.premium-card p').innerHTML = `
            <i class="bi bi-envelope"></i> ${data.cliente.correoElectronico} | 
            <i class="bi bi-phone"></i> ${data.cliente.telefono} | 
            <span class="badge bg-success">Cliente VIP</span>
        `;
        
        // Actualizar KPIs
        const kpiValues = modal.querySelectorAll('.kpi-value');
        kpiValues[0].textContent = data.estadisticas.total_citas;
        kpiValues[1].textContent = '$' + data.estadisticas.total_gastado;
        kpiValues[2].textContent = '$' + data.estadisticas.ticket_promedio;
        kpiValues[3].textContent = data.estadisticas.satisfaccion;
        
        // Actualizar tabla de últimas citas
        const tbody = modal.querySelector('tbody');
        tbody.innerHTML = '';
        
        if (data.ultimas_citas.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" class="text-center">No hay citas registradas</td></tr>';
        } else {
            data.ultimas_citas.forEach(cita => {
                const fecha = new Date(cita.fecha).toLocaleDateString('es-SV', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });
                
                const estilista = cita.estilista_nombre && cita.estilista_apellido 
                    ? `${cita.estilista_nombre} ${cita.estilista_apellido}` 
                    : 'N/A';
                
                const estadoClass = cita.estado === 'COMPLETADA' ? 'bg-success' : 'bg-warning';
                
                tbody.innerHTML += `
                    <tr>
                        <td>${fecha}</td>
                        <td>${cita.servicios}</td>
                        <td>${estilista}</td>
                        <td>$${parseFloat(cita.monto).toFixed(2)}</td>
                        <td><span class="badge ${estadoClass}">${cita.estado}</span></td>
                    </tr>
                `;
            });
        }
        
        // Mostrar modal
        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();
        
    } catch (error) {
        console.error('Error al cargar detalle del cliente:', error);
        alert('No se pudo cargar la información del cliente: ' + error.message);
    }
}
    // ========================================
    // VER DETALLE DE ESTILISTA (MODAL)
    // ========================================
    async function verDetalleEstilista(idEstilista) {
        try {
            const response = await fetch(
                `/admin/reportes/estilista/${idEstilista}?fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`,
                {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }
            );
            
            const data = await response.json();
            
            // Actualizar contenido del modal
            const modal = document.getElementById('modalDetalleEstilista');
            
            modal.querySelector('.premium-card h3').textContent = 
                `${data.estilista.nombre} ${data.estilista.apellido} - Estilista Destacado`;
            
            // Actualizar KPIs
            const kpis = modal.querySelectorAll('.kpi-value');
            kpis[0].textContent = data.estadisticas.total_citas;
            kpis[1].textContent = data.estadisticas.clientes_atendidos;
            kpis[2].textContent = '$' + parseFloat(data.estadisticas.ingresos_generados).toFixed(2);
            
            // Mostrar modal
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
            
        } catch (error) {
            console.error('Error al cargar detalle del estilista:', error);
            alert('No se pudo cargar la información del estilista');
        }
    }

    // ========================================
    // EXPORTAR PDF Y EXCEL
    // ========================================
function generarReportePDF() {
    const tipoReporte = document.getElementById('tipoReporte').value;
    const periodo = document.getElementById('periodo').value;
    const fechaInicio = document.getElementById('fechaInicio').value;
    const fechaFin = document.getElementById('fechaFin').value;
    
    // Construir URL con parámetros GET
    let url = '{{ route("admin.reportes.pdf") }}';
    const params = new URLSearchParams();
    
    params.append('tipo', tipoReporte);
    params.append('periodo', periodo);
    
    if (periodo === 'personalizado' && fechaInicio && fechaFin) {
        params.append('fecha_inicio', fechaInicio);
        params.append('fecha_fin', fechaFin);
    }
    
    // Abrir en nueva ventana para descargar
    const urlCompleta = url + '?' + params.toString();
    console.log('URL PDF:', urlCompleta); // Para debugging
    
    window.open(urlCompleta, '_blank');
}

    async function exportarExcel() {
        try {
            const response = await fetch('{{ route("admin.reportes.excel") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    tipo: document.getElementById('tipoReporte').value,
                    periodo: document.getElementById('periodo').value,
                    fecha_inicio: fechaInicio,
                    fecha_fin: fechaFin
                })
            });
            
            const result = await response.json();
            alert(result.message);
        } catch (error) {
            console.error('Error:', error);
            alert('Error al exportar Excel');
        }
    }

    function actualizarReportes() {
        location.reload();
    }

    // ========================================
    // ESTABLECER FECHAS POR DEFECTO
    // ========================================
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInicioInput = document.getElementById('fechaInicio');
        const fechaFinInput = document.getElementById('fechaFin');
        
        if (!fechaInicioInput.value) {
            fechaInicioInput.value = fechaInicio;
        }
        if (!fechaFinInput.value) {
            fechaFinInput.value = fechaFin;
        }

        // Cargar nombre de usuario
        const nombre = localStorage.getItem('clienteNombre') || 'Administrador';
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
    });
</script>

    
</body>
</html>