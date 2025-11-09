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
            </div>
            
           
                        
                        
                    </div>
                </div>
            </div>
        </div>

<!-- Citas de Hoy -->
         <div class="row g-4 mb-4">
<div class="col-xl-3 col-md-6">
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-icon primary">
                <i class="bi bi-calendar-check"></i>
            </div>
        </div>
        <h3 class="kpi-value">{{ $kpiCitas['totalHoy'] }}</h3>
        <p class="kpi-label">Citas Hoy</p>
        <span class="kpi-badge badge-success">
            <i class="bi bi-check-circle"></i> {{ $kpiCitas['completadasHoy'] }} completadas
        </span>
    </div>
</div>

<!-- Citas Pendientes -->
<div class="col-xl-3 col-md-6">
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-icon warning">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
        <h3 class="kpi-value">{{ $kpiCitas['pendientesHoy'] }}</h3>
        <p class="kpi-label">Pendientes</p>
        <span class="kpi-badge badge-neutral">
            <i class="bi bi-exclamation-circle"></i> Por atender
        </span>
    </div>
</div>

<!-- Citas Mañana -->
<div class="col-xl-3 col-md-6">
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-icon info">
                <i class="bi bi-calendar-event"></i>
            </div>
        </div>
        <h3 class="kpi-value">{{ $kpiCitas['totalManana'] }}</h3>
        <p class="kpi-label">Citas Mañana</p>
        <span class="kpi-badge badge-success">
            <i class="bi bi-arrow-right"></i> {{ $manana->format('l d M') }}
        </span>
    </div>
</div>

<!-- Canceladas Hoy -->
<div class="col-xl-3 col-md-6">
    <div class="kpi-card">
        <div class="kpi-header">
            <div class="kpi-icon success">
                <i class="bi bi-x-circle"></i>
            </div>
        </div>
        <h3 class="kpi-value">{{ $kpiCitas['canceladasHoy'] }}</h3>
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
        <button class="btn btn-sm btn-outline-gold me-1" onclick="editarCita({{ $cita->idCita }})" title="Editar Cita"><i class="bi bi-pencil-square"></i></button>

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
            data-precio="{{ $servicio->precioBase }}"
            data-requiere-largo="{{ $servicio->requiere_largo_cabello }}"
            data-requiere-tinturado="{{ $servicio->requiere_tinturado_previo }}"
            data-requiere-esmalte="{{ $servicio->requiere_retiro_esmalte }}"
            data-requiere-estilizado="{{ $servicio->requiere_estilizado }}"
            data-tiempo-largo="{{ $servicio->tiempo_adicional_largo }}"
            data-tiempo-tinturado="{{ $servicio->tiempo_adicional_tinturado }}"
            data-tiempo-esmalte="{{ $servicio->tiempo_adicional_esmalte }}"
            data-tiempo-estilizado="{{ $servicio->tiempo_adicional_estilizado }}">
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

