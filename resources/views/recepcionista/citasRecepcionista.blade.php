<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas Recepcionista | Salón de Belleza</title>
    
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
            <a href="{{ route('recepcionista.citasRecep') }}" class="menu-item active">
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
            <h1>Gestión de Citas</h1>
            <p>Administra la programación y el control de la agenda.</p>
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
        
        <!-- Botones de Acción y Filtros -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <button class="btn btn-gold me-2" data-bs-toggle="modal" data-bs-target="#modalNuevaCita">
                    <i class="bi bi-plus-circle"></i> Nueva Cita
                </button>
                <button class="btn btn-premium me-2" onclick="actualizarAgenda()">
                    <i class="bi bi-arrow-clockwise"></i> Actualizar
                </button>


                <button class="btn btn-outline-gold" onclick="imprimirAgenda()">
                    <i class="bi bi-printer"></i> Imprimir
                </button>
            </div>
            
           
                        
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Cards - Resumen de Citas -->
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
                    <h3 class="kpi-value">18</h3>
                    <p class="kpi-label">Citas Hoy</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> 12 completadas
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
                    <h3 class="kpi-value">6</h3>
                    <p class="kpi-label">Pendientes</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-exclamation-circle"></i> Sin confirmar
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
            WHERE DATE(fecha_hora) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-calendar-event"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">22</h3>
                    <p class="kpi-label">Citas Mañana</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-right"></i> Sábado 01 Nov
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
            AND estado = 'cancelada'
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-x-circle"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">2</h3>
                    <p class="kpi-label">Canceladas Hoy</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-info-circle"></i> Motivos varios
                    </span>
                </div>
            </div>
        </div>

        <!-- Agenda Completa de Estilistas -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-calendar3"></i>
                        Listado de citas
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT c.id, c.fecha_hora, c.estado, c.precio_total, c.notas,
                           u.nombre as cliente_nombre, u.apellido as cliente_apellido, 
                           u.telefono as cliente_telefono,
                           e.nombre as estilista_nombre, e.apellido as estilista_apellido,
                           s.nombre as servicio_nombre, s.duracion_minutos,
                           p.nombre as promocion_nombre, p.codigo_promocional
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
                                    <th>ID</th>
                                    <th>Hora</th>
                                    <th>Cliente</th>
                                    <th>Teléfono</th>
                                    <th>Servicio</th>
                                    <th>Estilista</th>
                                    <th>Duración</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablaCitas">
@foreach($citas as $cita)
<tr>
    <td><strong>#{{ str_pad($cita->idCita, 3, '0', STR_PAD_LEFT) }}</strong></td>
    <td><strong style="color: var(--borgona);">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</strong></td>
    <td>
        <div class="d-flex align-items-center">
            <div class="list-avatar me-2">{{ strtoupper(substr($cita->cliente->nombre, 0, 1)) }}</div>
            <strong>{{ $cita->cliente->nombre }} {{ $cita->cliente->apellido }}</strong>
        </div>
    </td>
    <td><small>{{ $cita->cliente->telefono }}</small></td>
    <td>
        @foreach($cita->servicios as $servicio)
            {{ $servicio->nombre }}<br>
        @endforeach
        @if($cita->promocion)
            <small style="color: var(--dorado-palido);">
                <i class="bi bi-gift"></i> {{ $cita->promocion->nombre }} - {{ $cita->promocion->codigoPromocional }}
            </small>
        @endif
    </td>
    <td>
        <div class="d-flex align-items-center">
            <div class="list-avatar me-1">{{ strtoupper(substr($cita->estilista->nombre, 0, 1)) }}</div>
            <small>{{ $cita->estilista->nombre }} {{ $cita->estilista->apellido }}</small>
        </div>
    </td>
    <td>{{ $cita->duracion }} min</td>
    <td>
        @php
            $estado = strtolower($cita->estado);
            $clase = match($estado) {
                'pendiente' => 'bg-warning text-dark',
                'confirmada' => 'bg-info',
                'en proceso' => 'bg-primary',
                'completada' => 'bg-success',
                'cancelada' => 'bg-danger',
                default => 'bg-secondary'
            };
        @endphp
        <span class="badge {{ $clase }}">{{ ucfirst($estado) }}</span>
    </td>
    <td>
        <button class="btn btn-sm btn-outline-gold me-1" onclick="verCita({{ $cita->idCita }})"><i class="bi bi-eye"></i></button>
        @if($estado === 'pendiente')
            <button class="btn btn-sm btn-premium me-1" onclick="confirmarCita({{ $cita->idCita }})"><i class="bi bi-telephone"></i></button>
        @elseif($estado === 'confirmada')
            <button class="btn btn-sm btn-premium me-1" onclick="iniciarCita({{ $cita->idCita }})"><i class="bi bi-play-circle"></i></button>
        @elseif($estado === 'en proceso')
            <button class="btn btn-sm btn-premium me-1" onclick="completarCita({{ $cita->idCita }})"><i class="bi bi-check-circle"></i></button>
        @endif
        <button class="btn btn-sm btn-gold" onclick="mostrarCancelar({{ $cita->idCita }})"><i class="bi bi-x-circle"></i></button>
    </td>
