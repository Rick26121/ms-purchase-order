// =================================================================
// VARIABLES GLOBALES PARA EL MODAL
// =================================================================
var ordenActualId = null;
var modoEdicionProductos = false;

// =================================================================
// FUNCIONES PARA CARGAR Y MANEJAR EL MODAL
// =================================================================

// Función para ver orden (llamada desde el botón)
window.verOrden = function(id) {
    cargarDetallesOrden(id);
};

// Función para cargar los detalles de la orden en el modal
function cargarDetallesOrden(orderId) {
    ordenActualId = orderId;
    
    $.ajax({
        url: '/ordenes/detalles/' + orderId,
        type: 'GET',
        data: {
            _token: window.csrfToken || '{{ csrf_token() }}',
            modo_edicion: true
        },
        beforeSend: function() {
            // Mostrar loading
            $('#productosBody').html('<tr><td colspan="7" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>');
        },
        success: function(response) {
            if (response.success) {
                var orden = response.data.orden;
                var productos = response.data.productos;
                var calculos = response.data.calculos;
                
                // Llenar información general con formato CZ
                var numeroFormateado = formatoNumeroControl(orden.id);
                $('#modalOrdenId').text(numeroFormateado);
                
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
                
                // Responsable 
                $('#ordenResponsable').text(orden.responsable_nombre || 'N/A');
                
                // Datos de la orden
                $('#ordenFecha').text(new Date(orden.fecha_orden || orden.created_at).toLocaleDateString('es-ES'));
                $('#ordenMoneda').text(orden.moneda ? orden.moneda.toUpperCase() : 'USD');
                $('#ordenTasa').text(parseFloat(orden.tasa_dia).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                
                // 🔹 MOSTRAR IVA CON DEDUCCIÓN SI APLICA
                var ivaTexto = '';
                if (orden.iva && !orden.iva_deduccion) {
                    ivaTexto = 'Sí (16%)';
                } else if (!orden.iva && orden.iva_deduccion) {
                    ivaTexto = 'Sí (4% - Con deducción)';
                } else {
                    ivaTexto = 'No';
                }
                $('#ordenIva').text(ivaTexto);
                
                // Actualizar estatus en el modal
                var estatusText = orden.estatus || 'Pendiente';
                $('#ordenEstatus').text(estatusText);
                
                $('#ordenUsuario').text(orden.usuario_nombre || 'Sistema');
                $('#ordenCreatedAt').text(new Date(orden.created_at).toLocaleString('es-ES'));
                $('#ordenUpdatedAt').text(new Date(orden.updated_at).toLocaleString('es-ES'));
                
                // 🔹 CARGAR OBSERVACIÓN
                if (orden.observacion && orden.observacion.trim() !== '') {
                    $('#ordenObservacion').text(orden.observacion);
                    $('#ordenObservacion').closest('.alert').removeClass('alert-secondary').addClass('alert-info');
                } else {
                    $('#ordenObservacion').text('Sin observaciones');
                    $('#ordenObservacion').closest('.alert').removeClass('alert-info').addClass('alert-secondary');
                }
                
                // Llenar productos con capacidad de edición
                var productosHtml = '';
                if (productos.length > 0) {
                    productos.forEach(function(producto, index) {
                        productosHtml += `
                            <tr data-producto-id="${producto.id}">
                                <td>${index + 1}</td>
                                <td>
                                    <span class="producto-nombre-view">${producto.producto_nombre}</span>
                                    <input type="text" class="form-control form-control-sm producto-nombre-edit" 
                                           value="${producto.producto_nombre}" style="display: none;">
                                </td>
                                <td>
                                    <span class="unidad-view">${producto.unidad_abreviatura}</span>
                                    <select class="form-control form-control-sm unidad-edit" style="display: none;">
                                        <option value="">Cargando unidades...</option>
                                    </select>
                                </td>
                                <td class="text-right">
                                    <span class="cantidad-view">${parseFloat(producto.cantidad).toFixed(2)}</span>
                                    <input type="number" class="form-control form-control-sm cantidad-edit text-right" 
                                           min="0.01" step="0.01" 
                                           value="${parseFloat(producto.cantidad).toFixed(2)}" style="display: none;">
                                </td>
                                <td class="text-right">
                                    <span class="precio-view">${parseFloat(producto.precio).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</span>
                                    <input type="number" class="form-control form-control-sm precio-edit text-right" 
                                           min="0.01" step="0.01" 
                                           value="${parseFloat(producto.precio).toFixed(2)}" style="display: none;">
                                </td>
                                <td class="subtotal text-right">${parseFloat(producto.subtotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-warning btn-sm btn-editar-producto" 
                                                data-producto-id="${producto.id}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-success btn-sm btn-guardar-producto" 
                                                data-producto-id="${producto.id}" style="display: none;">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-eliminar-producto" 
                                                data-producto-id="${producto.id}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    productosHtml = '<tr><td colspan="7" class="text-center">No hay productos registrados</td></tr>';
                }
                $('#productosBody').html(productosHtml);
                
                // Cargar unidades para los select de edición
                cargarUnidadesParaEdicion();
                
                // Actualizar totales
                actualizarTotalesModal(orden, calculos);
                
                // Configurar eventos para edición
                configurarEventosEdicionProductos();
                
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

// =================================================================
// FUNCIONES PARA EDICIÓN DE PRODUCTOS
// =================================================================

// Función para cargar unidades en los select de edición
function cargarUnidadesParaEdicion() {
    $.ajax({
        url: window.baseUrl + '/consultar/unidades',
        type: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                var unidadesHtml = '<option value="">Seleccionar unidad</option>';
                response.data.forEach(function(unidad) {
                    var unidadId = unidad.id_unidad || unidad.id;
                    var unidadNombre = unidad.nombre || unidad.abreviatura;
                    unidadesHtml += `<option value="${unidadId}">${unidadNombre}</option>`;
                });
                
                // Aplicar a todos los select de edición
                $('.unidad-edit').html(unidadesHtml);
                
                // Establecer valores actuales
                $('#productosBody tr[data-producto-id]').each(function() {
                    var $tr = $(this);
                    var unidadActual = $tr.find('.unidad-view').text();
                    var $select = $tr.find('.unidad-edit');
                    
                    // Buscar la opción que coincida
                    $select.find('option').each(function() {
                        if ($(this).text() === unidadActual) {
                            $(this).prop('selected', true);
                            return false;
                        }
                    });
                });
            }
        },
        error: function() {
            console.error('Error al cargar unidades');
        }
    });
}

// Función para configurar eventos de edición
function configurarEventosEdicionProductos() {
    // Botón para editar producto
    $(document).on('click', '.btn-editar-producto', function() {
        var productoId = $(this).data('producto-id');
        var $tr = $(this).closest('tr');
        
        // Activar modo edición para esta fila
        activarModoEdicion($tr);
    });
    
    // Botón para guardar cambios
    $(document).on('click', '.btn-guardar-producto', function() {
        var productoId = $(this).data('producto-id');
        var $tr = $(this).closest('tr');
        
        guardarCambiosProducto(productoId, $tr);
    });
    
    // Botón para eliminar producto
    $(document).on('click', '.btn-eliminar-producto', function() {
        var productoId = $(this).data('producto-id');
        
        eliminarProducto(productoId);
    });
    
    // Eventos para cambios en tiempo real durante edición
    $(document).on('input', '.cantidad-edit, .precio-edit', function() {
        var $tr = $(this).closest('tr');
        calcularSubtotalFila($tr);
    });
    
    // Botón para agregar nuevo producto
    $('#btnAgregarProductoModal').click(function() {
        agregarNuevoProducto();
    });
}

// Función para activar modo edición en una fila
function activarModoEdicion($tr) {
    // Ocultar vistas y mostrar inputs
    $tr.find('.producto-nombre-view').hide();
    $tr.find('.producto-nombre-edit').show();
    
    $tr.find('.unidad-view').hide();
    $tr.find('.unidad-edit').show();
    
    $tr.find('.cantidad-view').hide();
    $tr.find('.cantidad-edit').show();
    
    $tr.find('.precio-view').hide();
    $tr.find('.precio-edit').show();
    
    // Cambiar botones
    $tr.find('.btn-editar-producto').hide();
    $tr.find('.btn-guardar-producto').show();
}

// Función para desactivar modo edición
function desactivarModoEdicion($tr) {
    // Mostrar vistas y ocultar inputs
    $tr.find('.producto-nombre-view').show();
    $tr.find('.producto-nombre-edit').hide();
    
    $tr.find('.unidad-view').show();
    $tr.find('.unidad-edit').hide();
    
    $tr.find('.cantidad-view').show();
    $tr.find('.cantidad-edit').hide();
    
    $tr.find('.precio-view').show();
    $tr.find('.precio-edit').hide();
    
    // Cambiar botones
    $tr.find('.btn-editar-producto').show();
    $tr.find('.btn-guardar-producto').hide();
}

// Función para calcular subtotal de una fila DURANTE EDICIÓN
function calcularSubtotalFila($tr) {
    var cantidad = parseFloat($tr.find('.cantidad-edit').val()) || 0;
    var precio = parseFloat($tr.find('.precio-edit').val()) || 0;
    var subtotal = cantidad * precio;
    
    $tr.find('.subtotal').text(subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    
    // Actualizar totales generales CON LAS CONFIGURACIONES ORIGINALES
    actualizarTotalesGenerales();
}

// Función para actualizar totales generales - VERSIÓN QUE RESPETA CONFIGURACIÓN ORIGINAL
function actualizarTotalesGenerales() {
    var subtotalGeneral = 0;
    
    // Sumar todos los subtotales
    $('.subtotal').each(function() {
        var subtotalText = $(this).text().replace(/\./g, '').replace(',', '.');
        subtotalGeneral += parseFloat(subtotalText) || 0;
    });
    
    // Obtener información ORIGINAL de la orden desde los spans
    var tasa = parseFloat($('#ordenTasa').text().replace(/\./g, '').replace(',', '.'));
    var ivaTexto = $('#ordenIva').text();
    
    // Determinar configuración de IVA ORIGINAL
    var ivaAplica = ivaTexto.includes('Sí');
    var ivaDeduccion = ivaTexto.includes('deducción');
    
    // Actualizar etiqueta de IVA según configuración
    var ivaLabel = 'IVA:';
    if (ivaAplica && !ivaDeduccion) {
        ivaLabel = 'IVA (16%):';
    } else if (ivaAplica && ivaDeduccion) {
        ivaLabel = 'IVA (4% - Deducción):';
    }
    $('#ivaOrden').closest('tr').find('td:first').html('<strong>' + ivaLabel + '</strong>');
    
    // Calcular IVA según la configuración ORIGINAL
    var montoIva = 0;
    if (ivaAplica && !ivaDeduccion) {
        // IVA normal 16%
        montoIva = subtotalGeneral * 0.16;
    } else if (ivaAplica && ivaDeduccion) {
        // IVA con deducción 4% (16% con 75% deducción = 4% neto)
        montoIva = subtotalGeneral * 0.04;
    }
    
    var totalConIva = subtotalGeneral + montoIva;
    var totalBs = totalConIva * tasa;
    
    // Actualizar los totales en el modal
    $('#subtotalOrden').text(subtotalGeneral.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#ivaOrden').text(montoIva.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#totalOrden').text(totalConIva.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#totalBsOrden').text(totalBs.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

// Función para guardar cambios de producto - VERSIÓN MEJORADA
function guardarCambiosProducto(productoId, $tr) {
    var nuevoNombre = $tr.find('.producto-nombre-edit').val().trim();
    var nuevaCantidad = $tr.find('.cantidad-edit').val();
    var nuevoPrecio = $tr.find('.precio-edit').val();
    var nuevaUnidadId = $tr.find('.unidad-edit').val();
    var nuevaUnidadTexto = $tr.find('.unidad-edit option:selected').text();
    
    // Obtener la tasa ORIGINAL para validaciones
    var tasa = parseFloat($('#ordenTasa').text().replace(/\./g, '').replace(',', '.'));
    
    // Validaciones
    if (!nuevoNombre || !nuevaCantidad || !nuevoPrecio || !nuevaUnidadId) {
        Swal.fire({
            title: 'Error',
            text: 'Todos los campos son requeridos',
            icon: 'warning'
        });
        return;
    }
    
    if (parseFloat(nuevaCantidad) <= 0 || parseFloat(nuevoPrecio) <= 0) {
        Swal.fire({
            title: 'Error',
            text: 'Cantidad y precio deben ser mayores a 0',
            icon: 'warning'
        });
        return;
    }
    
    Swal.fire({
        title: '¿Guardar cambios?',
        text: '¿Desea guardar los cambios realizados en este producto?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/ordenes/actualizar-producto/' + productoId,
                type: 'PUT',
                data: {
                    _token: window.csrfToken || '{{ csrf_token() }}',
                    nombre: nuevoNombre,
                    cantidad: nuevaCantidad,
                    precio: nuevoPrecio,
                    id_unidad: nuevaUnidadId,
                    // Enviar tasa, moneda e información de IVA para que el backend recalcule correctamente
                    tasa: tasa,
                    moneda: $('#ordenMoneda').text(),
                    iva_config: $('#ordenIva').text()
                },
                beforeSend: function() {
                    $tr.find('.btn-guardar-producto').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        // Actualizar valores de visualización
                        $tr.find('.producto-nombre-view').text(nuevoNombre);
                        $tr.find('.unidad-view').text(nuevaUnidadTexto);
                        $tr.find('.cantidad-view').text(parseFloat(nuevaCantidad).toFixed(2));
                        $tr.find('.precio-view').text(parseFloat(nuevoPrecio).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                        
                        // Calcular y mostrar el subtotal actualizado
                        var subtotal = parseFloat(nuevaCantidad) * parseFloat(nuevoPrecio);
                        $tr.find('.subtotal').text(subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                        
                        // Desactivar modo edición
                        desactivarModoEdicion($tr);
                        
                        // Actualizar totales generales CON LA TASA ORIGINAL
                        actualizarTotalesGenerales();
                        
                        // Actualizar en la base de datos con recálculo completo
                        actualizarOrdenCompleta();
                        
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'Producto actualizado correctamente',
                            icon: 'success',
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error'
                        });
                        $tr.find('.btn-guardar-producto').prop('disabled', false);
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al actualizar el producto',
                        icon: 'error'
                    });
                    $tr.find('.btn-guardar-producto').prop('disabled', false);
                }
            });
        }
    });
}

// Función para eliminar producto
function eliminarProducto(productoId) {
    Swal.fire({
        title: '¿Eliminar producto?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/ordenes/eliminar-producto/' + productoId,
                type: 'DELETE',
                data: {
                    _token: window.csrfToken || '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Eliminar fila de la tabla
                        $(`tr[data-producto-id="${productoId}"]`).remove();
                        
                        // Verificar si quedan productos
                        if ($('#productosBody tr').length === 0) {
                            $('#productosBody').html('<tr><td colspan="7" class="text-center">No hay productos registrados</td></tr>');
                        } else {
                            // Renumerar las filas
                            $('#productosBody tr').each(function(index) {
                                $(this).find('td:first').text(index + 1);
                            });
                        }
                        
                        // Actualizar totales generales y en la base de datos
                        actualizarTotalesGenerales();
                        actualizarOrdenCompleta();
                        
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'Producto eliminado correctamente',
                            icon: 'success',
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error al eliminar el producto',
                        icon: 'error'
                    });
                }
            });
        }
    });
}

// Función para agregar nuevo producto
function agregarNuevoProducto() {
    // Verificar si ya existe una fila de nuevo producto
    if ($('#fila-nuevo-producto').length > 0) {
        Swal.fire({
            title: 'Atención',
            text: 'Ya hay un producto en proceso de agregado',
            icon: 'warning'
        });
        return;
    }
    
    // Crear fila para nuevo producto
    var nuevaFilaHtml = `
        <tr id="fila-nuevo-producto">
            <td>Nuevo</td>
            <td>
                <input type="text" class="form-control form-control-sm producto-nombre-nuevo" 
                       placeholder="Nombre del producto" required>
            </td>
            <td>
                <select class="form-control form-control-sm unidad-nuevo" required>
                    <option value="">Cargando unidades...</option>
                </select>
            </td>
            <td class="text-right">
                <input type="number" class="form-control form-control-sm cantidad-nuevo text-right" 
                       min="0.01" step="0.01" value="1" required>
            </td>
            <td class="text-right">
                <input type="number" class="form-control form-control-sm precio-nuevo text-right" 
                       min="0.01" step="0.01" value="0.00" required>
            </td>
            <td class="subtotal-nuevo text-right">0.00</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-success btn-sm btn-guardar-nuevo">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button class="btn btn-danger btn-sm btn-cancelar-nuevo">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </td>
        </tr>
    `;
    
    // Agregar al final de la tabla
    if ($('#productosBody tr:last').hasClass('text-center')) {
        $('#productosBody').html(nuevaFilaHtml);
    } else {
        $('#productosBody').append(nuevaFilaHtml);
    }
    
    // Cargar unidades en el select
    cargarUnidadesParaNuevoProducto();
    
    // Configurar eventos
    $(document).on('input', '#fila-nuevo-producto .cantidad-nuevo, #fila-nuevo-producto .precio-nuevo', function() {
        calcularSubtotalNuevoProducto();
    });
    
    $('#fila-nuevo-producto .btn-guardar-nuevo').click(function() {
        guardarNuevoProducto();
    });
    
    $('#fila-nuevo-producto .btn-cancelar-nuevo').click(function() {
        $('#fila-nuevo-producto').remove();
        // Si no quedan productos, mostrar mensaje
        if ($('#productosBody tr').length === 0) {
            $('#productosBody').html('<tr><td colspan="7" class="text-center">No hay productos registrados</td></tr>');
        }
        // Restaurar totales originales
        actualizarTotalesGenerales();
    });
}

// Función para cargar unidades para nuevo producto
function cargarUnidadesParaNuevoProducto() {
    $.ajax({
        url: window.baseUrl + '/consultar/unidades',
        type: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                var unidadesHtml = '<option value="">Seleccionar unidad</option>';
                response.data.forEach(function(unidad) {
                    var unidadId = unidad.id_unidad || unidad.id;
                    var unidadNombre = unidad.nombre || unidad.abreviatura;
                    unidadesHtml += `<option value="${unidadId}">${unidadNombre}</option>`;
                });
                
                $('#fila-nuevo-producto .unidad-nuevo').html(unidadesHtml);
            }
        }
    });
}

// Función para calcular subtotal de nuevo producto DURANTE EDICIÓN
function calcularSubtotalNuevoProducto() {
    var $fila = $('#fila-nuevo-producto');
    var cantidad = parseFloat($fila.find('.cantidad-nuevo').val()) || 0;
    var precio = parseFloat($fila.find('.precio-nuevo').val()) || 0;
    var subtotal = cantidad * precio;
    
    $fila.find('.subtotal-nuevo').text(subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    
    // Actualizar totales generales (para vista previa)
    calcularTotalesTemporal();
}

// Función para calcular totales temporal durante la edición de nuevo producto
function calcularTotalesTemporal() {
    var $fila = $('#fila-nuevo-producto');
    if ($fila.length === 0) return;
    
    var subtotalFila = parseFloat($fila.find('.subtotal-nuevo').text().replace(/\./g, '').replace(',', '.')) || 0;
    var subtotalGeneral = 0;
    
    // Sumar subtotales de productos existentes
    $('.subtotal').each(function() {
        var subtotalText = $(this).text().replace(/\./g, '').replace(',', '.');
        subtotalGeneral += parseFloat(subtotalText) || 0;
    });
    
    // Agregar subtotal del nuevo producto
    subtotalGeneral += subtotalFila;
    
    // Obtener información ORIGINAL
    var tasa = parseFloat($('#ordenTasa').text().replace(/\./g, '').replace(',', '.'));
    var ivaTexto = $('#ordenIva').text();
    var ivaAplica = ivaTexto.includes('Sí');
    var ivaDeduccion = ivaTexto.includes('deducción');
    
    // Calcular IVA según configuración ORIGINAL
    var montoIva = 0;
    if (ivaAplica && !ivaDeduccion) {
        montoIva = subtotalGeneral * 0.16;
    } else if (ivaAplica && ivaDeduccion) {
        montoIva = subtotalGeneral * 0.04;
    }
    
    var totalConIva = subtotalGeneral + montoIva;
    var totalBs = totalConIva * tasa;
    
    // Mostrar totales estimados
    $('#subtotalOrden').text(subtotalGeneral.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#ivaOrden').text(montoIva.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#totalOrden').text(totalConIva.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#totalBsOrden').text(totalBs.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

// Función para guardar nuevo producto - VERSIÓN MEJORADA
function guardarNuevoProducto() {
    var $fila = $('#fila-nuevo-producto');
    var nombre = $fila.find('.producto-nombre-nuevo').val().trim();
    var unidadId = $fila.find('.unidad-nuevo').val();
    var unidadTexto = $fila.find('.unidad-nuevo option:selected').text();
    var cantidad = $fila.find('.cantidad-nuevo').val();
    var precio = $fila.find('.precio-nuevo').val();
    
    // Obtener información ORIGINAL de la orden
    var tasa = parseFloat($('#ordenTasa').text().replace(/\./g, '').replace(',', '.'));
    var moneda = $('#ordenMoneda').text();
    var ivaConfig = $('#ordenIva').text();
    
    // Validaciones
    if (!nombre || !unidadId || !cantidad || !precio) {
        Swal.fire({
            title: 'Error',
            text: 'Todos los campos son requeridos',
            icon: 'warning'
        });
        return;
    }
    
    if (parseFloat(cantidad) <= 0 || parseFloat(precio) <= 0) {
        Swal.fire({
            title: 'Error',
            text: 'Cantidad y precio deben ser mayores a 0',
            icon: 'warning'
        });
        return;
    }
    
    $.ajax({
        url: '/ordenes/agregar-producto',
        type: 'POST',
        data: {
            _token: window.csrfToken || '{{ csrf_token() }}',
            orden_id: ordenActualId,
            nombre: nombre,
            id_unidad: unidadId,
            cantidad: cantidad,
            precio: precio,
            // Enviar información de tasa, moneda e IVA
            tasa: tasa,
            moneda: moneda,
            iva_config: ivaConfig
        },
        beforeSend: function() {
            $fila.find('.btn-guardar-nuevo').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                // Calcular subtotal
                var subtotal = parseFloat(cantidad) * parseFloat(precio);
                
                // Crear nueva fila con el producto agregado
                var nuevaFilaHtml = `
                    <tr data-producto-id="${response.detalle_id}">
                        <td>${$('#productosBody tr:not(#fila-nuevo-producto)').length + 1}</td>
                        <td>
                            <span class="producto-nombre-view">${nombre}</span>
                            <input type="text" class="form-control form-control-sm producto-nombre-edit" 
                                   value="${nombre}" style="display: none;">
                        </td>
                        <td>
                            <span class="unidad-view">${unidadTexto}</span>
                            <select class="form-control form-control-sm unidad-edit" style="display: none;">
                                <option value="">Cargando unidades...</option>
                            </select>
                        </td>
                        <td class="text-right">
                            <span class="cantidad-view">${parseFloat(cantidad).toFixed(2)}</span>
                            <input type="number" class="form-control form-control-sm cantidad-edit text-right" 
                                   min="0.01" step="0.01" 
                                   value="${parseFloat(cantidad).toFixed(2)}" style="display: none;">
                        </td>
                        <td class="text-right">
                            <span class="precio-view">${parseFloat(precio).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</span>
                            <input type="number" class="form-control form-control-sm precio-edit text-right" 
                                   min="0.01" step="0.01" 
                                   value="${parseFloat(precio).toFixed(2)}" style="display: none;">
                        </td>
                        <td class="subtotal text-right">${subtotal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ".")}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-warning btn-sm btn-editar-producto" 
                                        data-producto-id="${response.detalle_id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-success btn-sm btn-guardar-producto" 
                                        data-producto-id="${response.detalle_id}" style="display: none;">
                                    <i class="fas fa-save"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-eliminar-producto" 
                                        data-producto-id="${response.detalle_id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                
                // Reemplazar la fila de nuevo producto
                $fila.replaceWith(nuevaFilaHtml);
                
                // Cargar unidades para este nuevo producto
                cargarUnidadesParaFilaEspecifica(response.detalle_id, unidadId);
                
                // Actualizar totales generales
                actualizarTotalesGenerales();
                
                // Actualizar en la base de datos
                actualizarOrdenCompleta();
                
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Producto agregado correctamente',
                    icon: 'success',
                    timer: 1500
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.message,
                    icon: 'error'
                });
                $fila.find('.btn-guardar-nuevo').prop('disabled', false);
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error',
                text: 'Error al agregar el producto',
                icon: 'error'
            });
            $fila.find('.btn-guardar-nuevo').prop('disabled', false);
        }
    });
}

// Función auxiliar para cargar unidades en una fila específica
function cargarUnidadesParaFilaEspecifica(productoId, unidadSeleccionadaId) {
    $.ajax({
        url: window.baseUrl + '/consultar/unidades',
        type: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                var unidadesHtml = '<option value="">Seleccionar unidad</option>';
                response.data.forEach(function(unidad) {
                    var unidadId = unidad.id_unidad || unidad.id;
                    var unidadNombre = unidad.nombre || unidad.abreviatura;
                    var selected = unidadId == unidadSeleccionadaId ? 'selected' : '';
                    unidadesHtml += `<option value="${unidadId}" ${selected}>${unidadNombre}</option>`;
                });
                
                $(`tr[data-producto-id="${productoId}"] .unidad-edit`).html(unidadesHtml);
            }
        }
    });
}

