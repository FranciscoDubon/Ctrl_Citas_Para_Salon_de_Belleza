<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <div class="user-avatar" id="avatarInicial">A</div>
            <span class="user-name" id="nombreCliente">Administrador</span>
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
                    <h3 class="kpi-value">{{ $clientes->count() }}</h3>
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
                    <h3 class="kpi-value">{{ $clientesRecientes }}</h3>
                    <p class="kpi-label">Clientes Recientes (mes)</p>
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
                    <h3 class="kpi-value">{{ $clientesNewsletter }}</h3>
                    <p class="kpi-label">Suscritos al Newsletter</p>
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
                    <h3 class="kpi-value">{{ $clientesNoNewsletter }}</h3>
                    <p class="kpi-label">Clientes NO Suscritos</p>
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
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="list-avatar me-2" style="width: 40px; height: 40px;">
                            {{ strtoupper(substr($cliente->nombre, 0, 1)) }}
                        </div>
                        <div>
                            <strong>{{ $cliente->nombre }} {{ $cliente->apellido }}</strong><br>
                            <small style="color: var(--borgona); opacity: 0.7;">
                                <i class="bi bi-cake2"></i> {{ \Carbon\Carbon::parse($cliente->fechaNacimiento)->format('d M Y') }}
                                ({{ \Carbon\Carbon::parse($cliente->fechaNacimiento)->age }} años)
                            </small>
                        </div>
                    </div>
                </td>
                <td>
                    <div style="font-size: 0.875rem;">
                        <i class="bi bi-envelope"></i> {{ $cliente->correoElectronico }}<br>
                        <i class="bi bi-phone"></i> {{ $cliente->telefono }}
                    </div>
                </td>
                <td>
                    <span class="badge badge-luxury" style="font-size: 0.95rem;">
                        {{ $cliente->citas_count }} citas
                    </span>
                </td>
               @php
$totalGastado = $cliente->citas && $cliente->citas->isNotEmpty()
    ? $cliente->citas->flatMap->servicios->sum('precioBase')
    : 0;
@endphp
<td>
    <strong style="color: var(--borgona); font-size: 1.1rem;">
        ${{ number_format($totalGastado, 2) }}
    </strong>
