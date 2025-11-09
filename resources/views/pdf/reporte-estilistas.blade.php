@extends('pdf.base-pdf')

@section('titulo', 'Reporte de Estilistas')
@section('subtitulo', 'Análisis de Rendimiento y Productividad')

@section('contenido')
    <!-- Mejor Estilista del Período -->
    @if($mejorEstilista)
    <div class="info-section" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border-left: 4px solid #D4AF37;">
        <h2>🏆 Estilista Destacado del Período</h2>
        <div style="text-align: center; padding: 20px;">
            <h1 style="color: #8B4049; margin-bottom: 10px;">{{ $mejorEstilista->nombre }} {{ $mejorEstilista->apellido }}</h1>
            <div style="display: flex; justify-content: center; gap: 40px; margin-top: 20px;">
                <div>
                    <div style="font-size: 24pt; font-weight: bold; color: #8B4049;">{{ $mejorEstilista->total_citas }}</div>
                    <div style="font-size: 9pt; color: #666;">Citas Completadas</div>
                </div>
                <div>
                    <div style="font-size: 24pt; font-weight: bold; color: #8B4049;">${{ number_format($mejorEstilista->ingresos_generados, 2) }}</div>
                    <div style="font-size: 9pt; color: #666;">Ingresos Generados</div>
                </div>
                <div>
                    <div style="font-size: 24pt; font-weight: bold; color: #8B4049;">${{ number_format($mejorEstilista->ticket_promedio, 2) }}</div>
                    <div style="font-size: 9pt; color: #666;">Ticket Promedio</div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Tabla de Rendimiento Completo -->
    <div class="info-section" style="margin-top: 30px;">
        <h2>⭐ Rendimiento Detallado de Todos los Estilistas</h2>
        <p style="margin-bottom: 15px;">Total de estilistas activos: <strong>{{ count($rendimientoEstilistas) }}</strong></p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 25%;">Estilista</th>
                    <th style="width: 12%;">Citas</th>
                    <th style="width: 12%;">Clientes</th>
                    <th style="width: 18%;">Ingresos</th>
                    <th style="width: 15%;">Ticket Prom.</th>
                    <th style="width: 13%;">Productividad</th>
                    <th style="width: 15%;">Calificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rendimientoEstilistas as $index => $estilista)
                <tr style="{{ $index == 0 ? 'background: #fff3cd;' : '' }}">
                    <td>
                        <strong>{{ $estilista->nombre }} {{ $estilista->apellido }}</strong>
                        @if($index == 0)
                            <br><span style="color: #D4AF37; font-size: 8pt;">🏆 Mejor del Período</span>
                        @endif
                    </td>
                    <td class="text-center"><strong>{{ $estilista->total_citas }}</strong></td>
                    <td class="text-center">{{ $estilista->clientes_atendidos }}</td>
                    <td class="text-right"><strong>${{ $estilista->ingresos_generados }}</strong></td>
                    <td class="text-right">${{ $estilista->ticket_promedio }}</td>
                    <td class="text-center">
                        {{ $estilista->productividad }}%
                        <div style="background: #e9ecef; height: 6px; border-radius: 3px; margin-top: 2px;">
                            <div style="background: #D4AF37; height: 6px; border-radius: 3px; width: {{ $estilista->productividad }}%;"></div>
                        </div>
                    </td>
                    <td class="text-center">
                        <strong>{{ $estilista->calificacion }}</strong> / 5.0
                        <br>
                        <span style="color: #D4AF37;">
                            @for($i = 1; $i <= floor($estilista->calificacion); $i++)
                                ★
                            @endfor
                            @if($estilista->calificacion - floor($estilista->calificacion) >= 0.5)
                                ½
                            @endif
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Análisis Comparativo -->
    <div class="info-section" style="margin-top: 30px;">
        <h2>📈 Análisis Comparativo</h2>
        <div style="display: flex; justify-content: space-between; gap: 15px;">
            <div style="flex: 1; background: white; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px;">
                <div style="font-size: 9pt; color: #666; margin-bottom: 5px;">Promedio de Citas</div>
                <div style="font-size: 16pt; font-weight: bold; color: #8B4049;">
                    {{ round($rendimientoEstilistas->avg('total_citas'), 1) }}
                </div>
            </div>
            <div style="flex: 1; background: white; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px;">
                <div style="font-size: 9pt; color: #666; margin-bottom: 5px;">Promedio de Ingresos</div>
                <div style="font-size: 16pt; font-weight: bold; color: #8B4049;">
                    ${{ number_format($rendimientoEstilistas->avg(function($e) { return str_replace(',', '', $e->ingresos_generados); }), 2) }}
                </div>
            </div>
            <div style="flex: 1; background: white; border: 1px solid #dee2e6; padding: 15px; border-radius: 5px;">
                <div style="font-size: 9pt; color: #666; margin-bottom: 5px;">Productividad Promedio</div>
                <div style="font-size: 16pt; font-weight: bold; color: #8B4049;">
                    {{ round($rendimientoEstilistas->avg('productividad'), 1) }}%
                </div>
            </div>
        </div>
    </div>
@endsection