</tr>
@endforeach
</tbody>

                        </table>
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
        <p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer>

    <!-- ============================================
         MODAL: NUEVA CITA
         ============================================ -->
    <div class="modal fade" id="modalNuevaCita" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-plus-circle" style="color: var(--dorado-palido);"></i> 
                        Agendar Nueva Cita
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
                    - Cliente: requerido, existe en BD
                    - Servicio: requerido, existe y activo
                    - Estilista: requerido, existe y activo
                    - Fecha/Hora: requerida, futura, no conflicto
                    - Verificar disponibilidad de estilista
                    ================================================
                    -->
                    <form id="formNuevaCita" method="POST" action="{{ route('citas.store') }}">
                        @csrf
                        <div class="row g-3">
                            <!-- Cliente -->
                            <div class="col-12">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-person-circle"></i> Información del Cliente
                                </h6>
                            </div>

                            <div class="col-md-9">
                                <label class="form-label">Cliente *</label>
                                <select class="form-select" name="cliente_id" required>
                                    <option value="">Buscar cliente...</option>
                                    @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->idCliente }}">
                                    {{ $cliente->nombre }} {{ $cliente->apellido }} - {{ $cliente->telefono }}
                                    </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-3">
                                <label class="form-label">&nbsp;</label>
                               
                            </div>

                            <!-- Servicio -->
                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-scissors"></i> Servicio y Estilista
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Servicio *</label>
                                <select class="form-select" name="servicio_id" id="servicioSelect" onchange="actualizarDuracion()" required>
                                    <option value="">Seleccionar servicio...</option>
                                    @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->idServicio }}"
                                    data-duracion="{{ $servicio->duracionBase }}"
                                    data-precio="{{ $servicio->precioBase }}">
                                    {{ $servicio->nombre }} - ${{ number_format($servicio->precioBase, 2) }} ({{ $servicio->duracionBase }} min)
                                    </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estilista *</label>
                                <select class="form-select" name="estilista_id" required>
                                    <option value="">Seleccionar estilista...</option>
                                    @foreach($estilistas as $estilista)
                                    <option value="{{ $estilista->idEmpleado }}">
                                    {{ $estilista->nombre }} {{ $estilista->apellido }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>

                            <!-- Fecha y Hora -->
                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-calendar3"></i> Fecha y Hora
                                </h6>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Fecha *</label>
                                <input type="date" class="form-control" name="fecha" id="fechaFiltro" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Hora *</label>
                                <input type="time" class="form-control" name="hora" id="horaCita" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Duración Estimada</label>
                                <input type="text" class="form-control" id="duracionEstimada" value="-- min" readonly style="background: var(--champagne-light);">
                            </div>

                            <!-- Promoción -->
                            <div class="col-12 mt-4">
                                <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                                    <i class="bi bi-gift"></i> Promoción (Opcional)
                                </h6>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label">Código Promocional</label>
                                <input type="text" class="form-control" name="codigo_promocional" id="codigoPromo" placeholder="Ej: BLACK30, NUEVO10">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="button" class="btn btn-outline-gold w-100" onclick="validarPromocion()">
                                    <i class="bi bi-check-circle"></i> Validar Código
                                </button>
                            </div>

                            <div class="col-12" id="promoValidada" style="display: none;">
                                <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido);">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <strong style="color: var(--dorado-palido);">¡Promoción válida!</strong><br>
                                    <span id="promoDetalle"></span>
                                </div>
                            </div>

                            <!-- Notas -->
                            <div class="col-12">
                                <label class="form-label">Notas Adicionales</label>
                                <textarea class="form-control" name="notas" rows="2" placeholder="Observaciones, preferencias especiales, etc."></textarea>
                            </div>

                            <!-- Resumen -->
                            <div class="col-12 mt-4">
                                <div class="premium-card">
                                    <h6 style="margin-bottom: 1rem;">💰 Resumen de la Cita</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Precio Base:</p>
                                            <h5 style="color: var(--rosa-empolvado); margin: 0.5rem 0;" id="precioBase">$0.00</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Descuento:</p>
                                            <h5 style="color: var(--dorado-palido); margin: 0.5rem 0;" id="descuento">$0.00</h5>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Total a Pagar:</p>
                                            <h5 style="color: var(--dorado-palido); margin: 0.5rem 0; font-size: 1.5rem;" id="totalPagar">$0.00</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevaCita" class="btn btn-gold">
                        <i class="bi bi-save"></i> Agendar Cita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: EDITAR CITA
         ============================================ -->
    <div class="modal fade" id="modalEditarCita" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-pencil" style="color: var(--dorado-palido);"></i> 
                        Editar Cita #003
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Edición
                    ================================================
                    ACCIÓN: Enviar a ruta PUT /citas/{id}/actualizar
                    NOTA: Campos pre-llenados con datos actuales
                    ================================================
                    -->
                    <form id="formEditarCita">
                        <input type="hidden" name="cita_id" value="3">
                        <!-- Mismo contenido que formNuevaCita pero con valores -->
                        <p class="text-center">Formulario similar a Nueva Cita con datos pre-cargados</p>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formEditarCita" class="btn btn-gold">
                        <i class="bi bi-save"></i> Actualizar Cita
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: VER DETALLES DE CITA
         ============================================ -->
    <div class="modal fade" id="modalVerCita" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-info-circle" style="color: var(--dorado-palido);"></i> 
                        Detalles de la Cita #001
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="premium-card mb-3">
                        <h5>Cita Completada <span class="badge bg-success float-end">Completada</span></h5>
                        <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">
                            <i class="bi bi-calendar3"></i> Viernes, 31 de Octubre 2024 - 09:00 AM
                        </p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-person"></i> Cliente
                                </h6>
                                <p><strong>Nombre:</strong> María García López</p>
                                <p><strong>Teléfono:</strong> (503) 7890-1234</p>
                                <p><strong>Email:</strong> maria.garcia@email.com</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-scissors"></i> Servicio
                                </h6>
                                <p><strong>Servicio:</strong> Corte de Cabello</p>
                                <p><strong>Estilista:</strong> Ana López García</p>
                                <p><strong>Duración:</strong> 30 minutos</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card-custom">
                                <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1rem;">
                                    <i class="bi bi-cash-stack"></i> Información de Pago
                                </h6>
                                <p><strong>Precio Base:</strong> $15.00</p>
                                <p><strong>Descuento:</strong> $0.00</p>
                                <p><strong style="color: var(--borgona); font-size: 1.2rem;">Total Pagado:</strong> <strong style="color: var(--borgona); font-size: 1.2rem;">$15.00</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-outline-gold">
                        <i class="bi bi-printer"></i> Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        // Establecer fecha actual por defecto
        document.getElementById('fechaFiltro').value = new Date().toISOString().split('T')[0];
        const inputFecha = document.getElementById('fechaCita');
