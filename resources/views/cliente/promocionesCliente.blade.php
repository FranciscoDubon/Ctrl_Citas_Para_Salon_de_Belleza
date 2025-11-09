<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Promociones Cliente | Salón de Belleza</title>

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
            <a href="{{ route('cliente.promocionesCli') }}" class="menu-item active">
                <i class="bi bi-gift"></i> Promociones
            </a>
            <a href="{{ route('cliente.configCli') }}" class="menu-item">
                <i class="bi bi-gear"></i> Configuración
            </a>
        </nav>
    </div>

    <!-- ============================================
         HEADER (BARRA SUPERIOR)
         ============================================ -->
    <header class="top-header">
        <div class="header-title">
            <h1>Promociones</h1>
            <p>Consulta las promociones y combos del salón.</p>
        </div>

        <div class="header-actions">
            <!-- Usuario -->
            <div class="user-info">
                <div class="user-avatar"  id="avatarInicial">M</div>
                <span class="user-name" id="nombreCliente">María García - Cliente</span>
            </div>
        </div>
    </header>

    <!-- ============================================
         MAIN CONTENT (CONTENIDO PRINCIPAL)
         ============================================ -->
    <main class="main-content">
        
        <!-- Banner Principal de Promociones -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="premium-card" style="background: linear-gradient(135deg, var(--borgona) 0%, var(--borgona-light) 100%);">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 style="color: white; margin: 0 0 1rem 0; font-size: 2.5rem;">
                                <i class="bi bi-gift-fill" style="color: var(--dorado-palido);"></i> 
                                Promociones Especiales
                            </h1>
                            <p style="color: var(--rosa-empolvado); font-size: 1.2rem; margin: 0 0 1rem 0;">
                                Aprovecha nuestras ofertas exclusivas y obtén los mejores precios en tus servicios favoritos
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div style="font-size: 5rem; color: var(--dorado-palido);">
                                🎉
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<!-- Sección: PROMOCIONES DESTACADAS -->
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="card-custom">
            <h5 class="card-title-custom">
                <i class="bi bi-stars"></i>
                🔥 Promociones Destacadas del Mes
            </h5>
            
            <div class="row g-4">
                @forelse($promocionesDestacadas as $promocion)
                <div class="col-lg-4 col-md-6">
                    <div class="premium-card" style="background: linear-gradient(135deg, var(--borgona), var(--borgona-light)); min-height: 520px; display: flex; flex-direction: column;">
                        <div style="position: absolute; top: 10px; right: 10px;">
                            <span class="badge bg-danger" style="font-size: 0.75rem;">
                                <i class="bi bi-fire"></i> POPULAR
                            </span>
                        </div>
                        
                        <div class="text-center flex-grow-1 d-flex flex-column">
                            <div style="font-size: 4rem; color: var(--dorado-palido); margin-bottom: 1rem;">
                                <i class="bi bi-stars"></i>
                            </div>
                            <h4 style="color: white; margin-bottom: 0.5rem;">{{ $promocion->nombre }}</h4>
                            <h2 style="color: var(--dorado-palido); font-size: 3rem; margin: 0.5rem 0;">
                                {{ $promocion->tipoDescuento == 'porcentaje' ? $promocion->valorDescuento . '% OFF' : '$' . $promocion->valorDescuento }}
                            </h2>
                            <p style="color: var(--rosa-empolvado); margin-bottom: 1.5rem; flex-grow: 1;">
                                {{ $promocion->descripcion }}
                            </p>
                            
                            <div style="background: rgba(255,255,255,0.2); padding: 0.75rem; border-radius: 10px; margin-bottom: 1rem;">
                                <small style="color: white; opacity: 0.9;">Código promocional:</small>
                                <br>
                                <h5 style="color: var(--dorado-palido); margin: 0.25rem 0; font-family: monospace; letter-spacing: 2px;">
                                    {{ $promocion->codigoPromocional }}
                                </h5>
                            </div>
                            
                            <div style="background: rgba(255,255,255,0.15); padding: 0.5rem; border-radius: 8px; margin-bottom: 1rem;">
                                <small style="color: white;">
                                    <i class="bi bi-clock"></i> Válido hasta: 
                                    <strong>{{ \Carbon\Carbon::parse($promocion->fechaFin)->format('d M Y') }}</strong>
                                </small>
                                <br>
                                <small style="color: var(--dorado-palido);">
                                    <i class="bi bi-calendar-check"></i> 
                                    {{ $promocion->diasAplicables ? 'Días específicos' : 'Todos los días' }}
                                </small>
                            </div>

                            <button class="btn btn-gold btn-sm mb-2 w-100" onclick="copiarCodigoPromocion('{{ $promocion->codigoPromocional }}')">
                                <i class="bi bi-clipboard"></i> Copiar Código
                            </button>