</td>

                <td>
                    <button class="btn btn-sm btn-soft me-1" onclick="cargarCliente({{ $cliente->idCliente }})" title="Ver perfil">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-gold me-1" onclick="cargarEditarCliente({{ $cliente->idCliente }})" title="Editar">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-premium" onclick="nuevaCitaCliente({{ $cliente->idCliente }})" title="Nueva cita">
                        <i class="bi bi-calendar-plus"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-person-plus" style="color: var(--dorado-palido);"></i> 
                        Crear Cliente Nuevo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <p style="color: var(--borgona); margin-bottom: 1.5rem; text-align: center;">
                        Únete a nuestra familia de belleza y comienza a disfrutar de nuestros servicios
                    </p>
                    
                    <form id="formRegistro" onsubmit="handleRegistro(event)">
    <!-- Nombre Completo -->
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="registroNombre" placeholder="Nombre" required>
                <label for="registroNombre"><i class="bi bi-person"></i> Nombre</label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-floating">
                <input type="text" class="form-control" id="registroApellido" placeholder="Apellido" required>
                <label for="registroApellido"><i class="bi bi-person"></i> Apellido</label>
            </div>
        </div>
    </div>

    <!-- Email -->
    <div class="form-floating mb-3">
        <input type="email" class="form-control" id="registroEmail" placeholder="correo@ejemplo.com" required>
        <label for="registroEmail"><i class="bi bi-envelope"></i> Correo Electrónico</label>
        <small class="text-muted ms-2">Usaremos este correo para enviarte confirmaciones de citas</small>
    </div>

    <!-- Teléfono -->
    <div class="form-floating mb-3">
        <input type="tel" class="form-control" id="registroTelefono" placeholder="7777-7777" pattern="[0-9]{4}-[0-9]{4}" required>
        <label for="registroTelefono"><i class="bi bi-telephone"></i> Teléfono</label>
        <small class="text-muted ms-2">Formato: 7777-7777</small>
    </div>

    <!-- Fecha de Nacimiento -->
    <div class="form-floating mb-3">
        <input type="date" class="form-control" id="registroFechaNacimiento" placeholder="Fecha de Nacimiento" required>
        <label for="registroFechaNacimiento"><i class="bi bi-calendar-heart"></i> Fecha de Nacimiento</label>
        <small class="text-muted ms-2">Te enviaremos una sorpresa especial en tu cumpleaños 🎂</small>
    </div>

    <!-- Contraseña -->
    <div class="form-floating mb-3 position-relative">
        <input type="password" class="form-control" id="registroPassword" placeholder="Contraseña" minlength="8" required>
        <label for="registroPassword"><i class="bi bi-lock"></i> Contraseña</label>
        <span class="password-toggle" onclick="togglePasswordRegistro('registroPassword', 'toggleIconRegistro')">
            <i class="bi bi-eye" id="toggleIconRegistro"></i>
        </span>
        <small class="text-muted ms-2">Mínimo 8 caracteres</small>
    </div>

    <!-- Confirmar Contraseña -->
    <div class="form-floating mb-3 position-relative">
        <input type="password" class="form-control" id="registroPasswordConfirm" placeholder="Confirmar Contraseña" minlength="8" required>
        <label for="registroPasswordConfirm"><i class="bi bi-lock-fill"></i> Confirmar Contraseña</label>
        <span class="password-toggle" onclick="togglePasswordRegistro('registroPasswordConfirm', 'toggleIconRegistroConfirm')">
            <i class="bi bi-eye" id="toggleIconRegistroConfirm"></i>
        </span>
    </div>

    <!-- Género -->
    <div class="mb-3">
        <label class="form-label fw-semibold text-borgona"><i class="bi bi-gender-ambiguous"></i> Género (Opcional)</label>
        <div class="d-flex gap-3">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="genero" id="generoFemenino" value="femenino">
                <label class="form-check-label" for="generoFemenino">Femenino</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="genero" id="generoMasculino" value="masculino">
                <label class="form-check-label" for="generoMasculino">Masculino</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="genero" id="generoOtro" value="otro">
                <label class="form-check-label" for="generoOtro">Otro</label>
            </div>
        </div>
    </div>

    <!-- Cómo nos conociste -->
    <div class="form-floating mb-3">
        <select class="form-control" id="registroComoConocio">
            <option value="">Selecciona una opción</option>
            <option value="redes_sociales">Redes Sociales</option>
            <option value="recomendacion">Recomendación de un amigo/a</option>
            <option value="google">Búsqueda en Google</option>
            <option value="publicidad">Publicidad</option>
            <option value="paso_por_aqui">Pasé por aquí</option>
            <option value="otro">Otro</option>
        </select>
        <label for="registroComoConocio"><i class="bi bi-question-circle"></i> ¿Cómo nos conociste?</label>
    </div>

    <!-- Términos y Condiciones -->
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="registroTerminos" required>
        <label class="form-check-label text-borgona" for="registroTerminos">
            Acepto los <a href="#" class="text-dorado fw-semibold text-decoration-none">Términos y Condiciones</a> y la <a href="#" class="text-dorado fw-semibold text-decoration-none">Política de Privacidad</a>
        </label>
    </div>

    <!-- Newsletter -->
    <div class="form-check mb-4">
        <input class="form-check-input" type="checkbox" id="registroNewsletter" checked>
        <label class="form-check-label text-borgona" for="registroNewsletter">
            <i class="bi bi-envelope-heart"></i> Quiero recibir promociones y novedades por correo
        </label>
    </div>

    <!-- Alertas -->
    <div id="alertRegistro" class="alert-custom" style="display: none;">
        <i class="bi bi-info-circle"></i>
        <span id="mensajeRegistro"></span>
    </div>

    <!-- Botones -->
    <div class="d-flex gap-2">
        <button type="button" class="btn btn-soft flex-fill" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-gold flex-fill">
            <i class="bi bi-check-circle"></i> Crear Cuenta
        </button>
    </div>
