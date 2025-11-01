<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Promociones Cliente | Salón de Belleza</title>

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
            <a href="{{ route('cliente.citasCli') }}" class="menu-item">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('cliente.serviciosCli') }}" class="menu-item">
                <i class="bi bi-scissors"></i> Servicios
            </a>
            <a href="{{ route('cliente.promocionesCli') }}" class="menu-item active">
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
            <h1>Promociones</h1>
            <p>Consulta las promociones y combos del salón.</p>
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
        
        <!-- Banner Principal de Promociones -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card" style="background: linear-gradient(135deg, var(--borgona) 0%, var(--borgona-light) 100%);">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 style="color: white; margin: 0 0 1rem 0; font-size: 2.5rem;">
                                <i class="bi bi-gift-fill" style="color: var(--dorado-palido);"></i> 
                                Promociones Especiales
                            </h1>
                            <p style="color: var(--rosa-empolvado); font-size: 1.2rem; margin: 0 0 1rem 0;">
                                Aprovecha nuestras ofertas exclusivas y obtén los mejores precios en tus servicios favoritos
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge badge-luxury" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                    <i class="bi bi-star-fill"></i> Cliente VIP: +10% adicional
                                </span>
                                <span class="badge bg-light text-dark" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                    <i class="bi bi-calendar3"></i> Válidas hasta fin de mes
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div style="font-size: 5rem; color: var(--dorado-palido);">
                                🎉
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros y Búsqueda -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-10">
                            <label class="form-label" style="margin-bottom: 0.5rem;">
                                <i class="bi bi-search"></i> Buscar Promoción
                            </label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="buscarPromocion" 
                                placeholder="Buscar por nombre, código o servicio..."
                                onkeyup="buscarPromocion()"
                            >
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-gold w-100" onclick="buscarPromocion()">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card-custom" style="padding: 1rem;">
                    <label class="form-label" style="margin-bottom: 0.5rem;">
                        <i class="bi bi-funnel"></i> Ordenar por
                    </label>
                    <select class="form-control" id="ordenarPromociones" onchange="ordenarPromociones()">
                        <option value="destacadas">Más destacadas</option>
                        <option value="descuento">Mayor descuento</option>
                        <option value="vigencia">Próximas a vencer</option>
                        <option value="nuevas">Más recientes</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Categorías de Promociones -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <strong style="color: var(--borgona); margin-right: 0.5rem;">
                            <i class="bi bi-tags"></i> Categorías:
                        </strong>
                        <button class="btn btn-sm btn-gold" onclick="filtrarPromocionPorCategoria('todas')">
                            <i class="bi bi-grid"></i> Todas (12)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPromocionPorCategoria('porcentaje')">
                            <i class="bi bi-percent"></i> Descuentos % (5)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPromocionPorCategoria('combos')">
                            <i class="bi bi-box-seam"></i> Combos (4)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPromocionPorCategoria('2x1')">
                            <i class="bi bi-gift"></i> 2x1 (2)
                        </button>
                        <button class="btn btn-sm btn-outline-gold" onclick="filtrarPromocionPorCategoria('vip')">
                            <i class="bi bi-star-fill"></i> Solo VIP (1)
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: PROMOCIONES DESTACADAS -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-stars"></i>
                        🔥 Promociones Destacadas del Mes
                    </h5>
                    
                    <div class="row g-4">
                        
                        <!-- Promoción 1: Black Friday Beauty -->
                        <div class="col-lg-4 col-md-6">
                            <div class="premium-card" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light)); min-height: 520px; display: flex; flex-direction: column;">
                                <div style="position: absolute; top: 10px; right: 10px;">
                                    <span class="badge bg-danger" style="font-size: 0.75rem;">
                                        <i class="bi bi-fire"></i> POPULAR
                                    </span>
                                </div>
                                
                                <div class="text-center flex-grow-1 d-flex flex-column">
                                    <div style="font-size: 4rem; color: var(--dorado-palido); margin-bottom: 1rem;">
                                        <i class="bi bi-stars"></i>
                                    </div>
                                    <h4 style="color: white; margin-bottom: 0.5rem;">Black Friday Beauty</h4>
                                    <h2 style="color: var(--dorado-palido); font-size: 3rem; margin: 0.5rem 0;">30% OFF</h2>
                                    <p style="color: var(--rosa-empolvado); margin-bottom: 1.5rem; flex-grow: 1;">
                                        En todos los servicios de spa facial, tratamientos y limpiezas profundas
                                    </p>
                                    
                                    <div style="background: rgba(255,255,255,0.2); padding: 0.75rem; border-radius: 10px; margin-bottom: 1rem;">
                                        <small style="color: white; opacity: 0.9;">Código promocional:</small>
                                        <br>
                                        <h5 style="color: var(--dorado-palido); margin: 0.25rem 0; font-family: monospace; letter-spacing: 2px;">
                                            BLACK30
                                        </h5>
                                    </div>
                                    
                                    <div style="background: rgba(255,255,255,0.15); padding: 0.5rem; border-radius: 8px; margin-bottom: 1rem;">
                                        <small style="color: white;">
                                            <i class="bi bi-clock"></i> Válido hasta: <strong>15 Nov 2024</strong>
                                        </small>
                                        <br>
                                        <small style="color: var(--dorado-palido);">
                                            <i class="bi bi-calendar-check"></i> Disponible todos los días
                                        </small>
                                    </div>

                                    <button class="btn btn-gold btn-sm mb-2 w-100" onclick="copiarCodigoPromocion('BLACK30')">
                                        <i class="bi bi-clipboard"></i> Copiar Código
                                    </button>
                                    <button class="btn btn-outline-light btn-sm w-100" onclick="agendarConPromocion('BLACK30')">
                                        <i class="bi bi-calendar-plus"></i> Agendar con esta Promoción
                                    </button>
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
                </div>
            </div>
        </div>

        <!-- Sección: COMBOS ESPECIALES -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-box-seam-fill"></i>
                        💎 Combos y Paquetes Especiales
                    </h5>
                    
                    <div class="row g-4">
                        
                        <!-- Combo 1: Novia Perfecta -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(255, 248, 240, 0.5)); border-left: 5px solid var(--dorado-palido); min-height: 380px;">
                                <div class="d-flex align-items-start justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar" style="width: 70px; height: 70px; font-size: 2rem; background: linear-gradient(135deg, var(--dorado-palido), var(--champagne)); margin-right: 1rem;">
                                            <i class="bi bi-gem"></i>
                                        </div>
                                        <div>
                                            <h4 style="color: var(--borgona); margin: 0;">Combo Novia Perfecta</h4>
                                            <p style="margin: 0; color: var(--borgona); opacity: 0.7;">El paquete más completo para tu día especial</p>
                                        </div>
                                    </div>
                                    <span class="badge badge-luxury">POPULAR</span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div style="background: white; padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                                        <h6 style="color: var(--borgona); margin-bottom: 0.75rem;">
                                            <i class="bi bi-check-circle-fill" style="color: var(--dorado-palido);"></i> Incluye:
                                        </h6>
                                        <ul style="margin: 0; padding-left: 1.5rem; color: var(--borgona);">
                                            <li>Peinado profesional para novia</li>
                                            <li>Maquillaje completo de larga duración</li>
                                            <li>Manicure con esmaltado semipermanente</li>
                                            <li>Prueba de peinado y maquillaje (gratis)</li>
                                        </ul>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px;">
                                                <small style="color: var(--borgona); opacity: 0.7;">Duración Total</small>
                                                <br>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">
                                                    <i class="bi bi-clock"></i> 3 horas
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px;">
                                                <small style="color: var(--borgona); opacity: 0.7;">Precio Regular</small>
                                                <br>
                                                <span style="text-decoration: line-through; color: var(--borgona); opacity: 0.5;">$120.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100 mb-3" style="background: var(--dorado-palido); padding: 1rem; border-radius: 10px;">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <h3 style="color: white; margin: 0; font-size: 2rem;">$85.00</h3>
                                            <small style="color: white; opacity: 0.9;">
                                                <i class="bi bi-piggy-bank"></i> Ahorras <strong>$35.00</strong>
                                            </small>
                                        </div>
                                        <div class="col-5 text-end">
                                            <div class="badge bg-success" style="font-size: 0.9rem; padding: 0.5rem;">
                                                29% OFF
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-custom w-100 mb-3">
                                    <i class="bi bi-info-circle"></i>
                                    <small><strong>Importante:</strong> Reserva con al menos 3 días de anticipación</small>
                                </div>

                                <button class="btn btn-gold w-100" onclick="agendarCombo('novia-perfecta')">
                                    <i class="bi bi-calendar-plus"></i> Agendar Combo Novia
                                </button>
                            </div>
                        </div>

                        <!-- Combo 2: Renovación Total -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: linear-gradient(135deg, rgba(240, 128, 128, 0.1), rgba(255, 248, 240, 0.5)); border-left: 5px solid var(--rosa-empolvado); min-height: 380px;">
                                <div class="d-flex align-items-start justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar" style="width: 70px; height: 70px; font-size: 2rem; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light)); margin-right: 1rem;">
                                            <i class="bi bi-stars"></i>
                                        </div>
                                        <div>
                                            <h4 style="color: var(--borgona); margin: 0;">Combo Renovación Total</h4>
                                            <p style="margin: 0; color: var(--borgona); opacity: 0.7;">Date un día completo de relajación</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-info">NUEVO</span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div style="background: white; padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                                        <h6 style="color: var(--borgona); margin-bottom: 0.75rem;">
                                            <i class="bi bi-check-circle-fill" style="color: var(--rosa-empolvado);"></i> Incluye:
                                        </h6>
                                        <ul style="margin: 0; padding-left: 1.5rem; color: var(--borgona);">
                                            <li>Limpieza facial profunda</li>
                                            <li>Tratamiento capilar hidratante</li>
                                            <li>Manicure y pedicure spa</li>
                                            <li>Masaje de cuello y hombros</li>
                                        </ul>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div style="background: rgba(240, 128, 128, 0.1); padding: 0.75rem; border-radius: 8px;">
                                                <small style="color: var(--borgona); opacity: 0.7;">Duración Total</small>
                                                <br>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">
                                                    <i class="bi bi-clock"></i> 4 horas
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div style="background: rgba(240, 128, 128, 0.1); padding: 0.75rem; border-radius: 8px;">
                                                <small style="color: var(--borgona); opacity: 0.7;">Precio Regular</small>
                                                <br>
                                                <span style="text-decoration: line-through; color: var(--borgona); opacity: 0.5;">$150.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100 mb-3" style="background: var(--rosa-empolvado); padding: 1rem; border-radius: 10px;">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <h3 style="color: white; margin: 0; font-size: 2rem;">$95.00</h3>
                                            <small style="color: white; opacity: 0.9;">
                                                <i class="bi bi-piggy-bank"></i> Ahorras <strong>$55.00</strong>
                                            </small>
                                        </div>
                                        <div class="col-5 text-end">
                                            <div class="badge bg-warning text-dark" style="font-size: 0.9rem; padding: 0.5rem;">
                                                37% OFF
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-custom w-100 mb-3">
                                    <i class="bi bi-gift"></i>
                                    <small><strong>Bonus VIP:</strong> Incluye bebida y snack de cortesía</small>
                                </div>

                                <button class="btn btn-premium w-100" onclick="agendarCombo('renovacion-total')">
                                    <i class="bi bi-calendar-plus"></i> Agendar Combo Spa
                                </button>
                            </div>
                        </div>

                        <!-- Combo 3: Express -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: linear-gradient(135deg, rgba(128, 0, 32, 0.05), rgba(255, 248, 240, 0.5)); border-left: 5px solid var(--borgona);">
                                <div class="d-flex align-items-start justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar" style="width: 70px; height: 70px; font-size: 2rem; background: linear-gradient(135deg, var(--borgona), var(--borgona-light)); margin-right: 1rem;">
                                            <i class="bi bi-lightning-fill"></i>
                                        </div>
                                        <div>
                                            <h4 style="color: var(--borgona); margin: 0;">Combo Express</h4>
                                            <p style="margin: 0; color: var(--borgona); opacity: 0.7;">Rápido y efectivo para tu rutina</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-warning text-dark">EXPRESS</span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div style="background: white; padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                                        <h6 style="color: var(--borgona); margin-bottom: 0.75rem;">
                                            <i class="bi bi-check-circle-fill" style="color: var(--borgona);"></i> Incluye:
                                        </h6>
                                        <ul style="margin: 0; padding-left: 1.5rem; color: var(--borgona);">
                                            <li>Corte de cabello personalizado</li>
                                            <li>Brushing o planchado</li>
                                            <li>Manicure básico express</li>
                                        </ul>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div style="background: rgba(128, 0, 32, 0.08); padding: 0.75rem; border-radius: 8px;">
                                                <small style="color: var(--borgona); opacity: 0.7;">Duración Total</small>
                                                <br>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">
                                                    <i class="bi bi-clock"></i> 90 min
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div style="background: rgba(128, 0, 32, 0.08); padding: 0.75rem; border-radius: 8px;">
                                                <small style="color: var(--borgona); opacity: 0.7;">Precio Regular</small>
                                                <br>
                                                <span style="text-decoration: line-through; color: var(--borgona); opacity: 0.5;">$45.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100 mb-3" style="background: var(--borgona); padding: 1rem; border-radius: 10px;">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <h3 style="color: var(--dorado-palido); margin: 0; font-size: 2rem;">$32.00</h3>
                                            <small style="color: white; opacity: 0.9;">
                                                <i class="bi bi-piggy-bank"></i> Ahorras <strong>$13.00</strong>
                                            </small>
                                        </div>
                                        <div class="col-5 text-end">
                                            <div class="badge bg-light text-dark" style="font-size: 0.9rem; padding: 0.5rem;">
                                                29% OFF
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-gold w-100" onclick="agendarCombo('express')">
                                    <i class="bi bi-calendar-plus"></i> Agendar Combo Express
                                </button>
                            </div>
                        </div>

                        <!-- Combo 4: Look de Fiesta -->
                        <div class="col-lg-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: linear-gradient(135deg, rgba(255, 215, 0, 0.08), rgba(255, 248, 240, 0.5)); border-left: 5px solid var(--champagne);">
                                <div class="d-flex align-items-start justify-content-between w-100 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="list-avatar" style="width: 70px; height: 70px; font-size: 2rem; background: linear-gradient(135deg, var(--champagne), var(--champagne-light)); margin-right: 1rem;">
                                            <i class="bi bi-balloon-heart-fill"></i>
                                        </div>
                                        <div>
                                            <h4 style="color: var(--borgona); margin: 0;">Combo Look de Fiesta</h4>
                                            <p style="margin: 0; color: var(--borgona); opacity: 0.7;">Lista para cualquier evento especial</p>
                                        </div>
                                    </div>
                                    <span class="badge bg-danger">OFERTA</span>
                                </div>

                                <div class="w-100 mb-3">
                                    <div style="background: white; padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                                        <h6 style="color: var(--borgona); margin-bottom: 0.75rem;">
                                            <i class="bi bi-check-circle-fill" style="color: var(--champagne);"></i> Incluye:
                                        </h6>
                                        <ul style="margin: 0; padding-left: 1.5rem; color: var(--borgona);">
                                            <li>Peinado especial para fiesta</li>
                                            <li>Maquillaje profesional</li>
                                            <li>Uñas acrílicas o semipermanente</li>
                                        </ul>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div style="background: rgba(255, 215, 0, 0.12); padding: 0.75rem; border-radius: 8px;">
                                                <small style="color: var(--borgona); opacity: 0.7;">Duración Total</small>
                                                <br>
                                                <strong style="color: var(--borgona); font-size: 1.1rem;">
                                                    <i class="bi bi-clock"></i> 2.5 horas
                                                </strong>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div style="background: rgba(255, 215, 0, 0.12); padding: 0.75rem; border-radius: 8px;">
                                                <small style="color: var(--borgona); opacity: 0.7;">Precio Regular</small>
                                                <br>
                                                <span style="text-decoration: line-through; color: var(--borgona); opacity: 0.5;">$105.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-100 mb-3" style="background: var(--champagne); padding: 1rem; border-radius: 10px;">
                                    <div class="row align-items-center">
                                        <div class="col-7">
                                            <h3 style="color: var(--borgona); margin: 0; font-size: 2rem;">$70.00</h3>
                                            <small style="color: var(--borgona); opacity: 0.8;">
                                                <i class="bi bi-piggy-bank"></i> Ahorras <strong>$35.00</strong>
                                            </small>
                                        </div>
                                        <div class="col-5 text-end">
                                            <div class="badge bg-success" style="font-size: 0.9rem; padding: 0.5rem;">
                                                33% OFF
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-gold w-100" onclick="agendarCombo('look-fiesta')">
                                    <i class="bi bi-calendar-plus"></i> Agendar Look de Fiesta
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: PROMOCIONES POR TEMPORADA -->
        <div class="row g-4 mb-5">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-calendar-range"></i>
                        🍂 Promociones de Temporada
                    </h5>
                    
                    <div class="row g-4">
                        
                        <!-- Promoción Temporada 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="background: linear-gradient(135deg, #ff6b6b, #ee5a6f);">
                                        <i class="bi bi-heart-fill"></i>
                                    </div>
                                    <span class="badge bg-danger">Termina pronto</span>
                                </div>
                                
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Especial San Valentín</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    15% de descuento en paquetes de belleza para parejas
                                </p>

                                <div class="w-100 mb-3" style="background: rgba(255, 107, 107, 0.1); padding: 0.75rem; border-radius: 8px;">
                                    <small style="color: var(--borgona);">Código: <strong style="font-family: monospace;">AMOR15</strong></small>
                                    <br>
                                    <small style="color: var(--borgona); opacity: 0.7;">
                                        <i class="bi bi-clock"></i> Válido del 10-14 Feb
                                    </small>
                                </div>

                                <button class="btn btn-outline-gold btn-sm w-100" onclick="copiarCodigoPromocion('AMOR15')">
                                    <i class="bi bi-clipboard"></i> Copiar Código
                                </button>
                            </div>
                        </div>

                        <!-- Promoción Temporada 2 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="background: linear-gradient(135deg, #ff9a9e, #fad0c4);">
                                        <i class="bi bi-flower1"></i>
                                    </div>
                                    <span class="badge bg-info">Activa</span>
                                </div>
                                
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Primavera Radiante</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    25% OFF en tratamientos faciales y limpieza profunda
                                </p>

                                <div class="w-100 mb-3" style="background: rgba(255, 154, 158, 0.1); padding: 0.75rem; border-radius: 8px;">
                                    <small style="color: var(--borgona);">Código: <strong style="font-family: monospace;">SPRING25</strong></small>
                                    <br>
                                    <small style="color: var(--borgona); opacity: 0.7;">
                                        <i class="bi bi-clock"></i> Todo el mes de marzo
                                    </small>
                                </div>

                                <button class="btn btn-outline-gold btn-sm w-100" onclick="copiarCodigoPromocion('SPRING25')">
                                    <i class="bi bi-clipboard"></i> Copiar Código
                                </button>
                            </div>
                        </div>

                        <!-- Promoción Temporada 3 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="list-item-custom" style="flex-direction: column; align-items: flex-start;">
                                <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                    <div class="list-avatar" style="background: linear-gradient(135deg, #ffecd2, #fcb69f);">
                                        <i class="bi bi-brightness-high-fill"></i>
                                    </div>
                                    <span class="badge bg-warning text-dark">Próximamente</span>
                                </div>
                                
                                <h5 style="color: var(--borgona); margin: 0 0 0.5rem 0;">Verano Perfecto</h5>
                                <p style="margin: 0 0 1rem 0; color: var(--borgona); opacity: 0.8; font-size: 0.9rem;">
                                    2x1 en depilación láser y tratamientos corporales
                                </p>

                                <div class="w-100 mb-3" style="background: rgba(255, 236, 210, 0.5); padding: 0.75rem; border-radius: 8px;">
                                    <small style="color: var(--borgona);">Código: <strong style="font-family: monospace;">VERANO2X1</strong></small>
                                    <br>
                                    <small style="color: var(--borgona); opacity: 0.7;">
                                        <i class="bi bi-clock"></i> Disponible desde junio
                                    </small>
                                </div>

                                <button class="btn btn-outline-gold btn-sm w-100" disabled>
                                    <i class="bi bi-bell"></i> Notificarme
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Banner de Suscripción -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 style="color: var(--borgona); margin: 0 0 0.5rem 0;">
                                <i class="bi bi-envelope-heart"></i> No te pierdas ninguna promoción
                            </h4>
                            <p style="color: var(--borgona); margin: 0 0 1rem 0; opacity: 0.8;">
                                Suscríbete a nuestro boletín y recibe promociones exclusivas, descuentos especiales y novedades directamente en tu correo
                            </p>
                            <div class="row g-2">
                                <div class="col-md-7">
                                    <input type="email" class="form-control" placeholder="tu@email.com" id="emailSuscripcion">
                                </div>
                                <div class="col-md-5">
                                    <button class="btn btn-gold w-100" onclick="suscribirsePromos()">
                                        <i class="bi bi-send"></i> Suscribirme
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div style="font-size: 5rem; color: var(--borgona); opacity: 0.3;">
                                <i class="bi bi-gift-fill"></i>
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
        // Buscar promoción
        function buscarPromocion() {
            const termino = document.getElementById('buscarPromocion').value;
            console.log('Buscar promoción:', termino);
            alert('Buscando promociones que coincidan con: ' + termino);
            // TODO: Implementar búsqueda en producción
        }

        // Ordenar promociones
        function ordenarPromociones() {
            const criterio = document.getElementById('ordenarPromociones').value;
            console.log('Ordenar por:', criterio);
            alert('Ordenando promociones por: ' + criterio);
            // TODO: Reordenar elementos en la vista
        }

        // Filtrar por categoría
        function filtrarPromocionPorCategoria(categoria) {
            console.log('Filtrar promociones por:', categoria);
            alert('Mostrando promociones de categoría: ' + categoria);
            // TODO: Filtrar elementos dinámicamente
        }

        // Copiar código de promoción
        function copiarCodigoPromocion(codigo) {
            navigator.clipboard.writeText(codigo).then(() => {
                alert('✅ Código ' + codigo + ' copiado al portapapeles!\n\n' + 
                      'Puedes usarlo al momento de agendar tu cita para aplicar el descuento.');
            }).catch(() => {
                // Fallback si el navegador no soporta clipboard API
                const input = document.createElement('input');
                input.value = codigo;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                alert('✅ Código ' + codigo + ' copiado: ' + codigo);
            });
        }

        // Agendar con promoción
        function agendarConPromocion(codigo) {
            console.log('Agendar con promoción:', codigo);
            alert('Redirigiendo a página de reservas con el código ' + codigo + ' pre-aplicado...');
            // window.location.href = '/cliente/reservar-cita?promo=' + codigo;
        }

        // Agendar combo
        function agendarCombo(comboId) {
            console.log('Agendar combo:', comboId);
            alert('Redirigiendo a página de reservas para el combo: ' + comboId);
            // window.location.href = '/cliente/reservar-cita?combo=' + comboId;
        }

        // Suscribirse a promociones
        function suscribirsePromos() {
            const email = document.getElementById('emailSuscripcion').value;
            
            if (!email || !email.includes('@')) {
                alert('⚠️ Por favor ingresa un correo electrónico válido');
                return;
            }

            console.log('Suscribir email:', email);
            alert('✅ ¡Gracias por suscribirte!\n\n' +
                  'Recibirás nuestras mejores promociones en: ' + email);
            
            document.getElementById('emailSuscripcion').value = '';
            // TODO: Enviar email al backend para suscripción
        }

        // Búsqueda en tiempo real
        document.getElementById('buscarPromocion')?.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                buscarPromocion();
            }
        });
    </script>
    
</body>
</html>