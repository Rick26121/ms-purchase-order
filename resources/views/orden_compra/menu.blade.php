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
            <div class="btn-group" role="group" aria-label="Botones de acciones">
                <a href="{{ route('ordenes.crear') }}" class="btn btn-primary btn-sm mr-2">
                    <i class="fas fa-plus"></i> Nueva Orden
                </a>
                <button type="button" class="btn btn-warning btn-sm" id="btnActualizarTasa">
                    <i class="fas fa-sync-alt"></i> Actualizar Tasa Pendientes
                </button>
            </div>
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

<!-- Modal para gestionar factura/estatus -->
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

                    <!-- Campo Fecha de Factura -->
                    <div class="form-group">
                        <label for="fechaFactura"><strong>Fecha de Factura</strong></label>
                        <input type="date" class="form-control" id="fechaFactura" name="fechaFactura" required>
                        <small class="form-text text-muted">Seleccione la fecha de la factura</small>
                    </div>

                    <!-- Combo Box Tipo de Factura (LLENAR CON AJAX) -->
                    <div class="form-group">
                        <label for="tipoFactura"><strong>Tipo de Factura</strong></label>
                        <select class="form-control" id="tipoFactura" name="tipoFactura" required>
                            <option value="">Cargando tipos de factura...</option>
                        </select>
                    </div>

                    <!-- Combo Box Método de Pago (LLENAR CON LA VARIABLE GLOBAL) -->
                    <div class="form-group">
                        <label for="metodoPago"><strong>Método de Pago</strong></label>
                        <select class="form-control" id="metodoPago" name="metodoPago" required>
                            <option value="">Cargando métodos de pago...</option>
                        </select>
                    </div>

                    <!-- Campo Código de Referencia (dinámico) -->
                    <div class="form-group" id="codigoReferenciaContainer" style="display: none;">
                        <label for="codigoReferencia"><strong>Código de Referencia</strong></label>
                        <input type="text" class="form-control" id="codigoReferencia" name="codigoReferencia" placeholder="Ej: REF-1234567890">
                        <small class="form-text text-muted">Ingrese el código de referencia de la transacción</small>
                    </div>

                    <!-- Radio buttons para estatus -->
                    <div class="form-group">
                        <label><strong>Cambiar Estatus:</strong></label>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estatusRadio" id="estatusEnProceso" value="pendiente">
                                    <label class="form-check-label" for="estatusEnProceso">
                                        <span class="badge badge-warning">Pendiente</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="estatusRadio" id="estatusAprobado" value="aprobado">
                                    <label class="form-check-label" for="estatusAprobado">
                                        <span class="badge badge-success">Aprobado</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-3">
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

<!-- INCLUIR EL MODAL SEPARADO -->
@include('Modal.vista')

@stop

@section('css')
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">
<!-- CSS del modal (opcional) -->
<link rel="stylesheet" href="{{ asset('assets/css/modal-vista.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/menuorde.css') }}">

@stop

@section('js')
<script>
$(document).ready(function() {
    // Variable global para métodos de pago - DEBE INCLUIR ID Y NOMBRE
    var globalmetodos = @json($metodos);
    
    // Mapa para convertir IDs a nombres
    var mapaMetodos = {};
    
    // Crear mapa de IDs a nombres
    if (globalmetodos && Array.isArray(globalmetodos)) {
        globalmetodos.forEach(function(metodo) {
            if (typeof metodo === 'object') {
                var id = metodo.id || metodo.value;
                var nombre = metodo.nombre || metodo.name || metodo.descripcion;
                if (id && nombre) {
                    mapaMetodos[id] = nombre.toUpperCase().trim();
                }
            }
        });
    }
 
    // Cargar métodos cuando se abre el modal
    $('#modalFactura').on('shown.bs.modal', function() {
       
        
        // Cargar métodos
        var metodos = globalmetodos || [];
        var selectMetodo = $('#metodoPago');
        
        selectMetodo.empty();
        selectMetodo.append('<option value="">Seleccione método de pago...</option>');
        
        metodos.forEach(function(metodo) {
            if (typeof metodo === 'object') {
                var valor = metodo.id || metodo.value || metodo.nombre || metodo.name;
                var texto = metodo.nombre || metodo.name || metodo.descripcion || valor;
                selectMetodo.append('<option value="' + valor + '">' + texto + '</option>');
            } else {
                selectMetodo.append('<option value="' + metodo + '">' + metodo + '</option>');
            }
        });
        
        // Ocultar campo de referencia inicialmente
        $('#codigoReferenciaContainer').hide();
        $('#codigoReferencia').prop('required', false);
        
        // Función para obtener el nombre del método por ID
        function obtenerNombreMetodo(id) {
            if (mapaMetodos[id]) {
                return mapaMetodos[id];
            }
            
            // Buscar en las opciones del select
            var texto = $('#metodoPago option[value="' + id + '"]').text();
            return texto ? texto.toUpperCase().trim() : '';
        }
        
        // Función para manejar el cambio
        function manejarCambioMetodoPago() {
            var metodoId = $('#metodoPago').val();
  
            
            if (!metodoId) {
                $('#codigoReferenciaContainer').hide();
                $('#codigoReferencia').prop('required', false);
                return;
            }
            
            // Obtener el nombre real del método
            var metodoNombre = obtenerNombreMetodo(metodoId);
      
            
            // SOLO estos dos NO necesitan referencia
            var esEfectivoDivisas = metodoNombre === 'EFECTIVO DIVISAS' || 
                                   metodoNombre.includes('EFECTIVO DIVISAS');
            
            var esEfectivoBolivares = metodoNombre === 'EFECTIVO BOLIVARES' || 
                                     metodoNombre.includes('EFECTIVO BOLIVARES');
            
           
            
            if (esEfectivoDivisas || esEfectivoBolivares) {
               
                $('#codigoReferenciaContainer').hide('fast');
                $('#codigoReferencia').prop('required', false);
                $('#codigoReferencia').val('');
            } else {
              
                $('#codigoReferenciaContainer').show('fast');
                $('#codigoReferencia').prop('required', true);
            }
        }
        
        // Asignar evento de cambio
        selectMetodo.off('change.metodo').on('change.metodo', function() {
            manejarCambioMetodoPago();
        });
        
        // También eventos de clic
        selectMetodo.off('click').on('click', function() {
            setTimeout(manejarCambioMetodoPago, 100);
        });
    });
    
    // Reset al cerrar el modal
    $('#modalFactura').on('hidden.bs.modal', function() {
  
        $('#metodoPago').val('');
        $('#codigoReferenciaContainer').hide();
        $('#codigoReferencia').val('').prop('required', false);
    });
});
</script>
<script>
        // Guardar las unidades en una variable global
        var globalUnidades = @json($unidades);
        
        // Función para obtener las unidades
        function getUnidades() {
            if (typeof globalUnidades !== 'undefined' && globalUnidades !== null) {
                return globalUnidades;
            }
            return [];
        }
        
        
      
      
    </script>
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

<!-- JS del modal separado -->
<script src="{{ asset('assets/js/modal-vista.js') }}"></script>

<script>
// Definir variables globales que necesita el modal
window.baseUrl = '{{ url("/") }}';
window.csrfToken = '{{ csrf_token() }}';

