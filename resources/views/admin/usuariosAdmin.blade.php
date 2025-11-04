<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios Administrador | Salón de Belleza</title>
    
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
            <a href="{{ route('admin.citasAdm') }}" class="menu-item">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('admin.usuariosAdm') }}" class="menu-item active">
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
            <h1>Gestión de Empleados</h1>
            <p>Administra recepcionistas y estilistas.</p>
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
        
        <!-- Botones de Acción Superior -->
        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-gold me-2" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
                    <i class="bi bi-plus-circle"></i> Nuevo Empleado
                </button>
                
            </div>
        </div>

        <!-- KPI Cards - Resumen de Usuarios -->
        <div class="row g-4 mb-4">
            
            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM usuarios 
            WHERE rol = 'estilista' AND activo = 1
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon primary">
                            <i class="bi bi-scissors"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $estilistas }}</h3>
                    <p class="kpi-label">Estilistas Activos</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> Activos
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM usuarios 
            WHERE rol = 'recepcionista' AND activo = 1
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon success">
                            <i class="bi bi-person-badge"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $recepcionistas }}</h3>
                    <p class="kpi-label">Recepcionistas Activos</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-check-circle"></i> Activos
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM usuarios 
            WHERE activo = 0
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon info">
                            <i class="bi bi-person-x"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $inactivos }}</h3>
                    <p class="kpi-label">Usuarios Inactivos</p>
                    <span class="kpi-badge badge-neutral">
                        <i class="bi bi-x-circle"></i> Inactivos
                    </span>
                </div>
            </div>

            <!-- 
            ================================================
            TODO BACKEND: Conectar con BD
            ================================================
            CONSULTA SQL:
            SELECT COUNT(*) as total 
            FROM usuarios 
            WHERE DATE(fecha_creacion) >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            ================================================
            -->
            <div class="col-xl-3 col-md-6">
                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-icon warning">
                            <i class="bi bi-person-plus"></i>
                        </div>
                    </div>
                    <h3 class="kpi-value">{{ $clientesRecientes }}</h3>
                    <p class="kpi-label">Clientes Nuevos (30 días)</p>
                    <span class="kpi-badge badge-success">
                        <i class="bi bi-arrow-up"></i> Recientes
                    </span>
                </div>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        <!-- 
        ================================================
        TODO BACKEND: Conectar con BD - Lista de Usuarios
        ================================================
        CONSULTA SQL:
        SELECT u.id, u.nombre, u.apellido, u.email, u.telefono, 
               u.rol, u.activo, u.fecha_creacion
        FROM usuarios u
        WHERE u.rol IN ('estilista', 'recepcionista')
        ORDER BY u.activo DESC, u.rol, u.nombre
        ================================================
        -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card-custom">
                    <h5 class="card-title-custom">
                        <i class="bi bi-people-fill"></i>
                        Lista de Empleados del Sistema
                    </h5>

                    <!-- Buscador -->
                    <div class="mb-3">
                        <input type="text" id="buscarUsuario" class="form-control" placeholder="Buscar usuario..." onkeyup="buscarTabla()">
                    </div>
                    
                    <!-- Tabla Responsiva -->
                    <div class="table-responsive">
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Completo</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
    @foreach ($empleados as $empleado)
        <tr @if(!$empleado->activo) style="opacity: 0.6;" @endif>
            <td>#{{ str_pad($empleado->idEmpleado, 3, '0', STR_PAD_LEFT) }}</td>
            <td>
                <div class="d-flex align-items-center">
                    <div class="list-avatar me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">
                        {{ strtoupper(substr($empleado->nombre, 0, 1)) }}
                    </div>
                    <strong>{{ $empleado->nombre }} {{ $empleado->apellido }}</strong>
                </div>
            </td>
            <td>{{ $empleado->correoElectronico }}</td>
            <td>{{ $empleado->telefono }}</td>
            <td>
                <span class="badge {{ $empleado->rol->nombre === 'estilista' ? 'badge-luxury' : 'badge-gold' }}">
                    {{ strtoupper($empleado->rol->nombre) }}
                </span>
            </td>
            <td>
                <span class="badge {{ $empleado->activo ? 'bg-success' : 'bg-secondary' }}">
                    {{ $empleado->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </td>
            <td>
                <!-- Botones de acción -->
                <button class="btn btn-sm btn-soft me-1 btn-editar" 
        data-bs-toggle="modal" 
        data-bs-target="#modalEditarUsuario" 
        data-id="{{ $empleado->idEmpleado }}"
        data-nombre="{{ $empleado->nombre }}"
        data-apellido="{{ $empleado->apellido }}"
        data-email="{{ $empleado->correoElectronico }}"
        data-telefono="{{ $empleado->telefono }}"
        data-direccion="{{ $empleado->direccion }}"
        data-rol="{{ $empleado->rol->idRol }}"
        data-activo="{{ $empleado->activo }}">
    <i class="bi bi-pencil"></i>
</button>

               
                <button 
    class="btn btn-sm btn-toggle-estado {{ $empleado->activo ? 'btn-premium' : 'btn-gold' }}" 
    title="{{ $empleado->activo ? 'Desactivar' : 'Activar' }}"
    data-id="{{ $empleado->idEmpleado }}"
    data-estado="{{ $empleado->activo ? 1 : 0 }}">
    <i class="bi {{ $empleado->activo ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
</button>

            </td>
        </tr>
    @endforeach

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
         MODAL: NUEVO USUARIO
         ============================================ -->
    <div class="modal fade" id="modalNuevoUsuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-person-plus" style="color: var(--dorado-palido);"></i> 
                        Nuevo Empleado
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Creación
                    ================================================
                    ACCIÓN: Enviar a ruta POST /usuarios/crear
                    VALIDACIONES:
                    - Nombre: requerido, máx 50 caracteres
                    - Apellido: requerido, máx 50 caracteres
                    - Email: requerido, único, formato email
                    - Teléfono: requerido, formato (503) ####-####
                    - Rol: requerido, enum (estilista, recepcionista)
                    - Contraseña: requerida, mín 8 caracteres
                    ================================================
                    -->
                   <form id="formNuevoUsuario" action="{{ route('empleado.store') }}" method="POST">
                        <div class="row g-3">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label class="form-label">Nombre *</label>
                                <input type="text" class="form-control" name="nombre" placeholder="Ej: Ana" required>
                            </div>

                            <!-- Apellido -->
                            <div class="col-md-6">
                                <label class="form-label">Apellido *</label>
                                <input type="text" class="form-control" name="apellido" placeholder="Ej: López García" required>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" placeholder="usuario@salon.com" required>
                            </div>

                            <!-- Teléfono -->
                            <div class="col-md-6">
                                <label class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" name="telefono" placeholder="(503) 7890-1234" required>
                            </div>

                            <!-- Rol -->
                            <div class="col-md-6">
                                <label class="form-label">Rol *</label>
                                <select class="form-select" name="idRol" required>
                                    <option value="">Seleccione un rol</option>
                                    @foreach($roles as $rol)
                                    <option value="{{ $rol->idRol }}">{{ $rol->nombre }}</option>
                                     @endforeach
                                </select>

                            </div>

                            <!-- Estado -->
                            <div class="col-md-6">
                                <label class="form-label">Estado *</label>
                                <select class="form-select" name="activo" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            <!-- Contraseña -->
                            <div class="col-md-6">
                                <label class="form-label">Contraseña *</label>
                                <input type="password" class="form-control" name="password" placeholder="Mínimo 8 caracteres" required>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div class="col-md-6">
                                <label class="form-label">Confirmar Contraseña *</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Repetir contraseña" required>
                            </div>

                            <!-- Dirección (Opcional) -->
                            <div class="col-12">
                                <label class="form-label">Dirección (Opcional)</label>
                                <textarea class="form-control" name="direccion" rows="2" placeholder="Dirección completa"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevoUsuario" class="btn btn-gold">
                        <i class="bi bi-save"></i> Guardar Empleado
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================
         MODAL: EDITAR USUARIO
         ============================================ -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-pencil" style="color: var(--dorado-palido);"></i> 
                        Editar Usuario
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- 
                    ================================================
                    TODO BACKEND: Formulario de Edición
                    ================================================
                    ACCIÓN: Enviar a ruta PUT /usuarios/{id}/actualizar
                    NOTA: Los campos vienen pre-llenados con los datos actuales
                    ================================================
                    -->
                    <form id="formEditarUsuario" action="{{ route('empleado.update', ['id' => $empleado->idEmpleado]) }}" method="POST">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="usuario_id" value="1">
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre *</label>
                                <input type="text" class="form-control" name="nombre" value="Ana" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Apellido *</label>
                                <input type="text" class="form-control" name="apellido" value="López García" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" value="ana.lopez@salon.com" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" name="telefono" value="(503) 7890-1234" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Rol *</label>
                                <select name="idRol" class="form-select" id="idRol">

    @foreach ($roles as $rol)
        <option value="{{ $rol->idRol }}">{{ ucfirst($rol->nombre) }}</option>
    @endforeach
</select>

                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estado *</label>
                                <select class="form-select" name="activo" required>
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Dirección (Opcional)</label>
                                <textarea class="form-control" name="direccion" rows="2">Calle Principal #123, Colonia Escalón</textarea>
                            </div>

                            <div class="col-12">
                                <hr style="border-color: var(--rosa-empolvado);">
                                <p class="text-muted mb-2"><small><i class="bi bi-info-circle"></i> Dejar en blanco para mantener la contraseña actual</small></p>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password" placeholder="Solo si desea cambiarla">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Repetir nueva contraseña">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--rosa-empolvado);">
                    <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formEditarUsuario" class="btn btn-gold">
                        <i class="bi bi-save"></i> Actualizar Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <!-- Script de Funciones -->
    <script>
        // 
        // ================================================
        // TODO BACKEND: Implementar funciones
        // ================================================
        //

        document.querySelectorAll('.btn-editar').forEach(button => {
    button.addEventListener('click', () => {
        const form = document.getElementById('formEditarUsuario');

        form.usuario_id.value = button.dataset.id;
        form.nombre.value = button.dataset.nombre;
        form.apellido.value = button.dataset.apellido;
        form.email.value = button.dataset.email;
        form.telefono.value = button.dataset.telefono;
        form.direccion.value = button.dataset.direccion;

        form.idRol.value = button.dataset.rol;
        form.activo.value = button.dataset.activo;

        // Actualiza la acción del formulario con el ID correcto
        form.setAttribute('action', `/admin/usuariosAdm/${button.dataset.id}`);
        
    });
});


        // Función para toggle de estado activo/inactivo
        function toggleEstado(usuarioId) {
            // TODO: Hacer petición AJAX a /usuarios/{id}/toggle-estado
            console.log('Toggle estado usuario:', usuarioId);
            alert('Función de toggle estado - Conectar con backend');
        }

        //----------------------------------//

                    //crear usuario// 

        //----------------------------------//  
       document.getElementById('formNuevoUsuario')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const password = form.querySelector('[name="password"]').value;
    const confirmation = form.querySelector('[name="password_confirmation"]').value;

    if (password !== confirmation) {
        Swal.fire({
            icon: 'warning',
            title: 'Contraseñas no coinciden',
            text: 'Por favor verifica que ambas contraseñas sean iguales'
        });
        return;
    }

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');

        if (!response.ok) {
            if (contentType && contentType.includes('application/json')) {
                const errorData = await response.json();
                const mensaje = Object.values(errorData.errors || {}).flat().join('\n') || 'Error al crear empleado.';
                throw new Error(mensaje);
            } else {
                const text = await response.text();
                throw new Error(text || 'Error desconocido');
            }
        }

        return response.json();
    })
    .then(data => {
        Swal.fire({
            icon: 'success',
            title: 'Empleado creado',
            text: 'El nuevo empleado fue registrado correctamente',
            timer: 2000,
            showConfirmButton: false
        });

        // ✅ Cerrar el modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalNuevoUsuario'));
        modal.hide();

        // ✅ Limpiar el formulario
        form.reset();

        // ✅ Recargar la tabla o la página
        setTimeout(() => {
            location.reload();
        }, 2000);
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error al crear empleado',
            text: error.message || 'Ocurrió un error inesperado'
        });
    });
});

