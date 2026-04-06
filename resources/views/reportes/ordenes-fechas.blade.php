{{-- resources/views/reportes/ordenes-resultados.blade.php --}}
@extends('adminlte::page')

@section('title', 'MISUPER - Reporte por Fechas')

@section('content_header')

<div class="d-flex justify-content-between align-items-center">
    <h1 class="h4 mb-0">
        <i class="fas fa-chart-bar text-primary mr-2"></i>
        {{ $titulo }}
    </h1>
    <div>
        <span class="badge badge-primary">
            <i class="fas fa-file-invoice-dollar mr-1"></i>
            {{ $ordenes->count() }} órdenes
        </span>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <!-- Encabezado para impresión (solo visible al imprimir) -->
    <div class="print-header" style="display: none;">
        <div class="header-section">
            <div class="header-logo">
                <div class="logo-container">
                    <div class="logo-placeholder">
                        @if(config('adminlte.logo_img'))
                            <img src="{{ asset(config('adminlte.logo_img')) }}" alt="Logo" style="width: 60px; height: 60px;">
                        @else
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 60px; height: 60px;">
                        @endif
                    </div>
                </div>
                <div class="header-info">
                    <h1><i class="fas fa-file-invoice-dollar me-2"></i>REPORTE DE ÓRDENES</h1>
                    <h2>MISUPER</h2>
                </div>
            </div>
            <div class="mt-2">
                <span class="nro-control-formateado">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                </span>
                <span class="badge-status badge-aprobado">
                    {{ $ordenes->count() }} órdenes
                </span>
            </div>
        </div>
    </div>

    <!-- Formulario oculto para exportar Excel -->
    <form id="exportExcelForm" action="{{ route('reportes.exportar.excel') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="fecha_inicio" value="{{ $fechaInicio }}">
        <input type="hidden" name="fecha_fin" value="{{ $fechaFin }}">
        <input type="hidden" name="estado" value="{{ $estado }}">
    </form>

    <!-- Información del Reporte -->
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="info-box bg-gradient-vinotinto">
                <span class="info-box-icon"><i class="far fa-calendar-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Período Factura</span>
                    <span class="info-box-number">
                        {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}<br>
                        al {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="info-box bg-gradient-success">
                <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total en Bs</span>
                    <span class="info-box-number">
                        {{ number_format($ordenes->sum('Monto_en_Bs'), 2, ',', '.') }}
                    </span>
                    <div class="progress">
                        <div class="progress-bar bg-light" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="info-box bg-gradient-warning">
                <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total en $</span>
                    <span class="info-box-number">
                        ${{ number_format($ordenes->sum('Monto_en_dolares'), 2, ',', '.') }}
                    </span>
                    <div class="progress">
                        <div class="progress-bar bg-light" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="info-box bg-gradient-info">
                <span class="info-box-icon"><i class="fas fa-credit-card"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Métodos de Pago</span>
                    <span class="info-box-number">
                        {{ $ordenes->unique('Metodo_de_pago')->count() }} tipos
                    </span>
                    <div class="progress">
                        <div class="progress-bar bg-light" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Principal -->
    <div class="card card-vinotinto card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list mr-2"></i>
                Detalle de Órdenes por Fecha de Factura
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" onclick="imprimirReporteCompleto()" title="Imprimir">
                    <i class="fas fa-print"></i>
                </button>
                <button type="button" class="btn btn-tool" onclick="exportToExcelProfesional()" title="Exportar Excel">
                    <i class="fas fa-file-excel"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Minimizar">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        
        <div class="card-body p-0">
            <!-- Botones de Acción -->
            <div class="p-3 border-bottom no-print">
                <div class="action-buttons">
                    <a href="{{ route('ordenes.fechas.form') }}" class="btn btn-custom btn-vinotinto">
                        <i class="fas fa-search mr-1"></i> Nueva Búsqueda
                    </a>
                    <button type="button" class="btn btn-custom btn-success" onclick="exportToExcelProfesional()">
                        <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                    </button>
                    <button type="button" class="btn btn-custom btn-info" onclick="imprimirReporteCompleto()">
                        <i class="fas fa-print mr-1"></i> Imprimir
                    </button>
                    <a href="{{ route('reportes.menu') }}" class="btn btn-custom btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Volver
                    </a>
                </div>
            </div>

            <!-- Resumen del Reporte -->
            <div class="bg-light p-3 border-bottom">
                <div class="row">
                    <div class="col-md-2">
                        <div class="info-label">
                            <i class="fas fa-filter text-vinotinto mr-1"></i> <strong>Estado:</strong>
                        </div>
                        <span class="estado-badge 
                            @switch($estado)
                                @case('todas') badge-secondary @break
                                @case('aprobadas') badge-success @break
                                @case('pendientes') badge-warning @break
                            @endswitch">
                            @switch($estado)
                                @case('todas') Todas las órdenes @break
                                @case('aprobadas') Solo aprobadas @break
                                @case('pendientes') Solo pendientes @break
                            @endswitch
                        </span>
                    </div>
                    <div class="col-md-2">
                        <div class="info-label">
                            <i class="fas fa-calendar text-vinotinto mr-1"></i> <strong>Período:</strong>
                        </div>
                        <div>
                            {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - 
                            {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="info-label">
                            <i class="fas fa-chart-line text-vinotinto mr-1"></i> <strong>Tasa Prom:</strong>
                        </div>
                        <div>
                            @if($ordenes->count() > 0)
                                {{ number_format($ordenes->avg('Tasa_usada'), 2, ',', '.') }}
                            @else
                                0,00
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="info-label">
                            <i class="fas fa-credit-card text-vinotinto mr-1"></i> <strong>Métodos:</strong>
                        </div>
                        <div>
                            {{ $ordenes->unique('Metodo_de_pago')->count() }} tipos
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="info-label">
                            <i class="fas fa-hashtag text-vinotinto mr-1"></i> <strong>Registros:</strong>
                        </div>
                        <div>
                            {{ $ordenes->count() }} órdenes
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="info-label">
                            <i class="fas fa-exchange-alt text-vinotinto mr-1"></i> <strong>Con Ref:</strong>
                        </div>
                        <div>
                            {{ $ordenes->whereNotNull('Referencia')->count() }} con referencia
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Resultados -->
            @if($ordenes->count() > 0)
                <div class="table-responsive">
                    <table id="tablaReporte" class="table table-custom table-hover table-sm">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-file-invoice mr-1"></i> Fecha Factura
                                </th>
                                <th class="text-center" style="width: 90px;">
                                    <i class="fas fa-hashtag mr-1"></i> Correlativo
                                </th>
                                <th style="width: 120px;">
                                    <i class="fas fa-user mr-1"></i> Beneficiario
                                </th>
                                <th style="width: 150px;">
                                    <i class="fas fa-building mr-1"></i> Proveedor
                                </th>
                                <th class="text-right" style="width: 110px;">
                                    <i class="fas fa-money-bill-wave mr-1"></i> Monto Bs
                                </th>
                                <th class="text-right" style="width: 110px;">
                                    <i class="fas fa-dollar-sign mr-1"></i> Monto $
                                </th>
                                <th class="text-center" style="width: 90px;">
                                    <i class="fas fa-chart-line mr-1"></i> Tasa
                                </th>
                                <th style="width: 120px;">
                                    <i class="fas fa-user-tie mr-1"></i> Responsable
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-credit-card mr-1"></i> Método Pago
                                </th>
                                <th class="text-center" style="width: 100px;">
                                    <i class="fas fa-receipt mr-1"></i> Referencia
                                </th>
                                <th class="text-center" style="width: 90px;">
                                    <i class="fas fa-check-circle mr-1"></i> Estado
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ordenes as $orden)
                            @php
                                // Formatear correlativo: CZ + 6 dígitos con ceros
                                $numero = $orden->Correlativo;
                                if (strpos($numero, 'CZ') === 0) {
                                    $numero = substr($numero, 2);
                                }
                                $numero = preg_replace('/[^0-9]/', '', $numero);
                                $correlativo = 'CZ' . str_pad($numero, 6, '0', STR_PAD_LEFT);
                                
                                // Determinar clase de estado
                                $estadoClase = $orden->Estatus == 1 ? 'badge-success' : 'badge-warning';
                                $estadoTexto = $orden->Estatus == 1 ? 'Aprobada' : 'Pendiente';
                                
                                // Usar Fecha_Factura en lugar de Fecha
                                $fechaFactura = $orden->Fecha_Factura ?? null;
                                
                                // Método de pago
                                $metodoPago = $orden->Metodo_de_pago ?? 'No especificado';
                                $referencia = $orden->Referencia ?? null;
                            @endphp
                            <tr>
                                <td class="text-center">
                                    @if($fechaFactura)
                                        <span class="text-primary">
                                            {{ \Carbon\Carbon::parse($fechaFactura)->format('d/m/Y') }}
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($fechaFactura)->format('H:i') }}
                                        </small>
                                    @else
                                        <span class="text-muted" title="Sin fecha de factura">
                                            <i class="fas fa-calendar-times"></i> Sin fecha
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="nro-control-formateado">
                                        {{ $correlativo }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-dark">{{ $orden->Beneficiario }}</span>
                                </td>
                                <td>
                                    <small>{{ $orden->PROVEEDORES }}</small>
                                </td>
                                <td class="text-right font-weight-bold" style="color: #B22222;">
                                    {{ number_format($orden->Monto_en_Bs, 2, ',', '.') }}
                                </td>
                                <td class="text-right font-weight-bold" style="color: #228B22;">
                                    ${{ number_format($orden->Monto_en_dolares, 2, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill" style="background: #1E90FF; color: white; padding: 4px 8px;">
                                        {{ number_format($orden->Tasa_usada, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill" style="background: #6c757d; color: white; padding: 4px 8px;">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        {{ $orden->Responsable }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill" style="background: #20B2AA; color: white; padding: 4px 8px;">
                                        <i class="fas fa-credit-card mr-1"></i>
                                        {{ $metodoPago }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($referencia)
                                        <span class="badge rounded-pill" style="background: #9370DB; color: white; padding: 4px 8px;">
                                            <i class="fas fa-receipt mr-1"></i>
                                            {{ substr($referencia, 0, 15) }}{{ strlen($referencia) > 15 ? '...' : '' }}
                                        </span>
                                    @else
                                        <span class="text-muted" style="font-size: 0.85em;">
                                            <i class="fas fa-minus"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="estado-badge {{ $estadoClase }}">
                                        @if($orden->Estatus == 1)
                                            <i class="fas fa-check mr-1"></i> Aprobada
                                        @else
                                            <i class="fas fa-clock mr-1"></i> Pendiente
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-100">
                            <tr class="font-weight-bold">
                                <td colspan="4" class="text-right">
                                    TOTALES:
                                </td>
                                <td class="text-right" style="color: #B22222; font-size: 1.1em;">
                                    {{ number_format($ordenes->sum('Monto_en_Bs'), 2, ',', '.') }}
                                </td>
                                <td class="text-right" style="color: #228B22; font-size: 1.1em;">
                                    ${{ number_format($ordenes->sum('Monto_en_dolares'), 2, ',', '.') }}
                                </td>
                                <td colspan="5"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No se encontraron órdenes</h4>
                        <p class="text-muted mb-4">
                            No hay órdenes registradas en el período seleccionado.
                        </p>
                        <div class="action-buttons mt-3">
                            <a href="{{ route('ordenes.fechas.form') }}" class="btn btn-custom btn-vinotinto">
                                <i class="fas fa-search mr-1"></i> Nueva Búsqueda
                            </a>
                            <a href="{{ route('reportes.menu') }}" class="btn btn-custom btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Volver al Menú
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
        <div class="card-footer">
            <div class="row">
                <div class="col-md-4 text-left no-print">
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Reporte generado el {{ now()->format('d/m/Y H:i:s') }}
                    </small>
                </div>
                <div class="col-md-4 text-center only-print">
                    <div class="footer-section">
                        <p class="mb-1">
                            <i class="fas fa-lock me-1"></i>
                            Documento generado por MISUPER
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Generado el {{ now()->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-4 text-right no-print">
                    <small class="text-muted">
                        <i class="fas fa-file-invoice-dollar mr-1"></i>
                        Sistema de Órdenes de Compra MISUPER
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* Estilos personalizados - Tema Vinotinto */
    .bg-gradient-vinotinto {
        background: linear-gradient(135deg, #8a0a27, #B22222) !important;
        color: white !important;
    }
    
    .card-vinotinto {
        border-color: #8a0a27;
    }
    
    .card-vinotinto .card-header {
        background: linear-gradient(135deg, #8a0a27, #B22222);
        color: white;
        border-bottom: 1px solid #8a0a27;
    }
    
    .text-vinotinto {
        color: #8a0a27 !important;
    }
    
    .info-box {
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 0;
        min-height: 80px;
    }
    
    .info-box-icon {
        border-radius: 8px 0 0 8px;
        width: 70px;
    }
    
    .info-box-content {
        padding: 10px;
    }
    
    .info-box-number {
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .bg-gradient-info {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
    }
    
    .bg-gradient-success {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%) !important;
    }
    
    .bg-gradient-warning {
        background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%) !important;
    }
    
    /* Encabezado para impresión */
    .print-header {
        display: none;
    }
    
    .header-section {
        background: linear-gradient(135deg, #8a0a27, #B22222);
        color: white;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-bottom: 20px;
        border-radius: 8px;
    }
    
    .header-logo {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .logo-container {
        background: white;
        padding: 10px;
        border-radius: 8px;
        margin-right: 15px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    
    .logo-placeholder {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8a0a27;
        font-size: 24px;
        border: 2px solid #eaeaea;
    }
    
    .header-info {
        flex: 1;
        text-align: center;
    }
    
    .header-section h1 {
        font-size: 22px;
        margin-bottom: 5px;
        font-weight: 700;
        color: white;
    }
    
    .header-section h2 {
        font-size: 16px;
        margin-bottom: 5px;
        font-weight: 400;
        opacity: 0.9;
        color: white;
    }
    
    .nro-control-formateado {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        background: #8a0a27;
        color: white;
        padding: 6px 8px;
        border-radius: 4px;
        letter-spacing: 1px;
        font-size: 13px;
        display: inline-block;
    }
    
    .badge-status {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
        margin-left: 10px;
    }
    
    .badge-aprobado { background-color: #32CD32; color: white; }
    .badge-pendiente { background-color: #FFA500; color: #212529; }
    
    /* Botones personalizados */
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .btn-custom {
        padding: 7px 15px;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s ease;
        border: none;
        color: white;
        font-size: 14px;
    }
    
    .btn-vinotinto {
        background: linear-gradient(135deg, #8a0a27, #B22222);
    }
    
    .btn-vinotinto:hover {
        background: linear-gradient(135deg, #6B0000, #9B1A1A);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(139, 0, 0, 0.3);
        color: white;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #228B22, #32CD32);
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #1A7A1A, #28A428);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        color: white;
    }
    
    .btn-info {
        background: linear-gradient(135deg, #1E90FF, #4169E1);
    }
    
    .btn-info:hover {
        background: linear-gradient(135deg, #187BCD, #3159B9);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
        color: white;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d, #495057);
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #5a6268, #343a40);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        color: white;
    }
    
    /* Tabla personalizada - Ajustada para más columnas */
    .table-custom {
        margin-bottom: 0;
        font-size: 13px;
    }
    
    .table-custom thead {
        background: linear-gradient(135deg, #8a0a27, #B22222);
        color: white;
    }
    
    .table-custom th {
        border: none;
        padding: 10px 8px;
        font-weight: 600;
        font-size: 13px;
    }
    
    .table-custom td {
        padding: 8px 6px;
        vertical-align: middle;
        border-color: #eee;
        font-size: 13px;
    }
    
    .estado-badge {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    /* Estilos para campos de información */
    .info-label {
        font-weight: 600;
        color: #555;
        display: flex;
        align-items: center;
        margin-bottom: 3px;
        font-size: 12px;
    }
    
    .info-label i {
        margin-right: 6px;
        width: 16px;
    }
    
    /* Estilos para impresión */
    @media print {
        body {
            background: white !important;
            color: black !important;
            font-size: 10px !important;
        }
        
        .no-print {
            display: none !important;
        }
        
        .only-print {
            display: block !important;
        }
        
        .print-header {
            display: block !important;
            page-break-inside: avoid;
        }
        
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            max-width: 100% !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
            margin: 0 !important;
        }
        
        .card-header, .card-footer {
            background: white !important;
            color: black !important;
            border: 1px solid #ddd !important;
            font-size: 10px !important;
        }
        
        .info-box {
            background: #f8f9fa !important;
            color: #000 !important;
            border: 1px solid #dee2e6 !important;
            margin-bottom: 8px !important;
            page-break-inside: avoid;
            font-size: 10px !important;
        }
        
        .info-box-icon {
            background: #e9ecef !important;
            color: #000 !important;
        }
        
        .table-custom {
            border: 1px solid #ddd !important;
            font-size: 9px !important;
        }
        
        .table-custom thead {
            background: #f8f9fa !important;
            color: #000 !important;
            border-bottom: 2px solid #ddd !important;
        }
        
        .table-custom th, .table-custom td {
            border: 1px solid #ddd !important;
            padding: 4px 5px !important;
            font-size: 9px !important;
        }
        
        .nro-control-formateado {
            background: #f8f9fa !important;
            color: #000 !important;
            border: 1px solid #ddd !important;
            font-size: 9px !important;
            padding: 3px 5px !important;
        }
        
        .estado-badge, .badge {
            border: 1px solid #ddd !important;
            background-color: #fff !important;
            color: #000 !important;
            font-size: 8px !important;
            padding: 2px 5px !important;
        }
        
        /* Ajustar márgenes para impresión */
        @page {
            margin: 0.3cm;
            size: landscape; /* Cambiar a landscape para más columnas */
        }
        
        /* Evitar que la tabla se divida entre páginas */
        table {
            page-break-inside: auto;
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        thead {
            display: table-header-group;
        }
    }
    
    @media (max-width: 1200px) {
        .table-custom {
            font-size: 12px;
        }
        
        .table-custom th, .table-custom td {
            padding: 6px 4px;
        }
        
        .btn-custom {
            font-size: 13px;
            padding: 6px 12px;
        }
    }
    
    @media (max-width: 768px) {
        .info-box {
            margin-bottom: 0.8rem;
        }
        
        .info-box-number {
            font-size: 0.9rem;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        .table-custom td, .table-custom th {
            white-space: nowrap;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-custom {
            width: 100%;
            margin-bottom: 5px;
            justify-content: center;
        }
        
        .info-label {
            font-size: 11px;
        }
    }
</style>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Inicializar DataTable con ordenamiento personalizado
        $('#tablaReporte').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
            },
            "order": [[0, 'desc']], // Ordenar por Fecha Factura descendente
            "pageLength": 25,
            "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                   '<"row"<"col-sm-12"tr>>' +
                   '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            "columnDefs": [
                {
                    "targets": [0], // Columna Fecha Factura
                    "type": "date-eu",
                    "orderData": [0],
                    "render": function(data, type, row) {
                        if (type === 'sort') {
                            const dateText = $(data).find('.text-primary').text() || $(data).text();
                            if (dateText.includes('Sin fecha')) {
                                return '1970-01-01';
                            }
                            const parts = dateText.split('/');
                            if (parts.length === 3) {
                                return parts[2] + '-' + parts[1] + '-' + parts[0];
                            }
                            return '1970-01-01';
                        }
                        return data;
                    }
                },
                {
                    "targets": [1], // Columna Correlativo
                    "type": "num",
                    "render": function(data, type, row) {
                        if (type === 'sort') {
                            const num = data.replace('CZ', '').replace(/[^0-9]/g, '');
                            return parseInt(num, 10) || 0;
                        }
                        return data;
                    }
                },
                {
                    "targets": [4, 5], // Columnas de montos
                    "className": "text-right",
                    "type": "num-fmt"
                },
                {
                    "targets": [6, 10], // Columnas de tasa y estado
                    "className": "text-center"
                },
                {
                    "targets": [8, 9], // Columnas de método pago y referencia
                    "className": "text-center",
                    "orderable": false
                }
            ],
            "drawCallback": function(settings) {
                // Re-aplicar estilos después de ordenar
                $('.nro-control-formateado').each(function() {
                    const text = $(this).text();
                    const num = text.replace('CZ', '').replace(/[^0-9]/g, '');
                    $(this).text('CZ' + num.padStart(6, '0'));
                });
            }
        });
    });
    
    // Exportar a Excel profesional
    function exportToExcelProfesional() {
        const swalInstance = Swal.fire({
            title: 'Generando Excel Profesional',
            html: `
                <div class="text-center">
                    <div class="spinner-border text-vinotinto mb-3" role="status"></div>
                    <p class="mb-0">Procesando <strong>{{ $ordenes->count() }}</strong> registros...</p>
                    <small class="text-muted">Esto puede tardar unos segundos</small>
                </div>
            `,
            allowOutsideClick: false,
            showConfirmButton: false,
            showCancelButton: false,
            didOpen: () => {
                setTimeout(() => {
                    const iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.name = 'excelDownloadFrame';
                    document.body.appendChild(iframe);
                    
                    const form = document.getElementById('exportExcelForm');
                    form.target = 'excelDownloadFrame';
                    form.submit();
                    
                    setTimeout(() => {
                        swalInstance.close();
                        setTimeout(() => {
                            if (document.body.contains(iframe)) {
                                document.body.removeChild(iframe);
                            }
                        }, 5000);
                    }, 1000);
                }, 500);
            }
        });
    }
    
    // Imprimir reporte completo con nuevas columnas
    function imprimirReporteCompleto() {
        Swal.fire({
            title: 'Preparando para impresión',
            html: `
                <div class="text-center">
                    <div class="spinner-border text-info mb-3" role="status"></div>
                    <p class="mb-0">Preparando <strong>{{ $ordenes->count() }}</strong> registros para imprimir...</p>
                    <small class="text-muted">Por favor, espere</small>
                </div>
            `,
            allowOutsideClick: false,
            showConfirmButton: false,
            showCancelButton: false,
            timer: 1000,
            timerProgressBar: true,
            didOpen: () => {
                setTimeout(() => {
                    var ventanaImpresion = window.open('', '_blank');
                    
                    var html = `
                    <html>
                        <head>
                            <title>MISUPER - {{ $titulo }}</title>
                            <style>
                                @media print {
                                    @page { 
                                        margin: 0.3cm; 
                                        size: landscape; 
                                    }
                                    
                                    body { 
                                        font-family: Arial, sans-serif; 
                                        font-size: 9px; 
                                        color: #000; 
                                        background: white; 
                                        margin: 0; 
                                        padding: 0; 
                                    }
                                    
                                    .header-print { 
                                        background: linear-gradient(135deg, #8a0a27, #B22222);
                                        color: white; 
                                        padding: 10px 15px; 
                                        border-radius: 4px; 
                                        margin-bottom: 10px;
                                        page-break-after: avoid;
                                    }
                                    
                                    .header-print h2 { 
                                        margin: 0 0 4px 0; 
                                        font-size: 14px; 
                                        font-weight: bold;
                                    }
                                    
                                    .header-print p { 
                                        margin: 2px 0; 
                                        font-size: 9px; 
                                    }
                                    
                                    table { 
                                        border-collapse: collapse; 
                                        width: 100%; 
                                        margin-bottom: 10px; 
                                        page-break-inside: auto;
                                        font-size: 8px;
                                    }
                                    
                                    tr { 
                                        page-break-inside: avoid; 
                                        page-break-after: auto; 
                                    }
                                    
                                    thead { 
                                        display: table-header-group; 
                                        background: #f8f9fa !important;
                                    }
                                    
                                    th { 
                                        background-color: #8a0a27; 
                                        color: white; 
                                        font-weight: bold; 
                                        padding: 4px 5px; 
                                        border: 1px solid #ddd; 
                                        text-align: left; 
                                        font-size: 8px;
                                    }
                                    
                                    td { 
                                        padding: 3px 4px; 
                                        border: 1px solid #ddd; 
                                        vertical-align: top; 
                                        font-size: 8px;
                                    }
                                    
                                    .text-right { text-align: right; }
                                    .text-center { text-align: center; }
                                    .font-bold { font-weight: bold; }
                                    
                                    .totals-row { 
                                        background-color: #f8f9fa; 
                                        font-weight: bold;
                                    }
                                    
                                    .footer-print { 
                                        text-align: center; 
                                        font-size: 8px; 
                                        color: #666; 
                                        margin-top: 15px;
                                        border-top: 1px solid #ddd;
                                        padding-top: 8px;
                                        page-break-before: avoid;
                                    }
                                    
                                    tr { page-break-inside: avoid; }
                                    
                                    tfoot { page-break-inside: avoid; }
                                }
                                
                                body { 
                                    font-family: Arial, sans-serif; 
                                    font-size: 10px; 
                                    color: #000; 
                                    background: white; 
                                    margin: 10px; 
                                }
                                
                                .header-print { 
                                    background: linear-gradient(135deg, #8a0a27, #B22222);
                                    color: white; 
                                    padding: 12px 15px; 
                                    border-radius: 5px; 
                                    margin-bottom: 12px;
                                }
                                
                                table { 
                                    border-collapse: collapse; 
                                    width: 100%; 
                                    margin-bottom: 12px; 
                                }
                                
                                th { 
                                    background-color: #8a0a27; 
                                    color: white; 
                                    font-weight: bold; 
                                    padding: 6px 8px; 
                                    border: 1px solid #ddd; 
                                }
                                
                                td { 
                                    padding: 5px 6px; 
                                    border: 1px solid #ddd; 
                                }
                                
                                .text-right { text-align: right; }
                                .text-center { text-align: center; }
                                .font-bold { font-weight: bold; }
                                
                                .footer-print { 
                                    text-align: center; 
                                    font-size: 9px; 
                                    color: #666; 
                                    margin-top: 15px;
                                    border-top: 1px solid #ddd;
                                    padding-top: 10px;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="header-print">
                                <h2><i class="fas fa-file-invoice-dollar" style="margin-right: 6px;"></i> MISUPER - REPORTE DE ÓRDENES DE COMPRA</h2>
                                <p><strong>Período de Factura:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</p>
                                <p>
                                    <strong>Estado:</strong> 
                                    @switch($estado)
                                        @case('todas') Todas las órdenes @break
                                        @case('aprobadas') Solo aprobadas @break
                                        @case('pendientes') Solo pendientes @break
                                    @endswitch
                                    | 
                                    <strong>Registros:</strong> {{ $ordenes->count() }}
                                    |
                                    <strong>Con referencia:</strong> {{ $ordenes->whereNotNull('Referencia')->count() }}
                                </p>
                                <p>
                                    <strong>Total Bs:</strong> {{ number_format($ordenes->sum('Monto_en_Bs'), 2, ',', '.') }} | 
                                    <strong>Total $:</strong> ${{ number_format($ordenes->sum('Monto_en_dolares'), 2, ',', '.') }}
                                </p>
                            </div>
                            
                            <div style="margin-bottom: 8px; font-size: 8px; color: #666; padding: 4px; background: #f8f9fa; border-radius: 3px;">
                                <i class="fas fa-calendar-alt" style="margin-right: 4px;"></i>
                                Reporte generado el {{ now()->format('d/m/Y H:i:s') }} | MISUPER Sistema de Órdenes de Compra
                            </div>
                            
                            <table>
                                <thead>
                                    <tr>
                                        <th>Fecha Factura</th>
                                        <th>Correlativo</th>
                                        <th>Beneficiario</th>
                                        <th>Proveedor</th>
                                        <th style="text-align: right;">Monto Bs</th>
                                        <th style="text-align: right;">Monto $</th>
                                        <th style="text-align: center;">Tasa</th>
                                        <th>Responsable</th>
                                        <th style="text-align: center;">Método Pago</th>
                                        <th style="text-align: center;">Referencia</th>
                                        <th style="text-align: center;">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                    `;
                    
                    @foreach($ordenes as $orden)
                    @php
                        $correlativo = 'CZ' . str_pad(preg_replace('/[^0-9]/', '', substr($orden->Correlativo, 2)), 6, '0', STR_PAD_LEFT);
                        $estadoTexto = $orden->Estatus == 1 ? 'Aprobada' : 'Pendiente';
                        $estadoColor = $orden->Estatus == 1 ? '#28a745' : '#ffc107';
                        $fechaFactura = $orden->Fecha_Factura ?? null;
                        $metodoPago = $orden->Metodo_de_pago ?? 'No especificado';
                        $referencia = $orden->Referencia ?? null;
                    @endphp
                    html += `
                        <tr>
                            <td>
                                @if($fechaFactura)
                                    {{ \Carbon\Carbon::parse($fechaFactura)->format('d/m/Y') }}
                                @else
                                    <span style="color: #999; font-style: italic;">Sin fecha</span>
                                @endif
                            </td>
                            <td>${correlativo}</td>
                            <td>{{ $orden->Beneficiario }}</td>
                            <td>{{ $orden->PROVEEDORES }}</td>
                            <td style="text-align: right;">{{ number_format($orden->Monto_en_Bs, 2, ',', '.') }}</td>
                            <td style="text-align: right;">${{ number_format($orden->Monto_en_dolares, 2, ',', '.') }}</td>
                            <td style="text-align: center;">{{ number_format($orden->Tasa_usada, 2, ',', '.') }}</td>
                            <td>{{ $orden->Responsable }}</td>
                            <td style="text-align: center;">{{ $metodoPago }}</td>
                            <td style="text-align: center;">
                                @if($referencia)
                                    {{ $referencia }}
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                            <td style="text-align: center; color: ${estadoColor}; font-weight: bold;">${estadoTexto}</td>
                        </tr>
                    `;
                    @endforeach
                    
                    html += `
                                </tbody>
                                <tfoot>
                                    <tr class="totals-row">
                                        <td colspan="4" style="text-align: right; padding: 5px;"><strong>TOTALES:</strong></td>
                                        <td style="text-align: right; padding: 5px;"><strong>{{ number_format($ordenes->sum('Monto_en_Bs'), 2, ',', '.') }}</strong></td>
                                        <td style="text-align: right; padding: 5px;"><strong>${{ number_format($ordenes->sum('Monto_en_dolares'), 2, ',', '.') }}</strong></td>
                                        <td colspan="5"></td>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            <div class="footer-print">
                                <p>
                                    <i class="fas fa-lock" style="margin-right: 4px;"></i>
                                    Documento confidencial - Generado por MISUPER Sistema de Órdenes de Compra
                                </p>
                                <p>
                                    Página 1 de 1 | Impreso el {{ now()->format('d/m/Y H:i:s') }}
                                </p>
                            </div>
                            
                            <script>
                                window.onload = function() {
                                    setTimeout(function() {
                                        window.print();
                                        setTimeout(function() {
                                            window.close();
                                        }, 500);
                                    }, 100);
                                };
                                
                                setTimeout(function() {
                                    if (document.readyState === 'complete') {
                                        window.print();
                                        setTimeout(function() {
                                            window.close();
                                        }, 500);
                                    }
                                }, 2000);
                            <\/script>
                        </body>
                    </html>
                    `;
                    
                    ventanaImpresion.document.write(html);
                    ventanaImpresion.document.close();
                }, 1200);
            }
        });
    }
    
    // Configuración para impresión
    document.addEventListener('DOMContentLoaded', function() {
        window.onbeforeprint = function() {
            document.querySelector('.print-header').style.display = 'block';
        };
        
        window.onafterprint = function() {
            document.querySelector('.print-header').style.display = 'none';
        };
    });
</script>
@stop