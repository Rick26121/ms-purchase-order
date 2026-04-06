{{-- resources/views/reportes/ordenes-hoy.blade.php --}}
@extends('adminlte::page')

@section('title', 'Reporte del Día')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-calendar-day text-primary"></i>
            {{ $titulo }}
        </h1>
        <div>
            <span class="badge badge-primary">
                <i class="fas fa-file-invoice-dollar"></i>
                {{ $ordenes->count() }} facturas hoy
            </span>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Tarjetas de Resumen -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $ordenes->count() }}</h3>
                        <p>Total Facturas Hoy</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <a href="#detalle" class="small-box-footer">
                        Ver detalle <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4>{{ number_format($ordenes->sum('Monto_en_Bs'), 2, ',', '.') }} Bs</h4>
                        <p>Total en Bolívares</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="small-box-footer">
                        {{ $ordenes->where('Estatus', 1)->count() }} aprobadas
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h4>${{ number_format($ordenes->sum('Monto_en_dolares'), 2, ',', '.') }}</h4>
                        <p>Total en Dólares</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="small-box-footer">
                        Tasa promedio: 
                        @if($ordenes->count() > 0)
                            {{ number_format($ordenes->avg('Tasa_usada'), 2, ',', '.') }}
                        @else
                            0,00
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6">
                <div class="small-box bg-gradient-purple">
                    <div class="inner">
                        @php
                            $aprobadas = $ordenes->where('Estatus', 1)->count();
                            $pendientes = $ordenes->where('Estatus', 0)->count();
                        @endphp
                        <h3>{{ $aprobadas }}/{{ $ordenes->count() }}</h3>
                        <p>Facturas Aprobadas</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <div class="small-box-footer">
                        {{ $pendientes }} pendientes
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Principal -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list-ul"></i>
                    Detalle de Facturas - {{ date('d/m/Y') }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="window.print()" title="Imprimir">
                        <i class="fas fa-print"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="exportToExcel()" title="Exportar Excel">
                        <i class="fas fa-file-excel"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="location.reload()" title="Actualizar">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            
            <div class="card-body">
                <!-- Botones de Acción -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="btn-group" role="group">
                            <a href="{{ route('ordenes.fechas.form') }}" class="btn btn-outline-primary">
                                <i class="fas fa-calendar-alt mr-1"></i> Buscar por Fechas
                            </a>
                            <a href="{{ route('reportes.menu') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-th-large mr-1"></i> Menú Reportes
                            </a>
                            <button type="button" class="btn btn-outline-success" onclick="exportToExcel()">
                                <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                            </button>
                            <button type="button" class="btn btn-outline-info" onclick="exportToPDF()">
                                <i class="fas fa-file-pdf mr-1"></i> Exportar PDF
                            </button>
                            <button type="button" class="btn btn-outline-dark" onclick="window.print()">
                                <i class="fas fa-print mr-1"></i> Imprimir
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Facturas -->
                @if($ordenes->count() > 0)
                    <div class="table-responsive" id="detalle">
                        <table id="tablaOrdenes" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Fecha Factura</th>
                                    <th>Factura</th>
                                    <th>Correlativo OC</th>
                                    <th>Beneficiario</th>
                                    <th>Proveedor</th>
                                    <th class="text-right">Monto Bs</th>
                                    <th class="text-right">Monto $</th>
                                    <th class="text-right">Tasa</th>
                                    <th>Método Pago</th>
                                    <th>Referencia</th>
                                    <th>Responsable</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordenes as $orden)
                                @php
                                    // Formatear correlativo de orden de compra
                                    $correlativo_oc = isset($orden->Correlativo) ? 'CZ' . str_pad($orden->Correlativo, 6, '0', STR_PAD_LEFT) : 'N/A';
                                    
                                    // Formatear código de factura
                                    $codigo_factura = $orden->codigo_Factura ?? 'N/A';
                                    
                                    // Determinar color del estado
                                    $estado_class = ($orden->Estatus == 1) ? 'success' : 'warning';
                                    $estado_text = ($orden->Estatus == 1) ? 'Aprobada' : 'Pendiente';
                                @endphp
                                <tr>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($orden->Fecha_Factura)->format('d/m/Y') }}
                                        </small>
                                        <br>
                                        <span class="badge badge-light">
                                            {{ \Carbon\Carbon::parse($orden->Fecha)->format('H:i') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ $codigo_factura }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="correlativo-cell" data-original="{{ $orden->Correlativo ?? '' }}">
                                            {{ $correlativo_oc }}
                                        </span>
                                    </td>
                                    <td>{{ $orden->Beneficiario ?? 'N/A' }}</td>
                                    <td>{{ $orden->PROVEEDORES ?? 'N/A' }}</td>
                                    <td class="text-right font-weight-bold text-success">
                                        {{ number_format($orden->Monto_en_Bs ?? 0, 2, ',', '.') }} Bs
                                    </td>
                                    <td class="text-right font-weight-bold text-warning">
                                        ${{ number_format($orden->Monto_en_dolares ?? 0, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        <span class="badge badge-info">
                                            {{ number_format($orden->Tasa_usada ?? 0, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ $orden->Metodo_de_pago ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($orden->Referencia)
                                            <small class="text-muted">{{ $orden->Referencia }}</small>
                                        @else
                                            <span class="badge badge-light">Sin ref.</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-light">
                                            <i class="fas fa-user mr-1"></i>
                                            {{ $orden->Responsable ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $estado_class }}">
                                            @if($orden->Estatus == 1)
                                                <i class="fas fa-check-circle mr-1"></i>
                                            @else
                                                <i class="fas fa-clock mr-1"></i>
                                            @endif
                                            {{ $estado_text }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <td colspan="5" class="text-right font-weight-bold">
                                        TOTALES:
                                    </td>
                                    <td class="text-right font-weight-bold text-success">
                                        {{ number_format($ordenes->sum('Monto_en_Bs'), 2, ',', '.') }} Bs
                                    </td>
                                    <td class="text-right font-weight-bold text-warning">
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
                            <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                            <h3 class="text-muted">No hay facturas registradas hoy</h3>
                            <p class="text-muted mb-4">No se encontraron facturas para la fecha de hoy.</p>
                            <div class="mt-3">
                                <a href="{{ route('ordenes.fechas.form') }}" class="btn btn-primary mr-2">
                                    <i class="fas fa-calendar-alt mr-1"></i> Buscar por Fechas
                                </a>
                                @if(Route::has('ordenes.create'))
                                <a href="{{ route('ordenes.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus-circle mr-1"></i> Crear Nueva Orden
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <i class="fas fa-info-circle mr-1"></i>
                            Reporte generado el {{ now()->format('d/m/Y H:i:s') }}
                            | {{ $ordenes->count() }} registros
                            | Filtro: Facturas de hoy
                        </small>
                    </div>
                    <div class="col-md-6 text-right">
                        <small class="text-muted">
                            Sistema de Facturación
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap4.min.css">
    <style>
        .small-box {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .small-box .icon {
            top: 15px;
            right: 15px;
            font-size: 70px;
            opacity: 0.3;
        }
        
        .small-box:hover .icon {
            opacity: 0.4;
        }
        
        .table thead th {
            border-top: none;
            background-color: #f8f9fa;
        }
        
        .correlativo-cell {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #28a745;
            background-color: #f8fff9;
            padding: 3px 8px;
            border-radius: 4px;
            border: 1px solid #d4edda;
        }
        
        .empty-state {
            padding: 40px 20px;
        }
        
        .btn-group .btn {
            border-radius: 5px !important;
            margin-right: 5px;
        }
        
        @media print {
            .btn-group, .card-tools, .small-box-footer {
                display: none !important;
            }
            
            .card-header {
                background-color: #f8f9fa !important;
                color: #000 !important;
            }
            
            table {
                font-size: 10px;
            }
            
            .correlativo-cell {
                background-color: white !important;
                border: 1px solid #dee2e6 !important;
            }
        }
        
        /* Estilos específicos para tabla con más columnas */
        #tablaOrdenes th, #tablaOrdenes td {
            white-space: nowrap;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    
    <!-- SweetAlert2 para diálogos -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        $(document).ready(function() {
            // Inicializar DataTable
            var table = $('#tablaOrdenes').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "scrollX": true, // Para manejar muchas columnas
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                },
                "order": [[0, 'desc']], // Ordenar por fecha de factura
                "pageLength": 25,
                "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                       '<"row"<"col-sm-12"tr>>' +
                       '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                "buttons": [
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel mr-1"></i> Excel',
                        className: 'btn btn-success btn-sm',
                        title: 'Facturas_Hoy_{{ date("Ymd") }}',
                        messageTop: '{{ $titulo }}\nFecha: {{ date("d/m/Y H:i:s") }}\nTotal: {{ $ordenes->count() }} facturas',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    // Para exportar bien los números
                                    if (column === 5 || column === 6 || column === 7) {
                                        // Columnas de montos y tasa (5,6,7)
                                        var num = data.toString().replace(/[^\d,.-]/g, '');
                                        return num.replace(',', '.');
                                    }
                                    return data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf mr-1"></i> PDF',
                        className: 'btn btn-danger btn-sm',
                        title: '{{ $titulo }}',
                        messageTop: 'Fecha: {{ date("d/m/Y") }}\nGenerado: {{ now()->format("d/m/Y H:i:s") }}\nTotal facturas: {{ $ordenes->count() }}',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 7;
                            doc.styles.tableHeader.fontSize = 8;
                            doc.pageMargins = [10, 30, 10, 30];
                            doc.pageSize = 'A4';
                            doc.pageOrientation = 'landscape';
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print mr-1"></i> Imprimir',
                        className: 'btn btn-info btn-sm',
                        title: '<h3>{{ $titulo }}</h3>',
                        messageTop: '<p><strong>Fecha del reporte:</strong> {{ date("d/m/Y") }}<br>' +
                                   '<strong>Generado el:</strong> {{ now()->format("d/m/Y H:i:s") }}<br>' +
                                   '<strong>Total de facturas:</strong> {{ $ordenes->count() }}</p>',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(win) {
                            $(win.document.body).find('table').addClass('table-bordered table-sm');
                            $(win.document.body).css('font-size', '9pt');
                        }
                    }
                ],
                "columnDefs": [
                    {
                        "targets": [5, 6, 7], // Columnas de montos y tasa
                        "className": "text-right",
                        "type": "num-fmt" // Tipo numérico para ordenamiento
                    },
                    {
                        "targets": [11], // Columna de estado
                        "className": "text-center"
                    },
                    {
                        "targets": [8, 9], // Columnas de método pago y referencia
                        "className": "text-center"
                    }
                ]
            });
            
            // Configurar los botones
            new $.fn.dataTable.Buttons(table, {
                buttons: [
                    'excel', 'pdf', 'print'
                ]
            });
            
            table.buttons().container().appendTo('#tablaOrdenes_wrapper .col-md-6:eq(0)');
            
            // Auto-refresh cada 5 minutos
            setTimeout(function() {
                Swal.fire({
                    title: 'Actualizar datos',
                    text: '¿Desea actualizar el reporte para ver los últimos cambios?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, actualizar',
                    cancelButtonText: 'No, cancelar',
                    timer: 30000,
                    timerProgressBar: true
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss === Swal.DismissReason.timer) {
                        window.location.reload();
                    }
                });
            }, 300000); // 5 minutos
        });
        
        // Función para exportar a Excel
        function exportToExcel() {
            $('#tablaOrdenes').DataTable().button('.buttons-excel').trigger();
        }
        
        // Función para exportar a PDF
        function exportToPDF() {
            $('#tablaOrdenes').DataTable().button('.buttons-pdf').trigger();
        }
        
        // Función para formatear números con separadores
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>
    
    <script>
        // Mostrar notificación de actualización
        setInterval(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            
            Toast.fire({
                icon: 'info',
                title: 'Actualizando datos en 1 minuto...'
            })
        }, 240000); // 4 minutos
        
        // Filtros rápidos
        function filtrarPorEstado(estado) {
            var table = $('#tablaOrdenes').DataTable();
            if (estado === 'todos') {
                table.search('').draw();
            } else {
                table.column(11).search(estado).draw();
            }
        }
    </script>
@stop