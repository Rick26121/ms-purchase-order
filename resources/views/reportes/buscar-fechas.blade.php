{{-- resources/views/reportes/ordenes-fechas-form.blade.php --}}
@extends('adminlte::page')

@section('title', 'Buscar Órdenes por Fecha')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0">
            <i class="fas fa-calendar-alt text-primary"></i>
            <strong>Buscar Órdenes por Rango de Fechas</strong>
        </h1>
        <div>
            <a href="{{ route('ordenes.hoy') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-calendar-day mr-1"></i> Ver Hoy
            </a>
            <a href="{{ route('reportes.menu') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Volver
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Formulario Principal -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-filter mr-2"></i>
                        Seleccionar Rango y Filtros
                    </h3>
                </div>
                
                <form action="{{ route('ordenes.fechas') }}" method="POST" id="formBusqueda">
                    @csrf
                    
                    <div class="card-body">
                        <!-- Sección 1: Rango de Fechas -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Rango de Fechas
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><strong>Fecha Inicio</strong></label>
                                            <div class="input-group date" id="fechaInicioPicker">
                                                <input type="date" 
                                                       class="form-control" 
                                                       id="fecha_inicio" 
                                                       name="fecha_inicio" 
                                                       value="{{ $fechaHoy ?? date('Y-m-d') }}"
                                                       required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label"><strong>Fecha Fin</strong></label>
                                            <div class="input-group date" id="fechaFinPicker">
                                                <input type="date" 
                                                       class="form-control" 
                                                       id="fecha_fin" 
                                                       name="fecha_fin" 
                                                       value="{{ $fechaHoy ?? date('Y-m-d') }}"
                                                       required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Botones de selección rápida -->
                                <div class="mt-3">
                                    <label class="mb-2"><strong>Periodos Predefinidos:</strong></label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setToday()">
                                            <i class="fas fa-calendar-day"></i> Hoy
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setYesterday()">
                                            <i class="fas fa-calendar-minus"></i> Ayer
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setWeek()">
                                            <i class="fas fa-calendar-week"></i> Esta Semana
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setMonth()">
                                            <i class="fas fa-calendar-month"></i> Este Mes
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setLastWeek()">
                                            <i class="fas fa-arrow-left"></i> Semana Pasada
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="setLastMonth()">
                                            <i class="fas fa-arrow-left"></i> Mes Anterior
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Sección 2: Filtro por Estado -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Filtrar por Estado de Orden
                                </h5>
                                
                                <div class="d-flex flex-column flex-md-row gap-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="estado" 
                                               id="estado_todas" 
                                               value="todas" 
                                               checked>
                                        <label class="form-check-label" for="estado_todas">
                                            <span class="badge badge-light border p-2">
                                                <i class="fas fa-files text-primary mr-2"></i>
                                                <strong>Todas las Órdenes</strong>
                                            </span>
                                        </label>
                                    </div>
                                    
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="estado" 
                                               id="estado_aprobadas" 
                                               value="aprobadas">
                                        <label class="form-check-label" for="estado_aprobadas">
                                            <span class="badge badge-success p-2">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                <strong>Solo Aprobadas</strong>
                                            </span>
                                        </label>
                                    </div>
                                    
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="estado" 
                                               id="estado_pendientes" 
                                               value="pendientes">
                                        <label class="form-check-label" for="estado_pendientes">
                                            <span class="badge badge-warning p-2">
                                                <i class="fas fa-clock mr-2"></i>
                                                <strong>Solo Pendientes</strong>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Sección 3: Filtros Adicionales -->
                        <
                        
                        <!-- Botón de Envío -->
                        <div class="row mt-4">
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-search mr-2"></i>
                                    <strong>GENERAR REPORTE</strong>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Información Adicional -->
            <div class="card card-info mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información del Reporte
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><strong>¿Qué incluye el reporte?</strong></h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success mr-2"></i> Correlativos (CZ000001)</li>
                                <li><i class="fas fa-check text-success mr-2"></i> Montos en Bs y $</li>
                                <li><i class="fas fa-check text-success mr-2"></i> Tasas de cambio</li>
                                <li><i class="fas fa-check text-success mr-2"></i> Estados de aprobación</li>
                                <li><i class="fas fa-check text-success mr-2"></i> Información completa</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Opciones de exportación:</strong></h6>
                            <div class="d-flex flex-column gap-2">
                                <span class="badge badge-success p-2">
                                    <i class="fas fa-file-excel mr-2"></i> Exportar a Excel
                                </span>
                                <span class="badge badge-danger p-2">
                                    <i class="fas fa-file-pdf mr-2"></i> Exportar a PDF
                                </span>
                                <span class="badge badge-info p-2">
                                    <i class="fas fa-print mr-2"></i> Imprimir directamente
                                </span>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<style>
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border: none;
    }
    
    .card-header {
        border-radius: 10px 10px 0 0 !important;
        background: linear-gradient(135deg, #0069d9 0%, #0056b3 100%);
        color: white;
    }
    
    .card-primary {
        border-top: 4px solid #0069d9;
    }
    
    .card-info {
        border-top: 4px solid #17a2b8;
    }
    
    .form-control, .select2-container--bootstrap4 .select2-selection {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 10px;
    }
    
    .form-control:focus, .select2-container--bootstrap4 .select2-selection:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .input-group .input-group-text {
        background-color: #f8f9fa;
        border-radius: 0 8px 8px 0;
        border-left: none;
    }
    
    .input-group .form-control {
        border-radius: 8px 0 0 8px;
        border-right: none;
    }
    
    .btn-outline-primary {
        border-radius: 8px;
        border-width: 2px;
        font-weight: 500;
    }
    
    .btn-success {
        border-radius: 10px;
        padding: 12px 30px;
        font-size: 1.1rem;
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    
    hr {
        border-top: 2px dashed #dee2e6;
        margin: 2rem 0;
    }
    
    h5 {
        font-weight: 600;
        padding-bottom: 8px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .form-check-label .badge {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .form-check-label .badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .form-check-input:checked + .form-check-label .badge-light {
        background-color: #e3f2fd !important;
        border-color: #0069d9 !important;
    }
    
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.5rem + 2px);
    }
    
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: 2.5rem;
        padding-left: 10px;
    }
    
    .list-unstyled li {
        padding: 5px 0;
        font-size: 0.95rem;
    }
    
    @media (max-width: 768px) {
        .d-flex.flex-md-row {
            flex-direction: column !important;
        }
        
        .gap-2 {
            gap: 5px !important;
        }
        
        .btn-lg {
            padding: 10px 20px;
            font-size: 1rem;
        }
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Inicializar Select2 con tema Bootstrap 4
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: function() {
                $(this).data('placeholder');
            },
            allowClear: true,
            width: '100%'
        });
        
        // Inicializar con fecha de hoy
        setToday();
        
        // Validar que fecha fin no sea menor que fecha inicio
        $('#fecha_fin').change(function() {
            var inicio = $('#fecha_inicio').val();
            var fin = $(this).val();
            
            if (fin < inicio) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fecha inválida',
                    text: 'La fecha fin no puede ser menor que la fecha inicio',
                    confirmButtonText: 'Corregir',
                    confirmButtonColor: '#3085d6'
                });
                $(this).val(inicio);
            }
        });
        
        // Validar formulario antes de enviar
        $('#formBusqueda').submit(function(e) {
            var inicio = $('#fecha_inicio').val();
            var fin = $('#fecha_fin').val();
            
            if (!inicio || !fin) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Faltan datos',
                    text: 'Debe seleccionar ambas fechas',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }
            
            if (fin < inicio) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Rango inválido',
                    text: 'La fecha fin no puede ser menor que la fecha inicio',
                    confirmButtonText: 'Corregir'
                });
                return false;
            }
            
            // Mostrar carga
            Swal.fire({
                title: 'Generando reporte...',
                html: 'Por favor espere mientras procesamos su solicitud',
                allowOutsideClick: false,
                showConfirmButton: false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            return true;
        });
    });
    
    // Funciones de selección rápida
    function setToday() {
        const today = new Date().toISOString().split('T')[0];
        $('#fecha_inicio').val(today);
        $('#fecha_fin').val(today);
    }
    
    function setYesterday() {
        const yesterday = new Date();
        yesterday.setDate(yesterday.getDate() - 1);
        const dateStr = yesterday.toISOString().split('T')[0];
        $('#fecha_inicio').val(dateStr);
        $('#fecha_fin').val(dateStr);
    }
    
    function setWeek() {
        const today = new Date();
        const startOfWeek = new Date(today);
        startOfWeek.setDate(today.getDate() - today.getDay());
        const endOfWeek = new Date(today);
        endOfWeek.setDate(today.getDate() + (6 - today.getDay()));
        
        $('#fecha_inicio').val(startOfWeek.toISOString().split('T')[0]);
        $('#fecha_fin').val(endOfWeek.toISOString().split('T')[0]);
    }
    
    function setLastWeek() {
        const today = new Date();
        const startOfLastWeek = new Date(today);
        startOfLastWeek.setDate(today.getDate() - today.getDay() - 7);
        const endOfLastWeek = new Date(today);
        endOfLastWeek.setDate(today.getDate() - today.getDay() - 1);
        
        $('#fecha_inicio').val(startOfLastWeek.toISOString().split('T')[0]);
        $('#fecha_fin').val(endOfLastWeek.toISOString().split('T')[0]);
    }
    
    function setMonth() {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        
        $('#fecha_inicio').val(firstDay.toISOString().split('T')[0]);
        $('#fecha_fin').val(lastDay.toISOString().split('T')[0]);
    }
    
    function setLastMonth() {
        const today = new Date();
        const firstDay = new Date(today.getFullYear(), today.getMonth() - 1, 1);
        const lastDay = new Date(today.getFullYear(), today.getMonth(), 0);
        
        $('#fecha_inicio').val(firstDay.toISOString().split('T')[0]);
        $('#fecha_fin').val(lastDay.toISOString().split('T')[0]);
    }
</script>
@stop