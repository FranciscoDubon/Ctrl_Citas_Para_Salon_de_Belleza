<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Promociones Administrador | Salón de Belleza</title>

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
            <a href="{{ route('dashboardAdm') }}" class="menu-item">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.citasAdm') }}" class="menu-item">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('admin.usuariosAdm') }}" class="menu-item">
                <i class="bi bi-people"></i> Usuarios
            </a>
            <a href="{{ route('admin.serviciosAdm') }}" class="menu-item">
                <i class="bi bi-scissors"></i> Servicios
            </a>
            <a href="{{ route('admin.promocionesAdm') }}" class="menu-item active">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('admin.reportesAdm') }}" class="menu-item">
                <i class="bi bi-graph-up"></i> Reportes
            </a>
            <a href="{{ route('admin.configAdm') }}" class="menu-item">
                <i class="bi bi-gear"></i> Configuración
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Gestión de Promociones</h1>
            <p>Administra promociones y combos.</p>
        </div>

        <div class="header-actions">
            <!-- Usuario -->
            <div class="user-info">
                <div class="user-avatar">A</div>
                <span class="user-name">Administrador</span>
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
                <button class="btn btn-gold me-2" data-bs-toggle="modal" data-bs-target="#modalNuevaPromocion">
                    <i class="bi bi-plus-circle"></i> Nueva Promoción
                </button>
                <button class="btn btn-premium me-2" data-bs-toggle="modal" data-bs-target="#modalNuevoCombo">
                    <i class="bi bi-box-seam"></i> Nuevo Combo
                </button>
                <button class="btn btn-outline-gold me-2">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
                <button class="btn btn-soft">
                    <i class="bi bi-file-earmark-pdf"></i> Exportar
                </button>
            </div>
        </div>

        <!-- KPI Cards - Resumen de Promociones -->
        <div class="row g-4 mb-4">
            
            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM promociones 
            WHERE activo = 1 AND fecha_fin >= CURDATE()
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">6</h3>
                    <p class="kpi-label">Promociones Activas</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> Vigentes
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM combos 
            WHERE activo = 1
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">4</h3>
                    <p class="kpi-label">Combos Disponibles</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> Activos
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
            WHERE promocion_id IS NOT NULL 
            AND MONTH(fecha_hora) = MONTH(CURDATE())
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-ticket-perforated"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">87</h3>
                    <p class="kpi-label">Usos Este Mes</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +15%
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT SUM(descuento_aplicado) as total 
            FROM citas 
            WHERE promocion_id IS NOT NULL 
            AND MONTH(fecha_hora) = MONTH(CURDATE())
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-piggy-bank"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">$342</h3>
                    <p class="kpi-label">Descuentos Otorgados</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-graph-down"></i> Este mes
                    </span>
                </div>
            </div>
        </div>

        <!-- Promociones Activas -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-gift-fill"></i>
                        Promociones Activas
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT id, nombre, descripcion, tipo_descuento, 
                           valor_descuento, fecha_inicio, fecha_fin, 
                           codigo_promocional, usos_maximos, usos_actuales, activo
                    FROM promociones 
                    WHERE activo = 1
                    ORDER BY fecha_inicio DESC
                    ================================================
                    -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Descuento</th>
                                    <th>Código</th>
                                    <th>Vigencia</th>
                                    <th>Usos</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#P001</td>
                                    <td><strong>Black Friday Beauty</strong></td>
                                    <td><span class="badge badge-luxury">PORCENTAJE</span></td>
                                    <td><span class="badge badge-gold">30% OFF</span></td>
                                    <td><code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 5px; font-weight: 600;">BLACK30</code></td>
                                    <td>01 Nov - 30 Nov 2024</td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <strong style="color: var(--borgona);">45</strong> / 100
                                            <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                                <div style="width: 45%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Activa</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarPromocion" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerPromocion" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" onclick="togglePromocion(1)" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>#P002</td>
                                    <td><strong>Nuevo Cliente VIP</strong></td>
                                    <td><span class="badge badge-luxury">FIJO</span></td>
                                    <td><span class="badge badge-gold">$10 OFF</span></td>
                                    <td><code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 5px; font-weight: 600;">NUEVO10</code></td>
                                    <td>01 Oct - 31 Dic 2024</td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <strong style="color: var(--borgona);">23</strong> / 50
                                            <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                                <div style="width: 46%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Activa</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>#P003</td>
                                    <td><strong>Martes de Spa</strong></td>
                                    <td><span class="badge badge-luxury">PORCENTAJE</span></td>
                                    <td><span class="badge badge-gold">20% OFF</span></td>
                                    <td><code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 5px; font-weight: 600;">MARSPA20</code></td>
                                    <td>01 Nov - 31 Dic 2024</td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <strong style="color: var(--borgona);">∞</strong> Ilimitado
                                        </div>
                                    </td>
                                    <td><span class="badge bg-success">Activa</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr style="opacity: 0.6;">
                                    <td>#P004</td>
                                    <td><strong>Halloween Especial</strong></td>
                                    <td><span class="badge badge-luxury">PORCENTAJE</span></td>
                                    <td><span class="badge badge-gold">25% OFF</span></td>
                                    <td><code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 5px; font-weight: 600;">HALLOW25</code></td>
                                    <td>25 Oct - 31 Oct 2024</td>
                                    <td>
                                        <div style="font-size: 0.875rem;">
                                            <strong style="color: var(--borgona);">100</strong> / 100
                                            <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                                                <div style="width: 100%; background: var(--borgona); height: 5px; border-radius: 3px;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-danger">Expirada</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-gold" title="Reactivar">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combos de Servicios -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-box-seam-fill"></i>
                        Combos de Servicios
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT c.id, c.nombre, c.descripcion, c.precio_combo, 
                           c.precio_regular, c.ahorro, c.activo,
                           GROUP_CONCAT(s.nombre) as servicios
                    FROM combos c
                    LEFT JOIN combo_servicios cs ON c.id = cs.combo_id
                    LEFT JOIN servicios s ON cs.servicio_id = s.id
                    GROUP BY c.id
                    ORDER BY c.activo DESC, c.nombre
                    ================================================
                    -->
                    <div class="row g-4">
                        
                        <!-- Combo 1 -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div>
                                        <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">
                                            <i class="bi bi-box-seam" style="color: var(--dorado-palido);"></i>
                                            Combo Novia Perfecta
                                        </h5>
                                        <span class="badge bg-success mt-2">Activo</span>
                                        <span class="badge badge-soft mt-2">Popular</span>
                                    </div>
                                    <div class="text-end">
                                        <div style="text-decoration: line-through; color: var(--borgona); opacity: 0.6; font-size: 0.9rem;">$120.00</div>
                                        <div style="font-size: 2rem; font-weight: 700; color: var(--dorado-palido);">$85.00</div>
                                        <span class="badge badge-gold" style="font-size: 0.75rem;">Ahorra $35</span>
                                    </div>
                                </div>
                                
                                <p style="color: var(--negro-carbon); opacity: 0.8; margin-bottom: 1rem;">
                                    Paquete completo para el día especial: peinado, maquillaje y manicure
                                </p>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                    <i class="bi bi-list-check"></i>
                                    <strong>Servicios incluidos:</strong><br>
                                    • Peinado Especial (60 min)<br>
                                    • Maquillaje Profesional (45 min)<br>
                                    • Manicure Premium (30 min)
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-soft btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalEditarCombo">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-outline-gold btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#modalVerCombo">
                                        <i class="bi bi-eye"></i> Ver Detalles
                                    </button>
                                    <button class="btn btn-premium btn-sm" onclick="toggleCombo(1)">
                                        <i class="bi bi-toggle-on"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Combo 2 -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div>
                                        <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">
                                            <i class="bi bi-box-seam" style="color: var(--dorado-palido);"></i>
                                            Renovación Completa
                                        </h5>
                                        <span class="badge bg-success mt-2">Activo</span>
                                    </div>
                                    <div class="text-end">
                                        <div style="text-decoration: line-through; color: var(--borgona); opacity: 0.6; font-size: 0.9rem;">$75.00</div>
                                        <div style="font-size: 2rem; font-weight: 700; color: var(--dorado-palido);">$55.00</div>
                                        <span class="badge badge-gold" style="font-size: 0.75rem;">Ahorra $20</span>
                                    </div>
                                </div>
                                
                                <p style="color: var(--negro-carbon); opacity: 0.8; margin-bottom: 1rem;">
                                    Renueva tu look completo con corte, tinte y tratamiento
                                </p>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                    <i class="bi bi-list-check"></i>
                                    <strong>Servicios incluidos:</strong><br>
                                    • Corte de Cabello (30 min)<br>
                                    • Tinte Completo (90 min)<br>
                                    • Tratamiento Capilar (45 min)
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-soft btn-sm flex-fill">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-outline-gold btn-sm flex-fill">
                                        <i class="bi bi-eye"></i> Ver Detalles
                                    </button>
                                    <button class="btn btn-premium btn-sm">
                                        <i class="bi bi-toggle-on"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Combo 3 -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div>
                                        <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">
                                            <i class="bi bi-box-seam" style="color: var(--dorado-palido);"></i>
                                            Spa de Manos y Pies
                                        </h5>
                                        <span class="badge bg-success mt-2">Activo</span>
                                    </div>
                                    <div class="text-end">
                                        <div style="text-decoration: line-through; color: var(--borgona); opacity: 0.6; font-size: 0.9rem;">$35.00</div>
                                        <div style="font-size: 2rem; font-weight: 700; color: var(--dorado-palido);">$25.00</div>
                                        <span class="badge badge-gold" style="font-size: 0.75rem;">Ahorra $10</span>
                                    </div>
                                </div>
                                
                                <p style="color: var(--negro-carbon); opacity: 0.8; margin-bottom: 1rem;">
                                    Manicure y pedicure spa completo para máxima relajación
                                </p>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                    <i class="bi bi-list-check"></i>
                                    <strong>Servicios incluidos:</strong><br>
                                    • Manicure Básico (30 min)<br>
                                    • Pedicure Spa (45 min)
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-soft btn-sm flex-fill">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-outline-gold btn-sm flex-fill">
                                        <i class="bi bi-eye"></i> Ver Detalles
                                    </button>
                                    <button class="btn btn-premium btn-sm">
                                        <i class="bi bi-toggle-on"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Combo 4 - Inactivo -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; opacity: 0.6;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div>
                                        <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">
                                            <i class="bi bi-box-seam" style="color: var(--dorado-palido);"></i>
                                            Pack Express
                                        </h5>
                                        <span class="badge bg-secondary mt-2">Inactivo</span>
                                    </div>
                                    <div class="text-end">
                                        <div style="text-decoration: line-through; color: var(--borgona); opacity: 0.6; font-size: 0.9rem;">$45.00</div>
                                        <div style="font-size: 2rem; font-weight: 700; color: var(--borgona); opacity: 0.6;">$35.00</div>
                                        <span class="badge badge-neutral" style="font-size: 0.75rem;">Ahorra $10</span>
                                    </div>
                                </div>
                                
                                <p style="color: var(--negro-carbon); opacity: 0.8; margin-bottom: 1rem;">
                                    Corte y peinado rápido para el día a día
                                </p>

                                <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                    <i class="bi bi-list-check"></i>
                                    <strong>Servicios incluidos:</strong><br>
                                    • Corte de Cabello (30 min)<br>
                                    • Peinado Básico (20 min)
                                </div>

                                <div class="d-flex gap-2 w-100">
                                    <button class="btn btn-soft btn-sm flex-fill">
                                        <i class="bi bi-pencil"></i> Editar
                                    </button>
                                    <button class="btn btn-outline-gold btn-sm flex-fill">
                                        <i class="bi bi-eye"></i> Ver Detalles
                                    </button>
                                    <button class="btn btn-gold btn-sm">
                                        <i class="bi bi-toggle-off"></i>
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
        <p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer>

    <!-- ============================================
         MODAL: NUEVA PROMOCIÓN
         ============================================ -->
    <div class="modal fade" id="modalNuevaPromocion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-gift-fill" style="color: var(--dorado-palido);"></i> 
                        Nueva Promoción
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Creación de Promoción
                    ================================================
                    ACCIÓN: Enviar a ruta POST /promociones/crear
                    TABLA: promociones
                    CAMPOS: nombre, descripcion, tipo_descuento, valor_descuento,
                            fecha_inicio, fecha_fin, codigo_promocional, 
                            usos_maximos, dias_aplicables, servicios_aplicables
                    ================================================
                    -->
                    <form id="formNuevaPromocion">
                        <div class="row g-3">
                            <!-- Nombre -->
                            <div class="col-md-8">
                                <label class="form-label">Nombre de la Promoción *</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej: Black Friday Beauty" required>
                            </div>

                            <!-- Código Promocional -->
                            <div class="col-md-4">
                                <label class="form-label">Código Promocional *</label>
                                <input type="text" class="form-control" name="codigo_promocional" placeholder="Ej: BLACK30" required style="text-transform: uppercase;">
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="2" placeholder="Descripción de la promoción..."></textarea>
                            </div>

                            <!-- Tipo de Descuento -->
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Descuento *</label>
                                <select class="form-select" name="tipo_descuento" id="tipoDescuento" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="porcentaje">Porcentaje (%)</option>
                                    <option value="fijo">Monto Fijo ($)</option>
                                </select>
                            </div>

                            <!-- Valor del Descuento -->
                            <div class="col-md-6">
                                <label class="form-label">Valor del Descuento *</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="simboloDescuento" style="background: var(--dorado-palido); color: var(--borgona); border: 2px solid var(--dorado-palido); font-weight: 700;">%</span>
                                    <input type="number" class="form-control" name="valor_descuento" placeholder="0" step="0.01" min="0" required>
                                </div>
                            </div>

                            <!-- Fecha Inicio -->
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Inicio *</label>
                                <input type="date" class="form-control" name="fecha_inicio" required>
                            </div>

                            <!-- Fecha Fin -->
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Fin *</label>
                                <input type="date" class="form-control" name="fecha_fin" required>
                            </div>

                            <!-- Usos Máximos -->
                            <div class="col-md-6">
                                <label class="form-label">Usos Máximos</label>
                                <input type="number" class="form-control" name="usos_maximos" placeholder="Dejar vacío para ilimitado" min="1">
                                <small class="text-muted">Si se deja vacío, la promoción será ilimitada</small>
                            </div>

                            <!-- Usos por Cliente -->
                            <div class="col-md-6">
                                <label class="form-label">Usos por Cliente</label>
                                <input type="number" class="form-control" name="usos_por_cliente" placeholder="1" value="1" min="1">
                            </div>

                            <!-- Días Aplicables -->
                            <div class="col-12">
                                <label class="form-label">Días Aplicables</label>
                                <div class="alert-custom">
                                    <i class="bi bi-calendar3"></i>
                                    <strong>Selecciona los días en que aplica esta promoción:</strong>
                                </div>
                                <div class="row g-2 mt-2">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="lunes" id="lunes">
                                            <label class="form-check-label" for="lunes">Lunes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="martes" id="martes">
                                            <label class="form-check-label" for="martes">Martes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="miercoles" id="miercoles">
                                            <label class="form-check-label" for="miercoles">Miércoles</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="jueves" id="jueves">
                                            <label class="form-check-label" for="jueves">Jueves</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="viernes" id="viernes">
                                            <label class="form-check-label" for="viernes">Viernes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="sabado" id="sabado">
                                            <label class="form-check-label" for="sabado">Sábado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="domingo" id="domingo">
                                            <label class="form-check-label" for="domingo">Domingo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-sm btn-soft w-100" onclick="seleccionarTodosDias()">
                                            <i class="bi bi-check-all"></i> Todos
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="activo" id="activoPromo" checked>
                                    <label class="form-check-label" for="activoPromo">
                                        Activar promoción inmediatamente
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevaPromocion" class="btn btn-gold">
                        <i class="bi bi-save"></i> Crear Promoción
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: NUEVO COMBO
         ============================================ -->
    <div class="modal fade" id="modalNuevoCombo" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-box-seam-fill" style="color: var(--dorado-palido);"></i> 
                        Nuevo Combo de Servicios
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Creación de Combo
                    ================================================
                    ACCIÓN: Enviar a ruta POST /combos/crear
                    TABLAS: combos, combo_servicios
                    ================================================
                    -->
                    <form id="formNuevoCombo">
                        <div class="row g-3">
                            <!-- Nombre del Combo -->
                            <div class="col-md-8">
                                <label class="form-label">Nombre del Combo *</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej: Combo Novia Perfecta" required>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-4">
                                <label class="form-label">Estado *</label>
                                <select class="form-select" name="activo" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label class="form-label">Descripción del Combo</label>
                                <textarea class="form-control" name="descripcion" rows="2" placeholder="Descripción atractiva del combo..."></textarea>
                            </div>

                            <div class="col-12">
                                <div class="divider-luxury"></div>
                            </div>

                            <!-- Selección de Servicios -->
                            <div class="col-12">
                                <div class="alert-custom">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>Selecciona los servicios que incluye este combo:</strong>
                                </div>
                            </div>

                            <!-- 
                            ================================================
                            TODO BACKEND: Cargar servicios disponibles
                            ================================================
                            CONSULTA SQL:
                            SELECT id, nombre, precio, duracion_minutos 
                            FROM servicios 
                            WHERE activo = 1
                            ORDER BY categoria, nombre
                            ================================================
                            -->
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table-custom">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">
                                                    <input type="checkbox" id="selectAll" onchange="toggleAllServicios()">
                                                </th>
                                                <th>Servicio</th>
                                                <th>Precio</th>
                                                <th>Duración</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input class="form-check-input servicio-check" type="checkbox" name="servicios[]" value="1" data-precio="15.00">
                                                </td>
                                                <td>Corte de Cabello</td>
                                                <td><span class="badge badge-gold">$15.00</span></td>
                                                <td>30 min</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="form-check-input servicio-check" type="checkbox" name="servicios[]" value="2" data-precio="40.00">
                                                </td>
                                                <td>Tinte Completo</td>
                                                <td><span class="badge badge-gold">$40.00</span></td>
                                                <td>90 min</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="form-check-input servicio-check" type="checkbox" name="servicios[]" value="3" data-precio="30.00">
                                                </td>
                                                <td>Peinado Especial</td>
                                                <td><span class="badge badge-gold">$30.00</span></td>
                                                <td>60 min</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="form-check-input servicio-check" type="checkbox" name="servicios[]" value="4" data-precio="10.00">
                                                </td>
                                                <td>Manicure Básico</td>
                                                <td><span class="badge badge-gold">$10.00</span></td>
                                                <td>30 min</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="form-check-input servicio-check" type="checkbox" name="servicios[]" value="5" data-precio="15.00">
                                                </td>
                                                <td>Pedicure Spa</td>
                                                <td><span class="badge badge-gold">$15.00</span></td>
                                                <td>45 min</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input class="form-check-input servicio-check" type="checkbox" name="servicios[]" value="6" data-precio="25.00">
                                                </td>
                                                <td>Maquillaje Profesional</td>
                                                <td><span class="badge badge-gold">$25.00</span></td>
                                                <td>45 min</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="divider-luxury"></div>
                            </div>

                            <!-- Resumen de Precios -->
                            <div class="col-12">
                                <div class="premium-card">
                                    <h3 style="margin-bottom: 1.5rem;">💰 Resumen de Precios</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Precio Regular Total:</p>
                                            <h4 style="color: var(--rosa-empolvado); margin: 0.5rem 0;" id="precioRegularTotal">$0.00</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" style="color: var(--blanco-humo);">Precio del Combo *</label>
                                            <div class="input-group">
                                                <span class="input-group-text" style="background: var(--dorado-palido); color: var(--borgona); border: 2px solid var(--dorado-palido); font-weight: 700;">$</span>
                                                <input type="number" class="form-control" name="precio_combo" id="precioCombo" placeholder="0.00" step="0.01" min="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Ahorro para el Cliente:</p>
                                            <h4 style="color: var(--dorado-palido); margin: 0.5rem 0;" id="ahorroTotal">$0.00</h4>
                                            <p style="color: var(--blanco-humo); opacity: 0.7; font-size: 0.875rem; margin: 0;" id="porcentajeAhorro">0% de descuento</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevoCombo" class="btn btn-premium">
                        <i class="bi bi-save"></i> Crear Combo
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: EDITAR PROMOCIÓN
         ============================================ -->
    <div class="modal fade" id="modalEditarPromocion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-pencil" style="color: var(--dorado-palido);"></i> 
                        Editar Promoción
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarPromocion">
                        <input type="hidden" name="promocion_id" value="1">
                        <!-- Mismo contenido que formNuevaPromocion pero con valores pre-llenados -->
                        <p class="text-muted"><small>Campos similares a Nueva Promoción con datos pre-cargados</small></p>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formEditarPromocion" class="btn btn-gold">
                        <i class="bi bi-save"></i> Actualizar Promoción
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        // Toggle estado promoción
        function togglePromocion(id) {
            console.log('Toggle promoción:', id);
            alert('Función toggle promoción - Conectar con backend');
        }

        // Toggle estado combo
        function toggleCombo(id) {
            console.log('Toggle combo:', id);
            alert('Función toggle combo - Conectar con backend');
        }

        // Seleccionar todos los días
        function seleccionarTodosDias() {
            const checkboxes = document.querySelectorAll('input[name="dias[]"]');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        }

        // Cambiar símbolo según tipo de descuento
        document.getElementById('tipoDescuento')?.addEventListener('change', function() {
            const simbolo = document.getElementById('simboloDescuento');
            simbolo.textContent = this.value === 'porcentaje' ? '%' : '$';
        });

        // Toggle todos los servicios
        function toggleAllServicios() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.servicio-check');
            checkboxes.forEach(cb => cb.checked = selectAll.checked);
            calcularPreciosCombo();
        }

        // Calcular precios del combo
        function calcularPreciosCombo() {
            const checkboxes = document.querySelectorAll('.servicio-check:checked');
            let total = 0;
            
            checkboxes.forEach(cb => {
                total += parseFloat(cb.dataset.precio);
            });

            document.getElementById('precioRegularTotal').textContent = '$' + total.toFixed(2);
            
            const precioCombo = parseFloat(document.getElementById('precioCombo').value) || 0;
            const ahorro = total - precioCombo;
            const porcentaje = total > 0 ? ((ahorro / total) * 100).toFixed(1) : 0;

            document.getElementById('ahorroTotal').textContent = '$' + ahorro.toFixed(2);
            document.getElementById('porcentajeAhorro').textContent = porcentaje + '% de descuento';
        }

        // Event listeners
        document.querySelectorAll('.servicio-check').forEach(cb => {
            cb.addEventListener('change', calcularPreciosCombo);
        });

        document.getElementById('precioCombo')?.addEventListener('input', calcularPreciosCombo);

        // Validación formulario nueva promoción
        document.getElementById('formNuevaPromocion')?.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Crear nueva promoción');
            alert('Formulario validado - Conectar con backend');
        });

        // Validación formulario nuevo combo
        document.getElementById('formNuevoCombo')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const serviciosSeleccionados = document.querySelectorAll('.servicio-check:checked').length;
            
            if (serviciosSeleccionados < 2) {
                alert('Debes seleccionar al menos 2 servicios para crear un combo');
                return;
            }

            const precioCombo = parseFloat(document.getElementById('precioCombo').value);
            const precioRegular = parseFloat(document.getElementById('precioRegularTotal').textContent.replace('$', ''));

            if (precioCombo >= precioRegular) {
                alert('El precio del combo debe ser menor al precio regular para que sea atractivo');
                return;
            }

            console.log('Crear nuevo combo');
            alert('Formulario validado - Conectar con backend');
        });
    </script>
    
</body>
</html>