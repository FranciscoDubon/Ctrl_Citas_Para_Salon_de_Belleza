<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Servicios Administrador | Salón de Belleza</title>
    
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
            <a href="{{ route('dashboardAdm') }}" class="menu-item">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.usuariosAdm') }}" class="menu-item">
                <i class="bi bi-people"></i> Empleados & Usuarios
            </a>
            <a href="{{ route('admin.serviciosAdm') }}" class="menu-item active">
                <i class="bi bi-scissors"></i> Servicios
            </a>
            <a href="{{ route('admin.promocionesAdm') }}" class="menu-item">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('admin.reportesAdm') }}" class="menu-item">
                <i class="bi bi-graph-up"></i> Reportes
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Gestión de Servicios</h1>
            <p>Administra el catálogo de servicios del salón.</p>
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
        
        <!-- Botones de Acción Superior -->
        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-gold me-2" data-bs-toggle="modal" data-bs-target="#modalNuevoServicio">
                    <i class="bi bi-plus-circle"></i> Nuevo Servicio
                </button>
                <button class="btn btn-outline-gold me-2">
                    <i class="bi bi-funnel"></i> Filtrar por Categoría
                </button>
                <button class="btn btn-soft">
                    <i class="bi bi-file-earmark-excel"></i> Exportar
                </button>
            </div>
        </div>

        <!-- KPI Cards - Resumen de Servicios -->
        <div class="row g-4 mb-4">
            
            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM servicios 
            WHERE activo = 1
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-scissors"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $totalActivos }}</h3>
                    <p class="kpi-label">Servicios Activos</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> Disponibles
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT AVG(precio) as promedio 
            FROM servicios 
            WHERE activo = 1
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">${{ number_format($precioPromedio, 2) }}</h3>
                    <p class="kpi-label">Precio promedio </p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-graph-up"></i> Por servicio
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(DISTINCT categoria) as total 
            FROM servicios
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-tags"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $totalCategorias }}</h3>
                    <p class="kpi-label">Total por categoria</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-collection"></i> Activas
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT s.nombre, COUNT(cs.id) as total
            FROM servicios s
            INNER JOIN cita_servicio cs ON s.id = cs.servicio_id
            WHERE MONTH(cs.created_at) = MONTH(CURDATE())
            GROUP BY s.id
            ORDER BY total DESC
            LIMIT 1
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">45</h3>
                    <p class="kpi-label">Servicio Más Vendido sigue en mantenimiento XD</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-trophy"></i> Corte de cabello
                    </span>
                </div>
            </div>
        </div>

        <!-- Servicios por Categoría -->
        <div class="row g-4 mb-4">
            
            <!-- Categoría: Cabello -->
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-scissors"></i>
                        Servicios de Cabello
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT id, nombre, descripcion, precio, duracion_minutos, activo
                    FROM servicios 
                    WHERE categoria = 'cabello'
                    ORDER BY nombre
                    ================================================
                    -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
    @foreach($servicios->where('categoria', 'cabello') as $servicio)
    <tr>
        <td>#{{ str_pad($servicio->idServicio, 3, '0', STR_PAD_LEFT) }}</td>
        <td><strong>{{ $servicio->nombre }}</strong></td>
        <td>{{ $servicio->descripcion }}</td>
        <td><span class="badge badge-gold">${{ number_format($servicio->precioBase, 2) }}</span></td>
        <td>{{ $servicio->duracionBase }} min</td>
        <td>
            <span class="badge bg-{{ $servicio->activo ? 'success' : 'secondary' }}">
                {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
            </span>
        </td>
        <td>
            <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarServicio" onclick="cargarServicio({{ $servicio->idServicio }})" title="Editar">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerServicio" onclick="verServicio({{ $servicio->idServicio }})" title="Ver detalles">
                <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-premium" onclick="toggleEstado({{ $servicio->idServicio }})" title="{{ $servicio->activo ? 'Desactivar' : 'Activar' }}">
                <i class="bi bi-toggle-{{ $servicio->activo ? 'on' : 'off' }}"></i>
            </button>
        </td>
    </tr>
    @endforeach
</tbody>

                        </table>
                    </div>
                </div>
            </div>

            <!-- Categoría: Uñas -->
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-hand-index"></i>
                        Servicios de Uñas
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            @foreach($servicios->where('categoria', 'unas') as $servicio)
    <tr>
        <td>#{{ str_pad($servicio->idServicio, 3, '0', STR_PAD_LEFT) }}</td>
        <td><strong>{{ $servicio->nombre }}</strong></td>
        <td>{{ $servicio->descripcion }}</td>
        <td><span class="badge badge-gold">${{ number_format($servicio->precioBase, 2) }}</span></td>
        <td>{{ $servicio->duracionBase }} min</td>
        <td>
            <span class="badge bg-{{ $servicio->activo ? 'success' : 'secondary' }}">
                {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
            </span>
        </td>
        <td>
            <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarServicio" onclick="cargarServicio({{ $servicio->idServicio }})" title="Editar">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerServicio" onclick="verServicio({{ $servicio->idServicio }})" title="Ver detalles">
                <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-premium" onclick="toggleEstado({{ $servicio->idServicio }})" title="{{ $servicio->activo ? 'Desactivar' : 'Activar' }}">
                <i class="bi bi-toggle-{{ $servicio->activo ? 'on' : 'off' }}"></i>
            </button>
        </td>
    </tr>
    @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <!-- Categoría: Faciales -->
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-emoji-smile"></i>
                        Servicios Faciales
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            @foreach($servicios->where('categoria', 'facial') as $servicio)
    <tr>
        <td>#{{ str_pad($servicio->idServicio, 3, '0', STR_PAD_LEFT) }}</td>
        <td><strong>{{ $servicio->nombre }}</strong></td>
        <td>{{ $servicio->descripcion }}</td>
        <td><span class="badge badge-gold">${{ number_format($servicio->precioBase, 2) }}</span></td>
        <td>{{ $servicio->duracionBase }} min</td>
        <td>
            <span class="badge bg-{{ $servicio->activo ? 'success' : 'secondary' }}">
                {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
            </span>
        </td>
        <td>
            <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarServicio" onclick="cargarServicio({{ $servicio->idServicio }})" title="Editar">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerServicio" onclick="verServicio({{ $servicio->idServicio }})" title="Ver detalles">
                <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-premium" onclick="toggleEstado({{ $servicio->idServicio }})" title="{{ $servicio->activo ? 'Desactivar' : 'Activar' }}">
                <i class="bi bi-toggle-{{ $servicio->activo ? 'on' : 'off' }}"></i>
            </button>
        </td>
    </tr>
    @endforeach
                        </table>
                    </div>
                </div>
            </div>
<!-- Categoría: Corporales -->
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-emoji-smile"></i>
                        Servicios Corporales
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            @foreach($servicios->where('categoria', 'corporal') as $servicio)
    <tr>
        <td>#{{ str_pad($servicio->idServicio, 3, '0', STR_PAD_LEFT) }}</td>
        <td><strong>{{ $servicio->nombre }}</strong></td>
        <td>{{ $servicio->descripcion }}</td>
        <td><span class="badge badge-gold">${{ number_format($servicio->precioBase, 2) }}</span></td>
        <td>{{ $servicio->duracionBase }} min</td>
        <td>
            <span class="badge bg-{{ $servicio->activo ? 'success' : 'secondary' }}">
                {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
            </span>
        </td>
        <td>
            <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarServicio" onclick="cargarServicio({{ $servicio->idServicio }})" title="Editar">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerServicio" onclick="verServicio({{ $servicio->idServicio }})" title="Ver detalles">
                <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-premium" onclick="toggleEstado({{ $servicio->idServicio }})" title="{{ $servicio->activo ? 'Desactivar' : 'Activar' }}">
                <i class="bi bi-toggle-{{ $servicio->activo ? 'on' : 'off' }}"></i>
            </button>
        </td>
    </tr>
    @endforeach
                        </table>
                    </div>
                </div>
            </div>
<!-- Categoría: Maquillaje -->
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-emoji-smile"></i>
                        Servicios de Maquillaje
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            @foreach($servicios->where('categoria', 'maquillaje') as $servicio)
    <tr>
        <td>#{{ str_pad($servicio->idServicio, 3, '0', STR_PAD_LEFT) }}</td>
        <td><strong>{{ $servicio->nombre }}</strong></td>
        <td>{{ $servicio->descripcion }}</td>
        <td><span class="badge badge-gold">${{ number_format($servicio->precioBase, 2) }}</span></td>
        <td>{{ $servicio->duracionBase }} min</td>
        <td>
            <span class="badge bg-{{ $servicio->activo ? 'success' : 'secondary' }}">
                {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
            </span>
        </td>
        <td>
            <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarServicio" onclick="cargarServicio({{ $servicio->idServicio }})" title="Editar">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerServicio" onclick="verServicio({{ $servicio->idServicio }})" title="Ver detalles">
                <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-premium" onclick="toggleEstado({{ $servicio->idServicio }})" title="{{ $servicio->activo ? 'Desactivar' : 'Activar' }}">
                <i class="bi bi-toggle-{{ $servicio->activo ? 'on' : 'off' }}"></i>
            </button>
        </td>
    </tr>
    @endforeach
                        </table>
                    </div>
                </div>
            </div>
<!-- Categoría: Depilación -->
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-emoji-smile"></i>
                        Servicios de depilación
                    </h5>
                    
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            @foreach($servicios->where('categoria', 'depilacion') as $servicio)
    <tr>
        <td>#{{ str_pad($servicio->idServicio, 3, '0', STR_PAD_LEFT) }}</td>
        <td><strong>{{ $servicio->nombre }}</strong></td>
        <td>{{ $servicio->descripcion }}</td>
        <td><span class="badge badge-gold">${{ number_format($servicio->precioBase, 2) }}</span></td>
        <td>{{ $servicio->duracionBase }} min</td>
        <td>
            <span class="badge bg-{{ $servicio->activo ? 'success' : 'secondary' }}">
                {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
            </span>
        </td>
        <td>
            <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarServicio" onclick="cargarServicio({{ $servicio->idServicio }})" title="Editar">
                <i class="bi bi-pencil"></i>
            </button>
            <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerServicio" onclick="verServicio({{ $servicio->idServicio }})" title="Ver detalles">
                <i class="bi bi-eye"></i>
            </button>
            <button class="btn btn-sm btn-premium" onclick="toggleEstado({{ $servicio->idServicio }})" title="{{ $servicio->activo ? 'Desactivar' : 'Activar' }}">
                <i class="bi bi-toggle-{{ $servicio->activo ? 'on' : 'off' }}"></i>
            </button>
        </td>
    </tr>
    @endforeach
                        </table>
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
         MODAL: NUEVO SERVICIO
         ============================================ -->
    <div class="modal fade" id="modalNuevoServicio" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-plus-circle" style="color: var(--dorado-palido);"></i> 
                        Nuevo Servicio
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Creación
                    ================================================
                    ACCIÓN: Enviar a ruta POST /servicios/crear
                    VALIDACIONES:
                    - Nombre: requerido, máx 100 caracteres, único
                    - Descripción: opcional, máx 500 caracteres
                    - Precio: requerido, decimal, mayor a 0
                    - Duración: requerido, entero, mayor a 0
                    - Categoría: requerido
                    - Ajustes especiales: opcional, texto
                    ================================================
                    -->
                    <form id="formNuevoServicio">
                        <div class="row g-3">
                            <!-- Nombre del Servicio -->
                            <div class="col-md-8">
                                <label class="form-label">Nombre del Servicio *</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej: Corte de Cabello" required>
                            </div>

                            <!-- Categoría -->
                            <div class="col-md-4">
                                <label class="form-label">Categoría *</label>
                                <select class="form-select" name="categoria" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="cabello">Cabello</option>
                                    <option value="unas">Uñas</option>
                                    <option value="facial">Facial</option>
                                    <option value="corporal">Corporal</option>
                                    <option value="maquillaje">Maquillaje</option>
                                    <option value="depilacion">Depilación</option>
                                </select>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción detallada del servicio..."></textarea>
                            </div>

                            <!-- Precio -->
                            <div class="col-md-4">
                                <label class="form-label">Precio (USD) *</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: var(--dorado-palido); color: var(--borgona); border: 2px solid var(--dorado-palido); font-weight: 700;">$</span>
                                    <input type="number" class="form-control" name="precioBase" placeholder="0.00" step="0.01" min="0" required>
                                </div>
                            </div>

                            <!-- Duración -->
                            <div class="col-md-4">
                                <label class="form-label">Duración (minutos) *</label>
                                <input type="number" class="form-control" name="duracionBase" placeholder="Ej: 30" min="5" step="5" required>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-4">
                                <label class="form-label">Estado *</label>
                                <select class="form-select" name="activo" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            <!-- Ajustes Especiales -->
                            <div class="col-12">
                                <div class="alert-custom">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>Ajustes Especiales:</strong> Indica si este servicio requiere preparación especial, productos específicos, o consideraciones importantes.
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Ajustes Especiales</label>
                                <textarea class="form-control" name="ajustes_especiales" rows="3" placeholder="Ej: Requiere prueba de alergia 48 horas antes, No recomendado para embarazadas, etc."></textarea>
                            </div>

                            <!-- Disponible para Promociones -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permite_promociones" id="promociones" value="1" checked>
                                    <label class="form-check-label" for="promociones">
                                        Permitir que este servicio sea incluido en promociones
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevoServicio" class="btn btn-gold">
                        <i class="bi bi-save"></i> Guardar Servicio
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: EDITAR SERVICIO
         ============================================ -->
    <div class="modal fade" id="modalEditarServicio" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-pencil" style="color: var(--dorado-palido);"></i> 
                        Editar Servicio
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Edición
                    ================================================
                    ACCIÓN: Enviar a ruta PUT /servicios/{id}/actualizar
                    NOTA: Los campos vienen pre-llenados con los datos actuales
                    ================================================
                    -->
                    <form id="formEditarServicio">
                        <input type="hidden" name="servicio_id" value="1">
                        
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Nombre del Servicio *</label>
                                <input type="text" class="form-control" name="nombre" value="Corte de Cabello" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Categoría *</label>
                                <select class="form-select" name="categoria" required>
                                    <option value="cabello" selected>Cabello</option>
                                    <option value="unas">Uñas</option>
                                    <option value="facial">Facial</option>
                                    <option value="corporal">Corporal</option>
                                    <option value="maquillaje">Maquillaje</option>
                                    <option value="depilacion">Depilación</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="3">Corte clásico o moderno para dama o caballero</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Precio (USD) *</label>
                                <div class="input-group">
                                    <span class="input-group-text" style="background: var(--dorado-palido); color: var(--borgona); border: 2px solid var(--dorado-palido); font-weight: 700;">$</span>
                                    <input type="number" class="form-control" name="precioBase" value="15.00" step="0.01" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Duración (minutos) *</label>
                                <input type="number" class="form-control" name="duracionBase" value="30" min="5" step="5" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Estado *</label>
                                <select class="form-select" name="activo" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Ajustes Especiales</label>
                                <textarea class="form-control" name="ajustes_especiales" rows="3">Se recomienda lavar el cabello el día anterior. No aplicar productos como gel o spray antes de la cita.</textarea>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permite_promociones" id="promocionesEdit" value="1" checked>
                                    <label class="form-check-label" for="promocionesEdit">
                                        Permitir que este servicio sea incluido en promociones
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formEditarServicio" class="btn btn-gold">
                        <i class="bi bi-save"></i> Actualizar Servicio
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: VER DETALLES DEL SERVICIO
         ============================================ -->
    <div class="modal fade" id="modalVerServicio" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-eye" style="color: var(--dorado-palido);"></i> 
                        Detalles del Servicio
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Cargar datos del servicio
                    ================================================
                    CONSULTA SQL:
                    SELECT * FROM servicios WHERE id = ?
                    ================================================
                    -->
                    <div class="row g-3">
                        <!-- Información Básica -->
                        <div class="col-12">
                            <div class="premium-card">
                                <h3>Corte de Cabello</h3>
                                <p><span class="badge badge-gold">CABELLO</span> <span class="badge bg-success">ACTIVO</span></p>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="col-12">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="width: 50px; height: 50px;">
                                    <i class="bi bi-file-text"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Descripción</h6>
                                    <p>Corte clásico o moderno para dama o caballero</p>
                                </div>
                            </div>
                        </div>

                        <!-- Precio y Duración -->
                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="width: 50px; height: 50px;">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Precio</h6>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--borgona); margin: 0;">$15.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="list-item-custom">
                                <div class="list-avatar" style="width: 50px; height: 50px;">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="list-content">
                                    <h6>Duración</h6>
                                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--borgona); margin: 0;">30 min</p>
                                </div>
                            </div>
                        </div>

                        <!-- Ajustes Especiales -->
                        <div class="col-12">
                            <div class="alert-custom">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Ajustes Especiales:</strong><br>
                                Se recomienda lavar el cabello el día anterior. No aplicar productos como gel o spray antes de la cita.
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="col-12">
                            <div class="divider-luxury"></div>
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">Estadísticas del Servicio</h6>
                        </div>

                        <div class="col-md-4">
                            <div class="kpi-card">
                                <div class="kpi-header">
                                    <div class="kpi-icon success" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </div>
                                <h3 class="kpi-value" style="font-size: 1.75rem;">45</h3>
                                <p class="kpi-label">Veces solicitado (mes)</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="kpi-card">
                                <div class="kpi-header">
                                    <div class="kpi-icon primary" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        <i class="bi bi-cash-stack"></i>
                                    </div>
                                </div>
                                <h3 class="kpi-value" style="font-size: 1.75rem;">$675</h3>
                                <p class="kpi-label">Ingresos generados</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="kpi-card">
                                <div class="kpi-header">
                                    <div class="kpi-icon info" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                </div>
                                <h3 class="kpi-value" style="font-size: 1.75rem;">4.8</h3>
                                <p class="kpi-label">Calificación promedio</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#modalEditarServicio">
    <i class="bi bi-pencil"></i> Editar Servicio
</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script de Funciones -->
    <script>
        // 
        // ================================================
        // TODO BACKEND: Implementar funciones
        // ================================================
        //

        // Función para toggle de estado activo/inactivo
        function toggleEstado(servicioId) {
            // TODO: Hacer petición AJAX a /servicios/{id}/toggle-estado
            console.log('Toggle estado servicio:', servicioId);
            alert('Función de toggle estado - Conectar con backend');
        }

        // Validación de formulario nuevo servicio
        document.getElementById('formNuevoServicio')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const precio = parseFloat(this.querySelector('[name="precioBase"]').value);
            const duracion = parseInt(this.querySelector('[name="duracionBase"]').value);
            
            if (precio <= 0) {
                alert('El precio debe ser mayor a 0');
                return;
            }
            
            if (duracion < 5) {
                alert('La duración mínima es de 5 minutos');
                return;
            }
            
           
        });

        // Validación de formulario editar servicio
        document.getElementById('formEditarServicio')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const precio = parseFloat(this.querySelector('[name="precioBase"]').value);
            const duracion = parseInt(this.querySelector('[name="duracionBase"]').value);
            
            if (precio <= 0) {
                alert('El precio debe ser mayor a 0');
                return;
            }
            
            if (duracion < 5) {
                alert('La duración mínima es de 5 minutos');
                return;
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

document.getElementById('formNuevoServicio').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const data = Object.fromEntries(formData.entries());
    fetch('/recepcionista/servicios', {
        method: 'POST',
        headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": token
    },
    body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('✅ Servicio creado exitosamente');
            window.location.reload
            // Opcional: cerrar modal y refrescar tabla
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoServicio'));
            modal.hide();
            location.reload();
            const modalElement = document.getElementById('modalNuevoServicio');
            //const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            form.reset();
        } else {
            alert('❌ Error al crear el servicio');
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Error en el servidor');
    });
});

