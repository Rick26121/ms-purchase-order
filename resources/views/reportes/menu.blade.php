@extends('adminlte::page')

@section('title', 'Mi Panel')

@section('content_header')
    <h1>Reportes <small>Panel de control de reportes diarios y mensuales</small></h1>
@stop

@section('content')
    
<!-- Filtro de período -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="periodo">Periodo de Reporte:</label>
                            <select class="form-control" id="periodo">
                                <option value="diario">Reportes Diarios</option>
                                <option value="mensual">Reportes Mensuales</option>
                                <option value="todos">Todos los Reportes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" class="form-control" id="fecha" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- REPORTES DIARIOS -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">
                    <i class="fas fa-calendar-day"></i> Reportes Diarios
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Caja 1: Órdenes de Compras -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="/ordenes/menu" style="text-decoration: none; color: inherit;">
                            <div class="info-box bg-gradient-info">
                                <span class="info-box-icon">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Órdenes de Compras</span>
                                    <span class="info-box-number">{{ number_format($totalOrdenes) }}</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 70%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <i class="fas fa-clock"></i> Hoy: {{ number_format($ordenesHoy) }} nuevas
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Caja 2: Proveedores -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="info-box bg-gradient-success" style="cursor: pointer;" onclick="window.location.href='/proveedores';">
                            <span class="info-box-icon">
                                <i class="fas fa-truck-loading"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Proveedores Activos</span>
                                <span class="info-box-number">410</span>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 85%"></div>
                                </div>
                                <span class="progress-description">
                                    <i class="fas fa-clock"></i> Hoy: 3 nuevos
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- REPORTES MENSUALES -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">
                    <i class="fas fa-calendar-alt"></i> Reportes Mensuales
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Caja 3: Reporte Financiero Mensual -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="/reportes/financiero-mensual" style="text-decoration: none; color: inherit;">
                            <div class="info-box bg-gradient-indigo">
                                <span class="info-box-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Financiero Mensual</span>
                                    <span class="info-box-number">$450,120</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 80%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <i class="fas fa-calendar"></i> Mes actual
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Caja 4: Compras del Mes -->
                    <div class="col-md-6 col-lg-3 mb-3">
                        <a href="/reportes/compras-mensuales" style="text-decoration: none; color: inherit;">
                            <div class="info-box bg-gradient-teal">
                                <span class="info-box-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Compras del Mes</span>
                                    <span class="info-box-number">$125,800</span>
                                    <div class="progress">
                                        <div class="progress-bar" style="width: 65%"></div>
                                    </div>
                                    <span class="progress-description">
                                        <i class="fas fa-calendar"></i> -5% vs mes anterior
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECCIÓN PARA GRÁFICAS FUTURAS -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i> Gráficas de Reportes
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Visualización de datos estadísticos de todos los reportes.</p>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card bg-light">
                            <div class="card-body text-center">
                                <h4><i class="fas fa-chart-pie fa-3x text-primary mb-3"></i></h4>
                                <h5>Gráficas disponibles próximamente</h5>
                                <p>Esta sección estará disponible próximamente para mostrar gráficos de barras, líneas y pastel con información consolidada de reportes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Tipos de Gráficas:</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-chart-line text-success mr-2"></i> Tendencia de ventas</li>
                                    <li class="mb-2"><i class="fas fa-chart-bar text-info mr-2"></i> Compras por proveedor</li>
                                    <li class="mb-2"><i class="fas fa-chart-pie text-warning mr-2"></i> Distribución de gastos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <style>
        .info-box {
            box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
            border-radius: 0.25rem;
            background: #fff;
            display: flex;
            margin-bottom: 0;
            min-height: 80px;
            padding: .5rem;
            position: relative;
        }
        
        .info-box-icon {
            border-radius: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 70px;
            font-size: 1.875rem;
            text-align: center;
            flex-shrink: 0;
        }
        
        .info-box-content {
            flex: 1;
            padding: 5px 10px;
        }
        
        .info-box-text {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .info-box-number {
            display: block;
            font-weight: 700;
            font-size: 1.8rem;
        }
        
        .progress {
            height: 5px;
            margin: 5px 0;
        }
        
        .progress-description {
            font-size: 12px;
            color: #6c757d;
        }
        
        .bg-gradient-info {
            background: linear-gradient(to right, #17a2b8, #20c7c0) !important;
            color: white;
        }
        
        .bg-gradient-success {
            background: linear-gradient(to right, #28a745, #20c997) !important;
            color: white;
        }
        
        .bg-gradient-indigo {
            background: linear-gradient(to right, #6610f2, #8a63d2) !important;
            color: white;
        }
        
        .bg-gradient-teal {
            background: linear-gradient(to right, #20c997, #3dd9af) !important;
            color: white;
        }
        
        .info-box:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }
        
        .mr-2 {
            margin-right: 0.5rem;
        }
        
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        
        .mb-3 {
            margin-bottom: 1rem;
        }
    </style>
@stop

@section('js')
    <script>
        // Cambiar tipo de fecha según el período seleccionado
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('periodo').addEventListener('change', function() {
                const periodo = this.value;
                const fechaInput = document.getElementById('fecha');
                
                if(periodo === 'mensual') {
                    fechaInput.type = 'month';
                    fechaInput.value = new Date().toISOString().slice(0,7);
                } else {
                    fechaInput.type = 'date';
                    fechaInput.value = new Date().toISOString().slice(0,10);
                }
            });
            
            // Efecto hover en las cajas de reporte
            const infoBoxes = document.querySelectorAll('.info-box');
            infoBoxes.forEach(box => {
                box.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                });
                
                box.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@stop