// Función para actualizar la orden completa después de cambios
function actualizarOrdenCompleta() {
    if (!ordenActualId) return;
    
    $.ajax({
        url: '/ordenes/actualizar-totales/' + ordenActualId,
        type: 'POST',
        data: {
            _token: window.csrfToken || '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                // Actualizar la tabla principal si es necesario
                if (typeof window.ordersTable !== 'undefined') {
                    window.ordersTable.ajax.reload(null, false);
                }
            }
        }
    });
}

// Función para actualizar totales en el modal
function actualizarTotalesModal(orden, calculos) {
    $('#subtotalOrden').text(parseFloat(calculos.total_general - calculos.monto_iva).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    
    var ivaLabel = 'IVA (16%):';
    if (orden.iva_deduccion) {
        ivaLabel = 'IVA (4% - Deducción):';
    } else if (!orden.iva) {
        ivaLabel = 'IVA:';
    }
    $('#ivaOrden').closest('tr').find('td:first').html('<strong>' + ivaLabel + '</strong>');
    
    $('#ivaOrden').text(parseFloat(calculos.monto_iva).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#totalOrden').text(parseFloat(calculos.total_con_iva).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    $('#totalBsOrden').text(parseFloat(orden.totalbs).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, "."));
}

// =================================================================
// FUNCIÓN PARA IMPRIMIR ORDEN
// =================================================================
window.imprimirOrden = function() {
    var orderIdFormatted = $('#modalOrdenId').text();
    // Extraer el ID numérico del formato CZ000001
    var orderIdOriginal = orderIdFormatted.replace('CZ', '').replace(/^0+/, '');
    window.open('/orden-compras/plantilla/' + orderIdOriginal, '_blank');
};

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

// =================================================================
// INICIALIZACIÓN CUANDO EL DOM ESTÁ LISTO
// =================================================================
$(document).ready(function() {
    // Verificar si las variables globales están definidas
    if (!window.baseUrl) {
        window.baseUrl = window.location.origin;
    }
    
    if (!window.csrfToken) {
        // Intentar obtener el token CSRF de la meta tag
        window.csrfToken = $('meta[name="csrf-token"]').attr('content');
    }
    
   
});