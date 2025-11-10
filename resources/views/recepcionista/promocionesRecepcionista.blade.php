<!DOCTYPE html>
<html lang="es">
@php
    use Carbon\Carbon;
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Promociones Recepcionista | Salón de Belleza</title>

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
        <nav class="sidebar-menu">
            <a href="{{ route('recepcionista.dashboardRecep') }}" class="menu-item">
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
            <a href="{{ route('recepcionista.promocionesRecep') }}" class="menu-item active">
                <i class="bi bi-gift"></i> Promociones
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Gestión de Promociones</h1>
            <p>Administra promociones y combos.</p>
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
                <button class="btn btn-gold me-2" data-bs-toggle="modal" data-bs-target="#modalNuevaPromocion">
                    <i class="bi bi-plus-circle"></i> Nueva Promoción
                </button>
                <button class="btn btn-premium me-2" data-bs-toggle="modal" data-bs-target="#modalNuevoCombo">
                    <i class="bi bi-box-seam"></i> Nuevo Combo
                </button>
            </div>
        </div>

<!-- KPI Cards - Resumen de Promociones -->
<div class="row g-4 mb-4">

    <!-- Promociones activas -->
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-header">
                <div class="kpi-icon primary">
                    <i class="bi bi-gift-fill"></i>
                </div>
            </div>
            <h3 class="kpi-value">{{ $promocionesActivas }}</h3>
            <p class="kpi-label">Promociones Activas</p>
            <span class="kpi-badge badge-success">
                <i class="bi bi-check-circle"></i> Vigentes
            </span>
        </div>
    </div>

    <!-- Combos disponibles -->
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-header">
                <div class="kpi-icon success">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
            </div>
            <h3 class="kpi-value">{{ $combosDisponibles }}</h3>
            <p class="kpi-label">Combos Disponibles</p>
            <span class="kpi-badge badge-success">
                <i class="bi bi-check-circle"></i> Activos
            </span>
        </div>
    </div>

    <!-- Usos de promociones este mes -->
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-header">
                <div class="kpi-icon info">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
            </div>
            <h3 class="kpi-value">{{ $usosEsteMes }}</h3>
            <p class="kpi-label">Usos Este Mes</p>
            <span class="kpi-badge badge-success">
                <i class="bi bi-arrow-up"></i> +15%
            </span>
        </div>
    </div>

    <!-- Descuentos otorgados -->
    <div class="col-xl-3 col-md-6">
        <div class="kpi-card">
            <div class="kpi-header">
                <div class="kpi-icon warning">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <h3 class="kpi-value">${{ number_format($descuentosOtorgados, 2) }}</h3>
            <p class="kpi-label">Descuentos Otorgados</p>
            <span class="kpi-badge badge-success">
                <i class="bi bi-graph-up-arrow"></i> Este Mes
            </span>
        </div>
    </div>

</div>

        <!-- Promociones Activas -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-gift-fill"></i>
                        Promociones Activas
                    </h5>
                    
                    <!-- 
                    ================================================
                    TODO BACKEND: Conectar con BD
                    ================================================
                    CONSULTA SQL:
                    SELECT id, nombre, descripcion, tipo_descuento, 
                           valor_descuento, fecha_inicio, fecha_fin, 
                           codigo_promocional, usos_maximos, usos_actuales, activo
                    FROM promociones 
                    WHERE activo = 1
                    ORDER BY fecha_inicio DESC
                    ================================================
                    -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Descuento</th>
                                    <th>Código</th>
                                    <th>Vigencia</th>
                                    <th>Usos</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
<tbody>
    @forelse($promociones as $promocion)
    <tr @if(!$promocion->activo || $promocion->fechaFin < now()) style="opacity: 0.6;" @endif>
        <td>#P{{ str_pad($promocion->idPromocion, 3, '0', STR_PAD_LEFT) }}</td>
        <td><strong>{{ $promocion->nombre }}</strong></td>
        <td>
            <span class="badge badge-luxury">
                {{ strtoupper($promocion->tipoDescuento) }}
            </span>
        </td>
        <td>
            <span class="badge badge-gold">
                @if($promocion->tipoDescuento == 'porcentaje')
                    {{ $promocion->valorDescuento }}% OFF
                @else
                    ${{ number_format($promocion->valorDescuento, 2) }} OFF
                @endif
            </span>
        </td>
        <td>
            <code style="background: var(--rosa-empolvado); color: var(--borgona); padding: 0.25rem 0.5rem; border-radius: 5px; font-weight: 600;">
                {{ $promocion->codigoPromocional }}
            </code>
        </td>
        <td>{{ $promocion->fechaInicio->format('d M') }} - {{ $promocion->fechaFin->format('d M Y') }}</td>
        <td>
            <div style="font-size: 0.875rem;">
                @if($promocion->usosMaximos)
                    <strong style="color: var(--borgona);">{{ $promocion->usosActuales }}</strong> / {{ $promocion->usosMaximos }}
                    <div style="width: 100%; background: var(--rosa-empolvado); height: 5px; border-radius: 3px; margin-top: 3px;">
                        <div style="width: {{ ($promocion->usosActuales / $promocion->usosMaximos) * 100 }}%; background: var(--dorado-palido); height: 5px; border-radius: 3px;"></div>
                    </div>
                @else
                    <strong style="color: var(--borgona);">∞</strong> Ilimitado
                @endif
            </div>
        </td>
        <td>
            @if($promocion->activo && $promocion->fechaFin >= now())
                <span class="badge bg-success">Activa</span>
            @elseif($promocion->fechaFin < now())
                <span class="badge bg-danger">Expirada</span>
            @else
                <span class="badge bg-secondary">Inactiva</span>
            @endif
        </td>
        <td>