$(document).ready(function() {
    // =================================================================
    // FUNCIÓN DE FORMATO GLOBAL PARA NÚMEROS DE CONTROL
    // =================================================================
    function formatoNumeroControl(numero) {
        // Verificar si data es válido
        if (!numero) return 'CZ000000';
        
        // Convertir a string
        var numeroStr = numero.toString();
        
        // Remover cualquier "CZ" o espacios del inicio
        numeroStr = numeroStr.replace(/^CZ\s*/i, '');
        
        // Asegurar que solo tenemos números
        numeroStr = numeroStr.replace(/\D/g, '');
        
        // Si no hay números, usar 0
        if (!numeroStr) numeroStr = '0';
        
        // Formatear con ceros a la izquierda (6 dígitos)
        var numeroFormateado = 'CZ' + numeroStr.padStart(6, '0');
        
        return numeroFormateado;
    }

    // Función para formatear fecha para mostrar (DD/MM/YYYY)
    function formatDateForDisplay(dateString) {
        if (!dateString) return 'No especificada';
        
        try {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        } catch (e) {
            return dateString;
        }
    }

    // Crear la tabla DataTable
    window.ordersTable = $('#ordersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '{{ route("ordenes-compras.datos") }}',
            type: 'GET',
            dataSrc: 'data',
            dataFilter: function(data) {
               
                var json = JSON.parse(data);
                
                if (json.data && json.data.length > 0) {
                    
                    
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
                    
                    
                }
                
                return JSON.stringify(json);
            }
        },
        columns: [
            { 
                data: 'nro_control',
                name: 'nro_control',
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    return formatoNumeroControl(data);
                }
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
                        // Manejo simple para extraer solo la parte de la fecha
                        const fechaStr = data.toString();
                        
                        // Si la fecha tiene formato "2025-12-19 00:00:00"
                        if (fechaStr.includes(' ')) {
                            const [fecha] = fechaStr.split(' '); // Extrae solo "2025-12-19"
                            const [year, month, day] = fecha.split('-');
                            
                            // Formato DD/MM/YYYY
                            return `${day}/${month}/${year}`;
                        }
                        // Si ya viene solo la fecha "2025-12-19"
                        else if (fechaStr.includes('-')) {
                            const [year, month, day] = fechaStr.split('-');
                            return `${day}/${month}/${year}`;
                        }
                        
                        return fechaStr;
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
                    // Formatear número de control para tooltips
                    var numeroFormateado = formatoNumeroControl(data);
                    
                    return `
                        <div class="btn-group">
                            <button class="btn btn-info btn-sm btn-action" title="Ver Detalles de ${numeroFormateado}" onclick="verOrden(${data})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-action" title="Eliminar ${numeroFormateado}" onclick="eliminarOrden(${data})">
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
        ]
    });

    // =================================================================
    // BOTÓN PARA ACTUALIZAR TASA EN ÓRDENES PENDIENTES
    // =================================================================
    $('#btnActualizarTasa').click(function() {
        // Deshabilitar botón temporalmente
        var btn = $(this);
        var originalHtml = btn.html();
        btn.html('<i class="fas fa-spinner fa-spin"></i> Procesando...');
        btn.prop('disabled', true);
        
        Swal.fire({
            title: '¿Actualizar tasa del día?',
            text: 'Se actualizará la tasa del día en todas las órdenes con estatus "Pendiente". ¿Desea continuar?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fas fa-sync-alt"></i> Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Actualizando tasas...',
                    text: 'Por favor espere mientras se procesan las órdenes pendientes.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Enviar solicitud AJAX
                $.ajax({
                    url: '{{ route("actualizar.tasas") }}',
                    type: 'GET',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // Restaurar botón
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                        
                        if (response.success) {
                            Swal.fire({
                                title: '¡Éxito!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                // Recargar la tabla
                                window.ordersTable.ajax.reload(null, false);
                            });
                        } else {
                            Swal.fire({
                                title: 'Advertencia',
                                text: response.message,
                                icon: 'warning'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Restaurar botón
                        btn.html(originalHtml);
                        btn.prop('disabled', false);
                        
                        var errorMessage = 'Error al actualizar las tasas';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            title: 'Error',
                            text: errorMessage,
                            icon: 'error'
                        });
                    }
                });
            } else {
                // Restaurar botón si canceló
                btn.html(originalHtml);
                btn.prop('disabled', false);
            }
        });
    });

    // =================================================================
    // MODAL DE APROBAR/REVISAR
    // =================================================================

    // Función para cargar combobox con AJAX
    function cargarComboboxModal() {
       
        
        const baseUrl = window.location.origin;
        
        // 1. CARGAR RESPONSABLES
        fetch(`${baseUrl}/responsable`)
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('responsable');
                select.innerHTML = '';
                
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Seleccionar responsable...';
                defaultOption.selected = true;
                defaultOption.disabled = true;
                select.appendChild(defaultOption);
                
                if (data.success && data.data && data.data.length > 0) {
                    data.data.forEach(responsable => {
                        const id = responsable.id || responsable.Id || responsable.ID;
                        if (!id || id == 0) return;
                        
                        const nombre = responsable.nombre || responsable.Nombre || 
                                      responsable.descripcion || `Responsable ${id}`;
                        
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = nombre;
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error cargando responsables:', error);
                const select = document.getElementById('responsable');
                select.innerHTML = '<option value="">Error al cargar responsables</option>';
            });
        
        // 2. CARGAR TIPOS DE FACTURA
        fetch(`${baseUrl}/tipofactura`)
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('tipoFactura');
                select.innerHTML = '';
                
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Seleccionar tipo...';
                defaultOption.selected = true;
                defaultOption.disabled = true;
                select.appendChild(defaultOption);
                
                if (data.success && data.data && data.data.length > 0) {
                    data.data.forEach(tipo => {
                        const id = tipo.id || tipo.Id || tipo.ID;
                        if (!id || id == 0) return;
                        
                        const nombre = tipo.Tipo || tipo.tipo || 
                                      tipo.descripcion || `Tipo ${id}`;
                        
                        const option = document.createElement('option');
                        option.value = id;
                        option.textContent = nombre;
                        select.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error cargando tipos:', error);
                const select = document.getElementById('tipoFactura');
                select.innerHTML = '<option value="">Error al cargar tipos</option>';
            });
    }

    // Evento para abrir el modal de gestión al hacer clic en el badge
    $(document).on('click', '.badge[data-status]', function() {
        var orderId = $(this).data('id');
        var currentStatus = $(this).data('status');
     
        // Formatear número para mostrar
        var numeroFormateado = formatoNumeroControl(orderId);
        
        // Establecer valores en el modal
        $('#modalOrdenNumero').text(numeroFormateado);
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
        
        // Establecer fecha actual por defecto
        var today = new Date().toISOString().split('T')[0];
        $('#fechaFactura').val(today);
        
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
                        
                        // NUEVO: Si la orden tiene fecha_factura, cargarla
                        if (orden.fecha_factura) {
                            // Formatear la fecha para el input type="date" (YYYY-MM-DD)
                            var fecha = new Date(orden.fecha_factura);
                            var fechaFormateada = fecha.toISOString().split('T')[0];
                            $('#fechaFactura').val(fechaFormateada);
                        }
                    }, 800);
                }
            },
            error: function(error) {
                console.error('Error cargando datos de orden:', error);
            }
        });
    }

    // Evento para guardar cambios en el modal - ACTUALIZADO
$('#btnGuardarFactura').click(function() {
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
    var fechaFactura = $('#fechaFactura').val();
    var tipoFactura = $('#tipoFactura').val();
    var metodoPago = $('#metodoPago').val(); // NUEVO
    var codigoReferencia = $('#codigoReferencia').val(); // NUEVO
    var nuevoEstatus = $('input[name="estatusRadio"]:checked').val();
    
    // Formatear orden para mostrar en mensajes
    var numeroFormateado = formatoNumeroControl(orderId);
    
    // Validar método de pago
    if (!metodoPago) {
        Swal.fire({
            icon: 'warning',
            title: 'Método de pago requerido',
            text: 'Por favor selecciona un método de pago',
            confirmButtonColor: '#ffc107'
        });
        $('#metodoPago').focus();
        return;
    }
    
    // Validar código de referencia si es requerido
    if (metodoPago && $('#codigoReferenciaContainer').is(':visible') && !codigoReferencia) {
        Swal.fire({
            icon: 'warning',
            title: 'Código de referencia requerido',
            text: 'Para este método de pago es necesario ingresar el código de referencia',
            confirmButtonColor: '#ffc107'
        });
        $('#codigoReferencia').focus();
        return;
    }

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

    // Validar fecha
    if (!fechaFactura) {
        Swal.fire({
            icon: 'warning',
            title: 'Fecha requerida',
            text: 'Por favor selecciona una fecha de factura',
            confirmButtonColor: '#ffc107'
        });
        return;
    }

    // Mostrar confirmación - ACTUALIZADO
    Swal.fire({
        title: '¿Confirmar cambios?',
        html: `
            <div style="text-align: left; background: #f8f9fa; padding: 15px; border-radius: 5px;">
                <p><strong>Orden:</strong> ${numeroFormateado}</p>
                <p><strong>Nuevo estatus:</strong> ${getEstatusText(nuevoEstatus)}</p>
                <p><strong>Responsable:</strong> ${$('#responsable option:selected').text()}</p>
                <p><strong>Tipo Factura:</strong> ${$('#tipoFactura option:selected').text()}</p>
                <p><strong>Método Pago:</strong> ${$('#metodoPago option:selected').text()}</p>
                ${codigoReferencia ? `<p><strong>Código Referencia:</strong> ${codigoReferencia}</p>` : ''}
                <p><strong>Documento:</strong> ${numeroDocumento}</p>
                <p><strong>Fecha Factura:</strong> ${formatDateForDisplay(fechaFactura)}</p>
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
            enviarDatosAGestionOrdenes(orderId, responsable, numeroDocumento, fechaFactura, tipoFactura, metodoPago, codigoReferencia, nuevoEstatus);
        }
    });
});

    // FUNCIÓN ACTUALIZADA que envía a /gestion-ordenes
   // FUNCIÓN ACTUALIZADA que envía a /gestion-ordenes
