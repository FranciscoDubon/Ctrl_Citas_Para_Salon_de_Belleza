@extends('pdf.base-pdf')

@section('titulo', 'Reporte Financiero')
@section('subtitulo', 'Análisis de Ingresos y Rentabilidad')

@section('contenido')
    <!-- Resumen Financiero -->
    <div class="info-section" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-left: 4px solid #28a745;">
        <h2>💰 Resumen Financiero del Período</h2>
        <div style="display: flex; justify-content: space-between; gap: 15px; margin-top: 15px;">
            <div style="flex: 1; text-align: center;">
                <div style="font-size: 9pt; color: #666;">Ingresos Totales</div>
                <div style="font-size: 24pt; font-weight: bold; color: #28a745;">${{ $kpis['ingresos_totales'] }}</div>
                <div style="font-size: 8pt; color: {{ $kpis['porcentaje_ingresos'] >= 0 ? '#28a745' : '#dc3545' }};">
                    {{ $kpis['porcentaje_ingresos'] >= 0 ? '↑' : '↓' }} {{ abs($kpis['porcentaje_ingresos']) }}% vs período anterior
                </div>
            </div>
            <div style="flex: 1; text-align: center;">
                <div style="font-size: 9pt; color: #666;">Ticket Promedio</div>
                <div style="font-size: 24pt; font-weight: bold; color: #8B4049;">${{ $kpis['ticket_promedio'] }}</div>
                <div style="font-size: 8pt; color: {{ $kpis['porcentaje_ticket'] >= 0 ? '#28a745' : '#dc3545' }};">
                    {{ $kpis['porcentaje_ticket'] >= 0 ? '↑' : '↓' }} {{ abs($kpis['porcentaje_ticket']) }}%
                </div>
            </div>
            <div style="flex: 1; text-align: center;">
                <div style="font-size: 9pt; color: #666;">Total de Transacciones</div>
                <div style="font-size: 24pt; font-weight: bold; color: #8B4049;">{{ $kpis['citas_completadas'] }}</div>
                <div style="font-size: 8pt; color: {{ $kpis['porcentaje_citas'] >= 0 ? '#28a745' : '#dc3545' }};">
                    {{ $kpis['porcentaje_citas'] >= 0 ? '↑' : '↓' }} {{ abs($kpis['porcentaje_citas']) }}%
                </div>
            </div>
        </div>
    </div>

    <!-- Ingresos por Servicio -->
    <div class="info-section" style="margin-top: 30px;">
        <h2>💵 Ingresos por Servicio</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">Pos.</th>
                    <th style="width: 32%;">Servicio</th>
                    <th style="width: 15%;">Categoría</th>
                    <th style="width: 15%;">Solicitudes</th>
                    <th style="width: 15%;">Ingresos</th>
                    <th style="width: 15%;">% Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalIngresos = $serviciosMasSolicitados->sum(function($s) {
                        return floatval(str_replace(',', '', $s->ingresos_generados));
                    });
                @endphp
                @foreach($serviciosMasSolicitados as $servicio)
                @php
                    $ingreso = floatval(str_replace(',', '', $servicio->ingresos_generados));
                    $porcentajeIngreso = $totalIngresos > 0 ? round(($ingreso / $totalIngresos) * 100, 1) : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $servicio->ranking }}</td>
                    <td><strong>{{ $servicio->nombre }}</strong></td>
                    <td>{{ strtoupper($servicio->categoria) }}</td>
                    <td class="text-center">{{ $servicio->total_solicitudes }}</td>
                    <td class="text-right"><strong>${{ $servicio->ingresos_generados }}</strong></td>
                    <td class="text-center">{{ $porcentajeIngreso }}%</td>
                </tr>
                @endforeach
                <tr style="background: #f8f9fa; font-weight: bold;">
                    <td colspan="4" class="text-right">TOTAL:</td>
                    <td class="text-right">${{ number_format($totalIngresos, 2) }}</td>
                    <td class="text-center">100%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Ingresos por Categoría -->
    <div class="info-section" style="margin-top: 30px;">
        <h2>📊 Distribución de Ingresos por Categoría</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Categoría</th>
                    <th style="width: 20%;">Servicios</th>
                    <th style="width: 20%;">% del Total</th>
                    <th style="width: 20%;">Visualización</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                <tr>
                    <td><strong>{{ ucfirst($categoria->categoria) }}</strong></td>
                    <td class="text-center">{{ $categoria->total_servicios }}</td>
                    <td class="text-center"><strong>{{ $categoria->porcentaje }}%</strong></td>
                    <td>
                        <div style="background: #e9ecef; height: 10px; border-radius: 5px;">
                            <div style="background: #28a745; height: 10px; border-radius: 5px; width: {{ $categoria->porcentaje }}%;"></div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Conclusiones Financieras -->
    <div class="info-section" style="margin-top: 30px; background: #e7f3ff; border-left: 4px solid #007bff;">
        <h2>📌 Conclusiones y Recomendaciones</h2>
        <ul style="margin-left: 20px; line-height: 1.8;">
            <li><strong>Servicio con mayor rentabilidad:</strong> {{ $serviciosMasSolicitados->first()->nombre }} generó ${{ $serviciosMasSolicitados->first()->ingresos_generados }}</li>
            <li><strong>Categoría más rentable:</strong> {{ $categorias->first()->categoria }} representa el {{ $categorias->first()->porcentaje }}% de los servicios</li>
            <li><strong>Crecimiento de ingresos:</strong> {{ $kpis['porcentaje_ingresos'] >= 0 ? 'Incremento' : 'Decremento' }} del {{ abs($kpis['porcentaje_ingresos']) }}% respecto al período anterior</li>
            <li><strong>Ticket promedio:</strong> ${{ $kpis['ticket_promedio'] }} con {{ $kpis['porcentaje_ticket'] >= 0 ? 'tendencia positiva' : 'tendencia negativa' }}</li>
        </ul>
    </div>
@endsection