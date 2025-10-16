@extends('adminlte::page')

@section('title', 'Órdenes de Compra')

@section('content_header')
    <h1>Órdenes de Compra</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Órdenes de Compra</h3>
        <div class="card-tools">
            <a href="{{ route('ordenes.crear') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Orden
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="ordersTable" class="table table-bordered table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sucursal</th>
                        <th>Producto</th>
                        <th>Proveedor</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Total General</th>
                        <th>Tasa Día</th>
                        <th>Moneda</th>
                        <th>IVA</th>
                        <th>Total Bs.</th>
                        <th>Fecha Orden</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Los datos se cargarán via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
<style>
    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .badge:hover {
        opacity: 0.8;
        transform: scale(1.05);
    }
    .status-en-proceso {
        background-color: #ffc107;
        color: #212529;
    }
    .status-aprobado {
        background-color: #28a745;
        color: white;
    }
    .text-right {
        text-align: right;
    }
    .table th {
        background-color: #f8f9fa;
    }
    .btn-action {
        margin: 0 2px;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
</style>
@stop

@section('js')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    var table = $('#ordersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("ordenes-compras.datos") }}',
            type: 'GET',
            dataSrc: 'data'
        },
        columns: [
            { 
                data: 'id',
                name: 'id'
            },
            { 
                data: 'sucursal.nombre',
                name: 'sucursal',
                defaultContent: 'N/A'
            },
            { 
                data: 'producto.nombre',
                name: 'producto',
                defaultContent: 'N/A'
            },
            { 
                data: 'proveedor.nombre',
                name: 'proveedor',
                defaultContent: 'N/A'
            },
            { 
                data: 'cantidad',
                name: 'cantidad',
                className: 'text-right',
                render: function(data, type, row) {
                    return data ? data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '0';
                }
            },
            { 
                data: 'unidad.abreviatura',
                name: 'unidad',
                defaultContent: 'N/A'
            },
            { 
                data: 'totalGeneral',
                name: 'totalGeneral',
                className: 'text-right',
                render: function(data, type, row) {
                    return data ? parseFloat(data).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '0,00';
                }
            },
            { 
                data: 'tasa_dia',
                name: 'tasa_dia',
                className: 'text-right',
                render: function(data, type, row) {
                    return data ? parseFloat(data).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '0,00';
                }
            },
            { 
                data: 'moneda',
                name: 'moneda',
                render: function(data, type, row) {
                    return data ? data.toUpperCase() : '';
                }
            },
            { 
                data: 'iva',
                name: 'iva',
                render: function(data, type, row) {
                    return data == 1 ? 'Sí' : 'No';
                }
            },
            { 
                data: 'totalbs',
                name: 'totalbs',
                className: 'text-right',
                render: function(data, type, row) {
                    return data ? parseFloat(data).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '0,00';
                }
            },
            { 
                data: 'fecha_orden',
                name: 'fecha_orden',
                render: function(data, type, row) {
                    if (data) {
                        var date = new Date(data);
                        return date.toLocaleDateString('es-ES');
                    }
                    return 'N/A';
                }
            },
            { 
                data: 'estatus',
                name: 'estatus',
                render: function(data, type, row) {
                    var badgeClass = data == 1 ? 'status-aprobado' : 'status-en-proceso';
                    var badgeText = data == 1 ? 'Aprobado' : 'En Proceso';
                    return `<span class="badge ${badgeClass}" data-id="${row.id}" data-status="${data}">${badgeText}</span>`;
                }
            },
            { 
                data: 'id',
                name: 'acciones',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-warning btn-sm btn-action" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-action" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'btn btn-info btn-sm'
            }
        ]
    });

    // Debug info
    console.log('🔧 Debug Info:');
    console.log('CSRF Token exists:', '{{ csrf_token() }}' !== '');
    console.log('Route URL:', '{{ route("ordenes-compras.cambiar-estatus") }}');

    // Evento para cambiar el estatus
    $(document).on('click', '.badge[data-status]', function() {
        var orderId = $(this).data('id');
        var currentStatus = parseInt($(this).data('status'));
        var nuevoEstatus = currentStatus === 1 ? 0 : 1;
        
        console.log('🔄 Changing status:', {
            orderId: orderId,
            currentStatus: currentStatus,
            nuevoEstatus: nuevoEstatus
        });

        var mensajes = {
            0: {
                title: '¿Aprobar orden?',
                text: '¿Deseas aprobar esta orden de compra?',
                confirmText: 'Sí, aprobar',
                color: '#28a745'
            },
            1: {
                title: '¿Marcar como En Proceso?',
                text: '¿Deseas marcar esta orden como En Proceso?',
                confirmText: 'Sí, marcar como En Proceso',
                color: '#ffc107'
            }
        };

        var mensaje = mensajes[currentStatus];

        Swal.fire({
            title: mensaje.title,
            text: mensaje.text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: mensaje.color,
            cancelButtonColor: '#6c757d',
            confirmButtonText: mensaje.confirmText,
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                cambiarEstatus(orderId, nuevoEstatus);
            }
        });
    });

    function cambiarEstatus(orderId, nuevoEstatus) {
        console.log('📡 Sending AJAX request...', {
            orderId: orderId,
            nuevoEstatus: nuevoEstatus
        });

        $.ajax({
            url: '{{ route("ordenes-compras.cambiar-estatus") }}',
            type: 'POST',
            data: {
                id: orderId,
                estatus: nuevoEstatus,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log('✅ AJAX Success:', response);
                
                if (response.success) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: '#28a745'
                    });
                    
                    // Recargar la tabla
                    table.ajax.reload(null, false);
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'Error desconocido',
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('❌ AJAX Error:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error
                });

                var errorMessage = 'Error de conexión';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 419) {
                    errorMessage = 'Error de token CSRF. Por favor, recarga la página.';
                } else if (xhr.status === 404) {
                    errorMessage = 'La ruta no fue encontrada. Verifica la URL.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Error interno del servidor. Revisa los logs.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Error de validación en los datos enviados.';
                }
                
                Swal.fire({
                    title: 'Error ' + xhr.status,
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonColor: '#dc3545'
                });
            }
        });
    }
});
</script>
@stop