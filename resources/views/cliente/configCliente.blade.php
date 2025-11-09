<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración Cliente | Salón de Belleza</title>

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
            <p>Tu Salón de Belleza</p>
        </div>

        <!-- Menú de Navegación -->
        <nav class="sidebar-menu">
           
            <a href="{{ route('cliente.citasCli') }}" class="menu-item">
                <i class="bi bi-calendar-check"></i> Citas
            </a>
            <a href="{{ route('cliente.promocionesCli') }}" class="menu-item">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('cliente.configCli') }}" class="menu-item active">
                <i class="bi bi-gear"></i> Configuración
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Configuración</h1>
            <p>Administra tus preferencias.</p>
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
    <main class="main-content" min-height: calc(100vh - 140px);>

        <!-- Header de Configuración -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 style="color: var(--borgona); margin: 0 0 0.5rem 0;">
                                <i class="bi bi-gear-fill" style="color: var(--dorado-palido);"></i>
                                Configuración de mi Cuenta
                            </h2>
                            <p style="color: var(--borgona); opacity: 0.7; margin: 0;">
                                Administra tu perfil y seguridad
                            </p>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>

   

        <!-- Contenido de las pestañas -->
        <div class="tab-content" id="configTabContent">

            <!-- ============================================
                 TAB 1: MI PERFIL
                 ============================================ -->
            <div class="tab-pane fade show active" id="perfil" role="tabpanel">
                <div class="row g-4">
                    <!-- Información Personal -->
                    <div class="col-g-3">
                        <div class="card-custom">
                            <h6 style="color: var(--borgona); font-weight: 600; margin-bottom: 1.5rem; ">
                                <i class="bi bi-person"></i> Información Personal
                            </h6>

                            <form id="formPerfil" method="POST" action="{{ route('cliente.actualizarConfig') }}">
    @csrf
    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->nombre }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $cliente->apellido }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="correoElectronico" value="{{ $cliente->correoElectronico }}" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="telefono" name="telefono" value="{{ $cliente->telefono }}" pattern="[0-9]{4}-[0-9]{4}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="{{ $cliente->fechaNacimiento }}" readonly>
        </div>

        <div class="col-md-6">
            <label class="form-label">Género</label>
            <select class="form-control" id="genero" name="genero">
                <option value="femenino" {{ $cliente->genero == 'femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="masculino" {{ $cliente->genero == 'masculino' ? 'selected' : '' }}>Masculino</option>
                <option value="otro" {{ $cliente->genero == 'otro' ? 'selected' : '' }}>Otro</option>
                <option value="prefiero_no_decir" {{ $cliente->genero == 'prefiero_no_decir' ? 'selected' : '' }}>Prefiero no decir</option>
            </select>
        </div>

        

        <div class="col-md-6">
            <label class="form-label">¿Cómo nos conociste?</label>
            <input type="text" class="form-control" id="comoConocio" name="comoConocio" value="{{ old('comoConocio', $cliente->comoConocio) }}" readonly>
        </div>    

        <hr class="mt-4 mb-3">
        <h6 style="color: var(--borgona); font-weight: 600;">Cambiar Contraseña (opcional)</h6>
        <p style="font-size: 0.9rem; color: gray;">
            Si no deseas cambiar tu contraseña, deja estos campos en blanco.
        </p>

        <div class="col-md-6">
            <label class="form-label">Nueva Contraseña</label>
            <div class="input-group">
                <input type="password" class="form-control" id="clave" name="clave" placeholder="Nueva contraseña">
                <span class="input-group-text" onclick="toggleClave('clave', 'iconoClave')">
                    <i class="bi bi-eye" id="iconoClave"></i>
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Confirmar Contraseña</label>
            <div class="input-group">
                <input type="password" class="form-control" id="clave_confirmation" name="clave_confirmation" placeholder="Confirmar contraseña">
                <span class="input-group-text" onclick="toggleClave('clave_confirmation', 'iconoClaveConfirm')">
                    <i class="bi bi-eye" id="iconoClaveConfirm"></i>
                </span>
            </div>
        </div>

        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-gold">
                <i class="bi bi-check-circle"></i> Guardar Cambios
            </button>
        </div>
</form>

                            
                        </div>
                         
                    </div>

                </div>
            </div>
        </div>

    </main>

    
    <!-- ============================================
         FOOTER
         ============================================ 
 
  <footer class="main-footer">
        <p>&copy; 2025 BeautySalon - Sistema de Control de Citas |
            Desarrollado por <a href="#">Grupo 03 - IGF115</a>
        </p>
    </footer> -->


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    <script>
        // ========================================
        // TAB 1: MI PERFIL
        // ========================================


        // Guardar perfil
       function guardarPerfil() {
    const datos = {
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        email: document.getElementById('email').value,
        telefono: document.getElementById('telefono').value,
        fechaNacimiento: document.getElementById('fechaNacimiento').value,
        genero: document.getElementById('genero').value,
        direccion: document.getElementById('direccion').value
    };

    console.log('Guardar perfil:', datos);

    // Mostrar alerta personalizada
    const mensaje = `
        ✅ Perfil actualizado exitosamente.\n
        Para ver todos los cambios reflejados, por favor vuelve a iniciar sesión.
    `;
    alert(mensaje);
}

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

function toggleClave(id) {
    const input = document.getElementById(id);
    const icon = id === 'clave' ? document.getElementById('iconoClave') : document.getElementById('iconoClaveConfirm');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
    </script>

</body>

</html>