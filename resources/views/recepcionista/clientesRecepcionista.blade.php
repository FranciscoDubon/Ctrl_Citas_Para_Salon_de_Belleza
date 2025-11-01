<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes Recepcionista | Salón de Belleza</title>
    
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
            <a href="{{ route('recepcionista.dashboardRecep') }}" class="menu-item">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('recepcionista.citasRecep') }}" class="menu-item">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('recepcionista.clientesRecep') }}" class="menu-item active">
                <i class="bi bi-people"></i> Clientes
            </a>
            <a href="{{ route('recepcionista.serviciosRecep') }}" class="menu-item">
                <i class="bi bi-scissors"></i> Servicios
            </a>
            <a href="{{ route('recepcionista.promocionesRecep') }}" class="menu-item">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('recepcionista.configRecep') }}" class="menu-item">
                <i class="bi bi-gear"></i> Configuración
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Gestión de Clientes</h1>
            <p>Administra el registro y la información de los clientes.</p>
        </div>
        
        <div class="header-actions">
            <!-- Usuario -->
            <div class="user-info">
                <div class="user-avatar">L</div>
                <span class="user-name">Laura Hernández - Recepcionista</span>
            </div>
        </div>
    </header>

    <!-- ============================================
         MAIN CONTENT (CONTENIDO PRINCIPAL)
         ============================================ -->
    <main class="main-content">
        
        <!-- Barra de Búsqueda y Acciones -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-10">
                            <label class="form-label" style="margin-bottom: 0.5rem;">
                                <i class="bi bi-search"></i> Buscar Cliente
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="busquedaCliente" 
                                placeholder="Buscar por nombre, apellido, teléfono o email..."
                                onkeyup="buscarCliente()"
                            >
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-gold w-100" onclick="buscarCliente()">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="d-grid gap-2" style="margin-top: 1.8rem;">
                    <button class="btn btn-premium" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                        <i class="bi bi-person-plus"></i> Nuevo Cliente
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtros Rápidos -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <strong style="color: var(--borgona); margin-right: 0.5rem;">
                            <i class="bi bi-funnel"></i> Filtrar por:
                        </strong>
                        <button class="btn btn-sm btn-gold" onclick="filtrarClientes('todos')">
                            <i class="bi bi-people"></i> Todos (247)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarClientes('vip')">
                            <i class="bi bi-star-fill"></i> VIP (23)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarClientes('frecuentes')">
                            <i class="bi bi-heart-fill"></i> Frecuentes (45)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarClientes('nuevos')">
                            <i class="bi bi-person-plus-fill"></i> Nuevos (18)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarClientes('inactivos')">
                            <i class="bi bi-person-dash"></i> Inactivos (12)
                        </button>
                        
                        <div style="border-left: 2px solid var(--rosa-empolvado); height: 30px; margin: 0 0.5rem;"></div>
                        
                        <button class="btn btn-sm btn-soft" onclick="exportarClientes()">
                            <i class="bi bi-file-excel"></i> Exportar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards - Resumen de Clientes -->
        <div class="row g-4 mb-4">
            
            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM usuarios 
            WHERE rol = 'cliente'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">247</h3>
                    <p class="kpi-label">Total Clientes</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +18 este mes
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
            AND estado = 'completada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">142</h3>
                    <p class="kpi-label">Clientes Activos (mes)</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> Con citas
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM usuarios 
            WHERE rol = 'cliente'
            AND DATE(created_at) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-person-plus"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">18</h3>
                    <p class="kpi-label">Nuevos (30 días)</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-calendar"></i> Este mes
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM usuarios u
            WHERE u.rol = 'cliente'
            AND (
                SELECT COUNT(*) FROM citas c 
                WHERE c.cliente_id = u.id 
                AND c.estado = 'completada'
            ) >= 10
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">23</h3>
                    <p class="kpi-label">Clientes VIP</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-trophy"></i> 10+ visitas
                    </span>
                </div>
            </div>
        </div>

        <!-- Tabla de Clientes -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-list-ul"></i>
                        Lista de Clientes Registrados
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT u.id, u.nombre, u.apellido, u.email, u.telefono, 
                           u.direccion, u.fecha_nacimiento, u.created_at,
                           COUNT(c.id) as total_citas,
                           SUM(c.precio_total) as total_gastado,
                           MAX(c.fecha_hora) as ultima_visita
                    FROM usuarios u
                    LEFT JOIN citas c ON u.id = c.cliente_id AND c.estado = 'completada'
                    WHERE u.rol = 'cliente'
                    GROUP BY u.id, u.nombre, u.apellido, u.email, u.telefono, 
                             u.direccion, u.fecha_nacimiento, u.created_at
                    ORDER BY u.apellido, u.nombre
                    ================================================
                    -->
                    <div class="table-responsive" id="tablaClientes">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Contacto</th>
                                    <th>Visitas</th>
                                    <th>Total Gastado</th>
                                    <th>Última Visita</th>
                                    <th>Categoría</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Cliente VIP 1 -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">M</div>
                                            <div>
                                                <strong>María García López</strong><br>
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-cake2"></i> 15 Ene 1990 (34 años)
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> maria.garcia@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-1234<br>
                                            <i class="bi bi-geo-alt"></i> Col. Escalón, San Salvador
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.95rem;">18 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$642.00</strong>
                                    </td>
                                    <td>28 Oct 2024</td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="bi bi-star-fill"></i> VIP
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalVerCliente" onclick="cargarCliente(1)" title="Ver perfil">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalEditarCliente" onclick="cargarEditarCliente(1)" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" onclick="nuevaCitaCliente(1)" title="Nueva cita">
                                            <i class="bi bi-calendar-plus"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cliente VIP 2 -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">A</div>
                                            <div>
                                                <strong>Ana Rodríguez Pérez</strong><br>
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-cake2"></i> 22 Mar 1988 (36 años)
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> ana.rodriguez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-5678<br>
                                            <i class="bi bi-geo-alt"></i> Santa Tecla, La Libertad
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.95rem;">15 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$520.00</strong>
                                    </td>
                                    <td>30 Oct 2024</td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="bi bi-star-fill"></i> VIP
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Ver perfil">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Nueva cita">
                                            <i class="bi bi-calendar-plus"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cliente Frecuente -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">L</div>
                                            <div>
                                                <strong>Laura Martínez Díaz</strong><br>
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-cake2"></i> 10 Jul 1992 (32 años)
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> laura.martinez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-9012<br>
                                            <i class="bi bi-geo-alt"></i> Col. San Benito, San Salvador
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.95rem;">8 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$285.00</strong>
                                    </td>
                                    <td>25 Oct 2024</td>
                                    <td>
                                        <span class="badge badge-gold">
                                            <i class="bi bi-heart-fill"></i> Frecuente
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Ver perfil">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Nueva cita">
                                            <i class="bi bi-calendar-plus"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cliente Frecuente 2 -->
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">C</div>
                                            <div>
                                                <strong>Carla Hernández Silva</strong><br>
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-cake2"></i> 05 Dic 1995 (28 años)
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> carla.hernandez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-3456<br>
                                            <i class="bi bi-geo-alt"></i> Antiguo Cuscatlán
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.95rem;">6 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$195.00</strong>
                                    </td>
                                    <td>20 Oct 2024</td>
                                    <td>
                                        <span class="badge badge-gold">
                                            <i class="bi bi-heart-fill"></i> Frecuente
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Ver perfil">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Nueva cita">
                                            <i class="bi bi-calendar-plus"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cliente Nuevo -->
                                <tr style="background: rgba(212, 175, 55, 0.05);">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">S</div>
                                            <div>
                                                <strong>Sofía Ramírez Castro</strong><br>
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-cake2"></i> 18 Ago 1998 (26 años)
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> sofia.ramirez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-7890<br>
                                            <i class="bi bi-geo-alt"></i> Col. Maquilishuat, San Salvador
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.95rem;">2 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$65.00</strong>
                                    </td>
                                    <td>28 Oct 2024</td>
                                    <td>
                                        <span class="badge badge-soft">
                                            <i class="bi bi-star"></i> Nuevo
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Ver perfil">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Nueva cita">
                                            <i class="bi bi-calendar-plus"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cliente Inactivo -->
                                <tr style="opacity: 0.5;">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 40px; height: 40px;">P</div>
                                            <div>
                                                <strong>Patricia Gómez Ortiz</strong><br>
                                                <small style="color: var(--borgona); opacity: 0.7;">
                                                    <i class="bi bi-cake2"></i> 30 May 1987 (37 años)
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <i class="bi bi-envelope"></i> patricia.gomez@email.com<br>
                                            <i class="bi bi-phone"></i> (503) 7890-1111<br>
                                            <i class="bi bi-geo-alt"></i> Mejicanos, San Salvador
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-luxury" style="font-size: 0.95rem;">5 citas</span>
                                    </td>
                                    <td>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">$175.00</strong>
                                    </td>
                                    <td>15 Ago 2024</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-person-dash"></i> Inactivo
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Ver perfil">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-gold" onclick="reactivarCliente(6)" title="Contactar">
                                            <i class="bi bi-telephone"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div style="color: var(--borgona);">
                            <small>Mostrando 6 de 247 clientes</small>
                        </div>
                        <nav>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" style="color: var(--borgona);">Anterior</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#" style="background: var(--borgona); border-color: var(--borgona);">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="color: var(--borgona);">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="color: var(--borgona);">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" style="color: var(--borgona);">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
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
         MODAL: NUEVO CLIENTE
         ============================================ -->
    <div class="modal fade" id="modalNuevoCliente" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-person-plus" style="color: var(--dorado-palido);"></i> 
                        Registrar Nuevo Cliente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Registro de Cliente
                    ================================================
                    ACCIÓN: Enviar a ruta POST /clientes/crear
                    TABLA: usuarios (rol = 'cliente')
                    VALIDACIONES:
                    - Nombre: requerido, máx 50 caracteres
                    - Apellido: requerido, máx 50 caracteres
                    - Teléfono: requerido, único, formato (503) ####-####
                    - Email: opcional, único si se proporciona, formato email
                    - Fecha nacimiento: opcional, formato fecha
                    ================================================
                    -->
                    <form id="formNuevoCliente">
                        <div class="row g-3">
                            <!-- Información Personal -->
                            <div class="col-12">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-person-circle"></i> Información Personal
                                </h6>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Nombre *</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej: María" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Apellido *</label>
                                <input type="text" class="form-control" name="apellido" placeholder="Ej: García López" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento">
                            </div>

                            <!-- Información de Contacto -->
                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-telephone"></i> Información de Contacto
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" name="telefono" placeholder="(503) 7890-1234" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="cliente@email.com">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Dirección Completa</label>
                                <textarea class="form-control" name="direccion" rows="2" placeholder="Dirección completa del cliente"></textarea>
                            </div>

                            <!-- Notas Adicionales -->
                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-journal-text"></i> Notas y Observaciones
                                </h6>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Notas Adicionales</label>
                                <textarea class="form-control" name="notas" rows="3" placeholder="Preferencias, alergias, observaciones importantes..."></textarea>
                            </div>

                            <!-- Preferencias -->
                            <div class="col-md-6">
                                <label class="form-label">Estilista Preferido</label>
                                <select class="form-select" name="estilista_preferido_id">
                                    <option value="">Sin preferencia</option>
                                    <option value="1">Ana López García</option>
                                    <option value="2">María Torres Sánchez</option>
                                    <option value="3">Sofía Ramírez Cruz</option>
                                    <option value="4">Laura Gómez Ortiz</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">¿Cómo nos conoció?</label>
                                <select class="form-select" name="fuente_conocimiento">
                                    <option value="">Seleccionar...</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="recomendacion">Recomendación</option>
                                    <option value="google">Búsqueda Google</option>
                                    <option value="volante">Volante/Publicidad</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>

                            <!-- Consentimiento -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="acepta_promociones" id="aceptaPromos" checked>
                                    <label class="form-check-label" for="aceptaPromos">
                                        Desea recibir información sobre promociones y novedades
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevoCliente" class="btn btn-gold">
                        <i class="bi bi-save"></i> Registrar Cliente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: EDITAR CLIENTE
         ============================================ -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-pencil" style="color: var(--dorado-palido);"></i> 
                        Editar Información del Cliente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Edición
                    ================================================
                    ACCIÓN: Enviar a ruta PUT /clientes/{id}/actualizar
                    NOTA: Campos pre-llenados con datos actuales
                    ================================================
                    -->
                    <form id="formEditarCliente">
                        <input type="hidden" name="cliente_id" value="1">
                        <!-- Mismo contenido que formNuevoCliente pero con valores -->
                        <div class="row g-3">
                            <div class="col-12">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-person-circle"></i> Información Personal
                                </h6>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Nombre *</label>
                                <input type="text" class="form-control" name="nombre" value="María" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Apellido *</label>
                                <input type="text" class="form-control" name="apellido" value="García López" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" value="1990-01-15">
                            </div>

                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-telephone"></i> Información de Contacto
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" name="telefono" value="(503) 7890-1234" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="maria.garcia@email.com">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Dirección Completa</label>
                                <textarea class="form-control" name="direccion" rows="2">Col. Escalón, San Salvador</textarea>
                            </div>

                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-journal-text"></i> Notas y Observaciones
                                </h6>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Notas Adicionales</label>
                                <textarea class="form-control" name="notas" rows="3">Cliente VIP. Prefiere citas por la tarde. Alérgica a productos con parabenos.</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estilista Preferido</label>
                                <select class="form-select" name="estilista_preferido_id">
                                    <option value="">Sin preferencia</option>
                                    <option value="1" selected>Ana López García</option>
                                    <option value="2">María Torres Sánchez</option>
                                    <option value="3">Sofía Ramírez Cruz</option>
                                    <option value="4">Laura Gómez Ortiz</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">¿Cómo nos conoció?</label>
                                <select class="form-select" name="fuente_conocimiento">
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram" selected>Instagram</option>
                                    <option value="recomendacion">Recomendación</option>
                                    <option value="google">Búsqueda Google</option>
                                    <option value="volante">Volante/Publicidad</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="acepta_promociones" id="aceptaPromosEdit" checked>
                                    <label class="form-check-label" for="aceptaPromosEdit">
                                        Desea recibir información sobre promociones y novedades
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formEditarCliente" class="btn btn-gold">
                        <i class="bi bi-save"></i> Actualizar Cliente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: VER PERFIL COMPLETO DEL CLIENTE
         ============================================ -->
    <div class="modal fade" id="modalVerCliente" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-person-circle" style="color: var(--dorado-palido);"></i> 
                        Perfil del Cliente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Información del Cliente -->
                    <div class="premium-card mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="list-avatar me-3" style="width: 80px; height: 80px; font-size: 2rem;">M</div>
                                    <div>
                                        <h3 style="margin: 0;">María García López</h3>
                                        <p style="margin: 0.5rem 0;">
                                            <i class="bi bi-cake2"></i> 15 Ene 1990 (34 años) | 
                                            <span class="badge bg-success"><i class="bi bi-star-fill"></i> Cliente VIP</span>
                                        </p>
                                        <p style="margin: 0; opacity: 0.9;">
                                            <i class="bi bi-envelope"></i> maria.garcia@email.com | 
                                            <i class="bi bi-phone"></i> (503) 7890-1234
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <button class="btn btn-gold btn-sm mb-2" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalEditarCliente">
                                    <i class="bi bi-pencil"></i> Editar
                                </button>
                                <button class="btn btn-premium btn-sm mb-2">
                                    <i class="bi bi-calendar-plus"></i> Nueva Cita
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- KPIs del Cliente -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="kpi-card">
                                <h3 class="kpi-value" style="font-size: 1.75rem;">18</h3>
                                <p class="kpi-label">Total Visitas</p>
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
                                <h3 class="kpi-value" style="font-size: 1.75rem;">28 Oct</h3>
                                <p class="kpi-label">Última Visita</p>
                            </div>
                        </div>
                    </div>

                    <!-- Información Detallada -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-info-circle"></i> Información Personal
                                </h6>
                                <p><strong>Dirección:</strong> Col. Escalón, San Salvador</p>
                                <p><strong>Estilista Preferido:</strong> Ana López García</p>
                                <p><strong>Cómo nos conoció:</strong> Instagram</p>
                                <p><strong>Cliente desde:</strong> 15 Enero 2024</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-journal-text"></i> Notas Importantes
                                </h6>
                                <div class="alert-custom">
                                    <i class="bi bi-exclamation-circle"></i>
                                    Cliente VIP. Prefiere citas por la tarde. Alérgica a productos con parabenos.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Historial de Citas -->
                    <div class="divider-luxury my-4"></div>
                    
                    <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                        <i class="bi bi-clock-history"></i> Últimas 10 Citas
                    </h6>
                    
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
                                    <td>28 Oct 2024, 9:00 AM</td>
                                    <td>Corte de Cabello</td>
                                    <td>Ana López</td>
                                    <td>$15.00</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                </tr>
                                <tr>
                                    <td>15 Oct 2024, 2:00 PM</td>
                                    <td>Tinte Completo + Tratamiento</td>
                                    <td>Ana López</td>
                                    <td>$75.00</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                </tr>
                                <tr>
                                    <td>02 Oct 2024, 3:30 PM</td>
                                    <td>Manicure + Pedicure</td>
                                    <td>Sofía Ramírez</td>
                                    <td>$25.00</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                </tr>
                                <!-- Más filas... -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-gold">
                        <i class="bi bi-file-pdf"></i> Exportar Historial
                    </button>
                    <button type="button" class="btn btn-gold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalEditarCliente">
                        <i class="bi bi-pencil"></i> Editar Cliente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        // Búsqueda de clientes
        function buscarCliente() {
            const termino = document.getElementById('busquedaCliente').value;
            console.log('Buscando cliente:', termino);
            // TODO: Implementar búsqueda AJAX
            alert('Función de búsqueda - Conectar con backend');
        }

        // Filtrar clientes
        function filtrarClientes(tipo) {
            console.log('Filtrar por:', tipo);
            // TODO: Implementar filtrado
            alert('Filtro aplicado: ' + tipo + ' - Conectar con backend');
        }

        // Exportar clientes
        function exportarClientes() {
            console.log('Exportar clientes');
            alert('Exportando lista de clientes a Excel - Conectar con backend');
        }

        // Cargar datos del cliente en modal
        function cargarCliente(clienteId) {
            console.log('Cargar cliente:', clienteId);
            // TODO: Cargar datos del cliente desde BD
        }

        // Cargar datos para editar
        function cargarEditarCliente(clienteId) {
            console.log('Cargar edición cliente:', clienteId);
            // TODO: Cargar datos del cliente en formulario de edición
        }

        // Nueva cita para cliente
        function nuevaCitaCliente(clienteId) {
            console.log('Nueva cita para cliente:', clienteId);
            alert('Redirigir a módulo de nueva cita con cliente pre-seleccionado');
        }

        // Reactivar cliente inactivo
        function reactivarCliente(clienteId) {
            console.log('Reactivar cliente:', clienteId);
            alert('Enviar SMS/Email de reactivación al cliente - Conectar con backend');
        }

        // Validación formulario nuevo cliente
        document.getElementById('formNuevoCliente')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const telefono = this.querySelector('[name="telefono"]').value;
            
            // Validación básica de teléfono
            if (telefono.length < 10) {
                alert('El teléfono debe tener al menos 10 dígitos');
                return;
            }
            
            console.log('Crear nuevo cliente');
            alert('Formulario validado - Conectar con backend');
        });

        // Validación formulario editar cliente
        document.getElementById('formEditarCliente')?.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Actualizar cliente');
            alert('Formulario validado - Conectar con backend');
        });

        // Búsqueda en tiempo real
        document.getElementById('busquedaCliente')?.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                buscarCliente();
            }
        });
    </script>
    
</body>
</html>