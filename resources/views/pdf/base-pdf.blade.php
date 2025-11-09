<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.4;
        }
        
        .header {
            background: linear-gradient(135deg, #8B4049 0%, #A85763 100%);
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 24pt;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11pt;
            opacity: 0.9;
        }
        
        .info-section {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #D4AF37;
        }
        
        .info-section h2 {
            color: #8B4049;
            font-size: 14pt;
            margin-bottom: 10px;
            border-bottom: 2px solid #E8D5C4;
            padding-bottom: 5px;
        }
        
        .kpi-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }
        
        .kpi-box {
            flex: 1;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
        }
        
        .kpi-box .label {
            font-size: 9pt;
            color: #666;
            margin-bottom: 5px;
        }
        
        .kpi-box .value {
            font-size: 18pt;
            font-weight: bold;
            color: #8B4049;
        }
        
        .kpi-box .change {
            font-size: 8pt;
            color: #28a745;
            margin-top: 5px;
        }
        
        .kpi-box .change.negative {
            color: #dc3545;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9pt;
        }
        
        table thead {
            background: #8B4049;
            color: white;
        }
        
        table thead th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
        }
        
        table tbody td {
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        
        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: 600;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #333;
        }
        
        .badge-gold {
            background: #D4AF37;
            color: white;
        }
        
        .badge-soft {
            background: #e9ecef;
            color: #495057;
        }
        
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8pt;
            color: #666;
            padding: 10px 0;
            border-top: 1px solid #dee2e6;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .mb-20 {
            margin-bottom: 20px;
        }
        
        .highlight {
            background: #fff3cd;
            padding: 2px 5px;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🌸 BeautySalon</h1>
        <p>@yield('subtitulo')</p>
    </div>

    <div class="info-section mb-20">
        <table style="border: none; margin: 0;">
            <tr>
                <td style="border: none;"><strong>Período:</strong> {{ $periodo == 'personalizado' ? 'Personalizado' : ucfirst($periodo) }}</td>
                <td style="border: none; text-align: right;"><strong>Fecha de generación:</strong> {{ $fechaGeneracion }}</td>
            </tr>
            <tr>
                <td style="border: none;"><strong>Desde:</strong> {{ $fechaInicio }}</td>
                <td style="border: none; text-align: right;"><strong>Hasta:</strong> {{ $fechaFin }}</td>
            </tr>
        </table>
    </div>

    <!-- KPIs Generales -->
    <div class="info-section">
        <h2>📊 Indicadores Clave de Desempeño (KPIs)</h2>
        <div class="kpi-container">
            <div class="kpi-box">
                <div class="label">Citas Completadas</div>
                <div class="value">{{ $kpis['citas_completadas'] }}</div>
                <div class="change {{ $kpis['porcentaje_citas'] >= 0 ? '' : 'negative' }}">
                    {{ $kpis['porcentaje_citas'] >= 0 ? '↑' : '↓' }} {{ abs($kpis['porcentaje_citas']) }}%
                </div>
            </div>
            <div class="kpi-box">
                <div class="label">Ingresos Totales</div>
                <div class="value">${{ $kpis['ingresos_totales'] }}</div>
                <div class="change {{ $kpis['porcentaje_ingresos'] >= 0 ? '' : 'negative' }}">
                    {{ $kpis['porcentaje_ingresos'] >= 0 ? '↑' : '↓' }} {{ abs($kpis['porcentaje_ingresos']) }}%
                </div>
            </div>
            <div class="kpi-box">
                <div class="label">Ticket Promedio</div>
                <div class="value">${{ $kpis['ticket_promedio'] }}</div>
                <div class="change {{ $kpis['porcentaje_ticket'] >= 0 ? '' : 'negative' }}">
                    {{ $kpis['porcentaje_ticket'] >= 0 ? '↑' : '↓' }} {{ abs($kpis['porcentaje_ticket']) }}%
                </div>
            </div>
            <div class="kpi-box">
                <div class="label">Clientes Únicos</div>
                <div class="value">{{ $kpis['clientes_unicos'] }}</div>
                <div class="change">
                    +{{ $kpis['clientes_nuevos'] }} nuevos
                </div>
            </div>
        </div>
    </div>

    @yield('contenido')

    <div class="footer">
        <p>BeautySalon - Sistema de Gestión | Grupo 03 - IGF115 | Página {PAGE_NUM} de {PAGE_COUNT}</p>
    </div>
</body>
</html>