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
                        <th>N° Control</th>
                        <th>Sucursal</th>
                        <th>Proveedor</th>
                        <th>Tasa Día</th>
                        <th>IVA</th>
                        <th>Total Bs</th>
                        <th>Total General</th>
                        <th>Fecha Creación</th>
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

<!-- Modal para gestionar factura/estatus (REEMPLAZADO CON MODAL DE APROBAR) -->
<div class="modal fade" id="modalFactura" tabindex="-1" role="dialog" aria-labelledby="modalFacturaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalFacturaLabel">
                    <i class="fas fa-file-invoice-dollar"></i> Gestionar Orden #<span id="modalOrdenNumero"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formularioFactura">
                    <input type="hidden" id="ordenId" name="ordenId">
                    <input type="hidden" id="currentStatus" name="currentStatus">
                    
                    <!-- Combo Box Responsable (LLENAR CON AJAX) -->
                    <div class="form-group">
                        <label for="responsable"><strong>Responsable</strong></label>
                        <select class="form-control" id="responsable" name="responsable" required>
                            <option value="">Cargando responsables...</option>
                        </select>
                    </div>

                    <!-- Campo Número de Factura/Nota -->
                    <div class="form-group">
                        <label for="numeroDocumento"><strong>Número de Factura / Nota de Entrega</strong></label>
                        <input type="text" class="form-control" id="numeroDocumento" name="numeroDocumento" placeholder="Ej: FV-001234 o NE-005678" required>
                    </div>

                    <!-- Combo Box Tipo de Factura (LLENAR CON AJAX) -->
                    <div class="form-group">
                        <label for="tipoFactura"><strong>Tipo de Factura</strong></label>
                        <select class="form-control" id="tipoFactura" name="tipoFactura" required>
                            <option value="">Cargando tipos de factura...</option>
                        </select>
                    </div>

                    <!-- Radio buttons para estatus -->
                    <div class="form-group">
                        <label><strong>Cambiar Estatus:</strong></label>
                        <div class="row mt-2">
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estatusRadio" id="estatusEnProceso" value="pendiente">
                                    <label class="form-check-label" for="estatusEnProceso">
                                        <span class="badge badge-warning">Pendiente</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estatusRadio" id="estatusAprobado" value="aprobado">
                                    <label class="form-check-label" for="estatusAprobado">
                                        <span class="badge badge-success">Aprobado</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estatusRadio" id="estatusRechazado" value="rechazado">
                                    <label class="form-check-label" for="estatusRechazado">
                                        <span class="badge badge-danger">Rechazado</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" id="btnGuardarFactura">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver/editar orden -->
