
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión | Salón de Belleza</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('css/global-styles.css') }}">
    
    <style>
        /* Estilos adicionales específicos para login usando las variables CSS existentes */
        body {
            background: linear-gradient(135deg, var(--blanco-humo) 0%, var(--rosa-empolvado-light) 50%, var(--champagne-light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        
        .login-container {
            width: 100%;
            max-width: 480px;
            margin: 0 auto;
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-logo h1 {
            color: var(--borgona);
            font-size: 2.5rem;
            margin: 0.5rem 0;
            font-weight: 700;
        }
        
        .login-logo i {
            font-size: 3rem;
            color: var(--dorado-palido);
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 40px rgba(128, 0, 32, 0.15);
            border: 2px solid var(--rosa-empolvado);
        }
        
        .form-floating > label {
            color: var(--borgona);
            opacity: 0.7;
        }
        
        .form-control:focus {
            border-color: var(--dorado-palido);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
        
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--rosa-empolvado);
        }
        
        .divider span {
            padding: 0 1rem;
            color: var(--borgona);
            opacity: 0.6;
            font-size: 0.9rem;
        }
        
        .social-login-btn {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            border: 2px solid var(--rosa-empolvado);
            background: white;
            color: var(--borgona);
            font-weight: 600;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .social-login-btn:hover {
            background: var(--blanco-humo);
            border-color: var(--dorado-palido);
            transform: translateY(-2px);
        }
        
        .footer-links {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--rosa-empolvado);
        }
        
        .footer-links a {
            color: var(--borgona);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--dorado-palido);
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--borgona);
            opacity: 0.6;
            z-index: 10;
        }
        
        .password-toggle:hover {
            opacity: 1;
            color: var(--dorado-palido);
        }
    </style>
</head>
<body>

    <div class="login-container">
        
        <!-- Logo y Título -->
        <div class="login-logo">
            <i class="bi bi-scissors"></i>
            <h1>BeautySalon</h1>
            <p style="color: var(--borgona); opacity: 0.7; margin: 0;">Tu Salón de Belleza de Confianza</p>
        </div>

        <!-- Card Principal de Login -->
        <div class="login-card">
            
            <!-- Título del Card -->
            <div class="text-center mb-4">
                <h3 style="color: var(--borgona); font-weight: 700; margin-bottom: 0.5rem;">
                    <i class="bi bi-person-circle" style="color: var(--dorado-palido);"></i>
                    Iniciar Sesión
                </h3>
                <p style="color: var(--borgona); opacity: 0.7; margin: 0;">
                    Ingresa a tu cuenta para agendar y gestionar tus citas
                </p>
            </div>

            <!-- Formulario de Login -->
            <form id="loginForm" onsubmit="handleLogin(event)">
                
                <!-- Email -->
                <div class="form-floating mb-3">
                    <input 
                        type="email" 
                        class="form-control" 
                        id="email" 
                        placeholder="correo@ejemplo.com"
                        required
                    >
                    <label for="email">
                        <i class="bi bi-envelope"></i> Correo Electrónico
                    </label>
                </div>

                <!-- Password -->
                <div class="form-floating mb-3" style="position: relative;">
                    <input 
                        type="password" 
                        class="form-control" 
                        id="password" 
                        placeholder="Contraseña"
                        required
                    >
                    <label for="password">
                        <i class="bi bi-lock"></i> Contraseña
                    </label>
                    <span class="password-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye" id="toggleIcon"></i>
                    </span>
                </div>

                <!-- Recordarme y Olvidé contraseña -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="recordarme">
                        <label class="form-check-label" for="recordarme" style="color: var(--borgona);">
                            Recordarme
                        </label>
                    </div>
                    <a href="#" onclick="mostrarRecuperarPassword()" style="color: var(--dorado-palido); text-decoration: none; font-weight: 600;">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <!-- Botón de Login -->
                <button type="submit" class="btn btn-gold w-100 mb-3" style="padding: 0.75rem; font-size: 1.1rem;">
                    <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                </button>

                <!-- Alert de error (oculto por defecto) -->
                <div id="alertError" class="alert-custom" style="display: none; background: rgba(220, 53, 69, 0.1); border-left-color: #dc3545;">
                    <i class="bi bi-exclamation-triangle"></i>
                    <span id="mensajeError">Error al iniciar sesión</span>
                </div>

            </form>

            <!-- Link de Registro -->
            <div class="footer-links">
                <p style="color: var(--borgona); margin: 0 0 0.5rem 0;">
                    ¿No tienes una cuenta?
                </p>
                <a href="#" onclick="irARegistro()">
                    <i class="bi bi-person-plus"></i> Crear Cuenta Nueva
                </a>
            </div>

        </div>

        <!-- Información Adicional -->
        <div class="text-center mt-4">
            <small style="color: var(--borgona); opacity: 0.6;">
                Al iniciar sesión, aceptas nuestros 
                <a href="#" style="color: var(--dorado-palido); text-decoration: none;">Términos de Servicio</a> y 
                <a href="#" style="color: var(--dorado-palido); text-decoration: none;">Política de Privacidad</a>
            </small>
        </div>

    
    </div>

    <!-- Modal: Recuperar Contraseña -->
    <div class="modal fade" id="modalRecuperarPassword" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-key" style="color: var(--dorado-palido);"></i> 
                        Recuperar Contraseña
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p style="color: var(--borgona); margin-bottom: 1.5rem;">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>
                    
                    <form id="formRecuperar" onsubmit="enviarRecuperacion(event)">
                        <div class="form-floating mb-3">
                            <input 
                                type="email" 
                                class="form-control" 
                                id="emailRecuperar" 
                                placeholder="correo@ejemplo.com"
                                required
                            >
                            <label for="emailRecuperar">
                                <i class="bi bi-envelope"></i> Correo Electrónico
                            </label>
                        </div>

                        <div id="alertRecuperacion" class="alert-custom" style="display: none;">
                            <i class="bi bi-check-circle"></i>
                            <span id="mensajeRecuperacion"></span>
                        </div>

                        <button type="submit" class="btn btn-gold w-100">
                            <i class="bi bi-send"></i> Enviar Enlace de Recuperación
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Crear Cuenta / Registro -->
    <div class="modal fade" id="modalRegistro" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="background: linear-gradient(135deg, white 0%, var(--blanco-humo) 100%); border: 2px solid var(--rosa-empolvado);">
                <div class="modal-header" style="border-bottom: 2px solid var(--dorado-palido);">
                    <h5 class="modal-title" style="color: var(--borgona); font-weight: 700;">
                        <i class="bi bi-person-plus" style="color: var(--dorado-palido);"></i> 
                        Crear Cuenta Nueva
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    <p style="color: var(--borgona); margin-bottom: 1.5rem; text-align: center;">
                        Únete a nuestra familia de belleza y comienza a disfrutar de nuestros servicios
                    </p>
                    
                    <form id="formRegistro" onsubmit="handleRegistro(event)">
                        
                        <!-- Nombre Completo -->
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="registroNombre" 
                                        placeholder="Nombre"
                                        required
                                    >
                                    <label for="registroNombre">
                                        <i class="bi bi-person"></i> Nombre
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="registroApellido" 
                                        placeholder="Apellido"
                                        required
                                    >
                                    <label for="registroApellido">
                                        <i class="bi bi-person"></i> Apellido
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input 
                                type="email" 
                                class="form-control" 
                                id="registroEmail" 
                                placeholder="correo@ejemplo.com"
                                required
                            >
                            <label for="registroEmail">
                                <i class="bi bi-envelope"></i> Correo Electrónico
                            </label>
                            <small class="text-muted" style="margin-left: 0.5rem;">
                                Usaremos este correo para enviarte confirmaciones de citas
                            </small>
                        </div>

                        <!-- Teléfono -->
                        <div class="form-floating mb-3">
                            <input 
                                type="tel" 
                                class="form-control" 
                                id="registroTelefono" 
                                placeholder="7777-7777"
                                pattern="[0-9]{4}-[0-9]{4}"
                                required
                            >
                            <label for="registroTelefono">
                                <i class="bi bi-telephone"></i> Teléfono
                            </label>
                            <small class="text-muted" style="margin-left: 0.5rem;">
                                Formato: 7777-7777
                            </small>
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="form-floating mb-3">
                            <input 
                                type="date" 
                                class="form-control" 
                                id="registroFechaNacimiento" 
                                placeholder="Fecha de Nacimiento"
                                required
                            >
                            <label for="registroFechaNacimiento">
                                <i class="bi bi-calendar-heart"></i> Fecha de Nacimiento
                            </label>
                            <small class="text-muted" style="margin-left: 0.5rem;">
                                Te enviaremos una sorpresa especial en tu cumpleaños 🎂
                            </small>
                        </div>

                        <!-- Contraseña -->
                        <div class="form-floating mb-3" style="position: relative;">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="registroPassword" 
                                placeholder="Contraseña"
                                minlength="8"
                                required
                            >
                            <label for="registroPassword">
                                <i class="bi bi-lock"></i> Contraseña
                            </label>
                            <span class="password-toggle" onclick="togglePasswordRegistro('registroPassword', 'toggleIconRegistro')">
                                <i class="bi bi-eye" id="toggleIconRegistro"></i>
                            </span>
                            <small class="text-muted" style="margin-left: 0.5rem;">
                                Mínimo 8 caracteres
                            </small>
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="form-floating mb-3" style="position: relative;">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="registroPasswordConfirm" 
                                placeholder="Confirmar Contraseña"
                                minlength="8"
                                required
                            >
                            <label for="registroPasswordConfirm">
                                <i class="bi bi-lock-fill"></i> Confirmar Contraseña
                            </label>
                            <span class="password-toggle" onclick="togglePasswordRegistro('registroPasswordConfirm', 'toggleIconRegistroConfirm')">
                                <i class="bi bi-eye" id="toggleIconRegistroConfirm"></i>
                            </span>
                        </div>

                        <!-- Género (Opcional) -->
                        <div class="mb-3">
                            <label style="color: var(--borgona); font-weight: 600; margin-bottom: 0.5rem;">
                                <i class="bi bi-gender-ambiguous"></i> Género (Opcional)
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="generoFemenino" value="femenino">
                                    <label class="form-check-label" for="generoFemenino">
                                        Femenino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="generoMasculino" value="masculino">
                                    <label class="form-check-label" for="generoMasculino">
                                        Masculino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="generoOtro" value="otro">
                                    <label class="form-check-label" for="generoOtro">
                                        Otro
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Cómo nos conociste -->
                        <div class="form-floating mb-3">
                            <select class="form-control" id="registroComoConocio">
                                <option value="">Selecciona una opción</option>
                                <option value="redes_sociales">Redes Sociales</option>
                                <option value="recomendacion">Recomendación de un amigo/a</option>
                                <option value="google">Búsqueda en Google</option>
                                <option value="publicidad">Publicidad</option>
                                <option value="paso_por_aqui">Pasé por aquí</option>
                                <option value="otro">Otro</option>
                            </select>
                            <label for="registroComoConocio">
                                <i class="bi bi-question-circle"></i> ¿Cómo nos conociste?
                            </label>
                        </div>

                        <!-- Términos y Condiciones -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="registroTerminos" required>
                            <label class="form-check-label" for="registroTerminos" style="color: var(--borgona);">
                                Acepto los <a href="#" style="color: var(--dorado-palido); text-decoration: none; font-weight: 600;">Términos y Condiciones</a> 
                                y la <a href="#" style="color: var(--dorado-palido); text-decoration: none; font-weight: 600;">Política de Privacidad</a>
                            </label>
                        </div>

                        <!-- Suscripción a Newsletter -->
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="registroNewsletter" checked>
                            <label class="form-check-label" for="registroNewsletter" style="color: var(--borgona);">
                                <i class="bi bi-envelope-heart"></i> Quiero recibir promociones y novedades por correo
                            </label>
                        </div>

                        <!-- Alert de mensajes -->
                        <div id="alertRegistro" class="alert-custom" style="display: none;">
                            <i class="bi bi-info-circle"></i>
                            <span id="mensajeRegistro"></span>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-soft flex-fill" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-gold flex-fill" style="padding: 0.75rem;">
                                <i class="bi bi-check-circle"></i> Crear Cuenta
                            </button>
                        </div>
                    </form>

                    <!-- Divider -->
                    <div class="divider" style="margin: 1.5rem 0;">
                        <span>O regístrate con</span>
                    </div>

                    <!-- Registro Social -->
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="social-login-btn" onclick="registroConGoogle()">
                                <i class="bi bi-google" style="color: #EA4335;"></i>
                                Google
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="social-login-btn" onclick="registroConFacebook()">
                                <i class="bi bi-facebook" style="color: #1877F2;"></i>
                                Facebook
                            </button>
                        </div>
                    </div>

                    <!-- Ya tengo cuenta -->
                    <div class="text-center mt-3 pt-3" style="border-top: 1px solid var(--rosa-empolvado);">
                        <small style="color: var(--borgona);">
                            ¿Ya tienes una cuenta? 
                            <a href="#" onclick="cerrarRegistroAbrirLogin()" style="color: var(--dorado-palido); text-decoration: none; font-weight: 600;">
                                Iniciar Sesión
                            </a>
                        </small>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
        // Toggle mostrar/ocultar contraseña
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'bi bi-eye';
            }
        }

        // Manejar submit del formulario de login
        function handleLogin(event) {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const recordarme = document.getElementById('recordarme').checked;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!email || !password) {
            mostrarError('Por favor completa todos los campos');
            return false;
            }

            fetch("/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify({
            correoElectronico: email,
            clave: password,
            recordarme: recordarme ? 1 : 0
            })
        })
            .then(res => res.json())
            .then(data => {
            if (data.success) {
                mostrarExito();

            setTimeout(() => {
                redirigirSegunRol(data.rol || 'cliente');
            }, 1500);
        } else {
            mostrarError(data.message || 'Correo o contraseña incorrectos');
        }
    })
    .catch(() => {
        mostrarError('Error en el servidor. Intenta más tarde.');
    });

    return false;
}


        // Mostrar error
        function mostrarError(mensaje) {
            const alertError = document.getElementById('alertError');
            const mensajeError = document.getElementById('mensajeError');
            
            mensajeError.textContent = mensaje;
            alertError.style.display = 'block';
            
            // Ocultar después de 5 segundos
            setTimeout(() => {
                alertError.style.display = 'none';
            }, 5000);
        }

        // Mostrar éxito
        function mostrarExito() {
            const alertError = document.getElementById('alertError');
            const mensajeError = document.getElementById('mensajeError');
            
            alertError.style.background = 'rgba(40, 167, 69, 0.1)';
            alertError.style.borderLeftColor = '#28a745';
            mensajeError.innerHTML = '<i class="bi bi-check-circle"></i> ¡Login exitoso! Redirigiendo...';
            alertError.style.display = 'block';
        }

        // Mostrar modal de recuperar contraseña
        function mostrarRecuperarPassword() {
            const modal = new bootstrap.Modal(document.getElementById('modalRecuperarPassword'));
            modal.show();
        }

        // Enviar recuperación de contraseña
        function enviarRecuperacion(event) {
            event.preventDefault();
            
            const email = document.getElementById('emailRecuperar').value;
            console.log('Recuperar contraseña para:', email);

            // Mostrar mensaje de éxito
            const alertRecuperacion = document.getElementById('alertRecuperacion');
            const mensajeRecuperacion = document.getElementById('mensajeRecuperacion');
            
            mensajeRecuperacion.textContent = '✓ Se ha enviado un enlace de recuperación a tu correo electrónico';
            alertRecuperacion.style.display = 'block';

            // Limpiar formulario
            document.getElementById('emailRecuperar').value = '';

            // Cerrar modal después de 3 segundos
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('modalRecuperarPassword')).hide();
                alertRecuperacion.style.display = 'none';
            }, 3000);

            return false;
        }


        // Ir a página de registro (abrir modal)
        function irARegistro() {
            console.log('Abrir modal de registro');
            const modal = new bootstrap.Modal(document.getElementById('modalRegistro'));
            modal.show();
        }

        // Toggle password en registro
        function togglePasswordRegistro(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.className = 'bi bi-eye-slash';
            } else {
                passwordInput.type = 'password';
                toggleIcon.className = 'bi bi-eye';
            }
        }

        // Manejar registro
        function handleRegistro(event) {
        event.preventDefault();
            
            const nombre = document.getElementById('registroNombre').value;
            const apellido = document.getElementById('registroApellido').value;
            const email = document.getElementById('registroEmail').value;
            const telefono = document.getElementById('registroTelefono').value;
            const fechaNacimiento = document.getElementById('registroFechaNacimiento').value;
            const password = document.getElementById('registroPassword').value;
            const passwordConfirm = document.getElementById('registroPasswordConfirm').value;
            const genero = document.querySelector('input[name="genero"]:checked')?.value || null;
            const comoConocio = document.getElementById('registroComoConocio').value;
            const aceptaTerminos = document.getElementById('registroTerminos').checked;
            const newsletter = document.getElementById('registroNewsletter').checked;

    // Validar que las contraseñas coincidan
    if (password !== passwordConfirm) {
        mostrarErrorRegistro('Las contraseñas no coinciden');
        return false;
    }

    // Validar términos
    if (!aceptaTerminos) {
        mostrarErrorRegistro('Debes aceptar los términos y condiciones');
        return false;
    }

    // Crear el JSON que Laravel espera
    const data = {
        nombre,
        apellido,
        correoElectronico: email,
        telefono,
        fechaNacimiento,
        clave: password,
        clave_confirmation: passwordConfirm,
        genero,
        comoConocio,
        suscripcionNewsletter: newsletter ? 1 : 0
    };
 const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("/registro", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": token
    },
    body: JSON.stringify(data)
})
    .then(res => res.json())
    .then(data => {

        // Si hubo errores de validación en Laravel
        if (data.errors) {
            const msg = Object.values(data.errors).flat().join(', ');
            mostrarErrorRegistro(msg);
            return;
        }

        // Éxito
        if (data.success) {
            mostrarExitoRegistro();

            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('modalRegistro')).hide();
                document.getElementById('formRegistro').reset();

                alert(`✅ ¡Bienvenida ${nombre}!

            Tu cuenta ha sido creada exitosamente.
            Te hemos enviado un correo de confirmación a: ${email}

            Ya puedes iniciar sesión.`);
            }, 2000);
        }
    })
    .catch(() => {
        mostrarErrorRegistro("Hubo un error en el servidor. Intenta más tarde.");
    });

    return false;
}


        // Mostrar error en registro
        function mostrarErrorRegistro(mensaje) {
            const alertRegistro = document.getElementById('alertRegistro');
            const mensajeRegistro = document.getElementById('mensajeRegistro');
            
            alertRegistro.style.background = 'rgba(220, 53, 69, 0.1)';
            alertRegistro.style.borderLeftColor = '#dc3545';
            mensajeRegistro.innerHTML = '<i class="bi bi-exclamation-triangle"></i> ' + mensaje;
            alertRegistro.style.display = 'block';
            
            // Scroll al alert
            alertRegistro.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            
            // Ocultar después de 5 segundos
            setTimeout(() => {
                alertRegistro.style.display = 'none';
            }, 5000);
        }

        // Mostrar éxito en registro
        function mostrarExitoRegistro() {
            const alertRegistro = document.getElementById('alertRegistro');
            const mensajeRegistro = document.getElementById('mensajeRegistro');
            
            alertRegistro.style.background = 'rgba(40, 167, 69, 0.1)';
            alertRegistro.style.borderLeftColor = '#28a745';
            mensajeRegistro.innerHTML = '<i class="bi bi-check-circle"></i> ¡Cuenta creada exitosamente! Redirigiendo...';
            alertRegistro.style.display = 'block';
            
            // Scroll al alert
            alertRegistro.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

       

        // Cerrar registro y volver al login
        function cerrarRegistroAbrirLogin() {
            bootstrap.Modal.getInstance(document.getElementById('modalRegistro')).hide();
        }

        // Validación en tiempo real del email de registro
        document.getElementById('registroEmail')?.addEventListener('input', function() {
            if (this.value && !this.value.includes('@')) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '';
            }
        });

        // Validación de confirmación de contraseña en tiempo real
        document.getElementById('registroPasswordConfirm')?.addEventListener('input', function() {
            const password = document.getElementById('registroPassword').value;
            if (this.value && this.value !== password) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '';
            }
        });

        // Establecer fecha máxima para fecha de nacimiento (18 años mínimo)
        document.addEventListener('DOMContentLoaded', function() {
            const fechaNacInput = document.getElementById('registroFechaNacimiento');
            if (fechaNacInput) {
                const hoy = new Date();
                const hace18Anos = new Date(hoy.getFullYear() - 18, hoy.getMonth(), hoy.getDate());
                const hace100Anos = new Date(hoy.getFullYear() - 100, hoy.getMonth(), hoy.getDate());
                
                fechaNacInput.max = hace18Anos.toISOString().split('T')[0];
                fechaNacInput.min = hace100Anos.toISOString().split('T')[0];
            }
        });

        // Login Demo por Rol
        function loginDemo(rol) {
            console.log('Login demo como:', rol);
            alert('✓ Login demo como: ' + rol.toUpperCase() + '\n\nRedirigiendo al dashboard...');
            
            setTimeout(() => {
                redirigirSegunRol(rol);
            }, 1000);
        }

        // Redirigir según rol
        function redirigirSegunRol(rol) {
            switch(rol) {
                case 'ADMIN':
                    console.log('Redirigir a: /admin/dashboard');
                    alert('Redirigiendo al Dashboard de Administrador...');
                    window.location.href = '/admin/dashboard';
                    break;
                case 'ESTILISTA':
                    console.log('Redirigir a: /estilista/dashboard');
                    alert('Redirigiendo al Dashboard de Estilista...');
                    window.location.href = '/estilista/dashboard';
                    break;
                case 'CLIENTE':
                    console.log('Redirigir a: /cliente/dashboard');
                    alert('Redirigiendo al Dashboard de Cliente...');
                    window.location.href = '/cliente/dashboard';
                    break;
                default:
                    console.log('Rol desconocido');
                    mostrarError('Error: Rol de usuario no válido');
            }
        }

        // Validación en tiempo real
        document.getElementById('email')?.addEventListener('input', function() {
            if (this.value && !this.value.includes('@')) {
                this.style.borderColor = '#dc3545';
            } else {
                this.style.borderColor = '';
            }
        });

        // Enter en el formulario
        document.getElementById('loginForm')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleLogin(e);
            }
        });
    </script>
    
</body>

</html>