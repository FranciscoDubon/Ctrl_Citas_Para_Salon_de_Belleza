<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Cliente | Salón de Belleza</title>

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
            <a href="{{ route('cliente.promocionesCli') }}" class="menu-item">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('cliente.configCli') }}" class="menu-item active">
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
                <div class="user-avatar">M</div>
                <span class="user-name">María García - Cliente</span>
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
                                Administra tu perfil, preferencias y seguridad
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
                                <i class="bi bi-palette"></i> Preferencias
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
                            <button class="nav-link" id="historial-tab" data-bs-toggle="pill" data-bs-target="#historial" type="button" role="tab">
                                <i class="bi bi-clock-history"></i> Historial
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
                                M
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
                                        <input type="text" class="form-control" id="nombre" value="María" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" value="García" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" value="maria.garcia@email.com" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="telefono" value="7777-8888" pattern="[0-9]{4}-[0-9]{4}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control" id="fechaNacimiento" value="1995-05-15">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Género</label>
                                        <select class="form-control" id="genero">
                                            <option value="femenino" selected>Femenino</option>
                                            <option value="masculino">Masculino</option>
                                            <option value="otro">Otro</option>
                                            <option value="prefiero_no_decir">Prefiero no decir</option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Dirección (Opcional)</label>
                                        <input type="text" class="form-control" id="direccion" placeholder="Calle, colonia, ciudad">
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
                 TAB 2: PREFERENCIAS
                 ============================================ -->
            <div class="tab-pane fade" id="preferencias" role="tabpanel">
                <div class="row g-4">

                    <!-- Estilista Preferida -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-star-fill" style="color: var(--dorado-palido);"></i> Estilista Preferida
                            </h6>

                            <div class="list-item-custom mb-3">
                                <div class="list-avatar">A</div>
                                <div class="list-content">
                                    <h6>Ana López García</h6>
                                    <p>Estilista Senior - 8 años de experiencia</p>
                                </div>
                            </div>

                            <button class="btn btn-outline-gold btn-sm w-100" onclick="cambiarEstilistaPreferida()">
                                <i class="bi bi-arrow-repeat"></i> Cambiar Estilista Preferida
                            </button>

                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="siempreEstilistaPreferida" checked>
                                <label class="form-check-label" for="siempreEstilistaPreferida">
                                    Asignar automáticamente en nuevas reservas
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios Favoritos -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-heart-fill" style="color: var(--dorado-palido);"></i> Servicios Favoritos
                            </h6>

                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="favCorte" checked>
                                    <label class="form-check-label" for="favCorte">
                                        <i class="bi bi-scissors"></i> Corte de Cabello
                                    </label>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="favManicure" checked>
                                    <label class="form-check-label" for="favManicure">
                                        <i class="bi bi-hand-index-thumb"></i> Manicure + Pedicure
                                    </label>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="favFacial">
                                    <label class="form-check-label" for="favFacial">
                                        <i class="bi bi-stars"></i> Limpieza Facial
                                    </label>
                                </div>
                            </div>

                            <div class="alert-custom mt-3">
                                <i class="bi bi-info-circle"></i>
                                <small>Estos servicios aparecerán primero al agendar citas</small>
                            </div>
                        </div>
                    </div>

                    <!-- Recordatorios -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-alarm"></i> Recordatorios de Citas
                            </h6>

                            <div class="mb-3">
                                <label class="form-label">¿Con cuánta anticipación?</label>
                                <select class="form-control" id="recordatorioTiempo">
                                    <option value="30">30 minutos antes</option>
                                    <option value="60">1 hora antes</option>
                                    <option value="120">2 horas antes</option>
                                    <option value="1440" selected>1 día antes</option>
                                    <option value="2880">2 días antes</option>
                                </select>
                            </div>

                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="recordatorioEmail" checked>
                                    <label class="form-check-label" for="recordatorioEmail">
                                        <i class="bi bi-envelope"></i> Por Email
                                    </label>
                                </div>
                            </div>

                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="recordatorioSMS">
                                    <label class="form-check-label" for="recordatorioSMS">
                                        <i class="bi bi-phone"></i> Por SMS
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tema y Apariencia -->
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
                                            <input class="form-check-input" type="checkbox" id="notifCitaConfirmada" checked>
                                            <label class="form-check-label" for="notifCitaConfirmada">
                                                Cita confirmada
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
                                            <input class="form-check-input" type="checkbox" id="notifCitaRecordatorio" checked>
                                            <label class="form-check-label" for="notifCitaRecordatorio">
                                                Recordatorios de citas
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifCitaModificada" checked>
                                            <label class="form-check-label" for="notifCitaModificada">
                                                Cambios en mi cita
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: var(--rosa-empolvado); margin: 2rem 0;">

                            <!-- Notificaciones de Promociones -->
                            <div class="mb-4">
                                <h6 style="color: var(--borgona); font-size: 0.95rem; margin-bottom: 1rem;">
                                    🎁 Promociones y Ofertas
                                </h6>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifPromociones" checked>
                                            <label class="form-check-label" for="notifPromociones">
                                                Nuevas promociones
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifDescuentos" checked>
                                            <label class="form-check-label" for="notifDescuentos">
                                                Descuentos exclusivos
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifCumpleanos" checked>
                                            <label class="form-check-label" for="notifCumpleanos">
                                                Regalo de cumpleaños 🎂
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="notifNewsletter" checked>
                                            <label class="form-check-label" for="notifNewsletter">
                                                Newsletter mensual
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
                                            <input class="form-check-input" type="checkbox" id="canalSMS">
                                            <label class="form-check-label" for="canalSMS">
                                                <i class="bi bi-phone"></i> SMS
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="canalPush" checked>
                                            <label class="form-check-label" for="canalPush">
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
                                                <i class="bi bi-clock"></i> Última actividad: Hace 2 días
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

                    <!-- Eliminar Cuenta -->
                    <div class="col-12">
                        <div class="card-custom" style="border-left: 4px solid #dc3545;">
                            <h6 style="color: #dc3545; font-weight: 600; margin-bottom: 1rem;">
                                <i class="bi bi-exclamation-triangle"></i> Zona Peligrosa
                            </h6>

                            <p style="color: var(--borgona); opacity: 0.8; margin-bottom: 1rem;">
                                Una vez que elimines tu cuenta, no hay vuelta atrás. Por favor, esté seguro.
                            </p>

                            <button class="btn btn-outline-danger" onclick="confirmarEliminarCuenta()">
                                <i class="bi bi-trash"></i> Eliminar mi Cuenta
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 5: HISTORIAL
                 ============================================ -->
            <div class="tab-pane fade" id="historial" role="tabpanel">
                <div class="row g-4">

                    <!-- Resumen Estadístico -->
                    <div class="col-12">
                        <div class="row g-3">

                            <div class="col-lg-3 col-md-6">
                                <div class="kpi-card">
                                    <div class="kpi-header">
                                        <div class="kpi-icon success">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                    </div>
                                    <h3 class="kpi-value">18</h3>
                                    <p class="kpi-label">Citas Completadas</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="kpi-card">
                                    <div class="kpi-header">
                                        <div class="kpi-icon warning">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                    </div>
                                    <h3 class="kpi-value">$642</h3>
                                    <p class="kpi-label">Total Invertido</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="kpi-card">
                                    <div class="kpi-header">
                                        <div class="kpi-icon info">
                                            <i class="bi bi-gift"></i>
                                        </div>
                                    </div>
                                    <h3 class="kpi-value">7</h3>
                                    <p class="kpi-label">Promos Usadas</p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="kpi-card">
                                    <div class="kpi-header">
                                        <div class="kpi-icon primary">
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                    <h3 class="kpi-value">VIP</h3>
                                    <p class="kpi-label">Nivel Actual</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Filtros de Historial -->
                    <div class="col-12">
                        <div class="card-custom" style="padding: 1rem;">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label" style="margin-bottom: 0.5rem;">Desde</label>
                                    <input type="date" class="form-control" id="fechaDesde">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" style="margin-bottom: 0.5rem;">Hasta</label>
                                    <input type="date" class="form-control" id="fechaHasta">
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-gold w-100" onclick="filtrarHistorial()">
                                        <i class="bi bi-funnel"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Historial -->
                    <div class="col-12">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-clock-history"></i> Historial de Citas
                            </h6>

                            <!-- Cita 1 -->
                            <div class="list-item-custom mb-3">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--champagne));">
                                    <i class="bi bi-scissors"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>Corte de Cabello</h6>
                                            <p>
                                                <i class="bi bi-person-circle"></i> Ana López García<br>
                                                <i class="bi bi-calendar3"></i> 28 Oct 2024 - 10:00 AM<br>
                                                <i class="bi bi-currency-dollar"></i> $13.50
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-success mb-2">Completada</span>
                                            <br>
                                            <span style="color: var(--dorado-palido);">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cita 2 -->
                            <div class="list-item-custom mb-3">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                    <i class="bi bi-hand-index-thumb"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>Manicure + Pedicure</h6>
                                            <p>
                                                <i class="bi bi-person-circle"></i> Sofía Ramírez Cruz<br>
                                                <i class="bi bi-calendar3"></i> 15 Oct 2024 - 02:00 PM<br>
                                                <i class="bi bi-currency-dollar"></i> $22.50
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-success mb-2">Completada</span>
                                            <br>
                                            <span style="color: var(--dorado-palido);">
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cita 3 -->
                            <div class="list-item-custom" style="opacity: 0.7;">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                    <i class="bi bi-stars"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6>Limpieza Facial</h6>
                                            <p>
                                                <i class="bi bi-person-circle"></i> Laura Gómez Ortiz<br>
                                                <i class="bi bi-calendar3"></i> 01 Oct 2024 - 11:30 AM<br>
                                                <i class="bi bi-currency-dollar"></i> $31.50
                                            </p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-danger mb-2">Cancelada</span>
                                            <br>
                                            <small style="color: var(--borgona); opacity: 0.6;">Sin calificación</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button class="btn btn-outline-gold" onclick="cargarMasHistorial()">
                                    <i class="bi bi-arrow-down-circle"></i> Cargar Más
                                </button>
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

        // Previsualizar foto
        function previsualizarFoto(event) {
            const file = event.target.files[0];
            if (file) {
                // Validar tamaño (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('⚠️ El archivo es muy grande. Máximo 2MB.');
                    return;
                }

                // Validar tipo
                if (!file.type.match('image.*')) {
                    alert('⚠️ Solo se permiten imágenes.');
                    return;
                }

                console.log('Foto seleccionada:', file.name);
                alert('✓ Foto seleccionada: ' + file.name + '\n\nEn producción, se subiría al servidor.');
                // TODO: Subir al servidor
            }
        }

        // Eliminar foto
        function eliminarFoto() {
            if (confirm('¿Estás segura de que quieres eliminar tu foto de perfil?')) {
                console.log('Eliminar foto de perfil');
                alert('✓ Foto eliminada. Se mostrará la inicial de tu nombre.');
                // TODO: Eliminar del servidor
            }
        }

        // Guardar perfil
        function guardarPerfil() {
            const datos = {
                nombre: document.getElementById('nombre').value,
                apellido: document.getElementById('apellido').value,
                email: document.getElementById('email').value,
                telefono: document.getElementById('telefono').value,
                fechaNacimiento: document.getElementById('fechaNacimiento').value,
                genero: document.getElementById('genero').value,
                direccion: document.getElementById('direccion').value
            };

            console.log('Guardar perfil:', datos);
            alert('✅ Perfil actualizado exitosamente');
            // TODO: Enviar al backend
        }

        // ========================================
        // TAB 2: PREFERENCIAS
        // ========================================

        // Cambiar estilista preferida
        function cambiarEstilistaPreferida() {
            console.log('Cambiar estilista preferida');
            alert('Función: Abrir modal con lista de estilistas disponibles');
            // TODO: Abrir modal de selección
        }

        // Cambiar tema
        function cambiarTema(tema) {
            console.log('Cambiar tema a:', tema);
            document.querySelectorAll('button[onclick^="cambiarTema"]').forEach(btn => {
                btn.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            // TODO: Aplicar tema
        }

        // Guardar preferencias
        function guardarPreferencias() {
            console.log('Guardar preferencias');
            alert('✅ Preferencias guardadas exitosamente');
            // TODO: Enviar al backend
        }

        // ========================================
        // TAB 3: NOTIFICACIONES
        // ========================================

        // Guardar notificaciones
        function guardarNotificaciones() {
            const notificaciones = {
                citaConfirmada: document.getElementById('notifCitaConfirmada').checked,
                citaCancelada: document.getElementById('notifCitaCancelada').checked,
                citaRecordatorio: document.getElementById('notifCitaRecordatorio').checked,
                citaModificada: document.getElementById('notifCitaModificada').checked,
                promociones: document.getElementById('notifPromociones').checked,
                descuentos: document.getElementById('notifDescuentos').checked,
                cumpleanos: document.getElementById('notifCumpleanos').checked,
                newsletter: document.getElementById('notifNewsletterr').checked,
                email: document.getElementById('canalEmail').checked,
                sms: document.getElementById('canalSMS').checked,
                push: document.getElementById('canalPush').checked
            };

            console.log('Guardar notificaciones:', notificaciones);
            alert('✅ Configuración de notificaciones guardada');
            // TODO: Enviar al backend
        }

        // ========================================
        // TAB 4: SEGURIDAD
        // ========================================

        // Cambiar contraseña
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
            // TODO: Enviar al backend
        }

        // Activar 2FA
        function activar2FA() {
            console.log('Activar 2FA');
            alert('Función: Abrir modal para configurar autenticación de dos factores\n\nOpciones:\n- Aplicación autenticadora\n- SMS');
            // TODO: Abrir modal de configuración 2FA
        }

        // Cerrar sesión específica
        function cerrarSesion(sessionId) {
            if (confirm('¿Cerrar esta sesión?')) {
                console.log('Cerrar sesión:', sessionId);
                alert('✓ Sesión cerrada exitosamente');
                // TODO: Enviar al backend
            }
        }

        // Cerrar todas las sesiones
        function cerrarTodasSesiones() {
            if (confirm('¿Cerrar todas las sesiones excepto la actual?\n\nSerás el único con acceso a tu cuenta.')) {
                console.log('Cerrar todas las sesiones');
                alert('✓ Todas las sesiones han sido cerradas');
                // TODO: Enviar al backend
            }
        }

        // Confirmar eliminar cuenta
        function confirmarEliminarCuenta() {
            if (confirm('⚠️ ¿Estás segura de que quieres eliminar tu cuenta?\n\nEsta acción es PERMANENTE y no se puede deshacer.\n\n' +
                    'Perderás:\n- Todas tus citas\n- Tu historial\n- Tus datos personales\n\n¿Continuar?')) {

                const confirmacion = prompt('Escribe "ELIMINAR" para confirmar:');

                if (confirmacion === 'ELIMINAR') {
                    console.log('Eliminar cuenta confirmado');
                    alert('✓ Tu cuenta ha sido marcada para eliminación.\n\nRecibirás un email de confirmación final.');
                    // TODO: Enviar al backend
                } else {
                    alert('❌ Eliminación cancelada');
                }
            }
        }

        // ========================================
        // TAB 5: HISTORIAL
        // ========================================

        // Filtrar historial
        function filtrarHistorial() {
            const desde = document.getElementById('fechaDesde').value;
            const hasta = document.getElementById('fechaHasta').value;

            console.log('Filtrar historial:', {
                desde,
                hasta
            });
            alert('Filtrando historial...');
            // TODO: Filtrar con backend
        }

        // Cargar más historial
        function cargarMasHistorial() {
            console.log('Cargar más historial');
            alert('Cargando más registros...');
            // TODO: Paginación con backend
        }

        // ========================================
        // FUNCIONES GENERALES
        // ========================================

        // Guardar todos los cambios
        function guardarTodosCambios() {
            if (confirm('¿Guardar todos los cambios realizados en todas las pestañas?')) {
                console.log('Guardar todos los cambios');
                alert('✅ Todos los cambios han sido guardados exitosamente');
                // TODO: Guardar todo
            }
        }
    </script>

</body>

</html>