<button class="btn btn-sm btn-soft me-1 btnEditarPromocion" 
        title="Editar"
        data-bs-toggle="modal" 
        data-bs-target="#modalEditarPromocion"
        data-id="{{ $promocion->idPromocion }}"
        data-nombre="{{ $promocion->nombre }}"
        data-descripcion="{{ $promocion->descripcion }}"
        data-tipo="{{ $promocion->tipoDescuento }}"
        data-valor="{{ $promocion->valorDescuento }}"
        data-codigo="{{ $promocion->codigoPromocional }}"
        data-fecha-inicio="{{ \Carbon\Carbon::parse($promocion->fechaInicio)->format('Y-m-d') }}"
        data-fecha-fin="{{ \Carbon\Carbon::parse($promocion->fechaFin)->format('Y-m-d') }}"
        data-usos-maximos="{{ $promocion->usosMaximos }}"
        data-usos-cliente="{{ $promocion->usosPorCliente }}"
        data-dias="$promocion->diasAplicables ?? []"
        data-activo="{{ $promocion->activo }}">
    <i class="bi bi-pencil"></i>
</button>

            <button class="btn btn-sm {{ $promocion->activo ? 'btn-premium' : 'btn-gold' }}" 
                    onclick="togglePromocion({{ $promocion->idPromocion }})" 
                    title="{{ $promocion->activo ? 'Desactivar' : 'Activar' }}">
                <i class="bi bi-toggle-{{ $promocion->activo ? 'on' : 'off' }}"></i>
            </button>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="text-center">
            <p class="text-muted my-3">No hay promociones registradas</p>
        </td>
    </tr>
    @endforelse
