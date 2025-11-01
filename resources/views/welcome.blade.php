<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador | Salón de Belleza</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- CSS Global -->
    <link rel="stylesheet" href="css/global-styles.css">
</head>
<body class="dashboard-body">
    
    <!-- Header del Dashboard -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="dashboard-title">Panel de Administración</h1>
                    <p class="dashboard-subtitle">Bienvenido, Administrador</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="date-display">
                        <i class="bi bi-calendar3"></i>
                        <span id="currentDate"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="container-fluid mt-4 pb-5">
        
        <!-- KPI Cards -->
        <div class="row g-4">
            <!-- Citas de Hoy -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-primary">
                    <div class="kpi-icon">
                        <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="kpi-content">
                        <h3 class="kpi-value">12</h3>
                        <p class="kpi-label">Citas de Hoy</p>
                        <span class="kpi-badge badge-success">
                            <i class="bi bi-arrow-up"></i> +15%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ingresos del Mes -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-success">
                    <div class="kpi-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="kpi-content">
                        <h3 class="kpi-value">$5,420.50</h3>
                        <p class="kpi-label">Ingresos del Mes</p>
                        <span class="kpi-badge badge-success">
                            <i class="bi bi-arrow-up"></i> +8.2%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Clientes Activos -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-info">
                    <div class="kpi-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="kpi-content">
                        <h3 class="kpi-value">87</h3>
                        <p class="kpi-label">Clientes Activos</p>
                        <span class="kpi-badge badge-success">
                            <i class="bi bi-arrow-up"></i> +12 nuevos
                        </span>
                    </div>
                </div>
            </div>

            <!-- Promociones Activas -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card kpi-warning">
                    <div class="kpi-icon">
                        <i class="bi bi-gift"></i>
                    </div>
                    <div class="kpi-content">
                        <h3 class="kpi-value">4</h3>
                        <p class="kpi-label">Promociones Activas</p>
                        <span class="kpi-badge badge-neutral">
                            <i class="bi bi-dash"></i> Sin cambios
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos Principales -->
        <div class="row g-4 mt-3">
            <!-- Servicios Más Solicitados -->
            <div class="col-xl-8 col-lg-7">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">
                            <i class="bi bi-bar-chart-fill"></i>
                            Servicios Más Solicitados
                        </h5>
                        <select class="form-select form-select-sm" style="width: auto;">
                            <option>Última Semana</option>
                            <option selected>Último Mes</option>
                            <option>Último Año</option>
                        </select>
                    </div>
                    <div class="card-body-custom">
                        <canvas id="servicesChart" height="280"></canvas>
                    </div>
                </div>
            </div>

            <!-- Clientes Frecuentes -->
            <div class="col-xl-4 col-lg-5">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">
                            <i class="bi bi-star-fill"></i>
                            Clientes Frecuentes
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="clients-list">
                            <div class="client-item">
                                <div class="client-avatar">M</div>
                                <div class="client-info">
                                    <h6>María García</h6>
                                    <p>15 visitas</p>
                                </div>
                                <div class="client-badge">
                                    <i class="bi bi-trophy-fill"></i>
                                </div>
                            </div>
                            <div class="client-item">
                                <div class="client-avatar">A</div>
                                <div class="client-info">
                                    <h6>Ana Rodríguez</h6>
                                    <p>12 visitas</p>
                                </div>
                                <div class="client-badge">
                                    <i class="bi bi-trophy-fill"></i>
                                </div>
                            </div>
                            <div class="client-item">
                                <div class="client-avatar">L</div>
                                <div class="client-info">
                                    <h6>Laura Martínez</h6>
                                    <p>10 visitas</p>
                                </div>
                                <div class="client-badge">
                                    <i class="bi bi-trophy-fill"></i>
                                </div>
                            </div>
                            <div class="client-item">
                                <div class="client-avatar">C</div>
                                <div class="client-info">
                                    <h6>Carla Hernández</h6>
                                    <p>9 visitas</p>
                                </div>
                                <div class="client-badge">
                                    <i class="bi bi-trophy-fill"></i>
                                </div>
                            </div>
                            <div class="client-item">
                                <div class="client-avatar">S</div>
                                <div class="client-info">
                                    <h6>Sofía Ramírez</h6>
                                    <p>8 visitas</p>
                                </div>
                                <div class="client-badge">
                                    <i class="bi bi-trophy-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ingresos y Rendimiento -->
        <div class="row g-4 mt-3">
            <!-- Tendencia de Ingresos -->
            <div class="col-xl-8 col-lg-7">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">
                            <i class="bi bi-graph-up"></i>
                            Tendencia de Ingresos
                        </h5>
                        <button class="btn btn-sm btn-outline-gold">
                            <i class="bi bi-download"></i> Exportar
                        </button>
                    </div>
                    <div class="card-body-custom">
                        <canvas id="revenueChart" height="280"></canvas>
                    </div>
                </div>
            </div>

            <!-- Rendimiento de Estilistas -->
            <div class="col-xl-4 col-lg-5">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">
                            <i class="bi bi-person-badge"></i>
                            Rendimiento Estilistas
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <canvas id="stylistsChart" height="280"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h5 class="card-title-custom">
                            <i class="bi bi-lightning-fill"></i>
                            Acciones Rápidas
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-6">
                                <a href="#" class="action-btn">
                                    <i class="bi bi-people-fill"></i>
                                    <span>Gestionar Usuarios</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="#" class="action-btn">
                                    <i class="bi bi-scissors"></i>
                                    <span>Gestionar Servicios</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="#" class="action-btn">
                                    <i class="bi bi-gift-fill"></i>
                                    <span>Crear Promoción</span>
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <a href="#" class="action-btn">
                                    <i class="bi bi-file-earmark-bar-graph"></i>
                                    <span>Ver Reportes</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- JavaScript Global -->
    <script src="js/global-scripts.js"></script>
    
</body>
</html>