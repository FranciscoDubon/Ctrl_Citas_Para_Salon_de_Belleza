<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas Administrador | Salón de Belleza</title>

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
            <a href="{{ route('admin.citasAdm') }}" class="menu-item active">
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
            <h1>Gestión de Citas</h1>
            <p>Administra y supervisa las citas registradas en el sistema.</p>
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
        
        <!-- Header de Gestión de Citas -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 style="color: var(--borgona); margin: 0 0 0.5rem 0;">
                                <i class="bi bi-calendar-check" style="color: var(--dorado-palido);"></i>
                                Gestión de Citas
                            </h2>
                            <p style="color: var(--borgona); opacity: 0.7; margin: 0;">
                                Administra y supervisa todas las citas del salón
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button class="btn btn-gold" onclick="abrirModalNuevaCita()">
                                <i class="bi bi-plus-circle"></i> Nueva Cita
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards - Resumen del Día -->
        <div class="row g-4 mb-4">
            
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">12</h3>
                    <p class="kpi-label">Citas de Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> 8 Completadas
                    </span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">3</h3>
                    <p class="kpi-label">Pendientes</p>
                    <span class="kpi-badge badge-warning">
                        <i class="bi bi-hourglass"></i> En espera
                    </span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">45</h3>
                    <p class="kpi-label">Esta Semana</p>
                    <span class="kpi-badge badge-info">
                        <i class="bi bi-calendar-week"></i> +12 vs anterior
                    </span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">$1,240</h3>
                    <p class="kpi-label">Ingresos de Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-graph-up"></i> +8%
                    </span>
                </div>
            </div>

        </div>

        <!-- Filtros y Búsqueda -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom" style="padding: 1rem;">
                    <div class="row g-3 align-items-end">
                        
                        <div class="col-md-3">
                            <label class="form-label">Buscar</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="buscarCita" 
                                placeholder="Cliente, servicio, código..."
                                onkeyup="buscarCita()"
                            >
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="filtroFecha" onchange="filtrarCitas()">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Estado</label>
                            <select class="form-control" id="filtroEstado" onchange="filtrarCitas()">
                                <option value="">Todos</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="en_proceso">En Proceso</option>
                                <option value="completada">Completada</option>
                                <option value="cancelada">Cancelada</option>
                                <option value="no_asistio">No Asistió</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">Estilista</label>
                            <select class="form-control" id="filtroEstilista" onchange="filtrarCitas()">
                                <option value="">Todas</option>
                                <option value="1">Ana López</option>
                                <option value="2">María Torres</option>
                                <option value="3">Sofía Ramírez</option>
                                <option value="4">Laura Gómez</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button class="btn btn-gold flex-fill" onclick="filtrarCitas()">
                                    <i class="bi bi-funnel"></i> Filtrar
                                </button>
                                <button class="btn btn-soft" onclick="limpiarFiltros()">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs: Vista de Calendario vs Lista -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card-custom" style="padding: 1rem;">
                    <ul class="nav nav-pills" id="vistaTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="calendario-tab" data-bs-toggle="pill" data-bs-target="#calendario" type="button" role="tab">
                                <i class="bi bi-calendar3"></i> Vista de Calendario
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="lista-tab" data-bs-toggle="pill" data-bs-target="#lista" type="button" role="tab">
                                <i class="bi bi-list-ul"></i> Vista de Lista
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="estadisticas-tab" data-bs-toggle="pill" data-bs-target="#estadisticas" type="button" role="tab">
                                <i class="bi bi-graph-up"></i> Estadísticas
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contenido de las pestañas -->
        <div class="tab-content" id="vistaTabContent">
            
            <!-- ============================================
                 TAB 1: VISTA DE CALENDARIO
                 ============================================ -->
            <div class="tab-pane fade show active" id="calendario" role="tabpanel">
                <div class="row g-4">
                    
                    <div class="col-12">
                        <div class="card-custom">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 style="color: var(--borgona); font-weight: 600; margin: 0;">
                                    <i class="bi bi-calendar-week"></i> Viernes, 01 Noviembre 2024
                                </h5>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-soft btn-sm" onclick="cambiarDia(-1)">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <button class="btn btn-soft btn-sm" onclick="irHoy()">
                                        Hoy
                                    </button>
                                    <button class="btn btn-soft btn-sm" onclick="cambiarDia(1)">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Simulación de Calendario por Horarios -->
                            <div class="alert-custom mb-4">
                                <i class="bi bi-info-circle"></i>
                                <small><strong>Vista simplificada:</strong> En producción, aquí iría un calendario completo con FullCalendar.js o similar</small>
                            </div>

                            <!-- Citas por Horario -->
                            <div class="row g-3">
                                
                                <!-- Horario 9:00 AM -->
                                <div class="col-12">
                                    <div style="border-left: 4px solid var(--dorado-palido); padding-left: 1rem;">
                                        <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 0.5rem;">
                                            <i class="bi bi-clock"></i> 9:00 AM
                                        </h6>
                                        
                                        <div class="list-item-custom mb-2" style="background: rgba(40, 167, 69, 0.05); border-left: 4px solid #28a745;">
                                            <div class="list-avatar" style="background: linear-gradient(135deg, #28a745, #20c997);">
                                                <i class="bi bi-person-check"></i>
                                            </div>
                                            <div class="list-content">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6>María García - Corte de Cabello</h6>
                                                        <p>
                                                            <i class="bi bi-person-circle"></i> Estilista: Ana López | 
                                                            <i class="bi bi-clock"></i> 30 min | 
                                                            <i class="bi bi-currency-dollar"></i> $13.50
                                                        </p>
                                                    </div>
                                                    <div class="d-flex gap-2 align-items-start">
                                                        <span class="badge bg-success">Completada</span>
                                                        <button class="btn btn-soft btn-sm" onclick="verDetalleCita(1)">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Horario 10:00 AM -->
                                <div class="col-12">
                                    <div style="border-left: 4px solid var(--dorado-palido); padding-left: 1rem;">
                                        <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 0.5rem;">
                                            <i class="bi bi-clock"></i> 10:00 AM
                                        </h6>
                                        
                                        <div class="list-item-custom mb-2" style="background: rgba(0, 123, 255, 0.05); border-left: 4px solid #007bff;">
                                            <div class="list-avatar" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                                                <i class="bi bi-hourglass-split"></i>
                                            </div>
                                            <div class="list-content">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6>Carmen Rodríguez - Tinte Completo</h6>
                                                        <p>
                                                            <i class="bi bi-person-circle"></i> Estilista: María Torres | 
                                                            <i class="bi bi-clock"></i> 90 min | 
                                                            <i class="bi bi-currency-dollar"></i> $36.00
                                                        </p>
                                                    </div>
                                                    <div class="d-flex gap-2 align-items-start">
                                                        <span class="badge bg-primary">En Proceso</span>
                                                        <button class="btn btn-soft btn-sm" onclick="verDetalleCita(2)">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Horario 11:30 AM -->
                                <div class="col-12">
                                    <div style="border-left: 4px solid var(--dorado-palido); padding-left: 1rem;">
                                        <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 0.5rem;">
                                            <i class="bi bi-clock"></i> 11:30 AM
                                        </h6>
                                        
                                        <div class="list-item-custom mb-2" style="background: rgba(255, 193, 7, 0.05); border-left: 4px solid #ffc107;">
                                            <div class="list-avatar" style="background: linear-gradient(135deg, #ffc107, #ff9800);">
                                                <i class="bi bi-clock-history"></i>
                                            </div>
                                            <div class="list-content">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6>Laura Martínez - Manicure + Pedicure</h6>
                                                        <p>
                                                            <i class="bi bi-person-circle"></i> Estilista: Sofía Ramírez | 
                                                            <i class="bi bi-clock"></i> 75 min | 
                                                            <i class="bi bi-currency-dollar"></i> $22.50
                                                        </p>
                                                    </div>
                                                    <div class="d-flex gap-2 align-items-start">
                                                        <span class="badge bg-warning text-dark">Confirmada</span>
                                                        <button class="btn btn-gold btn-sm" onclick="marcarLlegada(3)">
                                                            <i class="bi bi-check-circle"></i> Llegó
                                                        </button>
                                                        <button class="btn btn-soft btn-sm" onclick="verDetalleCita(3)">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Horario 2:00 PM -->
                                <div class="col-12">
                                    <div style="border-left: 4px solid var(--dorado-palido); padding-left: 1rem;">
                                        <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 0.5rem;">
                                            <i class="bi bi-clock"></i> 2:00 PM
                                        </h6>
                                        
                                        <div class="list-item-custom mb-2" style="background: rgba(108, 117, 125, 0.05); border-left: 4px solid #6c757d;">
                                            <div class="list-avatar" style="background: linear-gradient(135deg, #6c757d, #495057);">
                                                <i class="bi bi-question-circle"></i>
                                            </div>
                                            <div class="list-content">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6>Ana Pérez - Limpieza Facial</h6>
                                                        <p>
                                                            <i class="bi bi-person-circle"></i> Estilista: Laura Gómez | 
                                                            <i class="bi bi-clock"></i> 60 min | 
                                                            <i class="bi bi-currency-dollar"></i> $31.50
                                                        </p>
                                                    </div>
                                                    <div class="d-flex gap-2 align-items-start">
                                                        <span class="badge bg-secondary">Pendiente</span>
                                                        <button class="btn btn-gold btn-sm" onclick="confirmarCita(4)">
                                                            <i class="bi bi-check-circle"></i> Confirmar
                                                        </button>
                                                        <button class="btn btn-soft btn-sm" onclick="verDetalleCita(4)">
                                                            <i class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Espacio vacío -->
                                <div class="col-12">
                                    <div style="border-left: 4px solid var(--rosa-empolvado); padding-left: 1rem; opacity: 0.5;">
                                        <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 0.5rem;">
                                            <i class="bi bi-clock"></i> 3:00 PM
                                        </h6>
                                        <div style="padding: 2rem; text-align: center; background: var(--blanco-humo); border-radius: 10px;">
                                            <i class="bi bi-calendar-x" style="font-size: 2rem; color: var(--rosa-empolvado); display: block; margin-bottom: 0.5rem;"></i>
                                            <small style="color: var(--borgona); opacity: 0.6;">Horario disponible</small>
                                            <br>
                                            <button class="btn btn-outline-gold btn-sm mt-2" onclick="agendarEnHorario('15:00')">
                                                <i class="bi bi-plus-circle"></i> Agendar Aquí
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 2: VISTA DE LISTA
                 ============================================ -->
            <div class="tab-pane fade" id="lista" role="tabpanel">
                <div class="row g-4">
                    
                    <div class="col-12">
                        <div class="card-custom">
                            <h5 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-list-ul"></i> Todas las Citas
                            </h5>

                            <!-- Tabla de Citas -->
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr style="background: var(--blanco-humo);">
                                            <th style="color: var(--borgona);">Código</th>
                                            <th style="color: var(--borgona);">Cliente</th>
                                            <th style="color: var(--borgona);">Servicio</th>
                                            <th style="color: var(--borgona);">Estilista</th>
                                            <th style="color: var(--borgona);">Fecha/Hora</th>
                                            <th style="color: var(--borgona);">Monto</th>
                                            <th style="color: var(--borgona);">Estado</th>
                                            <th style="color: var(--borgona);">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 4px;">BR-001</code></td>
                                            <td><strong>María García</strong></td>
                                            <td>Corte de Cabello</td>
                                            <td>Ana López</td>
                                            <td>01 Nov - 9:00 AM</td>
                                            <td><strong style="color: var(--dorado-palido);">$13.50</strong></td>
                                            <td><span class="badge bg-success">Completada</span></td>
                                            <td>
                                                <button class="btn btn-soft btn-sm" onclick="verDetalleCita(1)">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 4px;">BR-002</code></td>
                                            <td><strong>Carmen Rodríguez</strong></td>
                                            <td>Tinte Completo</td>
                                            <td>María Torres</td>
                                            <td>01 Nov - 10:00 AM</td>
                                            <td><strong style="color: var(--dorado-palido);">$36.00</strong></td>
                                            <td><span class="badge bg-primary">En Proceso</span></td>
                                            <td>
                                                <button class="btn btn-soft btn-sm" onclick="verDetalleCita(2)">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 4px;">BR-003</code></td>
                                            <td><strong>Laura Martínez</strong></td>
                                            <td>Manicure + Pedicure</td>
                                            <td>Sofía Ramírez</td>
                                            <td>01 Nov - 11:30 AM</td>
                                            <td><strong style="color: var(--dorado-palido);">$22.50</strong></td>
                                            <td><span class="badge bg-warning text-dark">Confirmada</span></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-gold btn-sm" onclick="marcarLlegada(3)" title="Marcar llegada">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                    <button class="btn btn-soft btn-sm" onclick="verDetalleCita(3)">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 4px;">BR-004</code></td>
                                            <td><strong>Ana Pérez</strong></td>
                                            <td>Limpieza Facial</td>
                                            <td>Laura Gómez</td>
                                            <td>01 Nov - 2:00 PM</td>
                                            <td><strong style="color: var(--dorado-palido);">$31.50</strong></td>
                                            <td><span class="badge bg-secondary">Pendiente</span></td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <button class="btn btn-gold btn-sm" onclick="confirmarCita(4)" title="Confirmar">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                    <button class="btn btn-soft btn-sm" onclick="verDetalleCita(4)">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button class="btn btn-soft btn-sm" onclick="cancelarCita(4)" title="Cancelar">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Paginación -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <small style="color: var(--borgona);">Mostrando 4 de 45 citas</small>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-soft btn-sm">
                                        <i class="bi bi-chevron-left"></i>
                                    </button>
                                    <button class="btn btn-gold btn-sm">1</button>
                                    <button class="btn btn-soft btn-sm">2</button>
                                    <button class="btn btn-soft btn-sm">3</button>
                                    <button class="btn btn-soft btn-sm">
                                        <i class="bi bi-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ============================================
                 TAB 3: ESTADÍSTICAS
                 ============================================ -->
            <div class="tab-pane fade" id="estadisticas" role="tabpanel">
                <div class="row g-4">
                    
                    <!-- Resumen General -->
                    <div class="col-12">
                        <div class="row g-3">
                            
                            <div class="col-lg-3 col-md-6">
                                <div class="kpi-card">
                                    <div class="kpi-header">
                                        <div class="kpi-icon success">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                    </div>
                                    <h3 class="kpi-value">124</h3>
                                    <p class="kpi-label">Citas este Mes</p>
                                    <span class="kpi-badge badge-success">
                                        <i class="bi bi-arrow-up"></i> +15%
                                    </span>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="kpi-card">
                                    <div class="kpi-header">
                                        <div class="kpi-icon warning">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                    </div>
                                    <h3 class="kpi-value">$3,850</h3>
                                    <p class="kpi-label">Ingresos del Mes</p>
                                    <span class="kpi-badge badge-success">
                                        <i class="bi bi-graph-up"></i> +22%
                                    </span>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="kpi-card">
                                    <div class="kpi-header">
                                        <div class="kpi-icon info">
                                            <i class="bi bi-percent"></i>
                                        </div>
                                    </div>
                                    <h3 class="kpi-value">92%</h3>
                                    <p class="kpi-label">Tasa de Asistencia</p>
                                    <span class="kpi-badge badge-success">
                                        <i class="bi bi-check-circle"></i> Excelente
                                    </span>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6">
                                <div class="kpi-card">
                                    <div class="kpi-header">
                                        <div class="kpi-icon primary">
                                            <i class="bi bi-star-fill"></i>
                                        </div>
                                    </div>
                                    <h3 class="kpi-value">4.8</h3>
                                    <p class="kpi-label">Calificación Promedio</p>
                                    <span class="kpi-badge badge-gold">
                                        <i class="bi bi-star-fill"></i> Muy bueno
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Servicios Más Solicitados -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-graph-up"></i> Servicios Más Solicitados
                            </h6>

                            <div class="list-item-custom mb-3">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light));">
                                    <i class="bi bi-scissors"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between">
                                        <h6>Corte de Cabello</h6>
                                        <strong style="color: var(--dorado-palido);">42 citas</strong>
                                    </div>
                                    <div style="background: var(--blanco-humo); height: 8px; border-radius: 4px; overflow: hidden;">
                                        <div style="background: var(--borgona); width: 85%; height: 100%;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="list-item-custom mb-3">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--dorado-palido), var(--champagne));">
                                    <i class="bi bi-palette"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between">
                                        <h6>Tinte Completo</h6>
                                        <strong style="color: var(--dorado-palido);">28 citas</strong>
                                    </div>
                                    <div style="background: var(--blanco-humo); height: 8px; border-radius: 4px; overflow: hidden;">
                                        <div style="background: var(--dorado-palido); width: 56%; height: 100%;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="list-item-custom">
                                <div class="list-avatar" style="background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light));">
                                    <i class="bi bi-hand-index-thumb"></i>
                                </div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between">
                                        <h6>Manicure + Pedicure</h6>
                                        <strong style="color: var(--dorado-palido);">35 citas</strong>
                                    </div>
                                    <div style="background: var(--blanco-humo); height: 8px; border-radius: 4px; overflow: hidden;">
                                        <div style="background: var(--rosa-empolvado); width: 70%; height: 100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Estilistas con Más Citas -->
                    <div class="col-lg-6">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem;">
                                <i class="bi bi-trophy"></i> Top Estilistas del Mes
                            </h6>

                            <div class="list-item-custom mb-3">
                                <div class="list-avatar">A</div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6>Ana López García</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">38 citas completadas</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge badge-luxury">
                                                <i class="bi bi-trophy-fill"></i> #1
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="list-item-custom mb-3">
                                <div class="list-avatar">M</div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6>María Torres Sánchez</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">32 citas completadas</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-info">
                                                <i class="bi bi-award"></i> #2
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="list-item-custom">
                                <div class="list-avatar">S</div>
                                <div class="list-content">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h6>Sofía Ramírez Cruz</h6>
                                            <small style="color: var(--borgona); opacity: 0.7;">29 citas completadas</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-star"></i> #3
                                            </span>
                                        </div>
                                    </div>
                                </div>
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
        <p>&copy; 2024 BeautySalon - Sistema de Gestión | 
           <a href="#">Términos</a> · <a href="#">Privacidad</a> · <a href="#">Soporte</a>
        </p>
    </footer>

    <!-- ============================================
         MODALES
         ============================================ -->

    <!-- Modal: Nueva Cita -->
    <div class="modal fade" id="modalNuevaCita" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-calendar-plus" style="color: var(--dorado-palido);"></i> 
                        Nueva Cita
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Nueva Cita
                    ================================================
                    ACCIÓN: Enviar a ruta POST /citas/crear
                    VALIDACIONES:
                    - Cliente: requerido
                    - Servicio: requerido
                    - Estilista: requerido
                    - Fecha: requerida, >= hoy
                    - Hora: requerida
                    ================================================
                    -->
                    <form id="formNuevaCita">
                        <div class="row g-3">
                            
                            <div class="col-12">
                                <label class="form-label">Cliente *</label>
                                <select class="form-control" id="clienteCita" required>
                                    <option value="">Seleccionar cliente...</option>
                                    <option value="1">María García - 7777-1111</option>
                                    <option value="2">Carmen Rodríguez - 7777-2222</option>
                                    <option value="3">Laura Martínez - 7777-3333</option>
                                    <option value="nuevo">+ Nuevo Cliente</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Servicio *</label>
                                <select class="form-control" id="servicioCita" required onchange="calcularPrecio()">
                                    <option value="">Seleccionar servicio...</option>
                                    <option value="1" data-precio="13.50" data-duracion="30">Corte de Cabello - $13.50</option>
                                    <option value="2" data-precio="36.00" data-duracion="90">Tinte Completo - $36.00</option>
                                    <option value="3" data-precio="22.50" data-duracion="75">Manicure + Pedicure - $22.50</option>
                                    <option value="4" data-precio="31.50" data-duracion="60">Limpieza Facial - $31.50</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estilista *</label>
                                <select class="form-control" id="estilista" required>
                                    <option value="">Seleccionar estilista...</option>
                                    <option value="1">Ana López</option>
                                    <option value="2">María Torres</option>
                                    <option value="3">Sofía Ramírez</option>
                                    <option value="4">Laura Gómez</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha *</label>
                                <input type="date" class="form-control" id="fechaCita" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Hora *</label>
                                <input type="time" class="form-control" id="horaCita" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Duración</label>
                                <input type="text" class="form-control" id="duracionCita" readonly placeholder="Automático">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Precio</label>
                                <input type="text" class="form-control" id="precioCita" readonly placeholder="$0.00">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Notas (Opcional)</label>
                                <textarea class="form-control" id="notasCita" rows="3" placeholder="Observaciones, preferencias, etc..."></textarea>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-gold" onclick="guardarNuevaCita()">
                        <i class="bi bi-save"></i> Agendar Cita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Detalle de Cita -->
    <div class="modal fade" id="modalDetalleCita" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-info-circle" style="color: var(--dorado-palido);"></i> 
                        Detalle de Cita
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    
                    <!-- Código de Cita -->
                    <div class="text-center mb-4">
                        <div style="display: inline-block; background: linear-gradient(135deg, var(--rosa-empolvado), var(--rosa-empolvado-light)); padding: 0.75rem 2rem; border-radius: 10px;">
                            <small style="color: var(--borgona); opacity: 0.8;">Código de Cita</small>
                            <h3 style="color: var(--borgona); margin: 0.25rem 0 0 0; font-family: monospace; letter-spacing: 2px;">
                                BR-001
                            </h3>
                        </div>
                    </div>

                    <!-- Información de la Cita -->
                    <div class="row g-4">
                        
                        <div class="col-md-6">
                            <div class="card-custom" style="background: var(--blanco-humo);">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-person-circle"></i> Información del Cliente
                                </h6>
                                <p style="margin: 0.5rem 0;"><strong>Nombre:</strong> María García</p>
                                <p style="margin: 0.5rem 0;"><strong>Teléfono:</strong> 7777-1111</p>
                                <p style="margin: 0.5rem 0;"><strong>Email:</strong> maria.garcia@email.com</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-custom" style="background: var(--blanco-humo);">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-calendar-event"></i> Fecha y Hora
                                </h6>
                                <p style="margin: 0.5rem 0;"><strong>Fecha:</strong> 01 Noviembre 2024</p>
                                <p style="margin: 0.5rem 0;"><strong>Hora:</strong> 9:00 AM</p>
                                <p style="margin: 0.5rem 0;"><strong>Duración:</strong> 30 minutos</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-custom" style="background: var(--blanco-humo);">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-scissors"></i> Servicio
                                </h6>
                                <p style="margin: 0.5rem 0;"><strong>Servicio:</strong> Corte de Cabello</p>
                                <p style="margin: 0.5rem 0;"><strong>Categoría:</strong> Cabello</p>
                                <p style="margin: 0.5rem 0;">
                                    <strong>Precio:</strong> 
                                    <span style="color: var(--dorado-palido); font-size: 1.2rem;">$13.50</span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-custom" style="background: var(--blanco-humo);">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-person-badge"></i> Estilista
                                </h6>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--borgona), var(--borgona-light)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: bold;">
                                        A
                                    </div>
                                    <div>
                                        <p style="margin: 0; font-weight: 600; color: var(--borgona);">Ana López García</p>
                                        <small style="color: var(--borgona); opacity: 0.7;">Estilista Senior</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-custom" style="background: var(--blanco-humo);">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-chat-left-text"></i> Notas
                                </h6>
                                <p style="margin: 0; color: var(--borgona);">Cliente prefiere corte en capas. Última visita hace 2 meses.</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert-custom" style="background: rgba(40, 167, 69, 0.1); border-left-color: #28a745;">
                                <i class="bi bi-check-circle"></i>
                                <strong>Estado:</strong> Completada el 01/11/2024 a las 9:32 AM
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-gold" onclick="editarCita()">
                        <i class="bi bi-pencil"></i> Editar
                    </button>
                    <button type="button" class="btn btn-gold" onclick="imprimirCita()">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Confirmar Acción -->
    <div class="modal fade" id="modalConfirmar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-question-circle" style="color: var(--dorado-palido);"></i> 
                        Confirmar Acción
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 2rem; text-align: center;">
                    <div style="font-size: 4rem; color: var(--dorado-palido); margin-bottom: 1rem;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <h5 style="color: var(--borgona); margin-bottom: 1rem;" id="confirmarTitulo">
                        ¿Estás seguro?
                    </h5>
                    <p style="color: var(--borgona); opacity: 0.8;" id="confirmarMensaje">
                        Esta acción no se puede deshacer.
                    </p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-gold" id="btnConfirmarAccion">
                        <i class="bi bi-save"></i> Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        // ========================================
        // FUNCIONES DE BÚSQUEDA Y FILTROS
        // ========================================

        function buscarCita() {
            const termino = document.getElementById('buscarCita').value;
            console.log('Buscar cita:', termino);
            // TODO: Implementar búsqueda
        }

        function filtrarCitas() {
            const fecha = document.getElementById('filtroFecha').value;
            const estado = document.getElementById('filtroEstado').value;
            const estilista = document.getElementById('filtroEstilista').value;

            console.log('Filtrar citas:', { fecha, estado, estilista });
            alert('Filtrando citas...');
            // TODO: Implementar filtrado
        }

        function limpiarFiltros() {
            document.getElementById('filtroFecha').value = '';
            document.getElementById('filtroEstado').value = '';
            document.getElementById('filtroEstilista').value = '';
            document.getElementById('buscarCita').value = '';
            console.log('Filtros limpiados');
        }

        // ========================================
        // FUNCIONES DE CALENDARIO
        // ========================================

        function cambiarDia(dias) {
            console.log('Cambiar día:', dias);
            alert('Función: Navegar ' + (dias > 0 ? 'al día siguiente' : 'al día anterior'));
            // TODO: Actualizar vista del calendario
        }

        function irHoy() {
            console.log('Ir a hoy');
            alert('Función: Volver a la fecha actual');
            // TODO: Resetear calendario a hoy
        }

        function agendarEnHorario(hora) {
            console.log('Agendar en horario:', hora);
            alert('Función: Abrir modal de nueva cita con hora ' + hora + ' pre-seleccionada');
            // TODO: Abrir modal con hora
        }

        // ========================================
        // FUNCIONES DE GESTIÓN DE CITAS
        // ========================================

        function abrirModalNuevaCita() {
            console.log('Abrir modal nueva cita');
            
            // Limpiar formulario
            document.getElementById('formNuevaCita').reset();
            
            // Establecer fecha mínima de hoy
            const hoy = new Date().toISOString().split('T')[0];
            document.getElementById('fechaCita').min = hoy;
            document.getElementById('fechaCita').value = hoy;
            
            // Abrir modal
            const modal = new bootstrap.Modal(document.getElementById('modalNuevaCita'));
            modal.show();
        }

        function calcularPrecio() {
            const select = document.getElementById('servicioCita');
            const option = select.options[select.selectedIndex];
            
            if (option.value) {
                const precio = option.getAttribute('data-precio');
                const duracion = option.getAttribute('data-duracion');
                
                document.getElementById('precioCita').value = '$' + precio;
                document.getElementById('duracionCita').value = duracion + ' minutos';
            } else {
                document.getElementById('precioCita').value = '';
                document.getElementById('duracionCita').value = '';
            }
        }

        function guardarNuevaCita() {
            const form = document.getElementById('formNuevaCita');
            
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const datos = {
                cliente: document.getElementById('clienteCita').value,
                servicio: document.getElementById('servicioCita').value,
                estilista: document.getElementById('estilista').value,
                fecha: document.getElementById('fechaCita').value,
                hora: document.getElementById('horaCita').value,
                notas: document.getElementById('notasCita').value
            };

            console.log('Guardar nueva cita:', datos);
            
            // Cerrar modal
            bootstrap.Modal.getInstance(document.getElementById('modalNuevaCita')).hide();
            
            // Mostrar confirmación
            alert('✅ Cita agendada exitosamente\n\nSe ha enviado confirmación al cliente por email');
            
            // TODO: Enviar a backend
        }

        function verDetalleCita(citaId) {
            console.log('Ver detalle cita:', citaId);
            
            // TODO: Cargar datos reales del backend
            // Por ahora mostramos datos estáticos
            
            // Abrir modal
            const modal = new bootstrap.Modal(document.getElementById('modalDetalleCita'));
            modal.show();
        }

        function editarCita() {
            console.log('Editar cita');
            // Cerrar modal de detalle
            bootstrap.Modal.getInstance(document.getElementById('modalDetalleCita')).hide();
            
            // Abrir modal de edición (podría ser el mismo de nueva cita con datos pre-cargados)
            setTimeout(() => {
                alert('Función: Abrir modal de edición con datos de la cita');
            }, 300);
        }

        function imprimirCita() {
            console.log('Imprimir cita');
            alert('Función: Generar PDF con los detalles de la cita');
            // TODO: Generar PDF
        }

        function confirmarCita(citaId) {
            console.log('Confirmar cita:', citaId);
            
            document.getElementById('confirmarTitulo').textContent = '¿Confirmar esta cita?';
            document.getElementById('confirmarMensaje').textContent = 'Se enviará una notificación por email al cliente.';
            
            const modal = new bootstrap.Modal(document.getElementById('modalConfirmar'));
            modal.show();
            
            document.getElementById('btnConfirmarAccion').onclick = function() {
                console.log('Cita confirmada:', citaId);
                modal.hide();
                alert('✅ Cita confirmada exitosamente\n\nSe ha notificado al cliente');
                // TODO: Actualizar estado en BD
            };
        }

        function marcarLlegada(citaId) {
            console.log('Marcar llegada:', citaId);
            
            document.getElementById('confirmarTitulo').textContent = '¿Marcar llegada del cliente?';
            document.getElementById('confirmarMensaje').textContent = 'El estado de la cita cambiará a "En Proceso".';
            
            const modal = new bootstrap.Modal(document.getElementById('modalConfirmar'));
            modal.show();
            
            document.getElementById('btnConfirmarAccion').onclick = function() {
                console.log('Llegada marcada:', citaId);
                modal.hide();
                alert('✅ Cliente marcado como "Llegó"\n\nEstado: En Proceso');
                // TODO: Actualizar estado en BD
            };
        }

        function cancelarCita(citaId) {
            console.log('Cancelar cita:', citaId);
            
            document.getElementById('confirmarTitulo').textContent = '⚠️ ¿Cancelar esta cita?';
            document.getElementById('confirmarMensaje').textContent = 'Esta acción notificará al cliente y no se puede deshacer.';
            
            const modal = new bootstrap.Modal(document.getElementById('modalConfirmar'));
            modal.show();
            
            document.getElementById('btnConfirmarAccion').onclick = function() {
                const motivo = prompt('Motivo de cancelación (opcional):');
                console.log('Cita cancelada:', citaId, 'Motivo:', motivo);
                modal.hide();
                alert('✅ Cita cancelada\n\nSe ha notificado al cliente');
                // TODO: Actualizar estado en BD
            };
        }

        // ========================================
        // FUNCIONES GENERALES
        // ========================================

        // Establecer fecha de hoy por defecto
        document.addEventListener('DOMContentLoaded', function() {
            const hoy = new Date().toISOString().split('T')[0];
            document.getElementById('filtroFecha').value = hoy;
        });
    </script>
    
</body>
</html>