</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combos de Servicios -->
<div class="row g-4">
    <div class="col-12">
        <div class="card-custom">
            <h5 class="card-title-custom">
                <i class="bi bi-box-seam-fill"></i>
                Combos de Servicios
            </h5>

            <!-- Fila de combos -->
            <div class="row g-4">
                @forelse($combos as $combo)
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="list-item-custom" 
                             style="flex-direction: column; align-items: flex-start; @if(!$combo->activo) opacity: 0.6; @endif">
                             
                            <div class="d-flex align-items-center justify-content-between w-100 mb-3">
                                <div>
                                    <h5 style="color: var(--borgona); margin: 0; font-weight: 700;">
                                        <i class="bi bi-box-seam" style="color: var(--dorado-palido);"></i>
                                        {{ $combo->nombre }}
                                    </h5>
                                    <span class="badge {{ $combo->activo ? 'bg-success' : 'bg-secondary' }} mt-2">
                                        {{ $combo->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>

                                <div class="text-end">
                                    <div style="text-decoration: line-through; color: var(--borgona); opacity: 0.6; font-size: 0.9rem;">
                                        ${{ number_format($combo->precioRegular, 2) }}
                                    </div>
                                    <div style="font-size: 2rem; font-weight: 700; color: var(--dorado-palido);">
                                        ${{ number_format($combo->precioCombo, 2) }}
                                    </div>
                                    <span class="badge badge-gold" style="font-size: 0.75rem;">
                                        Ahorra ${{ number_format($combo->ahorro, 2) }}
                                    </span>
                                </div>
                            </div>

                            <p style="color: var(--negro-carbon); opacity: 0.8; margin-bottom: 1rem;">
                                {{ $combo->descripcion }}
                            </p>

                            <div class="alert-custom w-100" style="margin-bottom: 1rem;">
                                <i class="bi bi-list-check"></i>
                                <strong>Servicios incluidos:</strong><br>
                                @foreach($combo->servicios as $servicio)
                                    • {{ $servicio->nombre }} ({{ $servicio->duracionBase }} min)<br>
                                @endforeach
                            </div>

                            <div class="d-flex gap-2 w-100">
<button class="btn btn-soft btn-sm flex-fill btnEditarCombo" 
        data-bs-toggle="modal" 
        data-bs-target="#modalEditarCombo"
        data-id="{{ $combo->idCombo }}">
    <i class="bi bi-pencil"></i> Editar
</button>
                                <button class="btn btn-sm {{ $combo->activo ? 'btn-premium' : 'btn-gold' }}" 
                                        onclick="toggleCombo({{ $combo->idCombo }})">
                                    <i class="bi bi-toggle-{{ $combo->activo ? 'on' : 'off' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted my-3">No hay combos registrados</p>
                    </div>
                @endforelse
            </div>
            <!-- Fin fila combos -->
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
         MODAL: NUEVA PROMOCIÓN
         ============================================ -->
    <div class="modal fade" id="modalNuevaPromocion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-gift-fill" style="color: var(--dorado-palido);"></i> 
                        Nueva Promoción
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Creación de Promoción
                    ================================================
                    ACCIÓN: Enviar a ruta POST /promociones/crear
                    TABLA: promociones
                    CAMPOS: nombre, descripcion, tipo_descuento, valor_descuento,
                            fecha_inicio, fecha_fin, codigo_promocional, 
                            usos_maximos, dias_aplicables, servicios_aplicables
                    ================================================
                    -->
                    <form id="formNuevaPromocion">
                        @csrf <!-- Token CSRF para seguridad -->
                        <div class="row g-3">
                            <!-- Nombre -->
                            <div class="col-md-8">
                                <label class="form-label">Nombre de la Promoción *</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej: Black Friday Beauty" required>
                            </div>

                            <!-- Código Promocional -->
                            <div class="col-md-4">
                                <label class="form-label">Código Promocional *</label>
                                <input type="text" class="form-control" name="codigoPromocional" placeholder="Ej: BLACK30" required style="text-transform: uppercase;">
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" name="descripcion" rows="2" placeholder="Descripción de la promoción..."></textarea>
                            </div>

                            <!-- Tipo de Descuento -->
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Descuento *</label>
                                <select class="form-select" name="tipoDescuento" id="tipoDescuento" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="porcentaje">Porcentaje (%)</option>
                                    <option value="fijo">Monto Fijo ($)</option>
                                </select>
                            </div>

                            <!-- Valor del Descuento -->
                            <div class="col-md-6">
                                <label class="form-label">Valor del Descuento *</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="simboloDescuento" style="background: var(--dorado-palido); color: var(--borgona); border: 2px solid var(--dorado-palido); font-weight: 700;">%</span>
                                    <input type="number" class="form-control" name="valorDescuento" placeholder="0" step="0.01" min="0" required>
                                </div>
                            </div>

                            <!-- Fecha Inicio -->
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Inicio *</label>
                                <input type="date" class="form-control" name="fechaInicio" required>
                            </div>

                            <!-- Fecha Fin -->
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Fin *</label>
                                <input type="date" class="form-control" name="fechaFin" required>
                            </div>

                            <!-- Usos Máximos -->
                            <div class="col-md-6">
                                <label class="form-label">Usos Máximos</label>
                                <input type="number" class="form-control" name="usosMaximos" placeholder="Dejar vacío para ilimitado" min="1">
                                <small class="text-muted">Si se deja vacío, la promoción será ilimitada</small>
                            </div>

                            <!-- Usos por Cliente -->
                            <div class="col-md-6">
                                <label class="form-label">Usos por Cliente</label>
                                <input type="number" class="form-control" name="usosPorCliente" placeholder="1" value="1" min="1">
                            </div>

                            <!-- Días Aplicables -->
                            <div class="col-12">
                                <label class="form-label">Días Aplicables</label>
                                <div class="alert-custom">
                                    <i class="bi bi-calendar3"></i>
                                    <strong>Selecciona los días en que aplica esta promoción:</strong>
                                </div>
                                <div class="row g-2 mt-2">
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="lunes" id="lunes">
                                            <label class="form-check-label" for="lunes">Lunes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="martes" id="martes">
                                            <label class="form-check-label" for="martes">Martes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="miercoles" id="miercoles">
                                            <label class="form-check-label" for="miercoles">Miércoles</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="jueves" id="jueves">
                                            <label class="form-check-label" for="jueves">Jueves</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="viernes" id="viernes">
                                            <label class="form-check-label" for="viernes">Viernes</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="sabado" id="sabado">
                                            <label class="form-check-label" for="sabado">Sábado</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="dias[]" value="domingo" id="domingo">
                                            <label class="form-check-label" for="domingo">Domingo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" class="btn btn-sm btn-soft w-100" onclick="seleccionarTodosDias()">
                                            <i class="bi bi-check-all"></i> Todos
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="activo" id="activoPromo" checked>
                                    <label class="form-check-label" for="activoPromo">
                                        Activar promoción inmediatamente
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevaPromocion" class="btn btn-gold">
                        <i class="bi bi-save"></i> Crear Promoción
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: NUEVO COMBO
         ============================================ -->
    <div class="modal fade" id="modalNuevoCombo" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-box-seam-fill" style="color: var(--dorado-palido);"></i> 
                        Nuevo Combo de Servicios
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Creación de Combo
                    ================================================
                    ACCIÓN: Enviar a ruta POST /combos/crear
                    TABLAS: combos, combo_servicios
                    ================================================
                    -->
                    <form id="formNuevoCombo">
                        <div class="row g-3">
                            <!-- Nombre del Combo -->
                            <div class="col-md-8">
                                <label class="form-label">Nombre del Combo *</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej: Combo Novia Perfecta" required>
                            </div>

                            <!-- Estado -->
                            <div class="col-md-4">
                                <label class="form-label">Estado *</label>
                                <select class="form-select" name="activo" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label class="form-label">Descripción del Combo</label>
                                <textarea class="form-control" name="descripcion" rows="2" placeholder="Descripción atractiva del combo..."></textarea>
                            </div>

                            <div class="col-12">
                                <div class="divider-luxury"></div>
                            </div>

                            <!-- Selección de Servicios -->
                            <div class="col-12">
                                <div class="alert-custom">
                                    <i class="bi bi-info-circle"></i>
                                    <strong>Selecciona los servicios que incluye este combo:</strong>
                                </div>
                            </div>

                            <!-- 
                            ================================================
                            TODO BACKEND: Cargar servicios disponibles
                            ================================================
                            CONSULTA SQL:
                            SELECT id, nombre, precio, duracion_minutos 
                            FROM servicios 
                            WHERE activo = 1
                            ORDER BY categoria, nombre
                            ================================================
                            -->
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table-custom">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">
                                                    <input type="checkbox" id="selectAll" onchange="toggleAllServicios()">
                                                </th>
                                                <th>Servicio</th>
                                                <th>Precio</th>
                                                <th>Duración</th>
                                            </tr>
                                        </thead>
<tbody>
    @foreach($servicios as $servicio)
    <tr>
        <td>
            <input class="form-check-input servicio-check" 
                   type="checkbox" 
                   name="servicios[]" 
                   value="{{ $servicio->idServicio }}" 
                   data-precio="{{ $servicio->precioBase }}">
        </td>
        <td>{{ $servicio->nombre }}</td>
        <td><span class="badge badge-gold">${{ number_format($servicio->precioBase, 2) }}</span></td>
        <td>{{ $servicio->duracionBase }} min</td>
    </tr>
    @endforeach
</tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="divider-luxury"></div>
                            </div>

                            <!-- Resumen de Precios -->
                            <div class="col-12">
                                <div class="premium-card">
                                    <h3 style="margin-bottom: 1.5rem;">💰 Resumen de Precios</h3>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Precio Regular Total:</p>
                                            <h4 style="color: var(--rosa-empolvado); margin: 0.5rem 0;" id="precioRegularTotal">$0.00</h4>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" style="color: var(--blanco-humo);">Precio del Combo *</label>
                                            <div class="input-group">
                                                <span class="input-group-text" style="background: var(--dorado-palido); color: var(--borgona); border: 2px solid var(--dorado-palido); font-weight: 700;">$</span>
                                                <input type="number" class="form-control" name="precioCombo" id="precioCombo" placeholder="0.00" step="0.01" min="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Ahorro para el Cliente:</p>
                                            <h4 style="color: var(--dorado-palido); margin: 0.5rem 0;" id="ahorroTotal">$0.00</h4>
                                            <p style="color: var(--blanco-humo); opacity: 0.7; font-size: 0.875rem; margin: 0;" id="porcentajeAhorro">0% de descuento</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevoCombo" class="btn btn-premium">
                        <i class="bi bi-save"></i> Crear Combo
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: EDITAR PROMOCIÓN
         ============================================ -->
    <div class="modal fade" id="modalEditarPromocion" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-pencil" style="color: var(--dorado-palido);"></i> 
                        Editar Promoción
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
<form id="formEditarPromocion" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="promocionId" id="edit_promocionId">

    <div class="row g-3">
        <!-- Nombre -->
        <div class="col-md-8">
            <label class="form-label">Nombre de la Promoción *</label>
            <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
        </div>

        <!-- Código Promocional -->
        <div class="col-md-4">
            <label class="form-label">Código Promocional *</label>
            <input type="text" class="form-control" name="codigoPromocional" id="edit_codigo" required style="text-transform: uppercase;">
        </div>

        <!-- Descripción -->
        <div class="col-12">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" id="edit_descripcion" rows="2"></textarea>
        </div>

        <!-- Tipo de Descuento -->
        <div class="col-md-6">
            <label class="form-label">Tipo de Descuento *</label>
            <select class="form-select" name="tipoDescuento" id="edit_tipo" required>
                <option value="">Seleccionar...</option>
                <option value="porcentaje">Porcentaje (%)</option>
                <option value="fijo">Monto Fijo ($)</option>
            </select>
        </div>

        <!-- Valor del Descuento -->
        <div class="col-md-6">
            <label class="form-label">Valor del Descuento *</label>
            <div class="input-group">
                <span class="input-group-text" id="simboloDescuentoEdit" style="background: var(--dorado-palido); color: var(--borgona); border: 2px solid var(--dorado-palido); font-weight: 700;">%</span>
                <input type="number" class="form-control" name="valorDescuento" id="edit_valor" step="0.01" min="0" required>
            </div>
        </div>

        <!-- Fecha Inicio -->
        <div class="col-md-6">
            <label class="form-label">Fecha de Inicio *</label>
            <input type="date" class="form-control" name="fechaInicio" id="edit_fechaInicio" required>
        </div>

        <!-- Fecha Fin -->
        <div class="col-md-6">
            <label class="form-label">Fecha de Fin *</label>
            <input type="date" class="form-control" name="fechaFin" id="edit_fechaFin" required>
        </div>

        <!-- Usos Máximos -->
        <div class="col-md-6">
            <label class="form-label">Usos Máximos</label>
            <input type="number" class="form-control" name="usosMaximos" id="edit_usosMaximos" placeholder="Dejar vacío para ilimitado" min="1">
            <small class="text-muted">Si se deja vacío, la promoción será ilimitada</small>
        </div>

        <!-- Usos por Cliente -->
        <div class="col-md-6">
            <label class="form-label">Usos por Cliente *</label>
            <input type="number" class="form-control" name="usosPorCliente" id="edit_usosCliente" placeholder="1" min="1" required>
        </div>

        <!-- Días Aplicables -->
        <div class="col-12">
            <label class="form-label">Días Aplicables</label>
            <div class="alert-custom">
                <i class="bi bi-calendar3"></i>
                <strong>Selecciona los días en que aplica esta promoción:</strong>
            </div>
            <div class="row g-2 mt-2">
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" value="lunes" id="edit_lunes">
                        <label class="form-check-label" for="edit_lunes">Lunes</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" value="martes" id="edit_martes">
                        <label class="form-check-label" for="edit_martes">Martes</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" value="miercoles" id="edit_miercoles">
                        <label class="form-check-label" for="edit_miercoles">Miércoles</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" value="jueves" id="edit_jueves">
                        <label class="form-check-label" for="edit_jueves">Jueves</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" value="viernes" id="edit_viernes">
                        <label class="form-check-label" for="edit_viernes">Viernes</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" value="sabado" id="edit_sabado">
                        <label class="form-check-label" for="edit_sabado">Sábado</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="dias[]" value="domingo" id="edit_domingo">
                        <label class="form-check-label" for="edit_domingo">Domingo</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado -->
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="activo" id="edit_activo">
                <label class="form-check-label" for="edit_activo">
                    Activar promoción
                </label>
            </div>
        </div>
    </div>
</form>

                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formEditarPromocion" class="btn btn-gold">
                        <i class="bi bi-save"></i> Actualizar Promoción
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
     MODAL: EDITAR COMBO
     ============================================ -->
<div class="modal fade" id="modalEditarCombo" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
            <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                    <i class="bi bi-pencil" style="color: var(--dorado-palido);"></i> 
                    Editar Combo de Servicios
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCombo">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="comboId" id="edit_comboId">
                    
                    <div class="row g-3">
                        <!-- Nombre del Combo -->
                        <div class="col-md-8">
                            <label class="form-label">Nombre del Combo *</label>
                            <input type="text" class="form-control" name="nombre" id="edit_combo_nombre" placeholder="Ej: Combo Novia Perfecta" required>
                        </div>

                        <!-- Estado -->
                        <div class="col-md-4">
                            <label class="form-label">Estado *</label>
                            <select class="form-select" name="activo" id="edit_combo_activo" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <!-- Descripción -->
                        <div class="col-12">
                            <label class="form-label">Descripción del Combo</label>
                            <textarea class="form-control" name="descripcion" id="edit_combo_descripcion" rows="2" placeholder="Descripción atractiva del combo..."></textarea>
                        </div>

                        <div class="col-12">
                            <div class="divider-luxury"></div>
                        </div>

                        <!-- Selección de Servicios -->
                        <div class="col-12">
                            <div class="alert-custom">
                                <i class="bi bi-info-circle"></i>
                                <strong>Selecciona los servicios que incluye este combo:</strong>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table-custom">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">
                                                <input type="checkbox" id="selectAllEdit" onchange="toggleAllServiciosEdit()">
                                            </th>
                                            <th>Servicio</th>
                                            <th>Precio</th>
                                            <th>Duración</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($servicios as $servicio)
                                        <tr>
                                            <td>
                                                <input class="form-check-input servicio-check-edit" 
                                                       type="checkbox" 
                                                       name="servicios[]" 
                                                       value="{{ $servicio->idServicio }}" 
                                                       data-precio="{{ $servicio->precioBase }}">
                                            </td>
                                            <td>{{ $servicio->nombre }}</td>
                                            <td><span class="badge badge-gold">${{ number_format($servicio->precioBase, 2) }}</span></td>
                                            <td>{{ $servicio->duracionBase }} min</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="divider-luxury"></div>
                        </div>

                        <!-- Resumen de Precios -->
                        <div class="col-12">
                            <div class="premium-card">
                                <h3 style="margin-bottom: 1.5rem;">💰 Resumen de Precios</h3>
                                <div class="row">
                                    <div class="col-md-4">
                                        <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Precio Regular Total:</p>
                                        <h4 style="color: var(--rosa-empolvado); margin: 0.5rem 0;" id="precioRegularTotalEdit">$0.00</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" style="color: var(--blanco-humo);">Precio del Combo *</label>
                                        <div class="input-group">
                                            <span class="input-group-text" style="background: var(--dorado-palido); color: var(--borgona); border: 2px solid var(--dorado-palido); font-weight: 700;">$</span>
                                            <input type="number" class="form-control" name="precioCombo" id="precioComboEdit" placeholder="0.00" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p style="color: var(--blanco-humo); opacity: 0.8; margin: 0;">Ahorro para el Cliente:</p>
                                        <h4 style="color: var(--dorado-palido); margin: 0.5rem 0;" id="ahorroTotalEdit">$0.00</h4>
                                        <p style="color: var(--blanco-humo); opacity: 0.7; font-size: 0.875rem; margin: 0;" id="porcentajeAhorroEdit">0% de descuento</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formEditarCombo" class="btn btn-premium">
                    <i class="bi bi-save"></i> Actualizar Combo
                </button>
            </div>
        </div>
    </div>
</div>
    <!-- ============================================
         FIN MODALES
         ============================================ -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Scripts -->
<script>
// ========================================
// CREAR NUEVA PROMOCIÓN
// ========================================
document.getElementById('formNuevaPromocion')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfToken) {
        Swal.fire({
            icon: 'error',
            title: 'Error de seguridad',
            text: 'No se encontró el token CSRF. Recarga la página.'
        });
        return;
    }

    const formData = new FormData(form);
    const activoCheckbox = form.querySelector('[name="activo"]');
    if (activoCheckbox) {
        formData.set('activo', activoCheckbox.checked ? '1' : '0');
    }

    const data = {};
    formData.forEach((value, key) => {
        if (key === 'dias[]') {
            if (!data.dias) data.dias = [];
            data.dias.push(value);
        } else {
            data[key] = value;
        }
    });

    fetch('/admin/promociones', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        if (!response.ok) {
            const errorData = await response.json();
            const mensaje = Object.values(errorData.errors || {}).flat().join('\n') || 'Error al crear promoción.';
            throw new Error(mensaje);
        }
        return response.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Promoción creada',
            text: 'La promoción fue creada correctamente',
            timer: 2000,
            showConfirmButton: false
        });

        const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevaPromocion'));
        modal.hide();
        form.reset();

        setTimeout(() => location.reload(), 2000);
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error al crear promoción',
            text: error.message || 'Ocurrió un error inesperado'
        });
    });
});

