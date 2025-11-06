<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
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
                    <h3 class="kpi-value">24</h3>
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
                    <h3 class="kpi-value">$28.50</h3>
                    <p class="kpi-label">Precio Promedio</p>
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
                    <h3 class="kpi-value">6</h3>
                    <p class="kpi-label">Categorías</p>
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
                    <p class="kpi-label">Servicio Más Vendido</p>
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
                                <tr>
                                    <td>#001</td>
                                    <td><strong>Corte de Cabello</strong></td>
                                    <td>Corte clásico o moderno para dama o caballero</td>
                                    <td><span class="badge badge-gold">$15.00</span></td>
                                    <td>30 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" data-bs-toggle="modal" data-bs-target="#modalEditarServicio" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" data-bs-toggle="modal" data-bs-target="#modalVerServicio" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" onclick="toggleEstado(1)" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#002</td>
                                    <td><strong>Tinte Completo</strong></td>
                                    <td>Coloración completa del cabello, incluye aplicación y lavado</td>
                                    <td><span class="badge badge-gold">$40.00</span></td>
                                    <td>90 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#003</td>
                                    <td><strong>Peinado Especial</strong></td>
                                    <td>Peinado para eventos especiales (bodas, graduaciones)</td>
                                    <td><span class="badge badge-gold">$30.00</span></td>
                                    <td>60 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#004</td>
                                    <td><strong>Tratamiento Capilar</strong></td>
                                    <td>Tratamiento de hidratación profunda y reparación</td>
                                    <td><span class="badge badge-gold">$35.00</span></td>
                                    <td>45 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
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
                            <tbody>
                                <tr>
                                    <td>#005</td>
                                    <td><strong>Manicure Básico</strong></td>
                                    <td>Limpieza, limado, esmaltado y masaje de manos</td>
                                    <td><span class="badge badge-gold">$10.00</span></td>
                                    <td>30 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#006</td>
                                    <td><strong>Pedicure Spa</strong></td>
                                    <td>Pedicure completo con exfoliación y masaje relajante</td>
                                    <td><span class="badge badge-gold">$15.00</span></td>
                                    <td>45 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#007</td>
                                    <td><strong>Uñas Acrílicas</strong></td>
                                    <td>Aplicación de uñas acrílicas con diseño a elección</td>
                                    <td><span class="badge badge-gold">$25.00</span></td>
                                    <td>90 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
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
                            <tbody>
                                <tr>
                                    <td>#008</td>
                                    <td><strong>Limpieza Facial</strong></td>
                                    <td>Limpieza profunda con extracción y mascarilla</td>
                                    <td><span class="badge badge-gold">$20.00</span></td>
                                    <td>60 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>#009</td>
                                    <td><strong>Depilación Facial</strong></td>
                                    <td>Depilación de cejas y labio superior con cera</td>
                                    <td><span class="badge badge-gold">$8.00</span></td>
                                    <td>20 min</td>
                                    <td><span class="badge bg-success">Activo</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-soft me-1" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-gold me-1" title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-premium" title="Desactivar">
                                            <i class="bi bi-toggle-on"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
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
                                    <input type="number" class="form-control" name="precio" placeholder="0.00" step="0.01" min="0" required>
                                </div>
                            </div>

                            <!-- Duración -->
                            <div class="col-md-4">
                                <label class="form-label">Duración (minutos) *</label>
                                <input type="number" class="form-control" name="duracion_minutos" placeholder="Ej: 30" min="5" step="5" required>
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
                                    <input class="form-check-input" type="checkbox" name="permite_promociones" id="promociones" checked>
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
                                    <input type="number" class="form-control" name="precio" value="15.00" step="0.01" min="0" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Duración (minutos) *</label>
                                <input type="number" class="form-control" name="duracion_minutos" value="30" min="5" step="5" required>
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
                                    <input class="form-check-input" type="checkbox" name="permite_promociones" id="promocionesEdit" checked>
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
                    <button type="button" class="btn btn-gold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#modalEditarServicio">
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
            
            const precio = parseFloat(this.querySelector('[name="precio"]').value);
            const duracion = parseInt(this.querySelector('[name="duracion_minutos"]').value);
            
            if (precio <= 0) {
                alert('El precio debe ser mayor a 0');
                return;
            }
            
            if (duracion < 5) {
                alert('La duración mínima es de 5 minutos');
                return;
            }
            
            // TODO: Enviar datos al backend
            console.log('Crear nuevo servicio');
            alert('Formulario validado - Conectar con backend');
        });

        // Validación de formulario editar servicio
        document.getElementById('formEditarServicio')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const precio = parseFloat(this.querySelector('[name="precio"]').value);
            const duracion = parseInt(this.querySelector('[name="duracion_minutos"]').value);
            
            if (precio <= 0) {
                alert('El precio debe ser mayor a 0');
                return;
            }
            
            if (duracion < 5) {
                alert('La duración mínima es de 5 minutos');
                return;
            }
            
            // TODO: Enviar datos al backend
            console.log('Actualizar servicio');
            alert('Formulario validado - Conectar con backend');
        });

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