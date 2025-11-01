<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Administrador | Salón de Belleza</title>

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
         <!-- Solo el de configuracion y citas tengo duda si ponerle al admin-->
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
            <a href="{{ route('admin.promocionesAdm') }}" class="menu-item">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('admin.reportesAdm') }}" class="menu-item">
                <i class="bi bi-graph-up"></i> Reportes
            </a>
            <a href="{{ route('admin.configAdm') }}" class="menu-item active">
                <i class="bi bi-gear"></i> Configuración
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Configuración</h1>
            <p>Administra tus preferencias.</p>
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
        
        <!-- Header de Configuración -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 style="color: var(--borgona); margin: 0 0 0.5rem 0;">
                                <i class="bi bi-gear-fill" style="color: var(--dorado-palido);"></i>
                                Configuración del Sistema
                            </h2>
                            <p style="color: var(--borgona); opacity: 0.7; margin: 0;">
                                Panel de administración y gestión del negocio
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-gold" onclick="guardarTodosCambios()">
                                <i class="bi bi-check-circle"></i> Guardar Todos los Cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navegación por pestañas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom" style="padding: 1rem;">
                    <ul class="nav nav-pills" id="configTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="perfil-tab" data-bs-toggle="pill" data-bs-target="#perfil" type="button" role="tab">
                                <i class="bi bi-person-circle"></i> Mi Perfil
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="negocio-tab" data-bs-toggle="pill" data-bs-target="#negocio" type="button" role="tab">
                                <i class="bi bi-building"></i> Negocio
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sistema-tab" data-bs-toggle="pill" data-bs-target="#sistema" type="button" role="tab">
                                <i class="bi bi-gear"></i> Sistema
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="notificaciones-tab" data-bs-toggle="pill" data-bs-target="#notificaciones" type="button" role="tab">
                                <i class="bi bi-bell"></i> Notificaciones
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="seguridad-tab" data-bs-toggle="pill" data-bs-target="#seguridad" type="button" role="tab">
                                <i class="bi bi-shield-lock"></i> Seguridad
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="facturacion-tab" data-bs-toggle="pill" data-bs-target="#facturacion" type="button" role="tab">
                                <i class="bi bi-credit-card"></i> Facturación
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contenido de las pestañas -->
        <div class="tab-content" id="configTabContent">
            
            <!-- ============================================
                 TAB 1: MI PERFIL
                 ============================================ -->
            <div class="tab-pane fade show active" id="perfil" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- Foto de Perfil -->
                    <div class="col-lg-4">
                        <div class="card-custom text-center">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-camera"></i> Foto de Perfil
                            </h6>
                            
                            <div style="width: 150px; height: 150px; margin: 0 auto 1.5rem; border-radius: 50%; background: linear-gradient(135deg, var(--borgona), var(--borgona-light)); display: flex; align-items: center; justify-content: center; border: 5px solid var(--dorado-palido); font-size: 4rem; color: white;">
                                A
                            </div>
                            
                            <div class="badge badge-luxury mb-3">
                                <i class="bi bi-shield-check"></i> Administrador
                            </div>
                            
                            <input type="file" id="fotoPerfil" accept="image/*" style="display: none;" onchange="previsualizarFoto(event)">
                            
                            <button class="btn btn-gold btn-sm mb-2 w-100" onclick="document.getElementById('fotoPerfil').click()">
                                <i class="bi bi-upload"></i> Cambiar Foto
                            </button>
                            <button class="btn btn-soft btn-sm w-100" onclick="eliminarFoto()">
                                <i class="bi bi-trash"></i> Eliminar Foto
                            </button>
                            
                            <div class="alert-custom mt-3" style="text-align: left;">
                                <i class="bi bi-info-circle"></i>
                                <small>Formatos: JPG, PNG. Máx: 2MB</small>
                            </div>
                        </div>
                    </div>

                    <!-- Información Personal -->
                    <div class="col-lg-8">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-person"></i> Información Personal
                            </h6>
                            
                            <form id="formPerfil">
                                <div class="row g-3">
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" value="Ana" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" value="Martínez" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="admin@beautysalon.com" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" value="7777-9999" pattern="[0-9]{4}-[0-9]{4}">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Cargo</label>
                                        <input type="text" class="form-control" id="cargo" value="Administradora General" readonly>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Fecha de Ingreso</label>
                                        <input type="date" class="form-control" id="fechaIngreso" value="2020-01-15" readonly>
                                    </div>
                                    
                                    <div class="col-12">
                                        <button type="button" class="btn btn-gold" onclick="guardarPerfil()">
                                            <i class="bi bi-check-circle"></i> Guardar Cambios
                                        </button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 2: CONFIGURACIÓN DEL NEGOCIO
                 ============================================ -->
            <div class="tab-pane fade" id="negocio" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- Información Básica del Negocio -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-building"></i> Información del Salón
                            </h6>
                            
                            <form id="formNegocio">
                                <div class="mb-3">
                                    <label class="form-label">Nombre del Salón</label>
                                    <input type="text" class="form-control" id="nombreSalon" value="BeautySalon" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Eslogan</label>
                                    <input type="text" class="form-control" id="eslogan" value="Tu Salón de Belleza de Confianza" placeholder="Tu eslogan aquí">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="direccion" value="Calle Principal #123, Col. Escalón">
                                </div>
                                
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label">Ciudad</label>
                                        <input type="text" class="form-control" id="ciudad" value="San Salvador">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">País</label>
                                        <input type="text" class="form-control" id="pais" value="El Salvador">
                                    </div>
                                </div>
                                
                                <div class="mb-3 mt-3">
                                    <label class="form-label">Teléfonos de Contacto</label>
                                    <input type="text" class="form-control mb-2" id="telefono1" value="(503) 2222-3333">
                                    <input type="text" class="form-control" id="telefono2" placeholder="Teléfono 2 (opcional)">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Email de Contacto</label>
                                    <input type="email" class="form-control" id="emailContacto" value="info@beautysalon.com">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Sitio Web</label>
                                    <input type="url" class="form-control" id="sitioWeb" placeholder="https://www.beautysalon.com">
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Horarios de Atención -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-clock"></i> Horarios de Atención
                            </h6>
                            
                            <div class="mb-3">
                                <div class="list-item-custom mb-2">
                                    <div class="list-content" style="width: 100%;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong style="color: var(--borgona);">Lunes a Viernes</strong>
                                            <div class="d-flex gap-2">
                                                <input type="time" class="form-control form-control-sm" value="09:00" style="width: 100px;">
                                                <span>-</span>
                                                <input type="time" class="form-control form-control-sm" value="18:00" style="width: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="list-item-custom mb-2">
                                    <div class="list-content" style="width: 100%;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong style="color: var(--borgona);">Sábado</strong>
                                            <div class="d-flex gap-2">
                                                <input type="time" class="form-control form-control-sm" value="09:00" style="width: 100px;">
                                                <span>-</span>
                                                <input type="time" class="form-control form-control-sm" value="14:00" style="width: 100px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="list-item-custom">
                                    <div class="list-content" style="width: 100%;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong style="color: var(--borgona);">Domingo</strong>
                                            <span class="badge bg-danger">CERRADO</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert-custom">
                                <i class="bi bi-info-circle"></i>
                                <small>Estos horarios se mostrarán a los clientes al agendar citas</small>
                            </div>
                        </div>

                        <!-- Redes Sociales -->
                        <div class="card-custom mt-4">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-share"></i> Redes Sociales
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-facebook"></i> Facebook</label>
                                <input type="url" class="form-control" placeholder="https://facebook.com/beautysalon">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-instagram"></i> Instagram</label>
                                <input type="url" class="form-control" placeholder="https://instagram.com/beautysalon">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label"><i class="bi bi-tiktok"></i> TikTok</label>
                                <input type="url" class="form-control" placeholder="https://tiktok.com/@beautysalon">
                            </div>
                        </div>
                    </div>

                    <!-- Logo e Imágenes -->
                    <div class="col-12">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-image"></i> Logo e Imágenes del Salón
                            </h6>
                            
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div style="width: 100%; height: 200px; background: var(--blanco-humo); border: 2px dashed var(--rosa-empolvado); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                            <i class="bi bi-image" style="font-size: 3rem; color: var(--rosa-empolvado);"></i>
                                        </div>
                                        <h6 style="color: var(--borgona); margin-bottom: 0.5rem;">Logo Principal</h6>
                                        <button class="btn btn-soft btn-sm w-100">
                                            <i class="bi bi-upload"></i> Subir Logo
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div style="width: 100%; height: 200px; background: var(--blanco-humo); border: 2px dashed var(--rosa-empolvado); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                            <i class="bi bi-image" style="font-size: 3rem; color: var(--rosa-empolvado);"></i>
                                        </div>
                                        <h6 style="color: var(--borgona); margin-bottom: 0.5rem;">Banner Principal</h6>
                                        <button class="btn btn-soft btn-sm w-100">
                                            <i class="bi bi-upload"></i> Subir Banner
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="text-center">
                                        <div style="width: 100%; height: 200px; background: var(--blanco-humo); border: 2px dashed var(--rosa-empolvado); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                            <i class="bi bi-image" style="font-size: 3rem; color: var(--rosa-empolvado);"></i>
                                        </div>
                                        <h6 style="color: var(--borgona); margin-bottom: 0.5rem;">Favicon</h6>
                                        <button class="btn btn-soft btn-sm w-100">
                                            <i class="bi bi-upload"></i> Subir Favicon
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="col-12">
                        <div class="text-end">
                            <button class="btn btn-gold btn-lg" onclick="guardarConfiguracionNegocio()">
                                <i class="bi bi-check-circle"></i> Guardar Configuración del Negocio
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 3: CONFIGURACIÓN DEL SISTEMA
                 ============================================ -->
            <div class="tab-pane fade" id="sistema" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- Configuración Regional -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-globe"></i> Configuración Regional
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Zona Horaria</label>
                                <select class="form-control" id="zonaHoraria">
                                    <option value="America/El_Salvador" selected>América/El Salvador (GMT-6)</option>
                                    <option value="America/Guatemala">América/Guatemala (GMT-6)</option>
                                    <option value="America/Tegucigalpa">América/Tegucigalpa (GMT-6)</option>
                                    <option value="America/Managua">América/Managua (GMT-6)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Moneda</label>
                                <select class="form-control" id="moneda">
                                    <option value="USD" selected>USD - Dólar Estadounidense ($)</option>
                                    <option value="GTQ">GTQ - Quetzal Guatemalteco (Q)</option>
                                    <option value="HNL">HNL - Lempira Hondureño (L)</option>
                                    <option value="NIO">NIO - Córdoba Nicaragüense (C$)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Idioma del Sistema</label>
                                <select class="form-control" id="idiomaSistema">
                                    <option value="es" selected>Español</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Formato de Fecha</label>
                                <select class="form-control" id="formatoFecha">
                                    <option value="DD/MM/YYYY" selected>DD/MM/YYYY (31/10/2024)</option>
                                    <option value="MM/DD/YYYY">MM/DD/YYYY (10/31/2024)</option>
                                    <option value="YYYY-MM-DD">YYYY-MM-DD (2024-10-31)</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Formato de Hora</label>
                                <select class="form-control" id="formatoHora">
                                    <option value="12h" selected>12 horas (2:30 PM)</option>
                                    <option value="24h">24 horas (14:30)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Configuración de Citas -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-calendar-event"></i> Configuración de Citas
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Intervalo entre citas (minutos)</label>
                                <select class="form-control" id="intervaloCitas">
                                    <option value="15">15 minutos</option>
                                    <option value="30" selected>30 minutos</option>
                                    <option value="60">60 minutos</option>
                                </select>
                                <small class="text-muted">Tiempo de separación entre cada cita</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Anticipación mínima para agendar</label>
                                <select class="form-control" id="anticipacionMinima">
                                    <option value="0">Sin anticipación</option>
                                    <option value="60">1 hora</option>
                                    <option value="120">2 horas</option>
                                    <option value="1440" selected>1 día</option>
                                    <option value="2880">2 días</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Anticipación máxima para agendar</label>
                                <select class="form-control" id="anticipacionMaxima">
                                    <option value="7">7 días</option>
                                    <option value="15">15 días</option>
                                    <option value="30" selected>30 días</option>
                                    <option value="60">60 días</option>
                                    <option value="90">90 días</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Límite de cancelaciones (horas antes)</label>
                                <input type="number" class="form-control" id="limiteCancelacion" value="24" min="1">
                                <small class="text-muted">Tiempo límite para cancelar sin penalización</small>
                            </div>
                            
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="permitirMultiplesCitas" checked>
                                <label class="form-check-label" for="permitirMultiplesCitas">
                                    Permitir múltiples citas por cliente el mismo día
                                </label>
                            </div>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="confirmacionAutomatica">
                                <label class="form-check-label" for="confirmacionAutomatica">
                                    Confirmación automática de citas
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Configuración de Email -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-envelope"></i> Configuración de Email
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Email Remitente</label>
                                <input type="email" class="form-control" value="noreply@beautysalon.com">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Nombre del Remitente</label>
                                <input type="text" class="form-control" value="BeautySalon">
                            </div>
                            
                            <div class="alert-custom">
                                <i class="bi bi-info-circle"></i>
                                <small><strong>SMTP:</strong> Configuración avanzada en el archivo .env del servidor</small>
                            </div>
                        </div>
                    </div>

                    <!-- Mantenimiento del Sistema -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-tools"></i> Mantenimiento del Sistema
                            </h6>
                            
                            <div class="list-item-custom mb-3">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--champagne));">
                                    <i class="bi bi-database"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Respaldo de Base de Datos</h6>
                                    <p>Último respaldo: Hace 2 días</p>
                                    <button class="btn btn-soft btn-sm" onclick="crearRespaldo()">
                                        <i class="bi bi-download"></i> Crear Respaldo Ahora
                                    </button>
                                </div>
                            </div>
                            
                            <div class="list-item-custom mb-3">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                    <i class="bi bi-trash"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Limpiar Caché</h6>
                                    <p>Mejora el rendimiento del sistema</p>
                                    <button class="btn btn-soft btn-sm" onclick="limpiarCache()">
                                        <i class="bi bi-arrow-clockwise"></i> Limpiar Caché
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="modoMantenimiento">
                                <label class="form-check-label" for="modoMantenimiento">
                                    <strong style="color: #dc3545;">Modo Mantenimiento</strong>
                                    <br>
                                    <small>El sitio mostrará un mensaje de mantenimiento</small>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="col-12">
                        <div class="text-end">
                            <button class="btn btn-gold btn-lg" onclick="guardarConfiguracionSistema()">
                                <i class="bi bi-check-circle"></i> Guardar Configuración del Sistema
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 4: NOTIFICACIONES
                 ============================================ -->
            <div class="tab-pane fade" id="notificaciones" role="tabpanel">
                <div class="row g-4">
                    
                    <div class="col-12">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-bell"></i> Notificaciones del Administrador
                            </h6>
                            
                            <!-- Notificaciones de Gestión -->
                            <div class="mb-4">
                                <h6 style="color: var(--borgona); font-size: 0.95rem; margin-bottom: 1rem;">
                                    🏢 Notificaciones de Gestión
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifNuevaCita" checked>
                                            <label class="form-check-label" for="notifNuevaCita">
                                                Nueva cita agendada
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifCitaCancelada" checked>
                                            <label class="form-check-label" for="notifCitaCancelada">
                                                Cita cancelada
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifNuevoCliente" checked>
                                            <label class="form-check-label" for="notifNuevoCliente">
                                                Nuevo cliente registrado
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifNuevaResena" checked>
                                            <label class="form-check-label" for="notifNuevaResena">
                                                Nueva reseña/calificación
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: var(--rosa-empolvado); margin: 2rem 0;">

                            <!-- Reportes y Resúmenes -->
                            <div class="mb-4">
                                <h6 style="color: var(--borgona); font-size: 0.95rem; margin-bottom: 1rem;">
                                    📊 Reportes y Resúmenes
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="reporteDiario" checked>
                                            <label class="form-check-label" for="reporteDiario">
                                                Reporte diario de ventas
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="reporteSemanal" checked>
                                            <label class="form-check-label" for="reporteSemanal">
                                                Resumen semanal
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="reporteMensual" checked>
                                            <label class="form-check-label" for="reporteMensual">
                                                Reporte mensual completo
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="alertaBajoInventario">
                                            <label class="form-check-label" for="alertaBajoInventario">
                                                Alerta de bajo inventario
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: var(--rosa-empolvado); margin: 2rem 0;">

                            <!-- Alertas del Sistema -->
                            <div class="mb-4">
                                <h6 style="color: var(--borgona); font-size: 0.95rem; margin-bottom: 1rem;">
                                    ⚠️ Alertas del Sistema
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="alertaErrores" checked>
                                            <label class="form-check-label" for="alertaErrores">
                                                Errores del sistema
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="alertaRespaldos" checked>
                                            <label class="form-check-label" for="alertaRespaldos">
                                                Estado de respaldos
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="alertaActualizaciones" checked>
                                            <label class="form-check-label" for="alertaActualizaciones">
                                                Actualizaciones disponibles
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="alertaSeguridad" checked>
                                            <label class="form-check-label" for="alertaSeguridad">
                                                Alertas de seguridad
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: var(--rosa-empolvado); margin: 2rem 0;">

                            <!-- Canal de Notificaciones -->
                            <div class="mb-4">
                                <h6 style="color: var(--borgona); font-size: 0.95rem; margin-bottom: 1rem;">
                                    📬 Canales de Notificación
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="canalEmailAdmin" checked>
                                            <label class="form-check-label" for="canalEmailAdmin">
                                                <i class="bi bi-envelope"></i> Email
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="canalSMSAdmin">
                                            <label class="form-check-label" for="canalSMSAdmin">
                                                <i class="bi bi-phone"></i> SMS
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="canalPushAdmin" checked>
                                            <label class="form-check-label" for="canalPushAdmin">
                                                <i class="bi bi-app-indicator"></i> Push
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón Guardar -->
                            <div class="text-end">
                                <button class="btn btn-gold" onclick="guardarNotificaciones()">
                                    <i class="bi bi-check-circle"></i> Guardar Configuración
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 5: SEGURIDAD
                 ============================================ -->
            <div class="tab-pane fade" id="seguridad" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- Cambiar Contraseña -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-key"></i> Cambiar Contraseña
                            </h6>
                            
                            <form id="formCambiarPassword">
                                <div class="mb-3">
                                    <label class="form-label">Contraseña Actual</label>
                                    <input type="password" class="form-control" id="passwordActual" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="passwordNueva" minlength="8" required>
                                    <small class="text-muted">Mínimo 8 caracteres, incluye mayúsculas y números</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="passwordConfirmar" minlength="8" required>
                                </div>
                                
                                <button type="button" class="btn btn-gold w-100" onclick="cambiarPassword()">
                                    <i class="bi bi-check-circle"></i> Cambiar Contraseña
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Autenticación de Dos Factores -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-shield-check"></i> Autenticación de Dos Factores (2FA)
                            </h6>
                            
                            <div class="alert-custom mb-3" style="background: rgba(212, 175, 55, 0.1); border-left-color: var(--dorado-palido);">
                                <i class="bi bi-exclamation-triangle"></i>
                                <small><strong>Recomendado:</strong> Como administrador, te sugerimos activar 2FA para mayor seguridad</small>
                            </div>
                            
                            <div class="list-item-custom mb-3" style="background: rgba(40, 167, 69, 0.05);">
                                <div class="list-avatar" style="background: linear-gradient(135deg, #28a745, #20c997);">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div class="list-content">
                                    <h6>2FA Activada</h6>
                                    <p>Tu cuenta está protegida con autenticación de dos factores</p>
                                </div>
                            </div>
                            
                            <button class="btn btn-outline-gold w-100" onclick="desactivar2FA()">
                                <i class="bi bi-shield-x"></i> Desactivar 2FA
                            </button>
                        </div>
                    </div>

                    <!-- Sesiones Activas -->
                    <div class="col-12">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-pc-display"></i> Sesiones Activas
                            </h6>
                            
                            <div class="list-item-custom mb-3">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--champagne));">
                                    <i class="bi bi-laptop"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>Windows - Chrome</h6>
                                            <p>
                                                <i class="bi bi-geo-alt"></i> San Salvador, El Salvador<br>
                                                <i class="bi bi-clock"></i> Última actividad: Ahora
                                            </p>
                                        </div>
                                        <span class="badge bg-success">Actual</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end mt-3">
                                <button class="btn btn-outline-gold btn-sm" onclick="cerrarTodasSesiones()">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar Todas las Sesiones
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Registro de Auditoría -->
                    <div class="col-12">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-clipboard-data"></i> Registro de Auditoría (Últimas Acciones)
                            </h6>
                            
                            <div class="list-item-custom mb-2">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light)); width: 40px; height: 40px;">
                                    <i class="bi bi-person-plus" style="font-size: 1rem;"></i>
                                </div>
                                <div class="list-content">
                                    <h6 style="font-size: 0.9rem;">Nuevo usuario creado</h6>
                                    <p style="font-size: 0.85rem; margin: 0;">Cliente: María López - Hace 2 horas</p>
                                </div>
                            </div>
                            
                            <div class="list-item-custom mb-2">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--champagne)); width: 40px; height: 40px;">
                                    <i class="bi bi-gear" style="font-size: 1rem;"></i>
                                </div>
                                <div class="list-content">
                                    <h6 style="font-size: 0.9rem;">Configuración modificada</h6>
                                    <p style="font-size: 0.85rem; margin: 0;">Horarios de atención actualizados - Hace 1 día</p>
                                </div>
                            </div>
                            
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light)); width: 40px; height: 40px;">
                                    <i class="bi bi-box-arrow-in-right" style="font-size: 1rem;"></i>
                                </div>
                                <div class="list-content">
                                    <h6 style="font-size: 0.9rem;">Inicio de sesión</h6>
                                    <p style="font-size: 0.85rem; margin: 0;">IP: 192.168.1.100 - Hace 3 días</p>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <button class="btn btn-outline-gold btn-sm" onclick="verRegistroCompleto()">
                                    <i class="bi bi-file-text"></i> Ver Registro Completo
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 6: FACTURACIÓN
                 ============================================ -->
            <div class="tab-pane fade" id="facturacion" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- Plan Actual -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-star"></i> Plan Actual
                            </h6>
                            
                            <div class="premium-card mb-3">
                                <div class="text-center">
                                    <div style="font-size: 3rem; color: var(--dorado-palido); margin-bottom: 1rem;">
                                        <i class="bi bi-trophy-fill"></i>
                                    </div>
                                    <h3 style="color: white; margin-bottom: 0.5rem;">Plan Premium</h3>
                                    <h2 style="color: var(--dorado-palido); font-size: 3rem; margin: 1rem 0;">
                                        $49<small style="font-size: 1.5rem;">/mes</small>
                                    </h2>
                                    <p style="color: var(--rosa-empolvado); margin-bottom: 1.5rem;">
                                        ✓ Usuarios ilimitados<br>
                                        ✓ Citas ilimitadas<br>
                                        ✓ Soporte prioritario 24/7<br>
                                        ✓ Reportes avanzados
                                    </p>
                                    <span class="badge bg-success" style="font-size: 0.9rem; padding: 0.5rem 1rem;">
                                        <i class="bi bi-check-circle"></i> Activo
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span style="color: var(--borgona);">Próxima renovación:</span>
                                    <strong style="color: var(--borgona);">15 Nov 2024</strong>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span style="color: var(--borgona);">Método de pago:</span>
                                    <strong style="color: var(--borgona);">
                                        <i class="bi bi-credit-card"></i> **** 4242
                                    </strong>
                                </div>
                            </div>
                            
                            <button class="btn btn-outline-gold w-100 mb-2" onclick="cambiarPlan()">
                                <i class="bi bi-arrow-repeat"></i> Cambiar Plan
                            </button>
                            <button class="btn btn-soft w-100" onclick="cancelarSuscripcion()">
                                <i class="bi bi-x-circle"></i> Cancelar Suscripción
                            </button>
                        </div>
                    </div>

                    <!-- Métodos de Pago -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-credit-card"></i> Métodos de Pago
                            </h6>
                            
                            <div class="list-item-custom mb-3">
                                <div class="list-avatar" style="background: linear-gradient(135deg, #1434CB, #0E2A8E);">
                                    <i class="bi bi-credit-card-fill"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>Visa •••• 4242</h6>
                                            <p>Vence: 12/2025</p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <span class="badge bg-success">Principal</span>
                                            <button class="btn btn-soft btn-sm" onclick="eliminarMetodoPago(1)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <button class="btn btn-gold btn-sm w-100" onclick="agregarMetodoPago()">
                                <i class="bi bi-plus-circle"></i> Agregar Método de Pago
                            </button>
                        </div>

                        <!-- Facturación -->
                        <div class="card-custom mt-4">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-file-earmark-text"></i> Información de Facturación
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Razón Social / Nombre</label>
                                <input type="text" class="form-control" value="BeautySalon S.A. de C.V.">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">NIT / RFC</label>
                                <input type="text" class="form-control" value="0614-010101-001-0">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Dirección Fiscal</label>
                                <input type="text" class="form-control" value="Calle Principal #123">
                            </div>
                            
                            <button class="btn btn-soft btn-sm w-100" onclick="guardarInfoFacturacion()">
                                <i class="bi bi-check-circle"></i> Guardar
                            </button>
                        </div>
                    </div>

                    <!-- Historial de Pagos -->
                    <div class="col-12">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-clock-history"></i> Historial de Pagos
                            </h6>
                            
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="background: var(--blanco-humo);">
                                            <th style="color: var(--borgona);">Fecha</th>
                                            <th style="color: var(--borgona);">Descripción</th>
                                            <th style="color: var(--borgona);">Monto</th>
                                            <th style="color: var(--borgona);">Estado</th>
                                            <th style="color: var(--borgona);">Factura</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>15 Oct 2024</td>
                                            <td>Plan Premium - Mensual</td>
                                            <td><strong style="color: var(--dorado-palido);">$49.00</strong></td>
                                            <td><span class="badge bg-success">Pagado</span></td>
                                            <td>
                                                <button class="btn btn-soft btn-sm" onclick="descargarFactura(1)">
                                                    <i class="bi bi-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>15 Sep 2024</td>
                                            <td>Plan Premium - Mensual</td>
                                            <td><strong style="color: var(--dorado-palido);">$49.00</strong></td>
                                            <td><span class="badge bg-success">Pagado</span></td>
                                            <td>
                                                <button class="btn btn-soft btn-sm" onclick="descargarFactura(2)">
                                                    <i class="bi bi-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>15 Ago 2024</td>
                                            <td>Plan Premium - Mensual</td>
                                            <td><strong style="color: var(--dorado-palido);">$49.00</strong></td>
                                            <td><span class="badge bg-success">Pagado</span></td>
                                            <td>
                                                <button class="btn btn-soft btn-sm" onclick="descargarFactura(3)">
                                                    <i class="bi bi-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
        // ========================================
        // TAB 1: MI PERFIL
        // ========================================

        function previsualizarFoto(event) {
            const file = event.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('⚠️ El archivo es muy grande. Máximo 2MB.');
                    return;
                }
                if (!file.type.match('image.*')) {
                    alert('⚠️ Solo se permiten imágenes.');
                    return;
                }
                console.log('Foto seleccionada:', file.name);
                alert('✓ Foto seleccionada: ' + file.name);
            }
        }

        function eliminarFoto() {
            if (confirm('¿Eliminar foto de perfil?')) {
                console.log('Eliminar foto');
                alert('✓ Foto eliminada');
            }
        }

        function guardarPerfil() {
            console.log('Guardar perfil');
            alert('✅ Perfil actualizado exitosamente');
        }

        // ========================================
        // TAB 2: CONFIGURACIÓN DEL NEGOCIO
        // ========================================

        function guardarConfiguracionNegocio() {
            console.log('Guardar configuración del negocio');
            alert('✅ Configuración del negocio guardada exitosamente');
        }

        // ========================================
        // TAB 3: CONFIGURACIÓN DEL SISTEMA
        // ========================================

        function crearRespaldo() {
            if (confirm('¿Crear respaldo de la base de datos?\n\nEsto puede tardar unos minutos.')) {
                console.log('Crear respaldo');
                alert('✓ Respaldo creado exitosamente\n\nArchivo: backup_' + Date.now() + '.sql');
            }
        }

        function limpiarCache() {
            if (confirm('¿Limpiar caché del sistema?\n\nEl sistema puede tardar un poco más en cargar la primera vez.')) {
                console.log('Limpiar caché');
                alert('✓ Caché limpiado exitosamente');
            }
        }

        function guardarConfiguracionSistema() {
            console.log('Guardar configuración del sistema');
            alert('✅ Configuración del sistema guardada exitosamente');
        }

        // ========================================
        // TAB 4: NOTIFICACIONES
        // ========================================

        function guardarNotificaciones() {
            console.log('Guardar notificaciones');
            alert('✅ Configuración de notificaciones guardada');
        }

        // ========================================
        // TAB 5: SEGURIDAD
        // ========================================

        function cambiarPassword() {
            const actual = document.getElementById('passwordActual').value;
            const nueva = document.getElementById('passwordNueva').value;
            const confirmar = document.getElementById('passwordConfirmar').value;

            if (nueva !== confirmar) {
                alert('⚠️ Las contraseñas no coinciden');
                return;
            }
            if (nueva.length < 8) {
                alert('⚠️ La contraseña debe tener al menos 8 caracteres');
                return;
            }

            console.log('Cambiar contraseña');
            alert('✅ Contraseña actualizada exitosamente');
            document.getElementById('formCambiarPassword').reset();
        }

        function desactivar2FA() {
            if (confirm('⚠️ ¿Desactivar autenticación de dos factores?\n\nEsto reducirá la seguridad de tu cuenta.')) {
                console.log('Desactivar 2FA');
                alert('✓ 2FA desactivada');
            }
        }

        function cerrarTodasSesiones() {
            if (confirm('¿Cerrar todas las sesiones?\n\nSerás el único con acceso a tu cuenta.')) {
                console.log('Cerrar todas las sesiones');
                alert('✓ Todas las sesiones cerradas');
            }
        }

        function verRegistroCompleto() {
            console.log('Ver registro completo');
            alert('Redirigir a página de registro de auditoría completo');
        }

        // ========================================
        // TAB 6: FACTURACIÓN
        // ========================================

        function cambiarPlan() {
            console.log('Cambiar plan');
            alert('Función: Abrir modal con opciones de planes disponibles');
        }

        function cancelarSuscripcion() {
            if (confirm('⚠️ ¿Cancelar suscripción?\n\nPerderás acceso a las funciones premium al final del período de facturación.')) {
                console.log('Cancelar suscripción');
                alert('Suscripción marcada para cancelación');
            }
        }

        function agregarMetodoPago() {
            console.log('Agregar método de pago');
            alert('Función: Abrir modal para agregar tarjeta de crédito/débito');
        }

        function eliminarMetodoPago(id) {
            if (confirm('¿Eliminar este método de pago?')) {
                console.log('Eliminar método de pago:', id);
                alert('✓ Método de pago eliminado');
            }
        }

        function guardarInfoFacturacion() {
            console.log('Guardar info de facturación');
            alert('✅ Información de facturación guardada');
        }

        function descargarFactura(id) {
            console.log('Descargar factura:', id);
            alert('✓ Descargando factura #' + id + '...\n\nArchivo: factura_' + id + '.pdf');
        }

        // ========================================
        // FUNCIONES GENERALES
        // ========================================

        function guardarTodosCambios() {
            if (confirm('¿Guardar todos los cambios realizados?')) {
                console.log('Guardar todos los cambios');
                alert('✅ Todos los cambios guardados exitosamente');
            }
        }
    </script>
    
</body>
</html>