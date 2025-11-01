<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente | Salón de Belleza</title>
    
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
            <a href="{{ route('cliente.dashboardCli') }}" class="menu-item active">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
            <a href="{{ route('cliente.citasCli') }}" class="menu-item">
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
            <h1>Panel del Cliente</h1>
            <p>Consulta tus citas, promociones y servicios disponibles.</p>
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
        
    <!-- Botones para redirigir a las siguientes pestañas por que como trabajamos por roles, esto solo se encontraran solo en los dashboards y de ahi se van a subdividir las paginas de cada rol
        todo esto por que como solo trabaje frontend y necesitaba ver como funcionaban xd-->
        <div class="d-flex gap-3">
            <a href="{{ route('logn') }}" class="text-decoration-none" style="color: #e91e63;">Login</a>
            <a href="{{ route('dashboardAdm') }}" class="text-decoration-none" style="color: #e91e63;">Administrador</a>
            <a href="{{ route('recepcionista.dashboardRecep') }}" class="text-decoration-none" style="color: #e91e63;">Recepcionista</a>
            <a href="{{ route('estilista.dashboardEsti') }}" class="text-decoration-none" style="color: #e91e63;">Estilista</a>
            <a href="{{ route('cliente.dashboardCli') }}" class="text-decoration-none" style="color: #e91e63;">Cliente</a>
        </div>

        <!-- Mensaje de Bienvenida Personalizado -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 style="margin: 0 0 0.5rem 0;">
                                <i class="bi bi-heart-fill" style="color: var(--dorado-palido);"></i> 
                                ¡Hola María! Bienvenida de nuevo 💖
                            </h2>
                            <p style="margin: 0; font-size: 1.1rem; opacity: 0.9;">
                                Es un placer tenerte con nosotros. Hoy es <strong>Viernes, 31 de Octubre 2024</strong>
                            </p>
                            <p style="margin: 0.5rem 0 0 0; font-size: 1rem; opacity: 0.8;">
                                Eres una <span class="badge bg-success"><i class="bi bi-star-fill"></i> Cliente VIP</span> 
                                con <strong style="color: var(--dorado-palido);">18 visitas</strong> · 
                                Tu última cita fue el <strong>28 de Octubre</strong>
                            </p>
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

        <!-- KPI Cards - Resumen Personal -->
        <div class="row g-4 mb-4">
            
            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM citas 
            WHERE cliente_id = [ID_CLIENTE_AUTENTICADO]
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
                    <h3 class="kpi-value">18</h3>
                    <p class="kpi-label">Total de Visitas</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-trophy"></i> Cliente VIP
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
            WHERE cliente_id = [ID_CLIENTE_AUTENTICADO]
            AND estado = 'completada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-piggy-bank"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">$642</h3>
                    <p class="kpi-label">Invertido en Belleza</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-graph-up"></i> Histórico
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM promociones_usadas 
            WHERE cliente_id = [ID_CLIENTE_AUTENTICADO]
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">7</h3>
                    <p class="kpi-label">Promociones Usadas</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-percent"></i> $87 ahorrados
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
            WHERE cliente_id = [ID_CLIENTE_AUTENTICADO]
            AND fecha_hora > NOW()
            AND estado != 'cancelada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">0</h3>
                    <p class="kpi-label">Citas Pendientes</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-calendar-plus"></i> ¡Agenda ya!
                    </span>
                </div>
            </div>
        </div>

        <!-- Promociones Activas (Destacadas) -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-gift-fill"></i>
                        🎉 Promociones Especiales para Ti
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT p.id, p.nombre, p.descripcion, p.codigo_promocional,
                           p.tipo_descuento, p.valor_descuento, p.fecha_fin,
                           p.imagen_url
                    FROM promociones p
                    WHERE p.activo = 1 
                    AND p.fecha_inicio <= CURDATE()
                    AND p.fecha_fin >= CURDATE()
                    AND (p.tipo_cliente IS NULL OR p.tipo_cliente = 'todos' OR p.tipo_cliente = 'vip')
                    ORDER BY p.prioridad DESC
                    LIMIT 3
                    ================================================
                    -->
                    <div class="row g-4">
                        
                        <!-- Promoción 1 - Destacada -->
                        <div class="col-lg-4 col-md-6">
                            <div class="premium-card" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                <div class="text-center">
                                    <div style="font-size: 4rem; color: var(--dorado-palido); margin-bottom: 1rem;">
                                        <i class="bi bi-stars"></i>
                                    </div>
                                    <h4 style="color: white; margin-bottom: 0.5rem;">Black Friday Beauty</h4>
                                    <h2 style="color: var(--dorado-palido); font-size: 3rem; margin: 0.5rem 0;">30% OFF</h2>
                                    <p style="color: var(--rosa-empolvado); margin-bottom: 1rem;">
                                        En todos los servicios de spa facial
                                    </p>
                                    <div style="background: rgba(255,255,255,0.2); padding: 0.75rem; border-radius: 10px; margin-bottom: 1rem;">
                                        <small style="color: white; opacity: 0.9;">Código:</small>
                                        <br>
                                        <h5 style="color: var(--dorado-palido); margin: 0.25rem 0; font-family: monospace; letter-spacing: 2px;">
                                            BLACK30
                                        </h5>
                                    </div>
                                    <button class="btn btn-gold btn-sm mb-2 w-100" onclick="copiarCodigo('BLACK30')">
                                        <i class="bi bi-clipboard"></i> Copiar Código
                                    </button>
                                    <small style="color: var(--rosa-empolvado);">
                                        <i class="bi bi-clock"></i> Válido hasta: 15 Nov 2024
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Promoción 2 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="premium-card" style="background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                <div class="text-center">
                                    <div style="font-size: 4rem; color: white; margin-bottom: 1rem;">
                                        <i class="bi bi-calendar-heart"></i>
                                    </div>
                                    <h4 style="color: var(--borgona); margin-bottom: 0.5rem;">Martes de Spa</h4>
                                    <h2 style="color: white; font-size: 3rem; margin: 0.5rem 0;">20% OFF</h2>
                                    <p style="color: var(--borgona); margin-bottom: 1rem;">
                                        Solo servicios faciales los martes
                                    </p>
                                    <div style="background: rgba(128, 0, 32, 0.15); padding: 0.75rem; border-radius: 10px; margin-bottom: 1rem;">
                                        <small style="color: var(--borgona); opacity: 0.9;">Código:</small>
                                        <br>
                                        <h5 style="color: var(--borgona); margin: 0.25rem 0; font-family: monospace; letter-spacing: 2px;">
                                            MARSPA20
                                        </h5>
                                    </div>
                                    <button class="btn btn-premium btn-sm mb-2 w-100" onclick="copiarCodigo('MARSPA20')">
                                        <i class="bi bi-clipboard"></i> Copiar Código
                                    </button>
                                    <small style="color: var(--borgona);">
                                        <i class="bi bi-calendar-week"></i> Solo los martes
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Promoción 3 - Combo -->
                        <div class="col-lg-4 col-md-6">
                            <div class="premium-card" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                <div class="text-center">
                                    <div style="font-size: 4rem; color: var(--borgona); margin-bottom: 1rem;">
                                        <i class="bi bi-box-seam-fill"></i>
                                    </div>
                                    <h4 style="color: var(--borgona); margin-bottom: 0.5rem;">Combo Novia Perfecta</h4>
                                    <h2 style="color: var(--dorado-palido); font-size: 2.5rem; margin: 0.5rem 0;">$85.00</h2>
                                    <p style="color: var(--borgona); margin-bottom: 1rem; font-size: 0.9rem;">
                                        Peinado + Maquillaje + Manicure
                                    </p>
                                    <div style="background: white; padding: 0.75rem; border-radius: 10px; margin-bottom: 1rem;">
                                        <small style="color: var(--borgona); opacity: 0.7;">Precio regular:</small>
                                        <br>
                                        <span style="text-decoration: line-through; color: var(--borgona); opacity: 0.6;">$120.00</span>
                                        <br>
                                        <strong style="color: var(--dorado-palido); font-size: 1.2rem;">¡Ahorra $35!</strong>
                                    </div>
                                    <button class="btn btn-soft btn-sm mb-2 w-100" onclick="agendarCombo('combo-novia')">
                                        <i class="bi bi-calendar-plus"></i> Agendar Combo
                                    </button>
                                    <small style="color: var(--borgona);">
                                        <i class="bi bi-info-circle"></i> Reserva con 3 días de anticipación
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-outline-gold" onclick="verTodasPromociones()">
                            <i class="bi bi-gift"></i> Ver Todas las Promociones
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Servicios Destacados -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-scissors"></i>
                        ✨ Nuestros Servicios Más Populares
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT s.id, s.nombre, s.descripcion, s.precio, 
                           s.duracion_minutos, s.imagen_url,
                           COUNT(c.id) as total_citas
                    FROM servicios s
                    LEFT JOIN citas c ON s.id = c.servicio_id 
                        AND c.estado = 'completada'
                        AND c.fecha_hora >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                    WHERE s.activo = 1
                    GROUP BY s.id, s.nombre, s.descripcion, s.precio, 
                             s.duracion_minutos, s.imagen_url
                    ORDER BY total_citas DESC
                    LIMIT 6
                    ================================================
                    -->
                    <div class="row g-4">
                        
                        <!-- Servicio 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                        <i class="bi bi-scissors"></i>
                                    </div>
                                    <span class="badge badge-luxury">Popular</span>
                                </div>
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Corte de Cabello</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    Corte personalizado según tu estilo y tipo de cabello con nuestras estilistas expertas.
                                </p>
                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small style="color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-clock"></i> Duración
                                            </small>
                                            <br>
                                            <strong style="color: var(--borgona);">30 minutos</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small style="color: var(--borgona); opacity: 0.7;">Precio</small>
                                            <br>
                                            <strong style="color: var(--dorado-palido); font-size: 1.3rem;">$15</strong>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(1)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Ahora
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 2 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                        <i class="bi bi-palette"></i>
                                    </div>
                                    <span class="badge bg-success"><i class="bi bi-star-fill"></i> Top</span>
                                </div>
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Tinte Completo</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    Tinte profesional con productos de alta calidad. Incluye prueba de alergia.
                                </p>
                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small style="color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-clock"></i> Duración
                                            </small>
                                            <br>
                                            <strong style="color: var(--borgona);">90 minutos</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small style="color: var(--borgona); opacity: 0.7;">Precio</small>
                                            <br>
                                            <strong style="color: var(--dorado-palido); font-size: 1.3rem;">$40</strong>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(2)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Ahora
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 3 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                        <i class="bi bi-hand-index-thumb"></i>
                                    </div>
                                    <span class="badge badge-soft">Nuevo</span>
                                </div>
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Manicure + Pedicure</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    Cuidado completo de manos y pies. Incluye esmaltado tradicional o semipermanente.
                                </p>
                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small style="color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-clock"></i> Duración
                                            </small>
                                            <br>
                                            <strong style="color: var(--borgona);">75 minutos</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small style="color: var(--borgona); opacity: 0.7;">Precio</small>
                                            <br>
                                            <strong style="color: var(--dorado-palido); font-size: 1.3rem;">$25</strong>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(3)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Ahora
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 4 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--champagne), var(--champagne-light));">
                                        <i class="bi bi-stars"></i>
                                    </div>
                                    <span class="badge badge-gold">Especial</span>
                                </div>
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Tratamiento Capilar</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    Hidratación profunda y reparación del cabello con productos premium.
                                </p>
                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small style="color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-clock"></i> Duración
                                            </small>
                                            <br>
                                            <strong style="color: var(--borgona);">50 minutos</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small style="color: var(--borgona); opacity: 0.7;">Precio</small>
                                            <br>
                                            <strong style="color: var(--dorado-palido); font-size: 1.3rem;">$50</strong>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(4)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Ahora
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 5 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                        <i class="bi bi-brilliance"></i>
                                    </div>
                                    <span class="badge badge-luxury">Premium</span>
                                </div>
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Limpieza Facial</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    Limpieza profunda con extracciones, mascarilla y hidratación personalizada.
                                </p>
                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small style="color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-clock"></i> Duración
                                            </small>
                                            <br>
                                            <strong style="color: var(--borgona);">60 minutos</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small style="color: var(--borgona); opacity: 0.7;">Precio</small>
                                            <br>
                                            <strong style="color: var(--dorado-palido); font-size: 1.3rem;">$35</strong>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(5)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Ahora
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 6 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                        <i class="bi bi-gem"></i>
                                    </div>
                                    <span class="badge bg-info">Recomendado</span>
                                </div>
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Peinado Especial</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    Peinado profesional para eventos especiales. Semi-recogido o suelto con ondas.
                                </p>
                                <div class="w-100 mb-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <small style="color: var(--borgona); opacity: 0.7;">
                                                <i class="bi bi-clock"></i> Duración
                                            </small>
                                            <br>
                                            <strong style="color: var(--borgona);">60 minutos</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <small style="color: var(--borgona); opacity: 0.7;">Precio</small>
                                            <br>
                                            <strong style="color: var(--dorado-palido); font-size: 1.3rem;">$30</strong>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(6)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Ahora
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button class="btn btn-outline-gold" onclick="verTodosServicios()">
                            <i class="bi bi-scissors"></i> Ver Catálogo Completo de Servicios
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Beneficios de ser Cliente VIP -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="premium-card" style="background: linear-gradient(135deg, var(--dorado-palido), var(--champagne));">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 style="color: var(--borgona); margin: 0 0 1rem 0;">
                                <i class="bi bi-crown-fill"></i> Tus Beneficios VIP
                            </h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div style="width: 40px; height: 40px; background: var(--borgona); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                            <i class="bi bi-percent" style="color: var(--dorado-palido); font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0;">10% de Descuento</h6>
                                            <p style="margin: 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">En todos tus servicios</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div style="width: 40px; height: 40px; background: var(--borgona); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                            <i class="bi bi-gift-fill" style="color: var(--dorado-palido); font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0;">Acceso Exclusivo</h6>
                                            <p style="margin: 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">A promociones especiales</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div style="width: 40px; height: 40px; background: var(--borgona); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                            <i class="bi bi-calendar-check" style="color: var(--dorado-palido); font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0;">Prioridad en Reservas</h6>
                                            <p style="margin: 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">Horarios preferenciales</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <div style="width: 40px; height: 40px; background: var(--borgona); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                            <i class="bi bi-cake2" style="color: var(--dorado-palido); font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <h6 style="color: var(--borgona); margin: 0;">Regalo de Cumpleaños</h6>
                                            <p style="margin: 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">Servicio gratis en tu día</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="font-size: 6rem; color: var(--borgona); opacity: 0.3;">
                                <i class="bi bi-trophy-fill"></i>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        // Agendar cita
        function agendarCita() {
            console.log('Agendar nueva cita');
            alert('Redirigir a página de agendar cita');
            // window.location.href = '/cliente/agendar-cita';
        }

        // Agendar servicio específico
        function agendarServicio(servicioId) {
            console.log('Agendar servicio:', servicioId);
            alert('Redirigir a agendar cita con servicio ' + servicioId + ' pre-seleccionado');
            // window.location.href = '/cliente/agendar-cita?servicio=' + servicioId;
        }

        // Agendar combo
        function agendarCombo(comboId) {
            console.log('Agendar combo:', comboId);
            alert('Redirigir a agendar combo especial: ' + comboId);
            // window.location.href = '/cliente/agendar-cita?combo=' + comboId;
        }

        // Copiar código de promoción
        function copiarCodigo(codigo) {
            navigator.clipboard.writeText(codigo).then(() => {
                alert('✅ Código ' + codigo + ' copiado al portapapeles!\n\nPuedes usarlo al agendar tu próxima cita.');
            }).catch(() => {
                alert('⚠️ No se pudo copiar el código. Por favor cópialo manualmente: ' + codigo);
            });
        }

        // Ver todas las promociones
        function verTodasPromociones() {
            console.log('Ver todas las promociones');
            alert('Redirigir a página de promociones completas');
            // window.location.href = '/cliente/promociones';
        }

        // Ver todos los servicios
        function verTodosServicios() {
            console.log('Ver catálogo completo');
            alert('Redirigir a catálogo de servicios');
            // window.location.href = '/cliente/servicios';
        }
    </script>
    
</body>
</html>