<div class="modal fade" id="ordenModal" tabindex="-1" role="dialog" aria-labelledby="ordenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ordenModalLabel">Detalles de Orden #<span id="modalOrdenId"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Información General -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0"><i class="fas fa-store"></i> Información de Sucursal</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Sucursal:</strong> <span id="sucursalNombre"></span></p>
                                    <p><strong>Dirección:</strong> <span id="sucursalDireccion"></span></p>
                                    <p><strong>Teléfono:</strong> <span id="sucursalTelefono"></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0"><i class="fas fa-truck"></i> Información de Proveedor</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Proveedor:</strong> <span id="proveedorNombre"></span></p>
                                    <p><strong>RIF:</strong> <span id="proveedorRif"></span></p>
                                    <p><strong>Teléfono:</strong> <span id="proveedorTelefono"></span></p>
                                    <p><strong>Correo:</strong> <span id="proveedorCorreo"></span></p>
                                    <p><strong>Dirección:</strong> <span id="proveedorDireccion"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Datos de la Orden -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="fas fa-file-invoice"></i> Datos de la Orden</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <p><strong>Fecha:</strong> <span id="ordenFecha"></span></p>
                                            <p><strong>Moneda:</strong> <span id="ordenMoneda"></span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Tasa del Día:</strong> <span id="ordenTasa"></span></p>
                                            <p><strong>Aplica IVA:</strong> <span id="ordenIva"></span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Estatus:</strong> <span id="ordenEstatus"></span></p>
                                            <p><strong>Creado por:</strong> <span id="ordenUsuario"></span></p>
                                        </div>
                                        <div class="col-md-3">
                                            <p><strong>Fecha Creación:</strong> <span id="ordenCreatedAt"></span></p>
                                            <p><strong>Última Actualización:</strong> <span id="ordenUpdatedAt"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Productos -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="fas fa-boxes"></i> Productos</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm" id="productosTable">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Producto</th>
                                                    <th>Unidad</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio Unitario</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productosBody">
                                                <!-- Los productos se cargarán aquí -->
                                            </tbody>
                                            <tfoot class="bg-light">
                                                <tr>
                                                    <td colspan="5" class="text-right"><strong>Subtotal:</strong></td>
                                                    <td id="subtotalOrden" class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="text-right"><strong>IVA (16%):</strong></td>
                                                    <td id="ivaOrden" class="text-right">0.00</td>
                                                </tr>
                                                <tr class="bg-success text-white">
                                                    <td colspan="5" class="text-right"><strong>Total General:</strong></td>
                                                    <td id="totalOrden" class="text-right">0.00</td>
                                                </tr>
                                                <tr class="bg-primary text-white">
                                                    <td colspan="5" class="text-right"><strong>Total en Bs:</strong></td>
                                                    <td id="totalBsOrden" class="text-right">0.00</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnImprimirOrden" onclick="imprimirOrden()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
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
    .status-pendiente {
        background-color: #ffc107;
        color: #212529;
    }
    .status-aprobado {
        background-color: #28a745;
        color: white;
    }
    .status-rechazado {
        background-color: #dc3545;
        color: white;
    }
    .status-procesado {
        background-color: #17a2b8;
        color: white;
    }
    .status-completado {
        background-color: #6f42c1;
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
    .modal-xl {
        max-width: 1200px;
    }
    .card-header h6 {
        font-size: 1rem;
    }
    /* Estilos para los radio buttons */
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    .form-check {
        padding-left: 0;
    }
    .form-check-label {
        margin-left: 25px;
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
<!-- Bootstrap JS (para el modal) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#ordersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("ordenes-compras.datos") }}',
            type: 'GET',
            dataSrc: 'data',
            dataFilter: function(data) {
                console.log('JSON original:', data);
                var json = JSON.parse(data);
                
                if (json.data && json.data.length > 0) {
                    console.log('Primer registro antes de transformar:', json.data[0]);
                    
                    json.data = json.data.map(function(item) {
                        return {
                            'nro_control': item['"N° Control"'],
                            'sucursal': item['"Sucursal"'],
                            'proveedor': item['"Proveedor"'],
                            'tasa_dia': item.tasa_dia,
                            'iva': item.iva,
                            'totalbs': item.totalbs,
                            'totalGeneral': item.totalGeneral,
                            'fecha_creacion': item['"Fecha Creacion"'],
                            'estatus': item.estatus
                        };
                    });
                    
                    console.log('Primer registro después de transformar:', json.data[0]);
                }
                
                return JSON.stringify(json);
            }
        },
        columns: [
            { 
                data: 'nro_control',
                name: 'nro_control',
                orderable: true,
                searchable: true
            },
            { 
                data: 'sucursal',
                name: 'sucursal',
                defaultContent: 'N/A'
            },
            { 
                data: 'proveedor',
                name: 'proveedor',
                defaultContent: 'N/A'
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
                data: 'totalGeneral',
                name: 'totalGeneral',
                className: 'text-right',
                render: function(data, type, row) {
                    return data ? parseFloat(data).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".") : '0,00';
                }
            },
            { 
                data: 'fecha_creacion',
                name: 'fecha_creacion',
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
                    // Determinar clase según estatus
                    var badgeClass, badgeText;
                    var status = String(data).toLowerCase();
                    
                    switch(status) {
                        case 'aprobado':
                        case '1':
                            badgeClass = 'status-aprobado';
                            badgeText = 'Aprobado';
                            break;
                        case 'rechazado':
                        case '2':
                            badgeClass = 'status-rechazado';
                            badgeText = 'Rechazado';
                            break;
                        case 'procesado':
                            badgeClass = 'status-procesado';
                            badgeText = 'Procesado';
                            break;
                        case 'completado':
                            badgeClass = 'status-completado';
                            badgeText = 'Completado';
                            break;
                        case 'pendiente':
                        case '0':
                        default:
                            badgeClass = 'status-pendiente';
                            badgeText = 'Pendiente';
                    }
                    
                    // Para compatibilidad, guardamos el status como string
                    var statusValue = (status === '0' || status === '1' || status === '2') ? status : 
                                     (status === 'pendiente' ? 'pendiente' : 
                                     (status === 'aprobado' ? 'aprobado' : 
                                     (status === 'rechazado' ? 'rechazado' : status)));
                    
                    return `<span class="badge ${badgeClass}" data-id="${row.nro_control}" data-status="${statusValue}">${badgeText}</span>`;
                }
            },
            { 
                data: 'nro_control',
                name: 'acciones',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group">
                            <button class="btn btn-info btn-sm btn-action" title="Ver Detalles" onclick="verOrden(${data})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm btn-action" title="Editar" onclick="editarOrden(${data})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-action" title="Eliminar" onclick="eliminarOrden(${data})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay datos disponibles en la tabla",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros coincidentes",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": activar para ordenar ascendente",
                "sortDescending": ": activar para ordenar descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad de columnas",
                "collection": "Colección",
                "copyTitle": "Copiar al portapapeles",
                "copySuccess": {
                    "1": "1 fila copiada",
                    "_": "%d filas copiadas"
                },
                "csv": "CSV",
                "excel": "Excel",
                "pdf": "PDF",
                "print": "Imprimir"
            }
        },
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        order: [[0, 'desc']],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });

    // Función para ver los detalles de una orden
    window.verOrden = function(id) {
        cargarDetallesOrden(id);
    };

    // Función para cargar los detalles de la orden en el modal
    function cargarDetallesOrden(orderId) {
        $.ajax({
            url: '/ordenes/detalles/' + orderId,
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                // Mostrar loading
                $('#productosBody').html('<tr><td colspan="6" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>');
            },
            success: function(response) {
                if (response.success) {
                    var orden = response.data.orden;
                    var productos = response.data.productos;
                    var calculos = response.data.calculos;
                    
                    // Llenar información general
                    $('#modalOrdenId').text(orden.id);
                    
                    // Información de sucursal
                    $('#sucursalNombre').text(orden.sucursal_nombre || 'N/A');
                    $('#sucursalDireccion').text(orden.sucursal_direccion || 'N/A');
                    $('#sucursalTelefono').text(orden.sucursal_telefono || 'N/A');
                    
                    // Información de proveedor
                    $('#proveedorNombre').text(orden.proveedor_nombre || 'N/A');
                    $('#proveedorRif').text(orden.proveedor_rif || 'N/A');
                    $('#proveedorTelefono').text(orden.proveedor_telefono || 'N/A');
                    $('#proveedorCorreo').text(orden.proveedor_correo || 'N/A');
                    $('#proveedorDireccion').text(orden.proveedor_direccion || 'N/A');
                    
                    // Datos de la orden
                    $('#ordenFecha').text(new Date(orden.fecha_orden || orden.created_at).toLocaleDateString('es-ES'));
                    $('#ordenMoneda').text(orden.moneda ? orden.moneda.toUpperCase() : 'USD');
                    $('#ordenTasa').text(parseFloat(orden.tasa_dia).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    $('#ordenIva').text(orden.iva ? 'Sí (16%)' : 'No');
                    
                    // Actualizar estatus en el modal
                    var estatusText = orden.estatus || 'Pendiente';
                    $('#ordenEstatus').text(estatusText);
                    
                    $('#ordenUsuario').text(orden.usuario_nombre || 'Sistema');
                    $('#ordenCreatedAt').text(new Date(orden.created_at).toLocaleString('es-ES'));
                    $('#ordenUpdatedAt').text(new Date(orden.updated_at).toLocaleString('es-ES'));
                    
                    // Llenar productos
                    var productosHtml = '';
                    if (productos.length > 0) {
                        productos.forEach(function(producto, index) {
                            productosHtml += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${producto.producto_nombre}</td>
                                    <td>${producto.unidad_abreviatura}</td>
                                    <td class="text-right">${parseFloat(producto.cantidad).toFixed(2)}</td>
                                    <td class="text-right">${parseFloat(producto.precio).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
                                    <td class="text-right">${parseFloat(producto.subtotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
                                </tr>
                            `;
                        });
                    } else {
                        productosHtml = '<tr><td colspan="6" class="text-center">No hay productos registrados</td></tr>';
                    }
                    $('#productosBody').html(productosHtml);
                    
                    // Actualizar totales
                    $('#subtotalOrden').text(parseFloat(calculos.total_general - calculos.monto_iva).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    $('#ivaOrden').text(parseFloat(calculos.monto_iva).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    $('#totalOrden').text(parseFloat(calculos.total_con_iva).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    $('#totalBsOrden').text(parseFloat(orden.totalbs).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                    
                    // Mostrar el modal
                    $('#ordenModal').modal('show');
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar detalles:', xhr.responseText);
                Swal.fire({
                    title: 'Error',
                    text: 'Error al cargar los detalles de la orden',
                    icon: 'error'
                });
            }
        });
    }

    // Función para imprimir la orden
    window.imprimirOrden = function() {
        var orderId = $('#modalOrdenId').text();
        window.open('/orden-compras/plantilla/' + orderId, '_blank');
    };

    // =================================================================
    // FUNCIONES PARA EL MODAL DE APROBAR/REVISAR
    // =================================================================

    // Función para cargar combobox con AJAX
    // Función mejorada para cargar combobox con logging
function cargarComboboxModal() {
    console.log('=== CARGANDO COMBOBOX ===');
    
    // URL base
    const baseUrl = window.location.origin;
    
    // 1. CARGAR RESPONSABLES
    console.log('📋 Cargando responsables de:', `${baseUrl}/responsable`);
    
    fetch(`${baseUrl}/responsable`)
        .then(response => {
            console.log('📥 Respuesta HTTP de responsables:', response.status, response.statusText);
            return response.json();
        })
        .then(data => {
            console.log('📊 Datos de responsables recibidos:', data);
            
            const select = document.getElementById('responsable');
            select.innerHTML = ''; // Limpiar primero
            
            // Agregar opción por defecto
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Seleccionar responsable...';
            defaultOption.selected = true;
            defaultOption.disabled = true;
            select.appendChild(defaultOption);
            
            if (data.success && data.data && data.data.length > 0) {
                console.log(`✅ ${data.data.length} responsables encontrados`);
                
                data.data.forEach(responsable => {
                    console.log('Responsable objeto:', responsable);
                    
                    // IMPORTANTE: Verificar que el ID existe y no es 0
                    const id = responsable.id || responsable.Id || responsable.ID;
                    if (!id || id == 0) {
                        console.warn('⚠️ Responsable con ID inválido:', responsable);
                        return; // Saltar este registro
                    }
                    
                    const nombre = responsable.nombre || responsable.Nombre || 
                                  responsable.descripcion || `Responsable ${id}`;
                    
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = nombre;
                    
                    // Mostrar en consola lo que se está agregando
                    console.log(`➕ Agregando responsable: ID=${id}, Nombre=${nombre}`);
                    select.appendChild(option);
                });
                
                if (select.options.length === 1) { // Solo tiene la opción por defecto
                    console.warn('⚠️ No se agregaron responsables válidos');
                    const errorOption = document.createElement('option');
                    errorOption.value = '';
                    errorOption.textContent = 'No hay responsables disponibles';
                    select.appendChild(errorOption);
                }
            } else {
                console.warn('⚠️ No hay datos de responsables o data.success es false');
                const errorOption = document.createElement('option');
                errorOption.value = '';
                errorOption.textContent = 'No hay responsables disponibles';
                select.appendChild(errorOption);
            }
        })
        .catch(error => {
            console.error('❌ Error cargando responsables:', error);
            const select = document.getElementById('responsable');
            select.innerHTML = '<option value="">Error al cargar responsables</option>';
        });
    
    // 2. CARGAR TIPOS DE FACTURA
    console.log('📋 Cargando tipos de factura de:', `${baseUrl}/tipofactura`);
    
    fetch(`${baseUrl}/tipofactura`)
        .then(response => {
            console.log('📥 Respuesta HTTP de tipos:', response.status, response.statusText);
            return response.json();
        })
        .then(data => {
            console.log('📊 Datos de tipos recibidos:', data);
            
            const select = document.getElementById('tipoFactura');
            select.innerHTML = ''; // Limpiar primero
            
            // Agregar opción por defecto
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Seleccionar tipo...';
            defaultOption.selected = true;
            defaultOption.disabled = true;
            select.appendChild(defaultOption);
            
            if (data.success && data.data && data.data.length > 0) {
                console.log(`✅ ${data.data.length} tipos encontrados`);
                
                data.data.forEach(tipo => {
                    console.log('Tipo objeto:', tipo);
                    
                    const id = tipo.id || tipo.Id || tipo.ID;
                    if (!id || id == 0) {
                        console.warn('⚠️ Tipo con ID inválido:', tipo);
                        return; // Saltar este registro
                    }
                    
                    const nombre = tipo.Tipo || tipo.tipo || 
                                  tipo.descripcion || `Tipo ${id}`;
                    
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = nombre;
                    
                    console.log(`➕ Agregando tipo: ID=${id}, Nombre=${nombre}`);
                    select.appendChild(option);
                });
                
                if (select.options.length === 1) {
                    console.warn('⚠️ No se agregaron tipos válidos');
                    const errorOption = document.createElement('option');
                    errorOption.value = '';
                    errorOption.textContent = 'No hay tipos disponibles';
                    select.appendChild(errorOption);
                }
            } else {
                console.warn('⚠️ No hay datos de tipos o data.success es false');
                const errorOption = document.createElement('option');
                errorOption.value = '';
                errorOption.textContent = 'No hay tipos disponibles';
                select.appendChild(errorOption);
            }
        })
        .catch(error => {
            console.error('❌ Error cargando tipos:', error);
            const select = document.getElementById('tipoFactura');
            select.innerHTML = '<option value="">Error al cargar tipos</option>';
        });
}

    // Evento para abrir el modal de gestión al hacer clic en el badge
    $(document).on('click', '.badge[data-status]', function() {
        var orderId = $(this).data('id');
        var currentStatus = $(this).data('status'); // Ahora es string
        
        console.log('Abriendo modal para orden:', orderId, 'estatus:', currentStatus);
        
        // Establecer valores en el modal
        $('#modalOrdenNumero').text(orderId);
        $('#ordenId').val(orderId);
        $('#currentStatus').val(currentStatus);
        
        // Cargar combobox con AJAX
        cargarComboboxModal();
        
        // Seleccionar el radio button según el estatus actual
        $('input[name="estatusRadio"]').prop('checked', false);
        
        // Convertir estatus numérico a string si es necesario
        var statusStr = String(currentStatus).toLowerCase();
        if (statusStr === '0' || statusStr === 'pendiente') {
            $('#estatusEnProceso').prop('checked', true);
        } else if (statusStr === '1' || statusStr === 'aprobado') {
            $('#estatusAprobado').prop('checked', true);
        } else if (statusStr === '2' || statusStr === 'rechazado') {
            $('#estatusRechazado').prop('checked', true);
        }
        
        // Limpiar campos de texto
        $('#numeroDocumento').val('');
      
        
        // Si la orden ya tiene datos, cargarlos
        cargarDatosOrdenActual(orderId);
        
        // Mostrar el modal
        $('#modalFactura').modal('show');
    });

    // Función para cargar los datos actuales de la orden
    function cargarDatosOrdenActual(orderId) {
        $.ajax({
            url: '/ordenes/detalles/' + orderId,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    var orden = response.data.orden;
                    
                    // Esperar un momento para que se carguen los combobox
                    setTimeout(() => {
                        // Si la orden tiene responsable_id, seleccionarlo
                        if (orden.responsable_id) {
                            $('#responsable').val(orden.responsable_id);
                        }
                        
                        // Si la orden tiene tipo_factura_id, seleccionarlo
                        if (orden.tipo_factura_id) {
                            $('#tipoFactura').val(orden.tipo_factura_id);
                        }
                        
                        // Si la orden tiene número de documento, cargarlo
                        if (orden.numero_documento) {
                            $('#numeroDocumento').val(orden.numero_documento);
                        }
                        
                        // Si la orden tiene observaciones, cargarlas
                       
                    }, 800); // Dar tiempo a que se carguen los combobox
                }
            },
            error: function(error) {
                console.error('Error cargando datos de orden:', error);
            }
        });
    }

    // Evento para guardar cambios en el modal
    // REEMPLAZA el evento actual del btnGuardarFactura con esto:

$('#btnGuardarFactura').click(function() {
    console.log('Botón Guardar presionado');
    
    var form = $('#formularioFactura')[0];
    
    // Validación básica
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Obtener todos los valores del formulario
    var orderId = $('#ordenId').val();
    var responsable = $('#responsable').val();
    var numeroDocumento = $('#numeroDocumento').val().trim();
    var tipoFactura = $('#tipoFactura').val();
    var nuevoEstatus = $('input[name="estatusRadio"]:checked').val();
    
    console.log('Datos recopilados:', {
        orderId: orderId,
        responsable: responsable,
        numeroDocumento: numeroDocumento,
        tipoFactura: tipoFactura,
        nuevoEstatus: nuevoEstatus
    });
    
    // Validar que se seleccionó un estatus
    if (!nuevoEstatus) {
        Swal.fire({
            icon: 'warning',
            title: 'Estatus requerido',
            text: 'Por favor selecciona un estatus',
            confirmButtonColor: '#ffc107'
        });
        return;
    }

    // Mostrar confirmación
    Swal.fire({
        title: '¿Confirmar cambios?',
        html: `
            <div style="text-align: left; background: #f8f9fa; padding: 15px; border-radius: 5px;">
                <p><strong>Orden:</strong> #${orderId}</p>
                <p><strong>Nuevo estatus:</strong> ${getEstatusText(nuevoEstatus)}</p>
                <p><strong>Responsable:</strong> ${$('#responsable option:selected').text()}</p>
                <p><strong>Tipo Factura:</strong> ${$('#tipoFactura option:selected').text()}</p>
                <p><strong>Documento:</strong> ${numeroDocumento}</p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-check"></i> Confirmar',
        cancelButtonText: '<i class="fas fa-times"></i> Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // IMPORTANTE: Usa la URL ABSOLUTA para evitar problemas
            enviarDatosAGestionOrdenes(orderId, responsable, numeroDocumento, tipoFactura, nuevoEstatus);
        }
    });
});

// FUNCIÓN ACTUALIZADA que envía a /gestion-ordenes
function enviarDatosAGestionOrdenes(orderId, responsable, numeroDocumento, tipoFactura, nuevoEstatus) {
    // URL ABSOLUTA - Esto es CRÍTICO
    var url = '{{ route("ordenes.gestion") }}';
    
    console.log('🚀 Enviando datos a:', url);
    console.log('📦 Datos:', {
        id: orderId,
        responsable_id: responsable,
        numero_documento: numeroDocumento,
        tipo_factura_id: tipoFactura,
        estatus: nuevoEstatus
    });
    
    // Deshabilitar botón y mostrar loading
    var btn = $('#btnGuardarFactura');
    var originalText = btn.html();
    btn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
    btn.prop('disabled', true);
    
    // Enviar AJAX a la ruta específica
    $.ajax({
        url: url,  // AQUÍ es donde se envía
        type: 'POST',
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        data: {
            id: orderId,
            responsable_id: responsable,
            numero_documento: numeroDocumento,
            tipo_factura_id: tipoFactura,
            estatus: nuevoEstatus,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('✅ Respuesta del servidor:', response);
            
            // Restaurar botón
            btn.html(originalText);
            btn.prop('disabled', false);
            
            if (response.success) {
                // Cerrar el modal
                $('#modalFactura').modal('hide');
                
                // Mostrar mensaje de éxito
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Información guardada correctamente en /gestion-ordenes',
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                });
                
                // Recargar la tabla DataTable
                if (typeof table !== 'undefined') {
                    table.ajax.reload(null, false);
                } else {
                    location.reload();
                }
                
            } else {
                Swal.fire({
                    title: 'Error en el servidor',
                    text: response.message || 'Error desconocido',
                    icon: 'error'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('❌ Error AJAX completo:', {
                xhr: xhr,
                status: status,
                error: error
            });
            
            // Restaurar botón
            btn.html(originalText);
            btn.prop('disabled', false);
            
            var errorMessage = 'Error al enviar los datos';
            
            // Intentar obtener mensaje de error más específico
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 422) {
                errorMessage = 'Error de validación. Revisa los datos.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorMessage += value + '\n';
                    });
                }
            } else if (xhr.status === 404) {
                errorMessage = 'Ruta /gestion-ordenes no encontrada. Verifica la URL.';
            } else if (xhr.status === 419) {
                errorMessage = 'Token CSRF expirado. Recarga la página.';
            } else if (xhr.status === 500) {
                errorMessage = 'Error interno del servidor. Verifica los logs.';
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

    // Función para obtener texto del estatus
    function getEstatusText(estatus) {
        switch(estatus) {
            case 'pendiente': return 'Pendiente';
            case 'aprobado': return 'Aprobado';
            case 'rechazado': return 'Rechazado';
            case 'procesado': return 'Procesado';
            case 'completado': return 'Completado';
            default: return 'Desconocido';
        }
    }

    // Función para enviar cambios al servidor
    function enviarCambiosOrden(orderId, responsable, numeroDocumento, tipoFactura, nuevoEstatus) {
        $.ajax({
            url: '{{ route("ordenes.cambiar-estatus") }}',
            type: 'POST',
            data: {
                id: orderId,
                responsable: responsable,
                numero_documento: numeroDocumento,
                tipo_factura: tipoFactura,
                estatus: nuevoEstatus,
                
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function() {
                // Mostrar loading en el botón
                $('#btnGuardarFactura').html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
                $('#btnGuardarFactura').prop('disabled', true);
            },
            success: function(response) {
                console.log('✅ Respuesta del servidor:', response);
                
                // Restaurar botón
                $('#btnGuardarFactura').html('<i class="fas fa-save"></i> Guardar Cambios');
                $('#btnGuardarFactura').prop('disabled', false);
                
                if (response.success) {
                    // Cerrar el modal
                    $('#modalFactura').modal('hide');
                    
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: '¡Éxito!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonColor: '#28a745'
                    });
                    
                    // Recargar la tabla
                    table.ajax.reload(null, false);
                    
                    // Si el modal de detalles está abierto, actualizarlo también
                    if ($('#ordenModal').is(':visible')) {
                        var currentOrderId = $('#modalOrdenId').text();
                        if (currentOrderId == orderId) {
                            cargarDetallesOrden(orderId);
                        }
                    }
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
                console.error('❌ Error AJAX:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText,
                    error: error
                });

                // Restaurar botón
                $('#btnGuardarFactura').html('<i class="fas fa-save"></i> Guardar Cambios');
                $('#btnGuardarFactura').prop('disabled', false);
                
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

    // Funciones para acciones (MANTENIENDO TU LÓGICA ORIGINAL)
    window.editarOrden = function(id) {
        // Redirigir a la página de edición
        window.location.href = '/ordenes-compras/' + id + '/editar';
    };

    window.eliminarOrden = function(id) {
        Swal.fire({
            title: '¿Eliminar orden?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/ordenes-compras/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            });
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Error al eliminar la orden',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    };

    // Limpiar formulario cuando se cierra el modal
    $('#modalFactura').on('hidden.bs.modal', function () {
        $('#formularioFactura')[0].reset();
        $('#ordenId').val('');
        $('#currentStatus').val('');
        $('input[name="estatusRadio"]').prop('checked', false);
    });
});
</script>
@stop