// ========================================
// CARGAR DATOS AL MODAL DE EDICIÓN DE PROMOCIÓN
// ========================================
document.querySelectorAll('.btnEditarPromocion').forEach(button => {
    button.addEventListener('click', function() {
        const form = document.getElementById('formEditarPromocion');
        
        const id = this.dataset.id;
        const nombre = this.dataset.nombre;
        const codigo = this.dataset.codigo;
        const descripcion = this.dataset.descripcion;
        const tipo = this.dataset.tipo;
        const valor = this.dataset.valor;
        const fechaInicio = this.dataset.fechaInicio;
        const fechaFin = this.dataset.fechaFin;
        const usosMaximos = this.dataset.usosMaximos;
        const usosCliente = this.dataset.usosCliente;
        const dias = this.dataset.dias;
        const activo = this.dataset.activo === '1';

        form.setAttribute('action', `/admin/promociones/${id}`);
        
        document.getElementById('edit_promocionId').value = id;
        document.getElementById('edit_nombre').value = nombre;
        document.getElementById('edit_codigo').value = codigo;
        document.getElementById('edit_descripcion').value = descripcion || '';
        document.getElementById('edit_tipo').value = tipo;
        document.getElementById('edit_valor').value = valor;
        document.getElementById('edit_fechaInicio').value = fechaInicio;
        document.getElementById('edit_fechaFin').value = fechaFin;
        document.getElementById('edit_usosMaximos').value = usosMaximos || '';
        document.getElementById('edit_usosCliente').value = usosCliente || '1';
        document.getElementById('edit_activo').checked = activo;

        const simbolo = document.getElementById('simboloDescuentoEdit');
        simbolo.textContent = tipo === 'porcentaje' ? '%' : '$';

        form.querySelectorAll('input[name="dias[]"]').forEach(chk => chk.checked = false);

        if (dias && dias !== 'null') {
            try {
                const listaDias = JSON.parse(dias);
                if (Array.isArray(listaDias)) {
                    listaDias.forEach(dia => {
                        const checkbox = form.querySelector(`input[name="dias[]"][value="${dia.toLowerCase()}"]`);
                        if (checkbox) checkbox.checked = true;
                    });
                }
            } catch (e) {
                console.error('Error al parsear días:', e);
            }
        }
    });
});

