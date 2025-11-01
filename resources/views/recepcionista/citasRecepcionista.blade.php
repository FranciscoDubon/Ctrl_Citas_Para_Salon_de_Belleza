<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas Recepcionista | Salón de Belleza</title>
    
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
            <a href="{{ route('recepcionista.citasRecep') }}" class="menu-item active">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('recepcionista.clientesRecep') }}" class="menu-item">
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
            <h1>Gestión de Citas</h1>
            <p>Administra la programación y el control de la agenda.</p>
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
        
        <!-- Botones de Acción y Filtros -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <button class="btn btn-gold me-2" data-bs-toggle="modal" data-bs-target="#modalNuevaCita">
                    <i class="bi bi-plus-circle"></i> Nueva Cita
                </button>
                <button class="btn btn-premium me-2" onclick="actualizarAgenda()">
                    <i class="bi bi-arrow-clockwise"></i> Actualizar
                </button>
                <button class="btn btn-outline-gold" onclick="imprimirAgenda()">
                    <i class="bi bi-printer"></i> Imprimir
                </button>
            </div>
            
            <div class="col-lg-6">
                <div class="card-custom" style="padding: 0.75rem;">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <label class="form-label mb-1" style="font-size: 0.875rem;">
                                <i class="bi bi-calendar3"></i> Fecha
                            </label>
                            <input type="date" class="form-control form-control-sm" id="fechaFiltro" onchange="filtrarPorFecha()">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1" style="font-size: 0.875rem;">
                                <i class="bi bi-person"></i> Estilista
                            </label>
                            <select class="form-select form-select-sm" id="estilistaFiltro" onchange="filtrarPorEstilista()">
                                <option value="">Todos</option>
                                <option value="1">Ana López</option>
                                <option value="2">María Torres</option>
                                <option value="3">Sofía Ramírez</option>
                                <option value="4">Laura Gómez</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label mb-1" style="font-size: 0.875rem;">
                                <i class="bi bi-funnel"></i> Estado
                            </label>
                            <select class="form-select form-select-sm" id="estadoFiltro" onchange="filtrarPorEstado()">
                                <option value="">Todos</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="en_proceso">En Proceso</option>
                                <option value="completada">Completada</option>
                                <option value="cancelada">Cancelada</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards - Resumen de Citas -->
        <div class="row g-4 mb-4">
            
            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM citas 
            WHERE DATE(fecha_hora) = CURDATE()
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">18</h3>
                    <p class="kpi-label">Citas Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> 12 completadas
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
            AND estado = 'pendiente'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">6</h3>
                    <p class="kpi-label">Pendientes</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-exclamation-circle"></i> Sin confirmar
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
            WHERE DATE(fecha_hora) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">22</h3>
                    <p class="kpi-label">Citas Mañana</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-right"></i> Sábado 01 Nov
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
            AND estado = 'cancelada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">2</h3>
                    <p class="kpi-label">Canceladas Hoy</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-info-circle"></i> Motivos varios
                    </span>
                </div>
            </div>
        </div>

        <!-- Agenda Completa de Estilistas -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-calendar3"></i>
                        Agenda Completa - Viernes, 31 de Octubre 2024
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT c.id, c.fecha_hora, c.estado, c.precio_total, c.notas,
                           u.nombre as cliente_nombre, u.apellido as cliente_apellido, 
                           u.telefono as cliente_telefono,
                           e.nombre as estilista_nombre, e.apellido as estilista_apellido,
                           s.nombre as servicio_nombre, s.duracion_minutos,
                           p.nombre as promocion_nombre, p.codigo_promocional
                    FROM citas c
                    INNER JOIN usuarios u ON c.cliente_id = u.id
                    INNER JOIN usuarios e ON c.estilista_id = e.id
                    INNER JOIN servicios s ON c.servicio_id = s.id
                    LEFT JOIN promociones p ON c.promocion_id = p.id
                    WHERE DATE(c.fecha_hora) = CURDATE()
                    ORDER BY c.fecha_hora ASC
                    ================================================
                    -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hora</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th>Servicio</th>
                                    <th>Estilista</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Cita Completada -->
                                <tr style="background: rgba(212, 175, 55, 0.05);">
                                    <td><strong>#001</strong></td>
                                    <td><strong style="color: var(--borgona);">09:00 AM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">M</div>
                                            <strong>María García</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-1234</small></td>
                                    <td>Corte de Cabello</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-1" style="width: 25px; height: 25px; font-size: 0.7rem;">A</div>
                                            <small>Ana López</small>
                                        </div>
                                    </td>
                                    <td>30 min</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerCita" onclick="cargarCita(1)" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita En Proceso -->
                                <tr style="background: rgba(128, 0, 32, 0.08); border-left: 4px solid var(--borgona);">
                                    <td><strong>#002</strong></td>
                                    <td><strong style="color: var(--borgona);">10:30 AM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">A</div>
                                            <strong>Ana Rodríguez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-5678</small></td>
                                    <td>
                                        Manicure + Pedicure
                                        <br><small style="color: var(--dorado-palido);"><i class="bi bi-gift"></i> Promo 20% OFF</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-1" style="width: 25px; height: 25px; font-size: 0.7rem;">S</div>
                                            <small>Sofía Ramírez</small>
                                        </div>
                                    </td>
                                    <td>75 min</td>
                                    <td><span class="badge bg-primary">En Proceso</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" onclick="completarCita(2)" title="Marcar completada">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Confirmada - Próxima -->
                                <tr style="border-left: 4px solid var(--dorado-palido);">
                                    <td><strong>#003</strong></td>
                                    <td><strong style="color: var(--borgona);">12:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">L</div>
                                            <strong>Laura Martínez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-9012</small></td>
                                    <td>Tinte Completo</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-1" style="width: 25px; height: 25px; font-size: 0.7rem;">M</div>
                                            <small>María Torres</small>
                                        </div>
                                    </td>
                                    <td>90 min</td>
                                    <td><span class="badge bg-info">Confirmada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarCita" onclick="cargarEditarCita(3)" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" onclick="iniciarCita(3)" title="Iniciar servicio">
                                            <i class="bi bi-play-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Pendiente -->
                                <tr style="background: rgba(232, 180, 184, 0.1);">
                                    <td><strong>#004</strong></td>
                                    <td><strong style="color: var(--borgona);">02:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">C</div>
                                            <strong>Carla Hernández</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-3456</small></td>
                                    <td>
                                        Peinado Especial
                                        <br><small style="color: var(--dorado-palido);"><i class="bi bi-box-seam"></i> Combo Novia</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-1" style="width: 25px; height: 25px; font-size: 0.7rem;">A</div>
                                            <small>Ana López</small>
                                        </div>
                                    </td>
                                    <td>60 min</td>
                                    <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium me-1" onclick="confirmarCita(4)" title="Confirmar">
                                            <i class="bi bi-telephone"></i>
                                        </button>
                                        <button class="btn btn-sm btn-gold" onclick="mostrarCancelar(4)" title="Cancelar">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Confirmada -->
                                <tr>
                                    <td><strong>#005</strong></td>
                                    <td><strong style="color: var(--borgona);">03:30 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">S</div>
                                            <strong>Sofía Ramírez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-7890</small></td>
                                    <td>Limpieza Facial</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-1" style="width: 25px; height: 25px; font-size: 0.7rem;">M</div>
                                            <small>María Torres</small>
                                        </div>
                                    </td>
                                    <td>60 min</td>
                                    <td><span class="badge bg-info">Confirmada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-gold" onclick="mostrarCancelar(5)" title="Cancelar">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Confirmada -->
                                <tr>
                                    <td><strong>#006</strong></td>
                                    <td><strong style="color: var(--borgona);">05:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">R</div>
                                            <strong>Rosa Méndez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-2222</small></td>
                                    <td>
                                        Uñas Acrílicas
                                        <br><small style="color: var(--dorado-palido);"><i class="bi bi-star"></i> Cliente Nuevo - NUEVO10</small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-1" style="width: 25px; height: 25px; font-size: 0.7rem;">S</div>
                                            <small>Sofía Ramírez</small>
                                        </div>
                                    </td>
                                    <td>90 min</td>
                                    <td><span class="badge bg-info">Confirmada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-gold" onclick="mostrarCancelar(6)" title="Cancelar">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Cancelada -->
                                <tr style="opacity: 0.5; text-decoration: line-through;">
                                    <td><strong>#007</strong></td>
                                    <td><strong style="color: var(--borgona);">04:30 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">P</div>
                                            <strong>Patricia Gómez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-1111</small></td>
                                    <td>Manicure Básico</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-1" style="width: 25px; height: 25px; font-size: 0.7rem;">L</div>
                                            <small>Laura Gómez</small>
                                        </div>
                                    </td>
                                    <td>30 min</td>
                                    <td><span class="badge bg-danger">Cancelada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver motivo">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vista por Estilista -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-people-fill"></i>
                        Vista por Estilista - Viernes, 31 de Octubre 2024
                    </h5>
                    
                    <div class="row g-4">
                        <!-- Ana López -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-2" style="width: 50px; height: 50px; font-size: 1.2rem;">A</div>
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0; font-weight: 700;">Ana López García</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">5 citas hoy</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-success">Disponible</span>
                                </div>

                                <div class="w-100">
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0.5rem; border-left: 3px solid var(--dorado-palido);">
                                        <strong style="color: var(--borgona);">09:00 AM</strong> - María García - Corte de Cabello (30 min)
                                        <span class="badge bg-success float-end">Completada</span>
                                    </div>
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0.5rem; border-left: 3px solid var(--rosa-empolvado);">
                                        <strong style="color: var(--borgona);">02:00 PM</strong> - Carla Hernández - Peinado Especial (60 min)
                                        <span class="badge bg-warning text-dark float-end">Pendiente</span>
                                    </div>
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0; border-left: 3px solid var(--dorado-palido);">
                                        <strong style="color: var(--dorado-palido);">Disponible desde: 3:30 PM</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- María Torres -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-2" style="width: 50px; height: 50px; font-size: 1.2rem;">M</div>
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0; font-weight: 700;">María Torres Sánchez</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">4 citas hoy</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-success">Disponible</span>
                                </div>

                                <div class="w-100">
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0.5rem; border-left: 3px solid var(--dorado-palido);">
                                        <strong style="color: var(--borgona);">12:00 PM</strong> - Laura Martínez - Tinte Completo (90 min)
                                        <span class="badge bg-info float-end">Confirmada</span>
                                    </div>
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0.5rem; border-left: 3px solid var(--dorado-palido);">
                                        <strong style="color: var(--borgona);">03:30 PM</strong> - Sofía Ramírez - Limpieza Facial (60 min)
                                        <span class="badge bg-info float-end">Confirmada</span>
                                    </div>
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0; border-left: 3px solid var(--dorado-palido);">
                                        <strong style="color: var(--dorado-palido);">Disponible desde: 5:00 PM</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sofía Ramírez -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: rgba(232, 180, 184, 0.1);">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-2" style="width: 50px; height: 50px; font-size: 1.2rem;">S</div>
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0; font-weight: 700;">Sofía Ramírez Cruz</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">6 citas hoy</small>
                                        </div>
                                    </div>
                                    <span class="badge bg-primary">Ocupada</span>
                                </div>

                                <div class="w-100">
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0.5rem; border-left: 3px solid var(--borgona); background: rgba(128, 0, 32, 0.1);">
                                        <strong style="color: var(--borgona);">10:30 AM</strong> - Ana Rodríguez - Manicure + Pedicure (75 min)
                                        <span class="badge bg-primary float-end">En Proceso</span>
                                    </div>
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0.5rem; border-left: 3px solid var(--dorado-palido);">
                                        <strong style="color: var(--borgona);">05:00 PM</strong> - Rosa Méndez - Uñas Acrílicas (90 min)
                                        <span class="badge bg-info float-end">Confirmada</span>
                                    </div>
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0; border-left: 3px solid var(--borgona);">
                                        <strong style="color: var(--borgona);">Atendiendo cliente hasta: 11:45 AM</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Laura Gómez -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar me-2" style="width: 50px; height: 50px; font-size: 1.2rem;">L</div>
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0; font-weight: 700;">Laura Gómez Ortiz</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">3 citas hoy</small>
                                        </div>
                                    </div>
                                    <span class="badge badge-gold"><i class="bi bi-lightning-fill"></i> Libre</span>
                                </div>

                                <div class="w-100">
                                    <div class="alert-custom" style="padding: 0.5rem; margin-bottom: 0; border-left: 3px solid var(--dorado-palido); background: rgba(212, 175, 55, 0.1);">
                                        <strong style="color: var(--dorado-palido);"><i class="bi bi-star-fill"></i> Disponible inmediatamente</strong>
                                        <br>
                                        <small>Sin citas programadas en este momento</small>
                                    </div>
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
        <p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer>

    <!-- ============================================
         MODAL: NUEVA CITA
         ============================================ -->
    <div class="modal fade" id="modalNuevaCita" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-plus-circle" style="color: var(--dorado-palido);"></i> 
                        Agendar Nueva Cita
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Nueva Cita
                    ================================================
                    ACCIÓN: Enviar a ruta POST /citas/crear
                    VALIDACIONES:
                    - Cliente: requerido, existe en BD
                    - Servicio: requerido, existe y activo
                    - Estilista: requerido, existe y activo
                    - Fecha/Hora: requerida, futura, no conflicto
                    - Verificar disponibilidad de estilista
                    ================================================
                    -->
                    <form id="formNuevaCita">
                        <div class="row g-3">
                            <!-- Cliente -->
                            <div class="col-12">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-person-circle"></i> Información del Cliente
                                </h6>
                            </div>

                            <div class="col-md-9">
                                <label class="form-label">Cliente *</label>
                                <select class="form-select" name="cliente_id" id="clienteSelect" required>
                                    <option value="">Buscar cliente...</option>
                                    <option value="1">María García López - (503) 7890-1234</option>
                                    <option value="2">Ana Rodríguez Pérez - (503) 7890-5678</option>
                                    <option value="3">Laura Martínez Díaz - (503) 7890-9012</option>
                                    <option value="4">Carla Hernández Silva - (503) 7890-3456</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-soft w-100" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente">
                                    <i class="bi bi-person-plus"></i> Nuevo Cliente
                                </button>
                            </div>

                            <!-- Servicio -->
                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-scissors"></i> Servicio y Estilista
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Servicio *</label>
                                <select class="form-select" name="servicio_id" id="servicioSelect" onchange="actualizarDuracion()" required>
                                    <option value="">Seleccionar servicio...</option>
                                    <option value="1" data-duracion="30" data-precio="15.00">Corte de Cabello - $15.00 (30 min)</option>
                                    <option value="2" data-duracion="90" data-precio="40.00">Tinte Completo - $40.00 (90 min)</option>
                                    <option value="3" data-duracion="60" data-precio="30.00">Peinado Especial - $30.00 (60 min)</option>
                                    <option value="4" data-duracion="45" data-precio="35.00">Tratamiento Capilar - $35.00 (45 min)</option>
                                    <option value="5" data-duracion="30" data-precio="10.00">Manicure Básico - $10.00 (30 min)</option>
                                    <option value="6" data-duracion="45" data-precio="15.00">Pedicure Spa - $15.00 (45 min)</option>
                                    <option value="7" data-duracion="90" data-precio="25.00">Uñas Acrílicas - $25.00 (90 min)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estilista *</label>
                                <select class="form-select" name="estilista_id" required>
                                    <option value="">Seleccionar estilista...</option>
                                    <option value="1">Ana López García</option>
                                    <option value="2">María Torres Sánchez</option>
                                    <option value="3">Sofía Ramírez Cruz</option>
                                    <option value="4">Laura Gómez Ortiz</option>
                                </select>
                            </div>

                            <!-- Fecha y Hora -->
                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-calendar3"></i> Fecha y Hora
                                </h6>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha *</label>
                                <input type="date" class="form-control" name="fecha" id="fechaCita" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Hora *</label>
                                <input type="time" class="form-control" name="hora" id="horaCita" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Duración Estimada</label>
                                <input type="text" class="form-control" id="duracionEstimada" value="-- min" readonly style="background: var(--champagne-light);">
                            </div>

                            <!-- Promoción -->
                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-gift"></i> Promoción (Opcional)
                                </h6>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">Código Promocional</label>
                                <input type="text" class="form-control" name="codigo_promocional" id="codigoPromo" placeholder="Ej: BLACK30, NUEVO10">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-outline-gold w-100" onclick="validarPromocion()">
                                    <i class="bi bi-check-circle"></i> Validar Código
                                </button>
                            </div>

                            <div class="col-12" id="promoValidada" style="display: none;">
                                <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido);">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <strong style="color: var(--dorado-palido);">¡Promoción válida!</strong><br>
                                    <span id="promoDetalle"></span>
                                </div>
                            </div>

                            <!-- Notas -->
                            <div class="col-12">
                                <label class="form-label">Notas Adicionales</label>
                                <textarea class="form-control" name="notas" rows="2" placeholder="Observaciones, preferencias especiales, etc."></textarea>
                            </div>

                            <!-- Resumen -->
                            <div class="col-12 mt-4">
                                <div class="premium-card">
                                    <h6 style="margin-bottom: 1rem;">💰 Resumen de la Cita</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Precio Base:</p>
                                            <h5 style="color: var(--rosa-empolvado); margin: 0.5rem 0;" id="precioBase">$0.00</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Descuento:</p>
                                            <h5 style="color: var(--dorado-palido); margin: 0.5rem 0;" id="descuento">$0.00</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Total a Pagar:</p>
                                            <h5 style="color: var(--dorado-palido); margin: 0.5rem 0; font-size: 1.5rem;" id="totalPagar">$0.00</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevaCita" class="btn btn-gold">
                        <i class="bi bi-save"></i> Agendar Cita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: EDITAR CITA
         ============================================ -->
    <div class="modal fade" id="modalEditarCita" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-pencil" style="color: var(--dorado-palido);"></i> 
                        Editar Cita #003
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Edición
                    ================================================
                    ACCIÓN: Enviar a ruta PUT /citas/{id}/actualizar
                    NOTA: Campos pre-llenados con datos actuales
                    ================================================
                    -->
                    <form id="formEditarCita">
                        <input type="hidden" name="cita_id" value="3">
                        <!-- Mismo contenido que formNuevaCita pero con valores -->
                        <p class="text-center">Formulario similar a Nueva Cita con datos pre-cargados</p>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formEditarCita" class="btn btn-gold">
                        <i class="bi bi-save"></i> Actualizar Cita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: VER DETALLES DE CITA
         ============================================ -->
    <div class="modal fade" id="modalVerCita" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-info-circle" style="color: var(--dorado-palido);"></i> 
                        Detalles de la Cita #001
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="premium-card mb-3">
                        <h5>Cita Completada <span class="badge bg-success float-end">Completada</span></h5>
                        <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">
                            <i class="bi bi-calendar3"></i> Viernes, 31 de Octubre 2024 - 09:00 AM
                        </p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-person"></i> Cliente
                                </h6>
                                <p><strong>Nombre:</strong> María García López</p>
                                <p><strong>Teléfono:</strong> (503) 7890-1234</p>
                                <p><strong>Email:</strong> maria.garcia@email.com</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-scissors"></i> Servicio
                                </h6>
                                <p><strong>Servicio:</strong> Corte de Cabello</p>
                                <p><strong>Estilista:</strong> Ana López García</p>
                                <p><strong>Duración:</strong> 30 minutos</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-cash-stack"></i> Información de Pago
                                </h6>
                                <p><strong>Precio Base:</strong> $15.00</p>
                                <p><strong>Descuento:</strong> $0.00</p>
                                <p><strong style="color: var(--borgona); font-size: 1.2rem;">Total Pagado:</strong> <strong style="color: var(--borgona); font-size: 1.2rem;">$15.00</strong></p>
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
        document.getElementById('fechaFiltro').value = new Date().toISOString().split('T')[0];
        document.getElementById('fechaCita')?.value = new Date().toISOString().split('T')[0];

        function actualizarAgenda() {
            console.log('Actualizar agenda');
            location.reload();
        }

        function filtrarPorFecha() {
            const fecha = document.getElementById('fechaFiltro').value;
            console.log('Filtrar por fecha:', fecha);
            alert('Filtro por fecha - Conectar con backend');
        }

        function filtrarPorEstilista() {
            const estilista = document.getElementById('estilistaFiltro').value;
            console.log('Filtrar por estilista:', estilista);
            alert('Filtro por estilista - Conectar con backend');
        }

        function filtrarPorEstado() {
            const estado = document.getElementById('estadoFiltro').value;
            console.log('Filtrar por estado:', estado);
            alert('Filtro por estado - Conectar con backend');
        }

        function imprimirAgenda() {
            console.log('Imprimir agenda');
            window.print();
        }

        function cargarCita(citaId) {
            console.log('Cargar cita:', citaId);
        }

        function cargarEditarCita(citaId) {
            console.log('Cargar editar cita:', citaId);
        }

        function confirmarCita(citaId) {
            console.log('Confirmar cita:', citaId);
            alert('Enviar SMS/Email de confirmación - Conectar con backend');
        }

        function iniciarCita(citaId) {
            console.log('Iniciar cita:', citaId);
            if(confirm('¿Marcar esta cita como "En Proceso"?')) {
                alert('Cita iniciada - Conectar con backend');
            }
        }

        function completarCita(citaId) {
            console.log('Completar cita:', citaId);
            if(confirm('¿Marcar esta cita como "Completada"?')) {
                alert('Cita completada - Conectar con backend');
            }
        }

        function mostrarCancelar(citaId) {
            const motivo = prompt('¿Motivo de cancelación?');
            if(motivo) {
                console.log('Cancelar cita:', citaId, 'Motivo:', motivo);
                alert('Cita cancelada - Conectar con backend');
            }
        }

        function actualizarDuracion() {
            const select = document.getElementById('servicioSelect');
            const option = select.options[select.selectedIndex];
            const duracion = option.getAttribute('data-duracion');
            const precio = option.getAttribute('data-precio');
            
            if(duracion && precio) {
                document.getElementById('duracionEstimada').value = duracion + ' min';
                document.getElementById('precioBase').textContent = '$' + precio;
                document.getElementById('totalPagar').textContent = '$' + precio;
            }
        }

        function validarPromocion() {
            const codigo = document.getElementById('codigoPromo').value;
            if(!codigo) {
                alert('Ingrese un código promocional');
                return;
            }
            
            console.log('Validar promoción:', codigo);
            // TODO: Validar con backend
            
            // Simulación
            document.getElementById('promoValidada').style.display = 'block';
            document.getElementById('promoDetalle').textContent = '30% de descuento aplicado - Código: ' + codigo;
            document.getElementById('descuento').textContent = '$4.50';
            document.getElementById('totalPagar').textContent = '$10.50';
        }

        // Validación formulario nueva cita
        document.getElementById('formNuevaCita')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const cliente = this.querySelector('[name="cliente_id"]').value;
            const servicio = this.querySelector('[name="servicio_id"]').value;
            const estilista = this.querySelector('[name="estilista_id"]').value;
            const fecha = this.querySelector('[name="fecha"]').value;
            const hora = this.querySelector('[name="hora"]').value;
            
            if(!cliente || !servicio || !estilista || !fecha || !hora) {
                alert('Complete todos los campos requeridos');
                return;
            }
            
            console.log('Crear nueva cita');
            alert('Cita agendada exitosamente - Conectar con backend');
        });
    </script>
    
</body>
</html>