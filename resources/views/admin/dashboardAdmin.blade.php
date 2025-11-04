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
            <a href="{{ route('dashboardAdm') }}" class="menu-item active">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.citasAdm') }}" class="menu-item">
                <i class="bi bi-calendar-check"></i> Citas
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
            <a href="{{ route('admin.configAdm') }}" class="menu-item">
                <i class="bi bi-gear"></i> Configuración
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

    <!-- Botones para redirigir a las siguientes pestañas por que como trabajamos por roles, esto solo se encontraran solo en los dashboards y de ahi se van a subdividir las paginas de cada rol
     todo esto por que como solo trabaje frontend y necesitaba ver como funcionaban xd-->
        <div class="d-flex gap-3">
            <a href="{{ route('logn') }}" class="text-decoration-none" style="color: #e91e63;">Login</a>
            <a href="{{ route('dashboardAdm') }}" class="text-decoration-none" style="color: #e91e63;">Administrador</a>
            <a href="{{ route('recepcionista.dashboardRecep') }}" class="text-decoration-none" style="color: #e91e63;">Recepcionista</a>
            <a href="{{ route('estilista.dashboardEsti') }}" class="text-decoration-none" style="color: #e91e63;">Estilista</a>
            <a href="{{ route('cliente.dashboardCli') }}" class="text-decoration-none" style="color: #e91e63;">Cliente</a>
        </div>

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
                    <h3 class="kpi-value">12</h3>
                    <p class="kpi-label">Citas de Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +15%
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
                    <h3 class="kpi-value">$5,420.50</h3>
                    <p class="kpi-label">Ingresos del Mes</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +8.2%
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
                    <h3 class="kpi-value">87</h3>
                    <p class="kpi-label">Clientes Activos</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> +12 nuevos
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
                    <h3 class="kpi-value">4</h3>
                    <p class="kpi-label">Promociones Activas</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-dash"></i> Sin cambios
                    </span>
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
                            <tr>
                                <td>1</td>
                                <td>Corte de Cabello</td>
                                <td>45</td>
                                <td>$675.00</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Manicure</td>
                                <td>38</td>
                                <td>$380.00</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Pedicure</td>
                                <td>32</td>
                                <td>$480.00</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Tinte Completo</td>
                                <td>28</td>
                                <td>$1,120.00</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Peinado Especial</td>
                                <td>25</td>
                                <td>$750.00</td>
                            </tr>
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
                        <li class="list-item-custom">
                            <div class="list-avatar">M</div>
                            <div class="list-content">
                                <h6>María García</h6>
                                <p>15 visitas</p>
                            </div>
                            <div class="list-badge">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                        </li>
                        <li class="list-item-custom">
                            <div class="list-avatar">A</div>
                            <div class="list-content">
                                <h6>Ana Rodríguez</h6>
                                <p>12 visitas</p>
                            </div>
                            <div class="list-badge">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                        </li>
                        <li class="list-item-custom">
                            <div class="list-avatar">L</div>
                            <div class="list-content">
                                <h6>Laura Martínez</h6>
                                <p>10 visitas</p>
                            </div>
                            <div class="list-badge">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                        </li>
                        <li class="list-item-custom">
                            <div class="list-avatar">C</div>
                            <div class="list-content">
                                <h6>Carla Hernández</h6>
                                <p>9 visitas</p>
                            </div>
                            <div class="list-badge">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                        </li>
                        <li class="list-item-custom">
                            <div class="list-avatar">S</div>
                            <div class="list-content">
                                <h6>Sofía Ramírez</h6>
                                <p>8 visitas</p>
                            </div>
                            <div class="list-badge">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
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
                            <tr>
                                <td>#001</td>
                                <td>María García</td>
                                <td>Corte de Cabello</td>
                                <td>Ana López</td>
                                <td>30 Oct 2024, 10:00 AM</td>
                                <td><span class="badge bg-success">Completada</span></td>
                            </tr>
                            <tr>
                                <td>#002</td>
                                <td>Laura Martínez</td>
                                <td>Manicure</td>
                                <td>Sofía Ramírez</td>
                                <td>30 Oct 2024, 11:30 AM</td>
                                <td><span class="badge bg-warning">Pendiente</span></td>
                            </tr>
                            <tr>
                                <td>#003</td>
                                <td>Carla Hernández</td>
                                <td>Tinte Completo</td>
                                <td>María Torres</td>
                                <td>30 Oct 2024, 2:00 PM</td>
                                <td><span class="badge bg-primary">Confirmada</span></td>
                            </tr>
                            <tr>
                                <td>#004</td>
                                <td>Ana Rodríguez</td>
                                <td>Peinado Especial</td>
                                <td>Ana López</td>
                                <td>30 Oct 2024, 3:30 PM</td>
                                <td><span class="badge bg-primary">Confirmada</span></td>
                            </tr>
                            <tr>
                                <td>#005</td>
                                <td>Sofía Ramírez</td>
                                <td>Pedicure</td>
                                <td>Sofía Ramírez</td>
                                <td>30 Oct 2024, 4:00 PM</td>
                                <td><span class="badge bg-warning">Pendiente</span></td>
                            </tr>
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