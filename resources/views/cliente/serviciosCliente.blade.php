<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios Cliente | Salón de Belleza</title>

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
            
            <a href="{{ route('cliente.citasCli') }}" class="menu-item">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('cliente.serviciosCli') }}" class="menu-item active">
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
            <h1>Servicios</h1>
            <p>Consulta los servicios que ofrece el salón.</p>
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

        <!-- Barra de Búsqueda y Filtros -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-10">
                            <label class="form-label" style="margin-bottom: 0.5rem;">
                                <i class="bi bi-search"></i> Buscar Servicio
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="busquedaServicio"
                                placeholder="Buscar por nombre o descripción del servicio..."
                                onkeyup="buscarServicio()">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-gold w-100" onclick="buscarServicio()">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="d-grid gap-2" style="margin-top: 1.8rem;">
                    <button class="btn btn-premium" onclick="verMisCitas()">
                        <i class="bi bi-calendar-check"></i> Mis Citas
                    </button>
                </div>
            </div>
        </div>

        <!-- Filtros por Categoría -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <strong style="color: var(--borgona); margin-right: 0.5rem;">
                            <i class="bi bi-funnel"></i> Categorías:
                        </strong>
                        <button class="btn btn-sm btn-gold" onclick="filtrarCategoria('todos')">
                            <i class="bi bi-grid"></i> Todos (18)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarCategoria('cabello')">
                            <i class="bi bi-scissors"></i> Cabello (6)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarCategoria('unas')">
                            <i class="bi bi-hand-index-thumb"></i> Uñas (4)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarCategoria('facial')">
                            <i class="bi bi-stars"></i> Facial (4)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarCategoria('maquillaje')">
                            <i class="bi bi-palette"></i> Maquillaje (2)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarCategoria('combos')">
                            <i class="bi bi-box-seam"></i> Combos (2)
                        </button>

                        <div style="border-left: 2px solid var(--rosa-empolvado); height: 30px; margin: 0 0.5rem;"></div>

                        <button class="btn btn-sm btn-soft" onclick="ordenarPor('precio')">
                            <i class="bi bi-sort-numeric-down"></i> Por Precio
                        </button>
                        <button class="btn btn-sm btn-soft" onclick="ordenarPor('duracion')">
                            <i class="bi bi-clock"></i> Por Duración
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Informativo -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido);">
                    <i class="bi bi-info-circle-fill"></i>
                    <strong>Información importante:</strong><br>
                    Los precios incluyen IVA. Las duraciones son aproximadas y pueden variar según las necesidades de cada cliente.
                    <strong style="color: var(--dorado-palido);">Como Cliente VIP tienes 10% de descuento en todos los servicios.</strong>
                </div>
            </div>
        </div>

        <!-- Sección: SERVICIOS DE CABELLO -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-scissors"></i>
                        Servicios de Cabello
                    </h5>

                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT s.id, s.nombre, s.descripcion, s.precio, 
                           s.duracion_minutos, s.categoria, s.imagen_url,
                           s.requisitos_previos, s.recomendaciones
                    FROM servicios s
                    WHERE s.activo = 1 AND s.categoria = 'cabello'
                    ORDER BY s.orden, s.nombre
                    ================================================
                    -->
                    <div class="row g-4">

                        <!-- Servicio 1: Corte de Cabello -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 420px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                        <i class="bi bi-scissors"></i>
                                    </div>
                                    <span class="badge badge-luxury">Popular</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Corte de Cabello</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Corte personalizado según tu estilo y tipo de cabello. Incluye lavado, corte profesional y secado con brushing básico.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">30 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$15.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado);">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$13.50</strong>
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(1)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 2: Tinte Completo -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 420px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                        <i class="bi bi-palette"></i>
                                    </div>
                                    <span class="badge bg-success"><i class="bi bi-star-fill"></i> Top</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Tinte Completo</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Coloración profesional con productos de alta calidad. Incluye aplicación completa, tiempo de proceso y lavado especial.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">90 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$40.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado); margin-bottom: 0.5rem;">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$36.00</strong>
                                        </small>
                                    </div>

                                    <div class="alert-custom" style="padding: 0.5rem; margin: 0;">
                                        <small><i class="bi bi-info-circle"></i> <strong>Requisito:</strong> Prueba de alergia 48h antes</small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(2)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 3: Mechas/Highlights -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 420px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--champagne), var(--champagne-light));">
                                        <i class="bi bi-magic"></i>
                                    </div>
                                    <span class="badge bg-info">Tendencia</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Mechas / Highlights</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Iluminación del cabello con técnica de mechas tradicionales o balayage. Ideal para dar luminosidad natural.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">120 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$65.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado);">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$58.50</strong>
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(3)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 4: Tratamiento Capilar -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 420px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                        <i class="bi bi-stars"></i>
                                    </div>
                                    <span class="badge badge-gold">Especial</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Tratamiento Capilar</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Hidratación profunda y reparación del cabello dañado. Incluye masaje capilar, mascarilla intensiva y nutrición.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">50 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$50.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado);">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$45.00</strong>
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(4)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 5: Peinado Especial -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 420px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                        <i class="bi bi-gem"></i>
                                    </div>
                                    <span class="badge bg-warning text-dark">Eventos</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Peinado Especial</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Peinado profesional para eventos. Semi-recogido, ondas, rizado o liso. Incluye productos de fijación duraderos.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">60 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$30.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado);">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$27.00</strong>
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(5)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Servicio 6: Alaciado/Keratina -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 420px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                        <i class="bi bi-lightning"></i>
                                    </div>
                                    <span class="badge badge-luxury">Premium</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Alaciado / Keratina</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Tratamiento de alaciado permanente con keratina brasileña. Resultados duraderos hasta 4 meses. Cabello liso y sedoso.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">180 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$120.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado); margin-bottom: 0.5rem;">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$108.00</strong>
                                        </small>
                                    </div>

                                    <div class="alert-custom" style="padding: 0.5rem; margin: 0;">
                                        <small><i class="bi bi-info-circle"></i> <strong>Importante:</strong> No lavar cabello por 72 horas</small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(6)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: SERVICIOS DE UÑAS -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-hand-index-thumb"></i>
                        Servicios de Uñas
                    </h5>

                    <div class="row g-4">

                        <!-- Servicio: Manicure Básico -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 400px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                    </div>
                                    <span class="badge badge-soft">Básico</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Manicure Básico</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Cuidado completo de manos con limado, cutícula, masaje hidratante y esmaltado tradicional de larga duración.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">30 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$10.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado);">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$9.00</strong>
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(7)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Servicio: Pedicure Básico -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 400px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--champagne), var(--champagne-light));">
                                        <i class="bi bi-star"></i>
                                    </div>
                                    <span class="badge badge-soft">Básico</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Pedicure Básico</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Cuidado de pies con limado, exfoliación suave, corte de cutícula, masaje relajante y esmaltado.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">45 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$15.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado);">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$13.50</strong>
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(8)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Servicio: Manicure + Pedicure -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 400px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                        <i class="bi bi-stars"></i>
                                    </div>
                                    <span class="badge badge-luxury">Popular</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Manicure + Pedicure</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Combo completo de manos y pies. Incluye todos los beneficios del manicure y pedicure básico a mejor precio.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">75 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$25.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado); margin-bottom: 0.5rem;">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$22.50</strong>
                                        </small>
                                    </div>

                                    <div style="background: rgba(212, 175, 55, 0.15); padding: 0.5rem; border-radius: 5px;">
                                        <small style="color: var(--borgona); font-weight: 600;">
                                            <i class="bi bi-piggy-bank"></i> Ahorras: $5 vs servicios separados
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(9)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Servicio: Uñas Acrílicas -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 400px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                        <i class="bi bi-gem"></i>
                                    </div>
                                    <span class="badge bg-success"><i class="bi bi-star-fill"></i> Premium</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Uñas Acrílicas</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Aplicación completa de uñas acrílicas con diseño a elección. Duración aproximada de 3-4 semanas.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">90 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$45.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado);">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$40.50</strong>
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(10)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: SERVICIOS FACIALES -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-stars"></i>
                        Servicios Faciales y Spa
                    </h5>

                    <div class="row g-4">

                        <!-- Servicio: Limpieza Facial -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; min-height: 400px;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                        <i class="bi bi-stars"></i>
                                    </div>
                                    <span class="badge badge-luxury">Popular</span>
                                </div>

                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Limpieza Facial Profunda</h5>

                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem; flex-grow: 1;">
                                    Limpieza profunda con vapor, extracción de puntos negros, mascarilla personalizada según tipo de piel e hidratación.
                                </p>

                                <div class="w-100 mb-3">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px; margin-bottom: 0.5rem;">
                                        <div class="row">
                                            <div class="col-6">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">
                                                    <i class="bi bi-clock"></i> Duración
                                                </small>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">60 min</strong>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small style="color: var(--borgona); opacity: 0.7; display: block;">Precio</small>
                                                <strong style="color: var(--dorado-palido); font-size: 1.4rem;">$35.00</strong>
                                            </div>
                                        </div>
                                    </div>

                                    <div style="background: white; padding: 0.5rem; border-radius: 5px; border: 1px solid var(--rosa-empolvado);">
                                        <small style="color: var(--dorado-palido); font-weight: 600;">
                                            <i class="bi bi-star-fill"></i> Tu precio VIP: <strong>$31.50</strong>
                                        </small>
                                    </div>
                                </div>

                                <button class="btn btn-gold btn-sm w-100" onclick="agendarServicio(11)">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
                                </button>
                            </div>
                        </div>

                        <!-- Más servicios faciales podrían ir aquí -->

                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para ver más -->
        <div class="row mb-4">
            <div class="col-12 text-center">
                <button class="btn btn-outline-gold btn-lg" onclick="cargarMasServicios()">
                    <i class="bi bi-arrow-down-circle"></i> Cargar Más Servicios
                </button>
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
        // Buscar servicio
        function buscarServicio() {
            const termino = document.getElementById('busquedaServicio').value;
            console.log('Buscar servicio:', termino);
            alert('Función de búsqueda - Conectar con backend\nBuscando: ' + termino);
            // TODO: Implementar búsqueda AJAX
        }

        // Filtrar por categoría
        function filtrarCategoria(categoria) {
            console.log('Filtrar por categoría:', categoria);
            alert('Filtrar servicios por: ' + categoria + ' - Conectar con backend');
            // TODO: Implementar filtrado dinámico
        }

        // Ordenar servicios
        function ordenarPor(criterio) {
            console.log('Ordenar por:', criterio);
            alert('Ordenar servicios por: ' + criterio + ' - Conectar con backend');
            // TODO: Implementar ordenamiento
        }

        // Agendar servicio específico
        function agendarServicio(servicioId) {
            console.log('Agendar servicio:', servicioId);
            alert('Redirigir a agendar cita con servicio ' + servicioId + ' pre-seleccionado');
            // window.location.href = '/cliente/agendar-cita?servicio=' + servicioId;
        }

        // Ver mis citas
        function verMisCitas() {
            console.log('Ver mis citas');
            alert('Redirigir a página de Mis Citas');
            // window.location.href = '/cliente/mis-citas';
        }

        // Cargar más servicios
        function cargarMasServicios() {
            console.log('Cargar más servicios');
            alert('Cargar siguiente página de servicios - Conectar con backend (paginación)');
            // TODO: Implementar lazy loading o paginación
        }

        // Búsqueda en tiempo real
        document.getElementById('busquedaServicio')?.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                buscarServicio();
            }
        });
    </script>

</body>

</html>