<!-- ✅ CAMPOS DINÁMICOS PARA AJUSTES -->
<div class="col-12 mt-3" id="ajustesServicio" style="display: none;">
    <div class="card" style="background: var(--champagne-light); border: 1px solid var(--rosa-empolvado); padding: 1rem;">
        <h6 style="color: var(--borgona); margin-bottom: 1rem;">
            <i class="bi bi-sliders"></i> Ajustes del Servicio
        </h6>
        <div class="row g-3">
            <!-- Largo de cabello -->
            <div class="col-md-6" id="campo-largo" style="display: none;">
                <label class="form-label">Largo del Cabello</label>
                <select class="form-select" name="largo_cabello" id="largoCabello" onchange="recalcularDuracion()">
                    <option value="corto">Corto (sin costo adicional)</option>
                    <option value="medio">Medio (sin costo adicional)</option>
                    <option value="largo">Largo (+<span id="tiempo-largo">0</span> min)</option>
                </select>
            </div>
            
            <!-- Tinturado previo -->
            <div class="col-md-6" id="campo-tinturado" style="display: none;">
                <label class="form-label">¿Tinturado Previamente?</label>
                <select class="form-select" name="tinturado_previo" id="tinturadoPrevio" onchange="recalcularDuracion()">
                    <option value="0">No</option>
                    <option value="1">Sí (+<span id="tiempo-tinturado">0</span> min)</option>
                </select>
            </div>
            
            <!-- Retiro de esmalte -->
            <div class="col-md-6" id="campo-esmalte" style="display: none;">
                <label class="form-label">¿Requiere Retiro de Esmalte?</label>
                <select class="form-select" name="retiro_esmalte" id="retiroEsmalte" onchange="recalcularDuracion()">
                    <option value="0">No</option>
                    <option value="1">Sí (+<span id="tiempo-esmalte">0</span> min)</option>
                </select>
            </div>
            
            <!-- Con estilizado -->
            <div class="col-md-6" id="campo-estilizado" style="display: none;">
                <label class="form-label">¿Con Estilizado?</label>
                <select class="form-select" name="con_estilizado" id="conEstilizado" onchange="recalcularDuracion()">
                    <option value="0">No</option>
                    <option value="1">Sí (+<span id="tiempo-estilizado">0</span> min)</option>
                </select>
            </div>
        </div>
    </div>
</div>
                            <!--<div class="col-12 mt-4">
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

                            </div>-->

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
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloEditarCita">Editar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCita">
    <input type="hidden" name="cita_id" id="cita_id">

    <div class="row g-3">
        <!-- Cliente -->
        <div class="col-12">
            <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                <i class="bi bi-person-circle"></i> Información del Cliente
            </h6>
        </div>

        <div class="col-md-9">
            <label class="form-label">Cliente *</label>
            <select class="form-select" name="cliente_id" id="cliente_id" required>
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
            <select class="form-select" name="servicio_id" id="servicioSelectEditar" onchange="actualizarDuracionEditar()" required>
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
            <select class="form-select" name="estilista_id" id="estilista_id" required>
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
            <input type="date" class="form-control" name="fecha" id="fechaEditar" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Hora *</label>
            <input type="time" class="form-control" name="hora" id="horaEditar" required>
        </div>

        <div class="col-md-6">
    <label class="form-label">Estado de la Cita</label>
<select class="form-select" name="estado" id="estado">
    <option value="PENDIENTE">Pendiente</option>
    <option value="CONFIRMADA">Confirmada</option>
    <option value="EN_PROCESO">En Proceso</option>
    <option value="COMPLETADA">Completada</option>
    <option value="CANCELADA">Cancelada</option>
