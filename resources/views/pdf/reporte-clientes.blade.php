@extends('pdf.base-pdf')

@section('titulo', 'Reporte de Clientes')
@section('subtitulo', 'Historial Detallado de Clientes')

@section('contenido')
    <div class="info-section">
        <h2>👥 Historial Completo de Clientes</h2>
        <p style="margin-bottom: 15px;">Total de clientes en el período: <strong>{{ count($historialClientes) }}</strong></p>
        
        <table>
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Total Citas</th>
                    <th>Total Gastado</th>
                    <th>Ticket Prom.</th>
                    <th>Primera Visita</th>
                    <th>Última Visita</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historialClientes as $cliente)
                <tr>
                    <td><strong>{{ $cliente->nombre }} {{ $cliente->apellido }}</strong></td>
                    <td style="font-size: 8pt;">
                        {{ $cliente->correoElectronico }}<br>
                        {{ $cliente->telefono }}
                    </td>
                    <td class="text-center">{{ $cliente->total_citas }}</td>
                    <td class="text-right"><strong>${{ $cliente->total_gastado }}</strong></td>
                    <td class="text-right">${{ $cliente->ticket_promedio }}</td>
                    <td class="text-center">{{ $cliente->primera_visita }}</td>
                    <td class="text-center">{{ $cliente->ultima_visita }}</td>
                    <td><span class="badge {{ $cliente->badge_class }}">{{ $cliente->estado }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection