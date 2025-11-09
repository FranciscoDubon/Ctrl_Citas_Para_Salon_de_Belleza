@extends('pdf.base-pdf')

@section('titulo', 'Reporte de Servicios')
@section('subtitulo', 'Servicios Más Solicitados y Análisis por Categoría')

@section('contenido')
    <!-- Servicios Más Solicitados -->
    <div class="info-section">
        <h2>✂️ Ranking de Servicios Más Solicitados</h2>
        <p style="margin-bottom: 15px;">Total de servicios solicitados: <strong>{{ $serviciosMasSolicitados->sum('total_solicitudes') }}</strong></p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">Ranking</th>
                    <th style="width: 30%;">Servicio</th>
                    <th style="width: 15%;">Categoría</th>
                    <th style="width: 15%;">Solicitudes</th>
                    <th style="width: 15%;">Ingresos</th>
                    <th style="width: 17%;">% del Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($serviciosMasSolicitados as $servicio)
                <tr>
                    <td class="text-center">
                        @if($servicio->ranking == 1)
                            <span class="highlight">🏆 #1</span>
                        @elseif($servicio->ranking == 2)
                            <span class="highlight">🥈 #2</span>
                        @elseif($servicio->ranking == 3)
                            <span class="highlight">🥉 #3</span>
                        @else
                            #{{ $servicio->ranking }}
                        @endif
                    </td>
                    <td><strong>{{ $servicio->nombre }}</strong></td>
                    <td><span class="badge badge-gold">{{ strtoupper($servicio->categoria) }}</span></td>
                    <td class="text-center"><strong>{{ $servicio->total_solicitudes }}</strong></td>
                    <td class="text-right">${{ $servicio->ingresos_generados }}</td>
                    <td class="text-center">{{ $servicio->porcentaje }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Análisis por Categorías -->
    <div class="info-section" style="margin-top: 30px;">
        <h2>📊 Distribución por Categorías</h2>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Categoría</th>
                    <th style="width: 30%;">Total Servicios</th>
                    <th style="width: 30%;">Porcentaje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                <tr>
                    <td><strong>{{ ucfirst($categoria->categoria) }}</strong></td>
                    <td class="text-center">{{ $categoria->total_servicios }}</td>
                    <td class="text-center">
                        <strong>{{ $categoria->porcentaje }}%</strong>
                        <div style="background: #e9ecef; height: 8px; border-radius: 4px; margin-top: 3px;">
                            <div style="background: #8B4049; height: 8px; border-radius: 4px; width: {{ $categoria->porcentaje }}%;"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Resumen Ejecutivo -->
    <div class="info-section" style="margin-top: 30px; background: #fff3cd;">
        <h2>💡 Resumen Ejecutivo</h2>
        <ul style="margin-left: 20px; line-height: 1.8;">
            <li><strong>Servicio más popular:</strong> {{ $serviciosMasSolicitados->first()->nombre }} con {{ $serviciosMasSolicitados->first()->total_solicitudes }} solicitudes</li>
            <li><strong>Categoría dominante:</strong> {{ $categorias->first()->categoria }} representa el {{ $categorias->first()->porcentaje }}% del total</li>
            <li><strong>Ingresos por servicio más alto:</strong> ${{ $serviciosMasSolicitados->first()->ingresos_generados }}</li>
        </ul>
    </div>
@endsection