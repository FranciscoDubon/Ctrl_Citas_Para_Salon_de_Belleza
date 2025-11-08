<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Recepcionista | Salón de Belleza</title>
    
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
            <a href="{{ route('recepcionista.dashboardRecep') }}" class="menu-item active">
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
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Panel de Recepción</h1>
            <p>Bienvenida al sistema de gestión del salón.</p>
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
        
     <!-- Botones para redirigir a las siguientes pestañas por que como trabajamos por roles, esto solo se encontraran solo en los dashboards y de ahi se van a subdividir las paginas de cada rol
     todo esto por que como solo trabaje frontend y necesitaba ver como funcionaban xd-->
        <div class="d-flex gap-3">
            <a href="{{ route('logn') }}" class="text-decoration-none" style="color: #e91e63;">Login</a>
            <a href="{{ route('admin.dashboardAdm') }}" class="text-decoration-none" style="color: #e91e63;">Administrador</a>
            <a href="{{ route('recepcionista.dashboardRecep') }}" class="text-decoration-none" style="color: #e91e63;">Recepcionista</a>
            <a href="{{ route('estilista.dashboardEsti') }}" class="text-decoration-none" style="color: #e91e63;">Estilista</a>
            <a href="{{ route('cliente.dashboardCli') }}" class="text-decoration-none" style="color: #e91e63;">Cliente</a>
        </div>

        <!-- Alertas y Notificaciones -->
        <!-- 
        ================================================
        TODO BACKEND: Conectar con BD - Sistema de Alertas
        ================================================
        CONSULTA SQL:
        SELECT * FROM alertas 
        WHERE destinatario_rol = 'recepcionista' 
        AND fecha = CURDATE()
        AND leida = 0
        ORDER BY prioridad DESC, created_at DESC
        ================================================
        -->
        <div class="row mb-4">
            <!-- Alerta de Conflictos -->
            <div class="col-md-6">
                <div class="alert-custom" style="border-left: 5px solid var(--borgona);">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong style="color: var(--borgona);">¡Atención! 2 Conflictos de Horario</strong><br>
                    <small>Hay citas programadas que se superponen. <a href="#conflictos" style="color: var(--dorado-palido); font-weight: 600;">Ver detalles</a></small>
                </div>
            </div>

            <!-- Alerta de Promociones -->
            <div class="col-md-6">
                <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido);">
                    <i class="bi bi-gift-fill"></i>
                    <strong style="color: var(--dorado-palido);">4 Promociones Activas Hoy</strong><br>
                    <small>Recuerda ofrecer las promociones disponibles a los clientes. <a href="#promociones" style="color: var(--borgona); font-weight: 600;">Ver promociones</a></small>
                </div>
            </div>
        </div>

        <!-- KPI Cards - Resumen del Día -->
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
                    <h3 class="kpi-value">{{ $totalCitasHoy }}</h3>
                    <p class="kpi-label">Citas de Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> {{ $citasCompletadas }} completadas
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
                    <h3 class="kpi-value">{{ $citasPendientes }}</h3>
                    <p class="kpi-label">Citas Pendientes</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-hourglass-split"></i> Por atender
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
            AND promocion_id IS NOT NULL
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $promocionesAplicadas }}</h3>
                    <p class="kpi-label">Promociones Aplicadas</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-percent"></i> ${{ number_format($totalDescuento, 2) }} en descuentos
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
            AND fecha_hora > NOW()
            ================================================
            -->
           <div class="col-xl-3 col-md-6">
<div class="card kpi-card">
    <div class="kpi-header">
        <div class="kpi-icon warning">
            <i class="bi bi-clock-history"></i>
        </div>
    </div>
    <h3 class="kpi-value">{{ $promosDesactivadas }}</h3>
    <p class="kpi-label">Promociones desactivadas</p>