function actualizarKpis() {
    fetch('/recepcionista/serviciosRecep')
        .then(res => res.json())
        .then(data => {
            document.getElementById('kpi-activos').textContent = data.totalActivos;
            document.getElementById('kpi-promedio').textContent = `$${parseFloat(data.precioPromedio).toFixed(2)}`;
            document.getElementById('kpi-categorias').textContent = data.totalCategorias;
            document.getElementById('kpi-mas-vendido').textContent = data.masVendido.total;
        });
}
// Opcional: refrescar cada 30 segundos
setInterval(actualizarKpis, 30000);

document.getElementById('formEditarServicio').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const id = form.servicio_id.value;

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    // Asegurar que 'permite_promociones' esté presente como booleano
    data.permite_promociones = form.permite_promociones.checked;

    fetch(`/servicios/${id}/actualizar`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(res => {
        if (!res.ok) throw new Error(`Error ${res.status}`);
        return res.json();
    })
    .then(response => {
        if (response.success) {
            alert('Servicio actualizado correctamente');
            window.location.reload

            // Opcional: cerrar modal y refrescar tabla
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarServicio'));
            modal.hide();
            location.reload();
            // refrescarServicios(); // si tienes una función para recargar la lista
        } else {
            alert('Hubo un problema al actualizar el servicio');
        }
    })
    .catch(error => {
        console.error('Error al actualizar:', error);
        alert('No se pudo actualizar el servicio. Intenta más tarde.');
    });
});