// ========================================
// ENVIAR FORMULARIO DE EDICIÓN DE PROMOCIÓN
// ========================================
document.getElementById('formEditarPromocion')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const id = document.getElementById('edit_promocionId').value;

    if (!csrfToken) {
        Swal.fire({
            icon: 'error',
            title: 'Error de seguridad',
            text: 'No se encontró el token CSRF. Recarga la página.'
        });
        return;
    }

    const formData = new FormData(form);
    const data = {};
    
    formData.forEach((value, key) => {
        if (key === '_token' || key === '_method') return;
        
        if (key === 'dias[]') {
            if (!data.dias) data.dias = [];
            data.dias.push(value);
        } else {
            data[key] = value;
        }
    });

    data.activo = document.getElementById('edit_activo').checked ? '1' : '0';

    fetch(`/admin/promociones/${id}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        if (!response.ok) {
            const errorData = await response.json();
            const mensaje = Object.values(errorData.errors || {}).flat().join('\n') || 'Error al actualizar promoción.';
            throw new Error(mensaje);
        }
        return response.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Promoción actualizada',
            text: 'La promoción fue actualizada correctamente',
            timer: 2000,
            showConfirmButton: false
        });

        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarPromocion'));
        if (modal) modal.hide();

        setTimeout(() => location.reload(), 2000);
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error al actualizar promoción',
            text: error.message || 'Ocurrió un error inesperado'
        });
    });
});

// ========================================
// CAMBIAR SÍMBOLO EN MODAL DE EDICIÓN PROMOCIÓN
// ========================================
document.getElementById('edit_tipo')?.addEventListener('change', function() {
    const simbolo = document.getElementById('simboloDescuentoEdit');
    simbolo.textContent = this.value === 'porcentaje' ? '%' : '$';
});

// ========================================
// CREAR NUEVO COMBO
// ========================================
document.getElementById('formNuevoCombo')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfToken) {
        Swal.fire({
            icon: 'error',
            title: 'Error de seguridad',
            text: 'No se encontró el token CSRF. Recarga la página.'
        });
        return;
    }

    const serviciosSeleccionados = document.querySelectorAll('.servicio-check:checked');
    
    if (serviciosSeleccionados.length < 2) {
        Swal.fire({
            icon: 'warning',
            title: 'Servicios insuficientes',
            text: 'Debes seleccionar al menos 2 servicios para crear un combo'
        });
        return;
    }

    const precioCombo = parseFloat(document.getElementById('precioCombo').value);
    const precioRegular = parseFloat(document.getElementById('precioRegularTotal').textContent.replace('$', ''));

    if (precioCombo >= precioRegular) {
        Swal.fire({
            icon: 'warning',
            title: 'Precio incorrecto',
            text: 'El precio del combo debe ser menor al precio regular'
        });
        return;
    }

    const formData = new FormData(form);
    const data = {};
    
    formData.forEach((value, key) => {
        if (key === 'servicios[]') {
            if (!data.servicios) data.servicios = [];
            data.servicios.push(value);
        } else {
            data[key] = value;
        }
    });

    fetch('/admin/combos', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        if (!response.ok) {
            const errorData = await response.json();
            const mensaje = Object.values(errorData.errors || {}).flat().join('\n') || 'Error al crear combo.';
            throw new Error(mensaje);
        }
        return response.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Combo creado',
            text: 'El combo fue creado correctamente',
            timer: 2000,
            showConfirmButton: false
        });

        const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoCombo'));
        modal.hide();
        form.reset();

        setTimeout(() => location.reload(), 2000);
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error al crear combo',
            text: error.message || 'Ocurrió un error inesperado'
        });
    });
});

// ========================================
// CARGAR DATOS AL MODAL DE EDICIÓN DE COMBO
// ========================================
document.querySelectorAll('.btnEditarCombo').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const csrfToken = document.querySelector('meta[name="csrf-token"]');

        Swal.fire({
            title: 'Cargando...',
            text: 'Obteniendo datos del combo',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch(`/admin/combos/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(combo => {
            Swal.close();

            const form = document.getElementById('formEditarCombo');
            form.setAttribute('action', `/admin/combos/${combo.idCombo}`);
            
            document.getElementById('edit_comboId').value = combo.idCombo;
            document.getElementById('edit_combo_nombre').value = combo.nombre;
            document.getElementById('edit_combo_descripcion').value = combo.descripcion || '';
            document.getElementById('precioComboEdit').value = combo.precioCombo;
            document.getElementById('edit_combo_activo').value = combo.activo ? '1' : '0';

            document.querySelectorAll('.servicio-check-edit').forEach(chk => chk.checked = false);

            if (combo.servicios && Array.isArray(combo.servicios)) {
                combo.servicios.forEach(servicio => {
                    const checkbox = document.querySelector(`.servicio-check-edit[value="${servicio.idServicio}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            }

            setTimeout(() => calcularPreciosComboEdit(), 100);
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar la información del combo'
            });
        });
    });
});

// ========================================
// ENVIAR FORMULARIO DE EDICIÓN DE COMBO
// ========================================
document.getElementById('formEditarCombo')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    const id = document.getElementById('edit_comboId').value;

    if (!csrfToken) {
        Swal.fire({
            icon: 'error',
            title: 'Error de seguridad',
            text: 'No se encontró el token CSRF. Recarga la página.'
        });
        return;
    }

    const serviciosSeleccionados = document.querySelectorAll('.servicio-check-edit:checked');
    
    if (serviciosSeleccionados.length < 2) {
        Swal.fire({
            icon: 'warning',
            title: 'Servicios insuficientes',
            text: 'Debes seleccionar al menos 2 servicios para el combo'
        });
        return;
    }

    const precioCombo = parseFloat(document.getElementById('precioComboEdit').value);
    const precioRegular = parseFloat(document.getElementById('precioRegularTotalEdit').textContent.replace('$', ''));

    if (precioCombo >= precioRegular) {
        Swal.fire({
            icon: 'warning',
            title: 'Precio incorrecto',
            text: 'El precio del combo debe ser menor al precio regular'
        });
        return;
    }

    const formData = new FormData(form);
    const data = {};
    
    formData.forEach((value, key) => {
        if (key === '_token' || key === '_method' || key === 'comboId') return;
        
        if (key === 'servicios[]') {
            if (!data.servicios) data.servicios = [];
            data.servicios.push(parseInt(value));
        } else {
            data[key] = value;
        }
    });

    fetch(`/admin/combos/${id}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        if (!response.ok) {
            const errorData = await response.json();
            const mensaje = Object.values(errorData.errors || {}).flat().join('\n') || 'Error al actualizar combo.';
            throw new Error(mensaje);
        }
        return response.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: '¡Combo actualizado!',
            text: 'El combo fue actualizado correctamente',
            timer: 2000,
            showConfirmButton: false
        });

        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarCombo'));
        if (modal) modal.hide();

        setTimeout(() => location.reload(), 2000);
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error al actualizar combo',
            text: error.message || 'Ocurrió un error inesperado'
        });
    });
});