</select>
</div>


        <div class="col-md-4">
            <label class="form-label">Duración Estimada</label>
            <input type="text" class="form-control" id="duracionEstimadaEditar" value="-- min" readonly style="background: var(--champagne-light);">
        </div>

        <!-- Promoción -->
        <div class="col-12 mt-4">
            <h6 style="color: var(--borgona); font-weight: 600; border-bottom: 2px solid var(--rosa-empolvado); padding-bottom: 0.5rem;">
                <i class="bi bi-gift"></i> Promoción (Opcional)
            </h6>
        </div>

        <div class="col-md-8">
            <label class="form-label">Código Promocional</label>
            <input type="text" class="form-control" name="codigo_promocional" id="codigoPromoEditar" placeholder="Ej: BLACK30, NUEVO10">
        </div>

        <div class="col-md-4">
            <label class="form-label">&nbsp;</label>
            <button type="button" class="btn btn-outline-gold w-100" onclick="validarPromocionEditar()">
                <i class="bi bi-check-circle"></i> Validar Código
            </button>
        </div>

        <div class="col-12" id="promoValidadaEditar" style="display: none;">
            <div class="alert-custom" style="border-left: 5px solid var(--dorado-palido);">
                <i class="bi bi-check-circle-fill"></i>
                <strong style="color: var(--dorado-palido);">¡Promoción válida!</strong><br>
                <span id="promoDetalleEditar"></span>
            </div>
        </div>

        <!-- Notas -->
        <div class="col-12">
            <label class="form-label">Notas Adicionales</label>
            <textarea class="form-control" name="notas" id="notasEditar" rows="2" placeholder="Observaciones, preferencias especiales, etc."></textarea>
        </div>

        <!-- Resumen -->
        <div class="col-12 mt-4">
            <div class="premium-card">
                <h6 style="margin-bottom: 1rem;">💰 Resumen de la Cita</h6>
                <div class="row">
                    <div class="col-md-4">
                        <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Precio Base:</p>
                        <h5 style="color: var(--rosa-empolvado); margin: 0.5rem 0;" id="precioBaseEditar">$0.00</h5>
                    </div>
                    <div class="col-md-4">
                        <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Descuento:</p>
                        <h5 style="color: var(--dorado-palido); margin: 0.5rem 0;" id="descuentoEditar">$0.00</h5>
                    </div>
                    <div class="col-md-4">
                        <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Total a Pagar:</p>
                        <h5 style="color: var(--dorado-palido); margin: 0.5rem 0; font-size: 1.5rem;" id="totalPagarEditar">$0.00</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarCita" class="btn btn-gold">
                    <i class="bi bi-save"></i> Actualizar Cita
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
    // CONFIGURACIÓN INICIAL
    // ========================================
    
    document.addEventListener('DOMContentLoaded', function() {
        const fechaFiltro = document.getElementById('fechaFiltro');
        if (fechaFiltro) {
            fechaFiltro.value = new Date().toISOString().split('T')[0];
        }
        
        const nombre = localStorage.getItem('clienteNombre') || 'Cliente';
        const apellido = localStorage.getItem('clienteApellido') || '';
        const inicial = nombre.charAt(0).toUpperCase();

        const nombreSpan = document.getElementById('nombreCliente');
        if (nombreSpan) {
            nombreSpan.textContent = `${nombre} ${apellido}`;
        }

        const avatarDiv = document.getElementById('avatarInicial');
        if (avatarDiv) {
            avatarDiv.textContent = inicial;
        }
    });

    // ========================================
    // FUNCIONES DE FILTRADO
    // ========================================
    
    function actualizarAgenda() {
        location.reload();
    }

    function filtrarPorFecha() {
        const fecha = document.getElementById('fechaFiltro').value;
        console.log('Filtrar por fecha:', fecha);
    }

    function filtrarPorEstilista() {
        const estilista = document.getElementById('estilistaFiltro').value;
        console.log('Filtrar por estilista:', estilista);
    }

    function filtrarPorEstado() {
        const estado = document.getElementById('estadoFiltro').value;
        console.log('Filtrar por estado:', estado);
    }

    function imprimirAgenda() {
        window.print();
    }

    // ========================================
    // FUNCIONES PARA NUEVA CITA
    // ========================================
    
    function actualizarDuracion() {
        const select = document.getElementById('servicioSelect');
        const option = select.options[select.selectedIndex];
        const duracion = option.getAttribute('data-duracion');
        const precio = option.getAttribute('data-precio');
        
        if(duracion && precio) {
            document.getElementById('duracionEstimada').value = duracion + ' min';
            document.getElementById('precioBase').textContent = '$' + parseFloat(precio).toFixed(2);
            document.getElementById('descuento').textContent = '$0.00';
            document.getElementById('totalPagar').textContent = '$' + parseFloat(precio).toFixed(2);
            
            // Limpiar promoción si se cambia el servicio
            document.getElementById('codigoPromo').value = '';
            document.getElementById('promoValidada').style.display = 'none';
        }
    }

    async function validarPromocion() {
        const codigo = document.getElementById('codigoPromo').value;
        const servicioId = document.getElementById('servicioSelect').value;
        
        if(!codigo) {
            alert('Ingrese un código promocional');
            return;
        }
        
        if(!servicioId) {
            alert('Seleccione un servicio primero');
            return;
        }
        
        try {
            const response = await fetch('/recepcionista/promocion/validar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    codigo_promocional: codigo,
                    servicio_id: servicioId
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('promoValidada').style.display = 'block';
                document.getElementById('promoDetalle').textContent = 
                    `${data.promocion.nombre} - ${data.promocion.tipo === 'porcentaje' ? data.promocion.valor + '%' : '$' + data.promocion.valor} de descuento`;
                document.getElementById('descuento').textContent = '$' + data.precios.descuento;
                document.getElementById('totalPagar').textContent = '$' + data.precios.final;
            } else {
                alert(data.message);
                document.getElementById('promoValidada').style.display = 'none';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al validar la promoción');
        }
    }

    // Formulario de nueva cita
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('formNuevaCita');
        
        if (form) {
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
                        form.reset();
                        document.getElementById('duracionEstimada').value = '-- min';
                        document.getElementById('precioBase').textContent = '$0.00';
                        document.getElementById('descuento').textContent = '$0.00';
                        document.getElementById('totalPagar').textContent = '$0.00';
                        document.getElementById('promoValidada').style.display = 'none';
                        
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevaCita'));
                        modal.hide();
                        location.reload();
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error al enviar la cita:', error);
                    alert('Error inesperado al agendar la cita.');
                }
            });
        }
    });

    // ========================================
    // FUNCIONES PARA EDITAR CITA
    // ========================================
    
    function editarCita(idCita) {
        fetch(`/recepcionista/citas/${idCita}/editar`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('cita_id').value = data.idCita;
            document.getElementById('fechaEditar').value = data.fecha;
            document.getElementById('horaEditar').value = data.hora;
            document.getElementById('cliente_id').value = data.cliente_id;
            document.getElementById('estilista_id').value = data.estilista_id;
            document.getElementById('notasEditar').value = data.notas || '';
            
            // Normalizar estado a mayúsculas
            const estadoNormalizado = data.estado.toUpperCase();
            document.getElementById('estado').value = estadoNormalizado;
            
            const servicioSelect = document.getElementById('servicioSelectEditar');
            if (servicioSelect && data.servicio_id) {
                servicioSelect.value = data.servicio_id;
                actualizarDuracionEditar();
            }

            if (data.codigo_promocional) {
                document.getElementById('codigoPromoEditar').value = data.codigo_promocional;
            }

            document.getElementById('tituloEditarCita').textContent = 
                `Editar Cita de ${data.cliente_nombre} ${data.cliente_apellido}`;

            const modal = new bootstrap.Modal(document.getElementById('modalEditarCita'));
            modal.show();
        })
        .catch(error => {
            console.error('Error al cargar cita:', error);
            alert('No se pudo cargar la información de la cita.');
        });
    }

    function actualizarDuracionEditar() {
        const select = document.getElementById('servicioSelectEditar');
        const option = select.options[select.selectedIndex];
        const duracion = option.getAttribute('data-duracion');
        const precio = option.getAttribute('data-precio');

        if (duracion && precio) {
            document.getElementById('duracionEstimadaEditar').value = duracion + ' min';
            document.getElementById('precioBaseEditar').textContent = '$' + parseFloat(precio).toFixed(2);
            document.getElementById('descuentoEditar').textContent = '$0.00';
            document.getElementById('totalPagarEditar').textContent = '$' + parseFloat(precio).toFixed(2);
            
            // Limpiar promoción si se cambia el servicio
            document.getElementById('codigoPromoEditar').value = '';
            document.getElementById('promoValidadaEditar').style.display = 'none';
        }
    }

    async function validarPromocionEditar() {
        const codigo = document.getElementById('codigoPromoEditar').value;
        const servicioId = document.getElementById('servicioSelectEditar').value;
        
        if(!codigo) {
            alert('Ingrese un código promocional');
            return;
        }
        
        if(!servicioId) {
            alert('Seleccione un servicio primero');
            return;
        }
        
        try {
            const response = await fetch('/recepcionista/promocion/validar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    codigo_promocional: codigo,
                    servicio_id: servicioId
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('promoValidadaEditar').style.display = 'block';
                document.getElementById('promoDetalleEditar').textContent = 
                    `${data.promocion.nombre} - ${data.promocion.tipo === 'porcentaje' ? data.promocion.valor + '%' : '$' + data.promocion.valor} de descuento`;
                document.getElementById('descuentoEditar').textContent = '$' + data.precios.descuento;
                document.getElementById('totalPagarEditar').textContent = '$' + data.precios.final;
            } else {
                alert(data.message);
                document.getElementById('promoValidadaEditar').style.display = 'none';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al validar la promoción');
        }
    }

    // Formulario de editar cita
    document.addEventListener('DOMContentLoaded', function() {
        const formEditar = document.getElementById('formEditarCita');
        
        if (formEditar) {
            formEditar.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const citaId = document.getElementById('cita_id').value;
                const formData = new FormData(this);
                
                // Normalizar estado a mayúsculas
                const estado = formData.get('estado').toUpperCase();
                
                try {
                    const response = await fetch(`/recepcionista/citas/${citaId}/actualizar`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            cliente_id: formData.get('cliente_id'),
                            estilista_id: formData.get('estilista_id'),
                            fecha: formData.get('fecha'),
                            hora: formData.get('hora'),
                            servicio_id: formData.get('servicio_id'),
                            estado: estado,
                            notas: formData.get('notas'),
                            codigo_promocional: formData.get('codigo_promocional')
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert(result.message);
                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarCita'));
                        modal.hide();
                        location.reload();
                    } else {
                        alert('Error: ' + result.message);
                        if (result.errors) {
                            console.error('Errores de validación:', result.errors);
                        }
                    }
                } catch (error) {
                    console.error('Error al actualizar la cita:', error);
                    alert('Error inesperado al actualizar la cita.');
                }
            });
        }
    });

    // ========================================
    // FUNCIONES PARA CAMBIAR ESTADO DE CITAS
    // ========================================
    
    function actualizarEstadoCita(idCita, nuevoEstado) {
        fetch(`/recepcionista/citas/${idCita}/estado`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ estado: nuevoEstado })
        })
        .then(response => {
            if (!response.ok) throw new Error('Error al actualizar estado');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.mensaje);
                location.reload();
            } else {
                throw new Error(data.error || 'Error desconocido');
            }
        })
        .catch(error => {
            console.error(error);
            alert('No se pudo actualizar el estado de la cita: ' + error.message);
        });
    }

    function confirmarCita(idCita) {
        if (confirm('¿Confirmar esta cita?')) {
            actualizarEstadoCita(idCita, 'CONFIRMADA');
        }
    }

    function iniciarCita(idCita) {
        if (confirm('¿Marcar esta cita como "En Proceso"?')) {
            actualizarEstadoCita(idCita, 'EN_PROCESO');
        }
    }

    function completarCita(idCita) {
        if (confirm('¿Marcar esta cita como "Completada"?')) {
            actualizarEstadoCita(idCita, 'COMPLETADA');
        }
    }

    function mostrarCancelar(idCita) {
        const motivo = prompt('¿Motivo de cancelación?');
        if (motivo) {
            actualizarEstadoCita(idCita, 'CANCELADA');
        }
    }

    // ========================================