if (inputFecha) {
    inputFecha.value = new Date().toISOString().split('T')[0];
}


        function actualizarAgenda() {
            console.log('Actualizar agenda');
            location.reload();
        }

        function filtrarPorFecha() {
            const fecha = document.getElementById('fechaFiltro').value;
            console.log('Filtrar por fecha:', fecha);
            alert('Filtro por fecha - Conectar con backend');
        }

        function filtrarPorEstilista() {
            const estilista = document.getElementById('estilistaFiltro').value;
            console.log('Filtrar por estilista:', estilista);
            alert('Filtro por estilista - Conectar con backend');
        }

        function filtrarPorEstado() {
            const estado = document.getElementById('estadoFiltro').value;
            console.log('Filtrar por estado:', estado);
            alert('Filtro por estado - Conectar con backend');
        }

        function imprimirAgenda() {
            console.log('Imprimir agenda');
            window.print();
        }

        function cargarCita(citaId) {
            console.log('Cargar cita:', citaId);
        }

        function cargarEditarCita(citaId) {
            console.log('Cargar editar cita:', citaId);
        }

        function confirmarCita(citaId) {
            console.log('Confirmar cita:', citaId);
            alert('Enviar SMS/Email de confirmación - Conectar con backend');
        }

        function iniciarCita(citaId) {
            console.log('Iniciar cita:', citaId);
            if(confirm('¿Marcar esta cita como "En Proceso"?')) {
                alert('Cita iniciada - Conectar con backend');
            }
        }

        function completarCita(citaId) {
            console.log('Completar cita:', citaId);
            if(confirm('¿Marcar esta cita como "Completada"?')) {
                alert('Cita completada - Conectar con backend');
            }
        }

        function mostrarCancelar(citaId) {
            const motivo = prompt('¿Motivo de cancelación?');
            if(motivo) {
                console.log('Cancelar cita:', citaId, 'Motivo:', motivo);
                alert('Cita cancelada - Conectar con backend');
            }
        }

        function actualizarDuracion() {
            const select = document.getElementById('servicioSelect');
            const option = select.options[select.selectedIndex];
            const duracion = option.getAttribute('data-duracion');
            const precio = option.getAttribute('data-precio');
            
            if(duracion && precio) {
                document.getElementById('duracionEstimada').value = duracion + ' min';
                document.getElementById('precioBase').textContent = '$' + precio;
                document.getElementById('totalPagar').textContent = '$' + precio;
            }
        }

        function validarPromocion() {
            const codigo = document.getElementById('codigoPromo').value;
            if(!codigo) {
                alert('Ingrese un código promocional');
                return;
            }
            
            console.log('Validar promoción:', codigo);
            // TODO: Validar con backend
            
            // Simulación
            document.getElementById('promoValidada').style.display = 'block';
            document.getElementById('promoDetalle').textContent = '30% de descuento aplicado - Código: ' + codigo;
            document.getElementById('descuento').textContent = '$4.50';
            document.getElementById('totalPagar').textContent = '$10.50';
        }

        // Validación formulario nueva cita
        const form = document.getElementById('formNuevaCita');