// ========================================
// CALCULAR PRECIOS DEL COMBO EN EDICIÓN
// ========================================
function calcularPreciosComboEdit() {
    const checkboxes = document.querySelectorAll('.servicio-check-edit:checked');
    let total = 0;
    
    checkboxes.forEach(cb => {
        const precio = parseFloat(cb.dataset.precio);
        if (!isNaN(precio)) total += precio;
    });

    document.getElementById('precioRegularTotalEdit').textContent = '$' + total.toFixed(2);
    
    const precioComboInput = document.getElementById('precioComboEdit');
    const precioCombo = parseFloat(precioComboInput.value) || 0;
    const ahorro = total - precioCombo;
    const porcentaje = total > 0 ? ((ahorro / total) * 100).toFixed(1) : 0;

    document.getElementById('ahorroTotalEdit').textContent = '$' + ahorro.toFixed(2);
    document.getElementById('porcentajeAhorroEdit').textContent = porcentaje + '% de descuento';
}

// ========================================
// TOGGLE TODOS LOS SERVICIOS EN EDICIÓN
// ========================================
function toggleAllServiciosEdit() {
    const selectAll = document.getElementById('selectAllEdit');
    const checkboxes = document.querySelectorAll('.servicio-check-edit');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
    calcularPreciosComboEdit();
}