</form>

            

                    <!-- Ya tengo cuenta -->
                    <div class="text-center mt-3 pt-3" style="border-top: 1px solid var(--rosa-empolvado);">
                        <small style="color: var(--borgona);">
                            ¿Ya tienes una cuenta? 
                            <a href="#" onclick="cerrarRegistroAbrirLogin()" style="color: var(--dorado-palido); text-decoration: none; font-weight: 600;">
                                Iniciar Sesión
                            </a>
                        </small>
                    </div>

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

        
document.addEventListener('DOMContentLoaded', () => {
    const nombre = localStorage.getItem('clienteNombre') || 'Cliente';
    const apellido = localStorage.getItem('clienteApellido') || '';
    const inicial = nombre.charAt(0).toUpperCase();

    // Insertar nombre completo
    const nombreSpan = document.getElementById('nombreCliente');
    if (nombreSpan) {
        nombreSpan.textContent = `${nombre} ${apellido}`;
    }

    // Insertar inicial como avatar
    const avatarDiv = document.getElementById('avatarInicial');
    if (avatarDiv) {
        avatarDiv.textContent = inicial;
    }
});



        // Manejar registro
        function handleRegistro(event) {
        event.preventDefault();
            
            const nombre = document.getElementById('registroNombre').value;
            const apellido = document.getElementById('registroApellido').value;
            const email = document.getElementById('registroEmail').value;
            const telefono = document.getElementById('registroTelefono').value;
            const fechaNacimiento = document.getElementById('registroFechaNacimiento').value;
            const password = document.getElementById('registroPassword').value;
            const passwordConfirm = document.getElementById('registroPasswordConfirm').value;
            const genero = document.querySelector('input[name="genero"]:checked')?.value || null;
            const comoConocio = document.getElementById('registroComoConocio').value;
            const aceptaTerminos = document.getElementById('registroTerminos').checked;
            const newsletter = document.getElementById('registroNewsletter').checked;

    // Validar que las contraseñas coincidan
    if (password !== passwordConfirm) {
        mostrarErrorRegistro('Las contraseñas no coinciden');
        return false;
    }

    // Validar términos
    if (!aceptaTerminos) {
        mostrarErrorRegistro('Debes aceptar los términos y condiciones');
        return false;
    }

    // Crear el JSON que Laravel espera
    const data = {
        nombre,
        apellido,
        correoElectronico: email,
        telefono,
        fechaNacimiento,
        clave: password,
        clave_confirmation: passwordConfirm,
        genero,
        comoConocio,
        suscripcionNewsletter: newsletter ? 1 : 0
    };
 const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/registro", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": token
    },
    body: JSON.stringify(data)
})
    .then(res => res.json())
    .then(data => {

        // Si hubo errores de validación en Laravel
        if (data.errors) {
            const msg = Object.values(data.errors).flat().join(', ');
            mostrarErrorRegistro(msg);
            return;
        }

        // Éxito
        if (data.success) {
    mostrarExitoRegistro();

    setTimeout(() => {
        const modalElement = document.getElementById('modalNuevoCliente');
        if (modalElement) {
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (!modalInstance) {
                modalInstance = new bootstrap.Modal(modalElement);
            }
            modalInstance.hide();
        }

        const form = document.getElementById('formRegistro');
        if (form) {
            form.reset();
        }

        document.getElementById('alertRegistro').style.display = 'none';

        // Opcional: recargar lista de clientes
        if (typeof cargarClientes === 'function') {
            cargarClientes();
        }
    }, 2000);
}

    })
    .catch(() => {
        mostrarErrorRegistro("Hubo un error en el servidor. Intenta más tarde.");
    });

    return false;
}


        // Mostrar error en registro
        function mostrarErrorRegistro(mensaje) {
            const alertRegistro = document.getElementById('alertRegistro');
            const mensajeRegistro = document.getElementById('mensajeRegistro');
            
            alertRegistro.style.background = 'rgba(220, 53, 69, 0.1)';
            alertRegistro.style.borderLeftColor = '#dc3545';
            mensajeRegistro.innerHTML = '<i class="bi bi-exclamation-triangle"></i> ' + mensaje;
            alertRegistro.style.display = 'block';
            
            // Scroll al alert
            alertRegistro.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            // Ocultar después de 5 segundos
            setTimeout(() => {
                alertRegistro.style.display = 'none';
            }, 5000);
        }

        // Mostrar éxito en registro
        function mostrarExitoRegistro() {
            const alertRegistro = document.getElementById('alertRegistro');
            const mensajeRegistro = document.getElementById('mensajeRegistro');
            
            alertRegistro.style.background = 'rgba(40, 167, 69, 0.1)';
            alertRegistro.style.borderLeftColor = '#28a745';
            mensajeRegistro.innerHTML = '<i class="bi bi-check-circle"></i> ¡Cuenta creada exitosamente! Redirigiendo...';
            alertRegistro.style.display = 'block';
            
            // Scroll al alert
            alertRegistro.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

       function togglePasswordRegistro(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}

    </script>
    
</body>
</html>