function enviarDatosAGestionOrdenes(orderId, responsable, numeroDocumento, fechaFactura, tipoFactura, metodoPagoId, codigoReferencia, nuevoEstatus) {
    var url = '{{ route("ordenes.gestion") }}';
    
    // Obtener valores de método de pago y código de referencia
    var metodoPagoId = $('#metodoPago').val();
    var codigoReferencia = $('#codigoReferencia').val();
    
    // Formatear para logs
    var numeroFormateado = formatoNumeroControl(orderId);
    
    // Validar que se seleccionó método de pago
    if (!metodoPagoId) {
        Swal.fire({
            icon: 'warning',
            title: 'Método de pago requerido',
            text: 'Por favor selecciona un método de pago',
            confirmButtonColor: '#ffc107'
        });
        return;
    }
    
    // Deshabilitar botón y mostrar loading
    var btn = $('#btnGuardarFactura');
    var originalText = btn.html();
    btn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
    btn.prop('disabled', true);
    
    // Enviar AJAX a la ruta específica
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        data: {
            id: orderId,
            responsable_id: responsable,
            numero_documento: numeroDocumento,
            fecha_factura: fechaFactura,
            tipo_factura_id: tipoFactura,
            metodo_pago_id: metodoPagoId, // AÑADIR ESTE CAMPO
            codigo_referencia: codigoReferencia || '', // AÑADIR SI EXISTE
            estatus: nuevoEstatus,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Restaurar botón
            btn.html(originalText);
            btn.prop('disabled', false);
            
            if (response.success) {
                // Cerrar el modal
                $('#modalFactura').modal('hide');
                
                // Mostrar mensaje de éxito
                Swal.fire({
                    title: '¡Éxito!',
                    text: `Orden ${numeroFormateado} actualizada correctamente`,
                    icon: 'success',
                    confirmButtonColor: '#28a745'
                });
                
                // Recargar la tabla DataTable
                if (typeof window.ordersTable !== 'undefined') {
                    window.ordersTable.ajax.reload(null, false);
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
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.status === 422) {
                // Mostrar errores de validación específicos
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorList = '';
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errorList += errors[key].join(', ') + '\n';
                        }
                    }
                    errorMessage = 'Errores de validación:\n' + errorList;
                }
            } else if (xhr.status === 404) {
                errorMessage = 'Ruta no encontrada. Verifica la URL.';
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

    // =================================================================
    // FUNCIONES AUXILIARES
    // =================================================================
    
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

    // Función para eliminar orden
    window.eliminarOrden = function(id) {
        // Formatear número para mostrar en mensaje
        var numeroFormateado = formatoNumeroControl(id);
        
        Swal.fire({
            title: `¿Eliminar orden ${numeroFormateado}?`,
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
                                text: `Orden ${numeroFormateado} eliminada correctamente`,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            });
                            window.ordersTable.ajax.reload(null, false);
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
        // Establecer fecha actual por defecto cuando se abre de nuevo
        var today = new Date().toISOString().split('T')[0];
        $('#fechaFactura').val(today);
    });
});
</script>

@stop