// ========================================
// TOGGLE ESTADO PROMOCIÓN
// ========================================
function togglePromocion(id) {
    fetch(`/admin/promociones/${id}/estado`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Estado actualizado',
                text: `La promoción fue ${data.nuevo_estado ? 'activada' : 'desactivada'} correctamente`,
                timer: 2000,
                showConfirmButton: false
            });
            setTimeout(() => location.reload(), 2000);
        } else {
            throw new Error('No se pudo actualizar el estado');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Ocurrió un error inesperado'
        });
    });
}

// ========================================
// TOGGLE ESTADO COMBO
// ========================================
function toggleCombo(id) {
    fetch(`/admin/combos/${id}/estado`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Estado actualizado',
                text: `El combo fue ${data.nuevo_estado ? 'activado' : 'desactivado'} correctamente`,
                timer: 2000,
                showConfirmButton: false
            });
            setTimeout(() => location.reload(), 2000);
        } else {
            throw new Error('No se pudo actualizar el estado');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message || 'Ocurrió un error inesperado'
        });
    });
}

// ========================================
// SELECCIONAR TODOS LOS DÍAS
// ========================================
function seleccionarTodosDias() {
    const checkboxes = document.querySelectorAll('input[name="dias[]"]');
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    checkboxes.forEach(cb => cb.checked = !allChecked);
}