//----------------------------------//

        //editar usuario// 

//----------------------------------//        
document.getElementById('formEditarUsuario').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const id = form.querySelector('[name="usuario_id"]').value;
    const formData = new FormData(form);

    fetch(`/admin/usuariosAdm/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        const contentType = response.headers.get('content-type');

        if (!response.ok) {
            if (contentType && contentType.includes('application/json')) {
                const errorData = await response.json();
                const mensaje = Object.values(errorData.errors || {}).flat().join('\n') || 'Error al actualizar.';
                throw new Error(mensaje);
            } else {
                const text = await response.text();
                throw new Error(text || 'Error desconocido');
            }
        }

        return response.json(); // ✅ esto pasa al siguiente .then(data => ...)
    })
    .then(data => {
        // ✅ Mostrar alerta de éxito
        Swal.fire({
            icon: 'success',
            title: 'Usuario actualizado',
            text: 'Los datos se modificaron correctamente',
            timer: 2000,
            showConfirmButton: false
        });

        // ✅ Cerrar el modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarUsuario'));
        modal.hide();

        // ✅ Recargar la tabla o la página
        setTimeout(() => {
            location.reload();
        }, 2000);
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error al actualizar',
            text: error.message || 'Ocurrió un error inesperado'
        });
    });
});

document.querySelectorAll('.btn-toggle-estado').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;
        const estadoActual = parseInt(this.dataset.estado);
        const nuevoEstado = estadoActual === 1 ? 0 : 1;

        fetch(`/admin/usuariosAdm/${id}/estado`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ estado: nuevoEstado })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Estado actualizado',
                    text: `El empleado fue ${data.nuevoEstado ? 'activado' : 'desactivado'} correctamente`,
                    timer: 2000,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    location.reload(); // o actualiza solo la fila si prefieres
                }, 2000);
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
    });
});

function buscarTabla() {
    const input = document.getElementById('buscarUsuario');
    const filtro = input.value.toLowerCase();
    const filas = document.querySelectorAll('.table-custom tbody tr');

    filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(filtro) ? '' : 'none';
    });
}

</script>
</body>
</html>