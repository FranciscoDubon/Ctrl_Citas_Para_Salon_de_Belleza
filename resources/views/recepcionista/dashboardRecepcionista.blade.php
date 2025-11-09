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
            <!--<div class="col-md-6">
                <div class="alert-custom" style="border-left: 5px solid var(--borgona);">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong style="color: var(--borgona);">¡Atención! 2 Conflictos de Horario</strong><br>
                    <small>Hay citas programadas que se superponen. <a href="#conflictos" style="color: var(--dorado-palido); font-weight: 600;">Ver detalles</a></small>
                </div>
            </div>-->

            <!-- Alerta de Promociones -->
            <div class="col-md-6">
                <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido);">
                    <i class="bi bi-gift-fill"></i>
                    <strong style="color: var(--dorado-palido);">{{$promocionesActivas}}Promociones Activas Hoy</strong><br>
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
                    <h3 class="kpi-value">{{ $promocionesActivas }}</h3>
                    <p class="kpi-label">Promociones Activas</p>
                   <!-- <span class="kpi-badge badge-success">
                        <i class="bi bi-percent"></i> ${{ number_format($totalDescuento, 2) }} en descuentos
                    </span>-->
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
                                </tr>
                            </thead>
<tbody>
@foreach($citasDelDia as $cita)
    @php
        $servicio = $cita->servicios->first();
        $estadoColor = match($cita->estado) {
            'COMPLETADA' => 'success',
            'EN_PROCESO' => 'primary',
            'CONFIRMADA' => 'info',
            'PENDIENTE' => 'warning',
            'CANCELADA' => 'secondary',
            default => 'light',
        };
    @endphp
    <tr @if($cita->estado == 'COMPLETADA') style="background: rgba(212, 175, 55, 0.05);" @endif>
        <td><strong style="color: var(--borgona);">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</strong></td>
        <td>
            <div class="d-flex align-items-center">
                <div class="list-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                    {{ substr($cita->cliente->nombre,0,1) }}
                </div>
                <strong>{{ $cita->cliente->nombre }} {{ $cita->cliente->apellido }}</strong>
            </div>
        </td>
        <td><small>{{ $cita->cliente->telefono }}</small></td>
        <td>{{ $servicio ? $servicio->nombre : '-' }}</td>
        <td>{{ $cita->estilista->nombre }} {{ $cita->estilista->apellido }}</td>
        <td>{{ $servicio ? $servicio->duracionBase . ' min' : '-' }}</td>
        <td><span class="badge bg-{{ $estadoColor }}">{{ ucfirst(strtolower($cita->estado)) }}</span></td>
        <td>
            @if($cita->promocion)
                <span class="badge badge-gold" title="Promo: {{ $cita->promocion->nombre }}">
                    <i class="bi bi-gift"></i> {{ $cita->promocion->codigoPromocional }}
                </span>
            @else
                -
            @endif
        </td>
    </tr>
@endforeach
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
@foreach ($estilistas as $estilista)
    <li class="list-item-custom {{ $estilista['estado'] === 'Ocupada' ? 'bg-primary text-white' : '' }}">
        <div class="list-avatar"> {{ strtoupper(substr($estilista['nombre'], 0, 1))  }}</div>
        <div class="list-content">
            <h6>{{ $estilista['nombre'] }}</h6>
            <p>{{ $estilista['citas_hoy'] }} citas hoy 
               @if ($estilista['ultima_cita'])
                   | Última: {{ \Carbon\Carbon::parse($estilista['ultima_cita'])->format('h:i A') }}
               @else
                   | Sin asignaciones actuales
               @endif
            </p>
            <small style="color: var(--borgona); font-weight: 600;">
                @if ($estilista['estado'] === 'Ocupada')
                    En servicio hasta: {{ \Carbon\Carbon::parse($estilista['ultima_cita'])->addMinutes(60)->format('h:i A') }}
                @else
                    Disponible inmediatamente
                @endif
            </small>
        </div>
        <div class="list-badge">
            @if ($estilista['estado'] === 'Ocupada')
                <span class="badge bg-primary">Ocupada</span>
            @else
                <span class="badge bg-success">Disponible</span>
            @endif
        </div>
    </li>
@endforeach
</ul>

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