// FUNCIONES PARA AJUSTES DINÁMICOS
// ========================================

let tiemposAdicionales = {
    largo: 0,
    tinturado: 0,
    esmalte: 0,
    estilizado: 0
};

function actualizarDuracion() {
    const select = document.getElementById('servicioSelect');
    const option = select.options[select.selectedIndex];
    const duracion = option.getAttribute('data-duracion');
    const precio = option.getAttribute('data-precio');
    
    // Obtener configuraciones del servicio
    const requiereLargo = option.getAttribute('data-requiere-largo') == '1';
    const requiereTinturado = option.getAttribute('data-requiere-tinturado') == '1';
    const requiereEsmalte = option.getAttribute('data-requiere-esmalte') == '1';
    const requiereEstilizado = option.getAttribute('data-requiere-estilizado') == '1';
    
    // Guardar tiempos adicionales
    tiemposAdicionales.largo = parseInt(option.getAttribute('data-tiempo-largo')) || 0;
    tiemposAdicionales.tinturado = parseInt(option.getAttribute('data-tiempo-tinturado')) || 0;
    tiemposAdicionales.esmalte = parseInt(option.getAttribute('data-tiempo-esmalte')) || 0;
    tiemposAdicionales.estilizado = parseInt(option.getAttribute('data-tiempo-estilizado')) || 0;
    
    // Actualizar textos de tiempo adicional
    document.getElementById('tiempo-largo').textContent = tiemposAdicionales.largo;
    document.getElementById('tiempo-tinturado').textContent = tiemposAdicionales.tinturado;
    document.getElementById('tiempo-esmalte').textContent = tiemposAdicionales.esmalte;
    document.getElementById('tiempo-estilizado').textContent = tiemposAdicionales.estilizado;
    
    // Mostrar/ocultar campos según configuración
    const ajustesDiv = document.getElementById('ajustesServicio');
    const campoLargo = document.getElementById('campo-largo');
    const campoTinturado = document.getElementById('campo-tinturado');
    const campoEsmalte = document.getElementById('campo-esmalte');
    const campoEstilizado = document.getElementById('campo-estilizado');
    
    // Resetear campos
    campoLargo.style.display = 'none';
    campoTinturado.style.display = 'none';
    campoEsmalte.style.display = 'none';
    campoEstilizado.style.display = 'none';
    
    // Mostrar solo los campos necesarios
    let mostrarAjustes = false;
    if (requiereLargo) {
        campoLargo.style.display = 'block';
        mostrarAjustes = true;
    }
    if (requiereTinturado) {
        campoTinturado.style.display = 'block';
        mostrarAjustes = true;
    }
    if (requiereEsmalte) {
        campoEsmalte.style.display = 'block';
        mostrarAjustes = true;
    }
    if (requiereEstilizado) {
        campoEstilizado.style.display = 'block';
        mostrarAjustes = true;
    }
    
    ajustesDiv.style.display = mostrarAjustes ? 'block' : 'none';
    
    // Actualizar duración y precio
    if(duracion && precio) {
        document.getElementById('duracionEstimada').value = duracion + ' min';
        document.getElementById('precioBase').textContent = '$' + parseFloat(precio).toFixed(2);
        document.getElementById('descuento').textContent = '$0.00';
        document.getElementById('totalPagar').textContent = '$' + parseFloat(precio).toFixed(2);
        
        // Limpiar promoción
        document.getElementById('codigoPromo').value = '';
        document.getElementById('promoValidada').style.display = 'none';
    }
}