<button class="btn btn-outline-light btn-sm w-100" 
        onclick="agendarConPromocion('{{ $promocion->codigoPromocional }}')">
    <i class="bi bi-calendar-plus"></i> Agendar con esta Promoción
</button>

                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay promociones destacadas disponibles en este momento.
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Sección: COMBOS ESPECIALES -->
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="card-custom">
            <h5 class="card-title-custom">
                <i class="bi bi-box-seam-fill"></i>
                💎 Combos y Paquetes Especiales
            </h5>
            
            <div class="row g-4">
                @forelse($combos as $combo)
                <div class="col-lg-6">
                    <div class="list-item-custom" style="flex-direction: column; align-items: flex-start; background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(255, 248, 240, 0.5)); border-left: 5px solid var(--dorado-palido); min-height: 380px;">
                        <div class="d-flex align-items-start justify-content-between w-100 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="list-avatar" style="width: 70px; height: 70px; font-size: 2rem; background: linear-gradient(135deg, var(--dorado-palido), var(--champagne)); margin-right: 1rem;">
                                    <i class="bi bi-gem"></i>
                                </div>
                                <div>
                                    <h4 style="color: var(--borgona); margin: 0;">{{ $combo->nombre }}</h4>
                                    <p style="margin: 0; color: var(--borgona); opacity: 0.7;">{{ $combo->descripcion }}</p>
                                </div>
                            </div>
                            @if($loop->first)
                            <span class="badge badge-luxury">POPULAR</span>
                            @endif
                        </div>

                        <div class="w-100 mb-3">
                            <div style="background: white; padding: 1rem; border-radius: 10px; margin-bottom: 1rem;">
                                <h6 style="color: var(--borgona); margin-bottom: 0.75rem;">
                                    <i class="bi bi-check-circle-fill" style="color: var(--dorado-palido);"></i> Incluye:
                                </h6>
                                <ul style="margin: 0; padding-left: 1.5rem; color: var(--borgona);">
                                    @foreach($combo->servicios as $servicio)
                                    <li>{{ $servicio->nombre }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="row g-2">
                                <div class="col-6">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px;">
                                        <small style="color: var(--borgona); opacity: 0.7;">Duración Total</small>
                                        <br>
                                        <strong style="color: var(--borgona); font-size: 1.1rem;">
                                            <i class="bi bi-clock"></i> {{ $combo->servicios->sum('duracionBase') }} min
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="background: rgba(212, 175, 55, 0.1); padding: 0.75rem; border-radius: 8px;">
                                        <small style="color: var(--borgona); opacity: 0.7;">Precio Regular</small>
                                        <br>
                                        <span style="text-decoration: line-through; color: var(--borgona); opacity: 0.5;">
                                            ${{ number_format($combo->precioRegular, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-100 mb-3" style="background: var(--dorado-palido); padding: 1rem; border-radius: 10px;">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <h3 style="color: white; margin: 0; font-size: 2rem;">${{ number_format($combo->precioCombo, 2) }}</h3>
                                    <small style="color: white; opacity: 0.9;">
                                        <i class="bi bi-piggy-bank"></i> Ahorras <strong>${{ number_format($combo->ahorro, 2) }}</strong>
                                    </small>
                                </div>
                                <div class="col-5 text-end">
                                    <div class="badge bg-success" style="font-size: 0.9rem; padding: 0.5rem;">
                                        {{ round(($combo->ahorro / $combo->precioRegular) * 100) }}% OFF
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-gold w-100" onclick="agendarCombo({{ $combo->idCombo }})">
                            <i class="bi bi-calendar-plus"></i> Agendar Combo
                        </button>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No hay combos disponibles en este momento.
                    </div>
                </div>
                @endforelse
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


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script>
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
        // Buscar promoción
        function buscarPromocion() {
            const termino = document.getElementById('buscarPromocion').value;
            console.log('Buscar promoción:', termino);
            alert('Buscando promociones que coincidan con: ' + termino);
            // TODO: Implementar búsqueda en producción
        }

        // Ordenar promociones
        function ordenarPromociones() {
            const criterio = document.getElementById('ordenarPromociones').value;
            console.log('Ordenar por:', criterio);
            alert('Ordenando promociones por: ' + criterio);
            // TODO: Reordenar elementos en la vista
        }

        // Filtrar por categoría
        function filtrarPromocionPorCategoria(categoria) {
            console.log('Filtrar promociones por:', categoria);
            alert('Mostrando promociones de categoría: ' + categoria);
            // TODO: Filtrar elementos dinámicamente
        }

        // Copiar código de promoción
        function copiarCodigoPromocion(codigo) {
            navigator.clipboard.writeText(codigo).then(() => {
                alert('✅ Código ' + codigo + ' copiado al portapapeles!\n\n' + 
                      'Puedes usarlo al momento de agendar tu cita para aplicar el descuento.');
            }).catch(() => {
                // Fallback si el navegador no soporta clipboard API
                const input = document.createElement('input');
                input.value = codigo;
                document.body.appendChild(input);
                input.select();
                document.execCommand('copy');
                document.body.removeChild(input);
                alert('✅ Código ' + codigo + ' copiado: ' + codigo);
            });
        }

        // Agendar con promoción
function agendarConPromocion(codigo) {
    // Guardar código en localStorage temporalmente
    localStorage.setItem('promoTemp', codigo);
    
    // Redirige a la página de citas pasando el código como parámetro GET
    window.location.href = "{{ route('cliente.citasCli') }}" + "?promo=" + codigo;
}

        // Agendar combo
    function agendarCombo(comboId) {
        // Obtener ID del cliente de la sesión (pasado desde Blade)
        const clienteId = {{ session('clienteId') ?? 'null' }};

        if (!clienteId) {
            alert('No se detectó un cliente logueado.');
            return;
        }

        console.log('Agendar combo:', comboId, 'para cliente:', clienteId);

        // Redirigir a la página de citas con comboId como query param
        window.location.href = `/cliente/citasCli?comboId=${comboId}`;

    }
        // Suscribirse a promociones
        function suscribirsePromos() {
            const email = document.getElementById('emailSuscripcion').value;
            
            if (!email || !email.includes('@')) {
                alert('⚠️ Por favor ingresa un correo electrónico válido');
                return;
            }

            console.log('Suscribir email:', email);
            alert('✅ ¡Gracias por suscribirte!\n\n' +
                  'Recibirás nuestras mejores promociones en: ' + email);
            
            document.getElementById('emailSuscripcion').value = '';
            // TODO: Enviar email al backend para suscripción
        }

        // Búsqueda en tiempo real
        document.getElementById('buscarPromocion')?.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                buscarPromocion();
            }
        });

        function agendarConPromocion(codigo) {
    // Redirige a la página de citas pasando el código como parámetro GET
    window.location.href = "{{ route('cliente.citasCli') }}" + "?promo=" + codigo;

}
    </script>
    
</body>
</html>