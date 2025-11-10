<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrador | Salón de Belleza</title>

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
            <a href="{{ route('admin.dashboardAdm') }}" class="menu-item active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.usuariosAdm') }}" class="menu-item">
                <i class="bi bi-people"></i> Empleados & Usuarios
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
                        <a href="{{ route('logn') }}" class="menu-item">
                 Cerrar Sesión
            </a>
            
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Panel de Administración</h1>
            <p>Bienvenido al sistema de gestión del salón.</p>
        </div>

        <div class="header-actions">
            <!-- Usuario -->
             <div class="user-info">
            <div class="user-avatar" id="avatarInicial">A</div>
            <span class="user-name" id="nombreCliente">Administrador</span>
    </div>
        </div>
    </header>

    <!-- ============================================
         MAIN CONTENT (CONTENIDO PRINCIPAL)
         ============================================ -->
    <main class="main-content">
        <!-- KPI Cards -->
        <div class="row g-4 mb-4">

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM citas 
            WHERE DATE(fecha_hora) = CURDATE()
            AND estado != 'cancelada'
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
@php
    $citasIcon = $porcentajeCitas >= 0 ? 'bi-arrow-up' : 'bi-arrow-down';
@endphp

<span class="kpi-badge badge-success">
    <i class="bi {{ $citasIcon }}"></i>
    {{ abs($porcentajeCitas) }}%
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
            WHERE MONTH(fecha_hora) = MONTH(CURDATE())
            AND estado = 'completada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">${{ $ingresosTotales }}</h3>
                    <p class="kpi-label">Ingresos del Mes</p>
                    @php
                          $ingresosIcon = $porcentajeIngresos >= 0 ? 'bi-arrow-up' : 'bi-arrow-down';
                    @endphp
                    <span class="kpi-badge badge-success">
                        <i class="bi {{$ingresosIcon}}"></i> {{$porcentajeIngresos}}%
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
            WHERE fecha_hora >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $totalClientes }}</h3>
                    <p class="kpi-label">Clientes Activos</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +{{$clientesNuevos}} nuevos
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total
            FROM promociones 
            WHERE activo = 1 
            AND fecha_fin >= CURDATE()
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-gift"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $promocionesActivas}}</h3>
                    <p class="kpi-label">Promociones Activas</p>
                </div>
            </div>
        </div>

        <!-- Segunda Fila: Servicios y Clientes -->
        <div class="row g-4 mb-4">

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD - Servicios Más Solicitados
            ================================================
            CONSULTA SQL:
            SELECT s.nombre, COUNT(cs.id) as cantidad
            FROM servicios s
            INNER JOIN cita_servicio cs ON s.id = cs.servicio_id
            INNER JOIN citas c ON cs.cita_id = c.id
            WHERE c.estado = 'completada'
            AND c.fecha_hora >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
            GROUP BY s.id, s.nombre
            ORDER BY cantidad DESC
            LIMIT 10
            ================================================
            -->
            <div class="col-lg-8">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-bar-chart-fill"></i>
                        Servicios Más Solicitados (Este Mes)
                    </h5>

                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Servicio</th>
                                <th>Cantidad</th>
                                <th>Ingresos</th>
                            </tr>
                        </thead>
<tbody>
    @forelse($serviciosMasSolicitados as $index => $servicio)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $servicio->nombre }}</td>
            <td>{{ $servicio->cantidad }}</td>
            <td>${{ number_format($servicio->ingresos, 2, '.', ',') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" class="text-center text-muted">
                No hay datos disponibles para este mes.
            </td>
        </tr>
    @endforelse
</tbody>

                    </table>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD - Clientes Frecuentes
            ================================================
            CONSULTA SQL:
            SELECT u.id, u.nombre, u.apellido, COUNT(c.id) as visitas
            FROM usuarios u
            INNER JOIN citas c ON u.id = c.cliente_id
            WHERE c.estado = 'completada'
            AND c.fecha_hora >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY u.id, u.nombre, u.apellido
            ORDER BY visitas DESC
            LIMIT 5
            ================================================
            -->
            <div class="col-lg-4">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-star-fill"></i>
                        Clientes Frecuentes
                    </h5>

                    <ul class="list-custom">
            @foreach ($clientesFrecuentes as $cliente)
                <li class="list-item-custom">
                    <div class="list-avatar">
                        {{ strtoupper(substr($cliente->nombre, 0, 1)) }}
                    </div>
                    <div class="list-content">
                        <h6>{{ $cliente->nombre }} {{ $cliente->apellido }}</h6>
                        <p>{{ $cliente->visitas }} visitas</p>
                    </div>
                    <div class="list-badge">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                </li>
            @endforeach
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 
        ================================================
        TODO BACKEND: Conectar con BD - Últimas Citas
        ================================================
        CONSULTA SQL:
        SELECT c.id, u.nombre, u.apellido, s.nombre as servicio, 
               c.fecha_hora, c.estado, e.nombre as estilista
        FROM citas c
        INNER JOIN usuarios u ON c.cliente_id = u.id
        INNER JOIN servicios s ON c.servicio_id = s.id
        INNER JOIN usuarios e ON c.estilista_id = e.id
        ORDER BY c.fecha_hora DESC
        LIMIT 10
        ================================================
        -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-clock-history"></i>
                        Últimas Citas Registradas
                    </h5>

                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Servicio</th>
                                <th>Estilista</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
<tbody>
    @foreach ($ultimasCitas as $cita)
        <tr>
            <td>#{{ $cita->idCita }}</td>
            <td>{{ $cita->cliente_nombre }} {{ $cita->cliente_apellido }}</td>
            <td>{{ $cita->servicio }}</td>
            <td>{{ $cita->estilista_nombre }} {{ $cita->estilista_apellido }}</td>
            <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d M Y') }}</td>
            <td>
                @php
                    $estado = strtolower($cita->estado);
                    $color = match($estado) {
                        'completada' => 'success',
                        'pendiente' => 'warning',
                        'confirmada' => 'primary',
                        'cancelada' => 'danger',
                        default => 'secondary',
                    };
                @endphp
                <span class="badge bg-{{ $color }}">{{ ucfirst($cita->estado) }}</span>
            </td>
        </tr>
    @endforeach
</tbody>

                    </table>
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
<script>



        // ========================================
        // FUNCIONES PARA CARGAR NOMBRE DE USAURIO 
        // ========================================

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