</div>

            </div>
        </div>

        <!-- Línea de Tiempo del Día -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-calendar-day"></i>
                        Agenda del Día - Viernes, 31 de Octubre 2024
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD - Citas del Día
                    ================================================
                    CONSULTA SQL:
                    SELECT c.id, c.fecha_hora, c.estado, c.precio_total,
                           u.nombre as cliente_nombre, u.apellido as cliente_apellido, u.telefono,
                           e.nombre as estilista_nombre, e.apellido as estilista_apellido,
                           s.nombre as servicio_nombre, s.duracion_minutos,
                           p.nombre as promocion_nombre
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
                                    <th>Hora</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th>Servicio</th>
                                    <th>Estilista</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Promoción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Cita Completada -->
                                <tr style="background: rgba(212, 175, 55, 0.05);">
                                    <td><strong style="color: var(--borgona);">09:00 AM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">M</div>
                                            <strong>María García</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-1234</small></td>
                                    <td>Corte de Cabello</td>
                                    <td>Ana López</td>
                                    <td>30 min</td>
                                    <td><span class="badge bg-success">Completada</span></td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-gold" data-bs-toggle="modal" data-bs-target="#modalVerCita" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita En Proceso -->
                                <tr style="background: rgba(128, 0, 32, 0.08); border-left: 4px solid var(--borgona);">
                                    <td><strong style="color: var(--borgona);">10:30 AM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">A</div>
                                            <strong>Ana Rodríguez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-5678</small></td>
                                    <td>Manicure + Pedicure</td>
                                    <td>Sofía Ramírez</td>
                                    <td>75 min</td>
                                    <td><span class="badge bg-primary">En Proceso</span></td>
                                    <td><span class="badge badge-gold" title="Promo: 20% OFF"><i class="bi bi-gift"></i> 20% OFF</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Confirmada - Próxima -->
                                <tr style="border-left: 4px solid var(--dorado-palido);">
                                    <td><strong style="color: var(--borgona);">12:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">L</div>
                                            <strong>Laura Martínez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-9012</small></td>
                                    <td>Tinte Completo</td>
                                    <td>María Torres</td>
                                    <td>90 min</td>
                                    <td><span class="badge bg-info">Confirmada</span></td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Marcar llegada">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Pendiente de Confirmación -->
                                <tr style="background: rgba(232, 180, 184, 0.1);">
                                    <td><strong style="color: var(--borgona);">02:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">C</div>
                                            <strong>Carla Hernández</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-3456</small></td>
                                    <td>Peinado Especial</td>
                                    <td>Ana López</td>
                                    <td>60 min</td>
                                    <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                                    <td><span class="badge badge-gold" title="Combo Novia"><i class="bi bi-box-seam"></i> Combo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-premium me-1" onclick="confirmarCita(4)" title="Confirmar">
                                            <i class="bi bi-telephone"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Confirmada -->
                                <tr>
                                    <td><strong style="color: var(--borgona);">03:30 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">S</div>
                                            <strong>Sofía Ramírez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-7890</small></td>
                                    <td>Limpieza Facial</td>
                                    <td>María Torres</td>
                                    <td>60 min</td>
                                    <td><span class="badge bg-info">Confirmada</span></td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Marcar llegada">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Conflicto de Horario -->
                                <tr style="background: rgba(255, 0, 0, 0.05); border-left: 4px solid #dc3545;">
                                    <td><strong style="color: #dc3545;">03:45 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem; background: linear-gradient(135deg, #dc3545, #ff6b6b);">P</div>
                                            <strong>Patricia Gómez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-1111</small></td>
                                    <td>Manicure Básico</td>
                                    <td>Sofía Ramírez</td>
                                    <td>30 min</td>
                                    <td><span class="badge bg-danger"><i class="bi bi-exclamation-triangle"></i> Conflicto</span></td>
                                    <td>-</td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" onclick="resolverConflicto(6)" title="Resolver conflicto">
                                            <i class="bi bi-tools"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Cita Confirmada -->
                                <tr>
                                    <td><strong style="color: var(--borgona);">05:00 PM</strong></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">R</div>
                                            <strong>Rosa Méndez</strong>
                                        </div>
                                    </td>
                                    <td><small>(503) 7890-2222</small></td>
                                    <td>Uñas Acrílicas</td>
                                    <td>Sofía Ramírez</td>
                                    <td>90 min</td>
                                    <td><span class="badge bg-info">Confirmada</span></td>
                                    <td><span class="badge badge-gold" title="Nuevo Cliente"><i class="bi bi-star"></i> NUEVO10</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Marcar llegada">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

<!-- Sección de Promociones Activas Hoy -->
 <div class="row g-4 mb-4" id="promociones">
<div class="col-lg-6">
    <div class="card-custom">
        <h5 class="card-title-custom">
            <i class="bi bi-gift-fill"></i>
            Promociones Activas Hoy
        </h5>

        @if ($promocionesHoy->isEmpty())
            <p class="text-muted">No hay promociones activas hoy.</p>
        @else
            <ul class="list-custom">
                @foreach ($promocionesHoy as $promo)
                    <li class="list-item-custom">
                        <div class="list-avatar" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                            <i class="bi bi-percent"></i>
                        </div>
                        <div class="list-content">
                            <h6>{{ $promo->nombre }}</h6>

                            @if ($promo->tipoDescuento === 'porcentaje')
                                <p>
                                    <code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 5px; font-weight: 600;">
                                        {{ $promo->codigoPromocional }}
                                    </code>
                                    - {{ $promo->valorDescuento }}% de descuento
                                </p>
                            @else
                                <p>
                                    <code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 5px; font-weight: 600;">
                                        {{ $promo->codigoPromocional }}
                                    </code>
                                    - ${{ number_format($promo->valorDescuento, 2) }} de descuento
                                </p>
                            @endif

                            <small style="color: var(--borgona); opacity: 0.7;">
                                Usado: {{ $promo->usosActuales }}/{{ $promo->usosMaximos }} veces
                            </small>
                        </div>
                        <div class="list-badge">
                            <button class="btn btn-sm btn-gold"
                                    onclick="copiarCodigo('{{ $promo->codigoPromocional }}')"
                                    title="Copiar código">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>


            <!-- Disponibilidad de Estilistas -->
            <div class="col-lg-6">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-people-fill"></i>
                        Disponibilidad de Estilistas
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT u.id, u.nombre, u.apellido,
                           COUNT(c.id) as citas_hoy,
                           MAX(c.fecha_hora) as ultima_cita
                    FROM usuarios u
                    LEFT JOIN citas c ON u.id = c.estilista_id 
                        AND DATE(c.fecha_hora) = CURDATE()
                    WHERE u.rol = 'estilista' AND u.activo = 1
                    GROUP BY u.id, u.nombre, u.apellido
                    ORDER BY citas_hoy ASC
                    ================================================
                    -->
                    <ul class="list-custom">
                        <li class="list-item-custom">
                            <div class="list-avatar">A</div>
                            <div class="list-content">
                                <h6>Ana López García</h6>
                                <p>5 citas hoy | Última: 2:00 PM</p>
                                <small style="color: var(--borgona); opacity: 0.7;">Próxima disponible: 3:30 PM</small>
                            </div>
                            <div class="list-badge">
                                <span class="badge bg-success">Disponible</span>
                            </div>
                        </li>

                        <li class="list-item-custom">
                            <div class="list-avatar">M</div>
                            <div class="list-content">
                                <h6>María Torres Sánchez</h6>
                                <p>4 citas hoy | Última: 3:30 PM</p>
                                <small style="color: var(--borgona); opacity: 0.7;">Próxima disponible: 5:00 PM</small>
                            </div>
                            <div class="list-badge">
                                <span class="badge bg-success">Disponible</span>
                            </div>
                        </li>

                        <li class="list-item-custom" style="background: rgba(232, 180, 184, 0.1);">
                            <div class="list-avatar">S</div>
                            <div class="list-content">
                                <h6>Sofía Ramírez Cruz</h6>
                                <p>6 citas hoy | Actual: Atendiendo cliente</p>
                                <small style="color: var(--borgona); font-weight: 600;">En servicio hasta: 11:45 AM</small>
                            </div>
                            <div class="list-badge">
                                <span class="badge bg-primary">Ocupada</span>
                            </div>
                        </li>

                        <li class="list-item-custom">
                            <div class="list-avatar">L</div>
                            <div class="list-content">
                                <h6>Laura Gómez Ortiz</h6>
                                <p>3 citas hoy | Sin asignaciones actuales</p>
                                <small style="color: var(--dorado-palido); font-weight: 600;">Disponible inmediatamente</small>
                            </div>
                            <div class="list-badge">
                                <span class="badge badge-gold"><i class="bi bi-lightning-fill"></i> Libre</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
</div>
        <!-- Recordatorios y Notas del Día -->
        <div class="row g-4 mb-4" id="conflictos">
            <div class="col-lg-6">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Conflictos de Horario - Requieren Atención
                    </h5>
                    
                    <div class="alert-custom" style="border-left: 5px solid #dc3545; margin-bottom: 1rem;">
                        <i class="bi bi-clock-history"></i>
                        <strong style="color: #dc3545;">3:45 PM - Patricia Gómez</strong><br>
                        <small>Se superpone con la cita de Sofía Ramírez (3:30 PM). Estilista: Sofía Ramírez no estará disponible.</small>
                        <br>
                        <button class="btn btn-sm btn-gold mt-2" onclick="resolverConflicto(6)">
                            <i class="bi bi-tools"></i> Resolver Ahora
                        </button>
                    </div>

                    <div class="alert-custom" style="border-left: 5px solid #dc3545;">
                        <i class="bi bi-clock-history"></i>
                        <strong style="color: #dc3545;">12:00 PM - Laura Martínez</strong><br>
                        <small>Servicio de 90 min terminaría a 1:30 PM, pero María Torres tiene cita a 1:15 PM.</small>
                        <br>
                        <button class="btn btn-sm btn-gold mt-2" onclick="resolverConflicto(3)">
                            <i class="bi bi-tools"></i> Resolver Ahora
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-bell-fill"></i>
                        Recordatorios Importantes
                    </h5>
                    
                    <ul class="list-custom">
                        <li class="list-item-custom">
                            <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="list-content">
                                <h6>Confirmar cita de Carla Hernández</h6>
                                <p>2:00 PM - Peinado Especial (Combo Novia)</p>
                                <small style="color: var(--borgona); opacity: 0.7;">Cliente VIP - No confirmó asistencia</small>
                            </div>
                        </li>

                        <li class="list-item-custom">
                            <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--dorado-hover));">
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="list-content">
                                <h6>Cliente nuevo - Rosa Méndez</h6>
                                <p>5:00 PM - Primera visita al salón</p>
                                <small style="color: var(--dorado-palido); font-weight: 600;">Ofrecer promoción NUEVO10 ($10 OFF)</small>
                            </div>
                        </li>

                        <li class="list-item-custom">
                            <div class="list-avatar" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="list-content">
                                <h6>Pendiente de pago</h6>
                                <p>María García - Cita 9:00 AM ($15.00)</p>
                                <small style="color: var(--borgona); opacity: 0.7;">Recordar cobro al finalizar servicio</small>
                            </div>
                        </li>
                    </ul>
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
         MODAL: NUEVA CITA (Placeholder)
         ============================================ -->
    <div class="modal fade" id="modalNuevaCita" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-plus-circle" style="color: var(--dorado-palido);"></i> 
                        Nueva Cita
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Formulario de nueva cita (próxima vista)</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-gold">
                        <i class="bi bi-save"></i> Guardar Cita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        function actualizarDashboard() {
            console.log('Actualizar dashboard');
            location.reload();
        }

        function confirmarCita(citaId) {
            console.log('Confirmar cita:', citaId);
            alert('Función confirmar cita - Conectar con backend\nSe enviará SMS/Email de confirmación al cliente');
        }

        function resolverConflicto(citaId) {
            console.log('Resolver conflicto:', citaId);
            alert('Función resolver conflicto - Redirigir a módulo de reprogramación');
        }

        function copiarCodigo(codigo) {
            navigator.clipboard.writeText(codigo).then(() => {
                alert('Código ' + codigo + ' copiado al portapapeles');
            });
        }

        // Actualizar hora actual cada minuto
        setInterval(function() {
            const horaActual = new Date().toLocaleTimeString('es-SV', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: true 
            });
            console.log('Hora actual:', horaActual);
        }, 60000);

        
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
    </script>
    
</body>
</html>