if (form) { form.addEventListener('submit', function(e) { e.preventDefault();

        const cliente = this.querySelector('[name="cliente_id"]').value;
        const servicio = this.querySelector('[name="servicio_id"]').value;
        const estilista = this.querySelector('[name="estilista_id"]').value;
        const fecha = this.querySelector('[name="fecha"]').value;
        const hora = this.querySelector('[name="hora"]').value;

        if(!cliente || !servicio || !estilista || !fecha || !hora) {
            alert('Complete todos los campos requeridos');
            return;
        }
    });
}


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

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formNuevaCita');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                alert(result.message);

                // Opcional: cerrar modal y limpiar
                form.reset();
                document.getElementById('duracionEstimada').value = '-- min';
                document.getElementById('precioBase').textContent = '$0.00';
                document.getElementById('descuento').textContent = '$0.00';
                document.getElementById('totalPagar').textContent = '$0.00';
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevaCita'));
                modal.hide();
                location.reload();
                form.reset();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error al enviar la cita:', error);
            alert('Error inesperado al agendar la cita.');
        }
    });
});

function actualizarDuracion() {
    const select = document.getElementById('servicioSelect');
    const duracion = select.options[select.selectedIndex].getAttribute('data-duracion');
    const precio = select.options[select.selectedIndex].getAttribute('data-precio');

    document.getElementById('duracionEstimada').value = duracion + ' min';
    document.getElementById('precioBase').textContent = '$' + precio;
    document.getElementById('totalPagar').textContent = '$' + precio;
}

</script>

</body>
</html>