function recalcularDuracion() {
    const select = document.getElementById('servicioSelect');
    const option = select.options[select.selectedIndex];
    const duracionBase = parseInt(option.getAttribute('data-duracion')) || 0;
    
    let tiempoAdicionalTotal = 0;
    
    // Largo de cabello
    const largoCabello = document.getElementById('largoCabello')?.value;
    if (largoCabello === 'largo') {
        tiempoAdicionalTotal += tiemposAdicionales.largo;
    }
    
    // Tinturado previo
    const tinturado = document.getElementById('tinturadoPrevio')?.value;
    if (tinturado == '1') {
        tiempoAdicionalTotal += tiemposAdicionales.tinturado;
    }
    
    // Retiro de esmalte
    const esmalte = document.getElementById('retiroEsmalte')?.value;
    if (esmalte == '1') {
        tiempoAdicionalTotal += tiemposAdicionales.esmalte;
    }
    
    // Con estilizado
    const estilizado = document.getElementById('conEstilizado')?.value;
    if (estilizado == '1') {
        tiempoAdicionalTotal += tiemposAdicionales.estilizado;
    }
    
    const duracionTotal = duracionBase + tiempoAdicionalTotal;
    document.getElementById('duracionEstimada').value = duracionTotal + ' min' + 
        (tiempoAdicionalTotal > 0 ? ` (base: ${duracionBase} + adicional: ${tiempoAdicionalTotal})` : '');
}
</script>

</body>
</html>