function cargarServicio(id) {
    fetch(`/servicios/${id}`)
        .then(res => {
        const contentType = res.headers.get('content-type');
        if (!res.ok || !contentType || !contentType.includes('application/json')) {
            throw new Error('Respuesta no válida: se esperaba JSON');
        }
        return res.json();
    })
        .then(data => {
            const form = document.getElementById('formEditarServicio');
            form.servicio_id.value = data.idServicio;
            form.nombre.value = data.nombre;
            form.categoria.value = data.categoria;
            form.descripcion.value = data.descripcion;
            form.precioBase.value = data.precioBase;
            form.duracionBase.value = data.duracionBase;
            form.activo.value = data.activo ? '1' : '0';
            form.ajustes_especiales.value = data.ajustes_especiales;
            form.permite_promociones.checked = data.permite_promociones;
        })
        .catch(error => {
            console.error('Error al cargar el servicio:', error);
            alert('No se pudo cargar el servicio. Verifica el ID o intenta más tarde.');
        });
}

function toggleEstado(servicioId) {
    fetch(`/servicios/${servicioId}/toggle-estado`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Estado actualizado. Nuevo estado: ${data.nuevo_estado ? 'Activo' : 'Inactivo'}`);
            // Opcional: actualizar visualmente el estado en la tabla
            location.reload();
        } else {
            alert('Error al cambiar el estado');
        }
    })
    .catch(error => {
        console.error('Error en toggleEstado:', error);
        alert('Error de conexión con el servidor');
    });
}


</script>


</body>
</html>