// ========================================
// CAMBIAR SÍMBOLO SEGÚN TIPO DE DESCUENTO
// ========================================
document.getElementById('tipoDescuento')?.addEventListener('change', function() {
    const simbolo = document.getElementById('simboloDescuento');
    simbolo.textContent = this.value === 'porcentaje' ? '%' : '$';
});

// ========================================
// TOGGLE TODOS LOS SERVICIOS
// ========================================
function toggleAllServicios() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.servicio-check');
    checkboxes.forEach(cb => cb.checked = selectAll.checked);
    calcularPreciosCombo();
}

// ========================================
// CALCULAR PRECIOS DEL COMBO
// ========================================
function calcularPreciosCombo() {
    const checkboxes = document.querySelectorAll('.servicio-check:checked');
    let total = 0;
    
    checkboxes.forEach(cb => {
        total += parseFloat(cb.dataset.precio);
    });

    document.getElementById('precioRegularTotal').textContent = '$' + total.toFixed(2);
    
    const precioCombo = parseFloat(document.getElementById('precioCombo').value) || 0;
    const ahorro = total - precioCombo;
    const porcentaje = total > 0 ? ((ahorro / total) * 100).toFixed(1) : 0;

    document.getElementById('ahorroTotal').textContent = '$' + ahorro.toFixed(2);
    document.getElementById('porcentajeAhorro').textContent = porcentaje + '% de descuento';
}

// ========================================
// EVENT LISTENERS
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Event listeners para cálculo de combo nuevo
    document.querySelectorAll('.servicio-check').forEach(cb => {
        cb.addEventListener('change', calcularPreciosCombo);
    });

    document.getElementById('precioCombo')?.addEventListener('input', calcularPreciosCombo);
    
    // Event listeners para cálculo de combo edición
    document.querySelectorAll('.servicio-check-edit').forEach(cb => {
        cb.addEventListener('change', calcularPreciosComboEdit);
    });

    document.getElementById('precioComboEdit')?.addEventListener('input', calcularPreciosComboEdit);

    // Cargar nombre de usuario
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
</script>

    
</body>
</html>