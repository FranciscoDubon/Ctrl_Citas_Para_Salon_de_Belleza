@extends('pdf.base-pdf')

@section('titulo', 'Reporte General')
@section('subtitulo', 'Reporte General del Salón')

@section('contenido')
    <!-- Top 5 Clientes -->
    <div class="info-section">
        <h2>👥 Top 5 Clientes Frecuentes</h2>
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Citas</th>
                    <th>Total Gastado</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historialClientes as $cliente)
                <tr>
                    <td><strong>{{ $cliente->nombre }} {{ $cliente->apellido }}</strong></td>
                    <td>{{ $cliente->telefono }}</td>
                    <td class="text-center">{{ $cliente->total_citas }}</td>
                    <td class="text-right">${{ $cliente->total_gastado }}</td>
                    <td><span class="badge {{ $cliente->badge_class }}">{{ $cliente->estado }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Top 5 Servicios -->
    <div class="info-section">
        <h2>✂️ Top 5 Servicios Más Solicitados</h2>
        <table>
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Servicio</th>
                    <th>Categoría</th>
                    <th>Solicitudes</th>
                    <th>Ingresos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviciosMasSolicitados as $servicio)
                <tr>
                    <td class="text-center">
                        @if($servicio->ranking <= 3)
                            <span class="highlight">#{{ $servicio->ranking }}</span>
                        @else
                            #{{ $servicio->ranking }}
                        @endif
                    </td>
                    <td><strong>{{ $servicio->nombre }}</strong></td>
                    <td>{{ strtoupper($servicio->categoria) }}</td>
                    <td class="text-center">{{ $servicio->total_solicitudes }}</td>
                    <td class="text-right">${{ $servicio->ingresos_generados }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Top 5 Estilistas -->
    <div class="info-section">
        <h2>⭐ Top 5 Estilistas con Mejor Rendimiento</h2>
        <table>
            <thead>
                <tr>
                    <th>Estilista</th>
                    <th>Citas</th>
                    <th>Clientes</th>
                    <th>Ingresos</th>
                    <th>Productividad</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rendimientoEstilistas as $estilista)
                <tr>
                    <td><strong>{{ $estilista->nombre }} {{ $estilista->apellido }}</strong></td>
                    <td class="text-center">{{ $estilista->total_citas }}</td>
                    <td class="text-center">{{ $estilista->clientes_atendidos }}</td>
                    <td class="text-right">${{ $estilista->ingresos_generados }}</td>
                    <td class="text-center">{{ $estilista->productividad }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection