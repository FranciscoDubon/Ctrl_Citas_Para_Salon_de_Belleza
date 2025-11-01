<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Recepcionista | Salón de Belleza</title>
    
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
            <a href="{{ route('recepcionista.clientesRecep') }}" class="menu-item">
                <i class="bi bi-people"></i> Clientes
            </a>
            <a href="{{ route('recepcionista.serviciosRecep') }}" class="menu-item">
                <i class="bi bi-scissors"></i> Servicios
            </a>
            <a href="{{ route('recepcionista.promocionesRecep') }}" class="menu-item">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('recepcionista.configRecep') }}" class="menu-item active">
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
                <div class="user-avatar">L</div>
                <span class="user-name">Laura Hernández - Recepcionista</span>
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
                                Configuración de mi Cuenta
                            </h2>
                            <p style="color: var(--borgona); opacity: 0.7; margin: 0;">
                                Personaliza tu espacio de trabajo y preferencias
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
                            <button class="nav-link" id="preferencias-tab" data-bs-toggle="pill" data-bs-target="#preferencias" type="button" role="tab">
                                <i class="bi bi-sliders"></i> Preferencias
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
                            
                            <div style="width: 150px; height: 150px; margin: 0 auto 1.5rem; border-radius: 50%; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light)); display: flex; align-items: center; justify-content: center; border: 5px solid var(--dorado-palido); font-size: 4rem; color: white;">
                                C
                            </div>
                            
                            <div class="badge bg-info mb-3">
                                <i class="bi bi-person-badge"></i> Recepcionista
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
                                        <input type="text" class="form-control" id="nombre" value="Carmen" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" value="Rodríguez" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="carmen.rodriguez@beautysalon.com" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" value="7777-5555" pattern="[0-9]{4}-[0-9]{4}">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Cargo</label>
                                        <input type="text" class="form-control" id="cargo" value="Recepcionista" readonly>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Fecha de Ingreso</label>
                                        <input type="date" class="form-control" id="fechaIngreso" value="2023-03-10" readonly>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label class="form-label">Turno de Trabajo</label>
                                        <select class="form-control" id="turno" disabled>
                                            <option value="matutino" selected>Matutino (9:00 AM - 2:00 PM)</option>
                                            <option value="vespertino">Vespertino (2:00 PM - 6:00 PM)</option>
                                            <option value="completo">Tiempo Completo (9:00 AM - 6:00 PM)</option>
                                        </select>
                                        <small class="text-muted">Contacta al administrador para cambiar tu turno</small>
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
                 TAB 2: PREFERENCIAS DE TRABAJO
                 ============================================ -->
            <div class="tab-pane fade" id="preferencias" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- Vista del Calendario -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-calendar-week"></i> Vista del Calendario
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Vista predeterminada</label>
                                <select class="form-control" id="vistaCalendario">
                                    <option value="dia">Vista de Día</option>
                                    <option value="semana" selected>Vista de Semana</option>
                                    <option value="mes">Vista de Mes</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Intervalo de tiempo (minutos)</label>
                                <select class="form-control" id="intervaloTiempo">
                                    <option value="15">15 minutos</option>
                                    <option value="30" selected>30 minutos</option>
                                    <option value="60">60 minutos</option>
                                </select>
                                <small class="text-muted">Cuadrícula del calendario</small>
                            </div>
                            
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="mostrarFinDeSemana" checked>
                                <label class="form-check-label" for="mostrarFinDeSemana">
                                    Mostrar fines de semana
                                </label>
                            </div>
                            
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="mostrarHorasNoLaborables">
                                <label class="form-check-label" for="mostrarHorasNoLaborables">
                                    Mostrar horas no laborables
                                </label>
                            </div>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="resaltarHoraActual" checked>
                                <label class="form-check-label" for="resaltarHoraActual">
                                    Resaltar hora actual
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Gestión de Citas -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-calendar-check"></i> Gestión de Citas
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Confirmación de citas</label>
                                <select class="form-control" id="confirmacionCitas">
                                    <option value="automatica">Automática</option>
                                    <option value="manual" selected>Requiere confirmación manual</option>
                                </select>
                            </div>
                            
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="notificarNuevaCita" checked>
                                <label class="form-check-label" for="notificarNuevaCita">
                                    Notificarme de nuevas citas
                                </label>
                            </div>
                            
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="notificarCancelacion" checked>
                                <label class="form-check-label" for="notificarCancelacion">
                                    Notificarme de cancelaciones
                                </label>
                            </div>
                            
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="mostrarCitasCompletadas">
                                <label class="form-check-label" for="mostrarCitasCompletadas">
                                    Mostrar citas completadas en el calendario
                                </label>
                            </div>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="sonidoNotificacion" checked>
                                <label class="form-check-label" for="sonidoNotificacion">
                                    Reproducir sonido en notificaciones
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Accesos Rápidos -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-lightning"></i> Accesos Rápidos
                            </h6>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="accesoAgendar" checked>
                                <label class="form-check-label" for="accesoAgendar">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita Rápida
                                </label>
                            </div>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="accesoBuscarCliente" checked>
                                <label class="form-check-label" for="accesoBuscarCliente">
                                    <i class="bi bi-search"></i> Buscar Cliente
                                </label>
                            </div>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="accesoNuevoCliente" checked>
                                <label class="form-check-label" for="accesoNuevoCliente">
                                    <i class="bi bi-person-plus"></i> Registrar Nuevo Cliente
                                </label>
                            </div>
                            
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="accesoReportes">
                                <label class="form-check-label" for="accesoReportes">
                                    <i class="bi bi-file-earmark-bar-graph"></i> Ver Reportes del Día
                                </label>
                            </div>
                            
                            <div class="alert-custom mt-3">
                                <i class="bi bi-info-circle"></i>
                                <small>Estos accesos aparecerán en tu panel principal</small>
                            </div>
                        </div>
                    </div>

                    <!-- Apariencia -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-palette"></i> Apariencia
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Tema de la interfaz</label>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-gold flex-fill active" onclick="cambiarTema('claro')">
                                        <i class="bi bi-sun"></i> Claro
                                    </button>
                                    <button class="btn btn-outline-gold flex-fill" onclick="cambiarTema('oscuro')">
                                        <i class="bi bi-moon"></i> Oscuro
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Tamaño de texto</label>
                                <select class="form-control" id="tamanoTexto">
                                    <option value="pequeno">Pequeño</option>
                                    <option value="normal" selected>Normal</option>
                                    <option value="grande">Grande</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Idioma</label>
                                <select class="form-control" id="idioma">
                                    <option value="es" selected>Español</option>
                                    <option value="en">English</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Botón Guardar -->
                    <div class="col-12">
                        <div class="text-end">
                            <button class="btn btn-gold" onclick="guardarPreferencias()">
                                <i class="bi bi-check-circle"></i> Guardar Preferencias
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 3: NOTIFICACIONES
                 ============================================ -->
            <div class="tab-pane fade" id="notificaciones" role="tabpanel">
                <div class="row g-4">
                    
                    <div class="col-12">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-bell"></i> Configuración de Notificaciones
                            </h6>
                            
                            <!-- Notificaciones de Citas -->
                            <div class="mb-4">
                                <h6 style="color: var(--borgona); font-size: 0.95rem; margin-bottom: 1rem;">
                                    📅 Notificaciones de Citas
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
                                            <input class="form-check-input" type="checkbox" id="notifCitaModificada" checked>
                                            <label class="form-check-label" for="notifCitaModificada">
                                                Cita modificada
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifCitaProxima" checked>
                                            <label class="form-check-label" for="notifCitaProxima">
                                                Recordatorio de cita próxima (15 min antes)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: var(--rosa-empolvado); margin: 2rem 0;">

                            <!-- Notificaciones de Clientes -->
                            <div class="mb-4">
                                <h6 style="color: var(--borgona); font-size: 0.95rem; margin-bottom: 1rem;">
                                    👥 Notificaciones de Clientes
                                </h6>
                                
                                <div class="row g-3">
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
                                            <input class="form-check-input" type="checkbox" id="notifClienteLlegada">
                                            <label class="form-check-label" for="notifClienteLlegada">
                                                Cliente marcado como "llegó"
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifCumpleanosCliente" checked>
                                            <label class="form-check-label" for="notifCumpleanosCliente">
                                                Cumpleaños de clientes
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: var(--rosa-empolvado); margin: 2rem 0;">

                            <!-- Notificaciones del Sistema -->
                            <div class="mb-4">
                                <h6 style="color: var(--borgona); font-size: 0.95rem; margin-bottom: 1rem;">
                                    ⚙️ Notificaciones del Sistema
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifActualizaciones">
                                            <label class="form-check-label" for="notifActualizaciones">
                                                Actualizaciones del sistema
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifMantenimiento">
                                            <label class="form-check-label" for="notifMantenimiento">
                                                Mantenimiento programado
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
                                            <input class="form-check-input" type="checkbox" id="canalEmail" checked>
                                            <label class="form-check-label" for="canalEmail">
                                                <i class="bi bi-envelope"></i> Email
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="canalPush" checked>
                                            <label class="form-check-label" for="canalPush">
                                                <i class="bi bi-app-indicator"></i> Push (en pantalla)
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="canalSonido" checked>
                                            <label class="form-check-label" for="canalSonido">
                                                <i class="bi bi-volume-up"></i> Sonido
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
                 TAB 4: SEGURIDAD
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
                                    <small class="text-muted">Mínimo 8 caracteres</small>
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
                            
                            <div class="alert-custom mb-3">
                                <i class="bi bi-info-circle"></i>
                                <small>Agrega una capa extra de seguridad a tu cuenta</small>
                            </div>
                            
                            <div class="list-item-custom mb-3" style="background: rgba(212, 175, 55, 0.05);">
                                <div class="list-avatar" style="background: var(--rosa-empolvado);">
                                    <i class="bi bi-shield-x"></i>
                                </div>
                                <div class="list-content">
                                    <h6>2FA Desactivada</h6>
                                    <p>Tu cuenta no está protegida con 2FA</p>
                                </div>
                            </div>
                            
                            <button class="btn btn-gold w-100" onclick="activar2FA()">
                                <i class="bi bi-shield-plus"></i> Activar 2FA
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
                                                <i class="bi bi-clock"></i> Última actividad: Hace 5 minutos
                                            </p>
                                        </div>
                                        <span class="badge bg-success">Actual</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                    <i class="bi bi-phone"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>iPhone - Safari</h6>
                                            <p>
                                                <i class="bi bi-geo-alt"></i> San Salvador, El Salvador<br>
                                                <i class="bi bi-clock"></i> Última actividad: Hace 1 día
                                            </p>
                                        </div>
                                        <button class="btn btn-soft btn-sm" onclick="cerrarSesion(2)">
                                            <i class="bi bi-x-circle"></i> Cerrar
                                        </button>
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

                    <!-- Privacidad -->
                    <div class="col-12">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-eye-slash"></i> Privacidad
                            </h6>
                            
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="mostrarEnLinea" checked>
                                <label class="form-check-label" for="mostrarEnLinea">
                                    Mostrar mi estado en línea
                                </label>
                            </div>
                            
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="compartirEstadisticas">
                                <label class="form-check-label" for="compartirEstadisticas">
                                    Permitir que administradores vean mis estadísticas
                                </label>
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
            const datos = {
                nombre: document.getElementById('nombre').value,
                apellido: document.getElementById('apellido').value,
                email: document.getElementById('email').value,
                telefono: document.getElementById('telefono').value
            };

            console.log('Guardar perfil:', datos);
            alert('✅ Perfil actualizado exitosamente');
        }

        // ========================================
        // TAB 2: PREFERENCIAS
        // ========================================

        function cambiarTema(tema) {
            console.log('Cambiar tema a:', tema);
            document.querySelectorAll('button[onclick^="cambiarTema"]').forEach(btn => {
                btn.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
        }

        function guardarPreferencias() {
            const preferencias = {
                vistaCalendario: document.getElementById('vistaCalendario').value,
                intervaloTiempo: document.getElementById('intervaloTiempo').value,
                confirmacionCitas: document.getElementById('confirmacionCitas').value,
                mostrarFinDeSemana: document.getElementById('mostrarFinDeSemana').checked,
                mostrarHorasNoLaborables: document.getElementById('mostrarHorasNoLaborables').checked,
                resaltarHoraActual: document.getElementById('resaltarHoraActual').checked,
                notificarNuevaCita: document.getElementById('notificarNuevaCita').checked,
                sonidoNotificacion: document.getElementById('sonidoNotificacion').checked
            };

            console.log('Guardar preferencias:', preferencias);
            alert('✅ Preferencias guardadas exitosamente');
        }

        // ========================================
        // TAB 3: NOTIFICACIONES
        // ========================================

        function guardarNotificaciones() {
            console.log('Guardar notificaciones');
            alert('✅ Configuración de notificaciones guardada');
        }

        // ========================================
        // TAB 4: SEGURIDAD
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

        function activar2FA() {
            console.log('Activar 2FA');
            alert('Función: Abrir modal para configurar autenticación de dos factores');
        }

        function cerrarSesion(sessionId) {
            if (confirm('¿Cerrar esta sesión?')) {
                console.log('Cerrar sesión:', sessionId);
                alert('✓ Sesión cerrada exitosamente');
            }
        }

        function cerrarTodasSesiones() {
            if (confirm('¿Cerrar todas las sesiones excepto la actual?')) {
                console.log('Cerrar todas las sesiones');
                alert('✓ Todas las sesiones han sido cerradas');
            }
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