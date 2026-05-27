// =================================================================
// VARIABLES GLOBALES PARA EL MODAL
// =================================================================
var ordenActualId = null;
var modoEdicionProductos = false;

// 🔹 NUEVO: Objeto para almacenar valores exactos
var valoresExactosProductos = {};

// =================================================================
// FUNCIONES DE FORMATO Y PARSING PARA SISTEMA (PUNTO DECIMAL, COMA MILES)
// =================================================================

// Convertir número - SISTEMA: PUNTO = decimal, COMA = miles
function parseNumberES(value) {
    if (typeof value === 'number') return value;
    if (!value && value !== 0) return 0;
    
    let cleanValue = String(value).trim();
    
    // Caso 1: Ya es un número válido (5.0625)
    if (!isNaN(cleanValue)) {
        return parseFloat(cleanValue);
    }
    
    // Caso 2: Tiene coma y punto - determinar formato
    if (cleanValue.includes('.') && cleanValue.includes(',')) {
        const lastDotIndex = cleanValue.lastIndexOf('.');
        const lastCommaIndex = cleanValue.lastIndexOf(',');
        
        // El último separador es probablemente el decimal
        if (lastDotIndex > lastCommaIndex) {
            // Formato: 1,234.56 (punto decimal)
            cleanValue = cleanValue.replace(/,/g, '');
        } else {
            // Formato: 1.234,56 (coma decimal)
            cleanValue = cleanValue.replace(/\./g, '');
            cleanValue = cleanValue.replace(',', '.');
        }
    }
    // Caso 3: Solo tiene coma - es separador de miles (50,625 → 50625)
    else if (cleanValue.includes(',') && !cleanValue.includes('.')) {
        cleanValue = cleanValue.replace(/,/g, '');
    }
    // Caso 4: Solo tiene punto - es decimal (5.0625 → 5.0625)
    else if (cleanValue.includes('.') && !cleanValue.includes(',')) {
        // Ya está bien, el punto es decimal
    }
    
    const result = parseFloat(cleanValue);
    return isNaN(result) ? 0 : result;
}

// Formatear número con 2 decimales - PUNTO decimal, COMA miles
function formatNumber2Decimals(value) {
    if (value == null || (isNaN(value) && typeof value !== 'number')) return '0.00';
    
    const numValue = parseNumberES(value);
    if (isNaN(numValue)) return '0.00';
    
    // Redondear a 2 decimales
    const rounded = Math.round((numValue + Number.EPSILON) * 100) / 100;
    
    // Separar parte entera y decimal
    const partes = rounded.toFixed(2).split('.');
    let entero = partes[0];
    const decimal = partes[1];
    
    // Agregar comas como separadores de miles si es necesario
    if (entero.length > 3) {
        entero = entero.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
    return `${entero}.${decimal}`;
}

// Formatear número con 4 decimales - PUNTO decimal, COMA miles
function formatNumber4Decimals(value) {
    if (value == null || (isNaN(value) && typeof value !== 'number')) return '0.0000';
    
    const numValue = parseNumberES(value);
    if (isNaN(numValue)) return '0.0000';
    
    // Redondear a 4 decimales
    const rounded = Math.round((numValue + Number.EPSILON) * 10000) / 10000;
    
    // Separar parte entera y decimal
    const partes = rounded.toFixed(4).split('.');
    let entero = partes[0];
    const decimal = partes[1];
    
    // Agregar comas como separadores de miles si es necesario
    if (entero.length > 3) {
        entero = entero.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
    
    return `${entero}.${decimal}`;
}

// 🔹 FUNCIÓN PARA ENTRADA DE USUARIO: convertir formato visual a número
function parseUserInput(value) {
    if (!value) return 0;
    
    let cleanValue = String(value).trim();
    
    // Si el usuario escribe "50,625" (quiere decir 50625)
    // O escribe "5.0625" (quiere decir 5.0625)
    // Asumimos que si tiene punto, es decimal
    // Si solo tiene coma, es entrada directa sin formato
    
    if (cleanValue.includes('.') && !cleanValue.includes(',')) {
        // El usuario escribió con punto decimal
        return parseFloat(cleanValue);
    }
    
    if (cleanValue.includes(',') && !cleanValue.includes('.')) {
        // El usuario podría estar usando coma como decimal O como miles
        // Por seguridad, tratar como decimal reemplazando coma por punto
        return parseFloat(cleanValue.replace(',', '.'));
    }
    
    return parseNumberES(value);
}

// Calcular IVA normal (16%) CON PRECISIÓN
function calcularIVANormal(totalGeneral) {
    const total = parseNumberES(totalGeneral);
    const iva = total * 0.16;
    // Redondear a 2 decimales para evitar floating point
    return Math.round(iva * 100) / 100;
}

// Calcular total con IVA normal CON PRECISIÓN
function calcularTotalConIVANormal(totalGeneral, ivaNormal) {
    const total = parseNumberES(totalGeneral);
    const iva = parseNumberES(ivaNormal);
    const suma = total + iva;
    return Math.round(suma * 100) / 100;
}

// Calcular IVA con deducción CON PRECISIÓN
function calcularIVADeduccion(totalGeneral) {
    const total = parseNumberES(totalGeneral);
    
    // Calcular con redondeo en cada paso
    const ivaCalculado = Math.round(total * 0.16 * 100) / 100;
    const deduccion = Math.round(ivaCalculado * 0.75 * 100) / 100;
    const montoIvaNeto = Math.round((ivaCalculado - deduccion) * 100) / 100;
    const totalConDeduccion = Math.round((total + montoIvaNeto) * 100) / 100;
    
    return {
        ivaCalculado: ivaCalculado,
        deduccion: deduccion,
        montoIvaNeto: montoIvaNeto,
        totalConDeduccion: totalConDeduccion
    };
}

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
    valoresExactosProductos = {};
    
    $.ajax({
        url: '/ordenes/detalles/' + orderId,
        type: 'GET',
        data: {
            _token: window.csrfToken || '{{ csrf_token() }}',
            modo_edicion: true
        },
        beforeSend: function() {
            $('#productosBody').html('<tr><td colspan="7" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>');
        },
        success: function(response) {
            if (response.success) {
                var orden = response.data.orden;
                var productos = response.data.productos;
                
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
                
                // Mostrar tasa con 4 decimales
                const tasa = parseNumberES(orden.tasa_dia);
                $('#ordenTasa').text(formatNumber4Decimals(tasa));
                
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
                    // En la sección donde procesas los productos, cambia esto:
                    productos.forEach(function(producto, index) {
                        const cantidad = parseNumberES(producto.cantidad);
                        const precio = parseNumberES(producto.precio);
                        const subtotal = parseNumberES(producto.subtotal); // Usa el subtotal calculado
                        
                        // 🔥 CORRECCIÓN: Usa detalle_id en lugar de id
                        const detalleId = producto.detalle_id;
                        
                        console.log(`Producto ${index + 1}:`, {
                            detalle_id: detalleId,         // ← Esto viene del controller
                            producto_id: producto.producto_id,
                            nombre: producto.producto_nombre,
                            cantidad: cantidad,
                            precio: precio,
                            subtotal: subtotal
                        });
                        
                        // Guardar valor exacto usando detalle_id
                        valoresExactosProductos[detalleId] = {
                            cantidad: cantidad,
                            precio: precio,
                            subtotal: subtotal
                        };
                        
                        // 🔥 CORRECCIÓN: Usa detalle_id en todos los data attributes
                        productosHtml += `
                            <tr data-producto-id="${detalleId}" data-subtotal="${subtotal}">
                                <td>${index + 1}</td>
                                <td>
                                    <span class="producto-nombre-view">${producto.producto_nombre}</span>
                                    <input type="text" class="form-control form-control-sm producto-nombre-edit" 
                                        value="${producto.producto_nombre}" style="display: none;">
                                </td>
                                <td>
                                    <span class="unidad-view">${producto.unidad_abreviatura}</span>
                                    <select class="form-control form-control-sm unidad-edit" style="display: none;">
                                        <option value="">Seleccionar unidad</option>
                                    </select>
                                </td>
                                <td class="text-right">
                                    <span class="cantidad-view">${formatNumber2Decimals(cantidad)}</span>
                                    <input type="text" class="form-control form-control-sm cantidad-edit text-right" 
                                        value="${cantidad}" style="display: none;" 
                                        onblur="this.value=formatNumber2Decimals(this.value)">
                                </td>
                                <td class="text-right">
                                    <span class="precio-view">${formatNumber2Decimals(precio)}</span>
                                    <input type="text" class="form-control form-control-sm precio-edit text-right" 
                                        value="${precio}" style="display: none;"
                                        onblur="this.value=formatNumber2Decimals(this.value)">
                                </td>
                                <td class="subtotal text-right subtotal-producto" data-subtotal="${subtotal}">
                                    ${formatNumber2Decimals(subtotal)}
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-warning btn-sm btn-editar-producto" 
                                                data-producto-id="${detalleId}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-success btn-sm btn-guardar-producto" 
                                                data-producto-id="${detalleId}" 
                                                style="display: none;">
                                            <i class="fas fa-save"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-eliminar-producto" 
                                                data-producto-id="${detalleId}">
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
                
                // Actualizar totales usando cálculos exactos
                actualizarTotalesModalExactos(orden, productos);
                
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
    console.log('Intentando cargar unidades...');
    
    // PRIMERO intentar usar globalUnidades (definida en la vista Blade)
    if (typeof globalUnidades !== 'undefined' && globalUnidades !== null && Array.isArray(globalUnidades)) {
        console.log('Usando globalUnidades:', globalUnidades);
        cargarUnidadesDesdeArray(globalUnidades);
    }
    // SEGUNDO intentar usar window.unidadesData (definida en la vista Blade)
    else if (typeof window.unidadesData !== 'undefined' && window.unidadesData !== null && Array.isArray(window.unidadesData)) {
        console.log('Usando window.unidadesData:', window.unidadesData);
        cargarUnidadesDesdeArray(window.unidadesData);
    }
    // Si no hay unidades en las variables globales, intentar cargarlas via AJAX
    else {
        console.log('No hay unidades en variables globales, cargando via AJAX...');
        cargarUnidadesViaAJAX();
    }
}

// Función para cargar unidades desde un array
function cargarUnidadesDesdeArray(unidadesArray) {
    if (!unidadesArray || unidadesArray.length === 0) {
        console.warn('Array de unidades vacío');
        $('.unidad-edit').html('<option value="">No hay unidades disponibles</option>');
        return;
    }
    
    var unidadesHtml = '<option value="">Seleccionar unidad</option>';
    unidadesArray.forEach(function(unidad) {
        var unidadId = unidad.id || unidad.id_unidad;
        var unidadNombre = unidad.abreviatura || unidad.nombre;
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

// Función para cargar unidades via AJAX como fallback
function cargarUnidadesViaAJAX() {
    $.ajax({
        url: window.baseUrl + '/consultar/unidades',
        type: 'GET',
        success: function(response) {
            if (response.success && response.data) {
                var unidadesHtml = '<option value="">Seleccionar unidad</option>';
                response.data.forEach(function(unidad) {
                    var unidadId = unidad.id_unidad || unidad.id;
                    var unidadNombre = unidad.abreviatura || unidad.nombre;
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
            console.error('Error al cargar unidades via AJAX');
            $('.unidad-edit').html('<option value="">Error al cargar unidades</option>');
        }
    });
}

// Función para configurar eventos de edición
function configurarEventosEdicionProductos() {
    // Botón para editar producto
    $(document).on('click', '.btn-editar-producto', function() {
        var productoId = $(this).data('producto-id');
        var $tr = $(this).closest('tr');
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
        calcularSubtotalFilaExacto($tr);
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
    
    // Formatear valores en los inputs
    var cantidad = parseUserInput($tr.find('.cantidad-edit').val());
    var precio = parseUserInput($tr.find('.precio-edit').val());
    
    $tr.find('.cantidad-edit').val(cantidad);
    $tr.find('.precio-edit').val(precio);
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

// Función para calcular subtotal de una fila
function calcularSubtotalFilaExacto($tr) {
    var productoId = $tr.data('producto-id');
    var cantidad = parseUserInput($tr.find('.cantidad-edit').val()) || 0;
    var precio = parseUserInput($tr.find('.precio-edit').val()) || 0;
    
    // Calcular con redondeo
    var subtotal = Math.round(cantidad * precio * 100) / 100;
    
    // Guardar valores
    $tr.find('.subtotal').attr('data-subtotal', subtotal);
    
    if (valoresExactosProductos[productoId]) {
        valoresExactosProductos[productoId].subtotal = subtotal;
    }
    
    // Mostrar formateado
    $tr.find('.subtotal').text(formatNumber2Decimals(subtotal));
    
    // Actualizar totales generales
    actualizarTotalesGeneralesExactos();
}

// Función para calcular subtotal de nuevo producto
function calcularSubtotalNuevoProducto() {
    var $fila = $('#fila-nuevo-producto');
    var cantidad = parseUserInput($fila.find('.cantidad-nuevo').val()) || 0;
    var precio = parseUserInput($fila.find('.precio-nuevo').val()) || 0;
    var subtotal = Math.round(cantidad * precio * 100) / 100;
    
    $fila.find('.subtotal-nuevo').text(formatNumber2Decimals(subtotal));
}

// Función para calcular total general
function calcularTotalGeneralExacto() {
    let total = 0;
    
    // Usar valores exactos almacenados
    const subtotalesExactos = Object.values(valoresExactosProductos);
    if (subtotalesExactos.length > 0) {
        subtotalesExactos.forEach(producto => {
            total += (producto.subtotal || 0);
        });
    } else {
        // Fallback: usar valores del DOM
        const subtotalElements = document.querySelectorAll('.subtotal-producto');
        subtotalElements.forEach(element => {
            const subtotalText = $(element).attr('data-subtotal');
            const subtotal = parseNumberES(subtotalText) || 0;
            total += subtotal;
        });
    }
    
    // Redondear para evitar floating point
    return Math.round(total * 100) / 100;
}

// Función para actualizar totales generales
function actualizarTotalesGeneralesExactos() {
    const totalGeneral = calcularTotalGeneralExacto();
    
    // Obtener información de IVA de la orden
    const ivaTexto = $('#ordenIva').text();
    const ivaAplica = ivaTexto.includes('Sí');
    const ivaDeduccion = ivaTexto.includes('deducción');
    const tasa = parseNumberES($('#ordenTasa').text());
    
    let montoIva = 0;
    let totalConIva = totalGeneral;
    
    // Calcular IVA según corresponda
    if (ivaAplica && !ivaDeduccion) {
        montoIva = calcularIVANormal(totalGeneral);
        totalConIva = calcularTotalConIVANormal(totalGeneral, montoIva);
        $('#ivaOrden').closest('tr').find('td:first').html('<strong>IVA (16%):</strong>');
    } else if (ivaAplica && ivaDeduccion) {
        const calculosDeduccion = calcularIVADeduccion(totalGeneral);
        montoIva = calculosDeduccion.montoIvaNeto;
        totalConIva = calculosDeduccion.totalConDeduccion;
        $('#ivaOrden').closest('tr').find('td:first').html('<strong>IVA (4% - Deducción):</strong>');
    } else {
        $('#ivaOrden').closest('tr').find('td:first').html('<strong>IVA:</strong>');
    }
    
    // Calcular total en bolívares
    const totalBs = Math.round(totalConIva * tasa * 100) / 100;
    
    // Actualizar los totales en el modal
    $('#subtotalOrden').text(formatNumber2Decimals(totalGeneral));
    $('#ivaOrden').text(formatNumber2Decimals(montoIva));
    $('#totalOrden').text(formatNumber2Decimals(totalConIva));
    $('#totalBsOrden').text(formatNumber2Decimals(totalBs));
}

// Función para actualizar totales en el modal
function actualizarTotalesModalExactos(orden, productos) {
    // Calcular total general
    let totalGeneral = 0;
    productos.forEach(function(producto) {
        const subtotal = parseNumberES(producto.subtotal);
        totalGeneral += subtotal;
    });
    
    // Redondear
    totalGeneral = Math.round(totalGeneral * 100) / 100;
    
    const tasa = parseNumberES(orden.tasa_dia);
    
    // Determinar configuración de IVA
    const ivaAplica = orden.iva;
    const ivaDeduccion = orden.iva_deduccion;
    
    let montoIva = 0;
    let totalConIva = totalGeneral;
    
    // Calcular según tipo de IVA
    if (ivaAplica && !ivaDeduccion) {
        montoIva = calcularIVANormal(totalGeneral);
        totalConIva = calcularTotalConIVANormal(totalGeneral, montoIva);
    } else if (!ivaAplica && ivaDeduccion) {
        const calculosDeduccion = calcularIVADeduccion(totalGeneral);
        montoIva = calculosDeduccion.montoIvaNeto;
        totalConIva = calculosDeduccion.totalConDeduccion;
    }
    
    // Calcular total en bolívares
    const totalBs = Math.round(totalConIva * tasa * 100) / 100;
    
    // Actualizar los totales en el modal
    $('#subtotalOrden').text(formatNumber2Decimals(totalGeneral));
    $('#ivaOrden').text(formatNumber2Decimals(montoIva));
    $('#totalOrden').text(formatNumber2Decimals(totalConIva));
    $('#totalBsOrden').text(formatNumber2Decimals(totalBs));
    
    // Actualizar etiqueta de IVA
    let ivaLabel = 'IVA (16%):';
    if (ivaAplica && ivaDeduccion) {
        ivaLabel = 'IVA (4% - Deducción):';
    } else if (!ivaAplica && !ivaDeduccion) {
        ivaLabel = 'IVA:';
    }
    $('#ivaOrden').closest('tr').find('td:first').html('<strong>' + ivaLabel + '</strong>');
}

// Función para guardar cambios de producto
// Función para guardar cambios de producto - MODIFICADA
// Función para guardar cambios de producto
function guardarCambiosProducto(productoId, $tr) {
    var nuevoNombre = $tr.find('.producto-nombre-edit').val().trim();
    var nuevaCantidad = parseUserInput($tr.find('.cantidad-edit').val());
    var nuevoPrecio = parseUserInput($tr.find('.precio-edit').val());
    var nuevaUnidadId = $tr.find('.unidad-edit').val();
    
    console.log('=== ACTUALIZAR PRODUCTO ===');
    console.log('URL: /actualizar-producto-orden');
    console.log('Orden ID:', ordenActualId);
    console.log('Detalle ID:', productoId);
    console.log('Datos:', {
        nombre: nuevoNombre,
        cantidad: nuevaCantidad,
        precio: nuevoPrecio,
        unidad: nuevaUnidadId
    });
    
    // Validaciones
    if (!nuevoNombre || nuevaCantidad <= 0 || nuevoPrecio <= 0 || !nuevaUnidadId) {
        Swal.fire({
            title: 'Error',
            text: 'Todos los campos son requeridos y valores deben ser mayores a 0',
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
                // 🔥 CORRECCIÓN: Usar la ruta correcta
                url: '/actualizar-producto-orden',
                type: 'PUT',
                data: {
                    _token: window.csrfToken,
                    orden_id: ordenActualId,
                    detalle_id: productoId,
                    producto: nuevoNombre,
                    cantidad: nuevaCantidad,
                    precio: nuevoPrecio,
                    id_unidad: nuevaUnidadId
                },
                beforeSend: function() {
                    $tr.find('.btn-guardar-producto').prop('disabled', true);
                },
                success: function(response) {
                    console.log('Respuesta actualizar:', response);
                    
                    if (response.success) {
                        // Actualizar valores de visualización
                        $tr.find('.producto-nombre-view').text(nuevoNombre);
                        $tr.find('.unidad-view').text($tr.find('.unidad-edit option:selected').text());
                        $tr.find('.cantidad-view').text(formatNumber2Decimals(nuevaCantidad));
                        $tr.find('.precio-view').text(formatNumber2Decimals(nuevoPrecio));
                        
                        // Desactivar modo edición
                        desactivarModoEdicion($tr);
                        
                        // Calcular y actualizar subtotal
                        var subtotal = Math.round(nuevaCantidad * nuevoPrecio * 100) / 100;
                        $tr.find('.subtotal')
                            .text(formatNumber2Decimals(subtotal))
                            .attr('data-subtotal', subtotal);
                        
                        // Actualizar valor exacto
                        valoresExactosProductos[productoId] = {
                            cantidad: nuevaCantidad,
                            precio: nuevoPrecio,
                            subtotal: subtotal
                        };
                        
                        // Actualizar totales
                        actualizarTotalesGeneralesExactos();
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
                            text: response.message || 'Error desconocido',
                            icon: 'error'
                        });
                        $tr.find('.btn-guardar-producto').prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', xhr.responseText);
                    Swal.fire({
                        title: 'Error AJAX',
                        text: 'Error al actualizar el producto. Código: ' + xhr.status,
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
    console.log('=== ELIMINAR PRODUCTO DESDE MODAL ===');
    console.log('Detalle ID:', productoId);
    console.log('Orden ID:', ordenActualId);
    console.log('URL: /eliminar-producto-modal');
    
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
                // 🔥 NUEVA RUTA ESPECÍFICA
                url: '/eliminar-producto-modal',
                type: 'DELETE',
                data: {
                    _token: window.csrfToken || '{{ csrf_token() }}',
                    orden_id: ordenActualId,
                    detalle_id: productoId
                },
                beforeSend: function() {
                    console.log('Enviando petición a nueva ruta...');
                },
                success: function(response) {
                    console.log('✅ Respuesta nueva función:', response);
                    
                    if (response.success) {
                        // Eliminar del objeto de valores
                        if (valoresExactosProductos[productoId]) {
                            delete valoresExactosProductos[productoId];
                        }
                        
                        // Eliminar fila del DOM
                        $(`tr[data-producto-id="${productoId}"]`).fadeOut(300, function() {
                            $(this).remove();
                            
                            // Verificar si quedan productos
                            var filasRestantes = $('#productosBody tr[data-producto-id]').length;
                            console.log('Productos restantes:', filasRestantes);
                            
                            if (filasRestantes === 0) {
                                $('#productosBody').html('<tr><td colspan="7" class="text-center">No hay productos registrados</td></tr>');
                            } else {
                                // Renumerar las filas
                                $('#productosBody tr[data-producto-id]').each(function(index) {
                                    $(this).find('td:first').text(index + 1);
                                });
                            }
                            
                            // Actualizar totales
                            actualizarTotalesGeneralesExactos();
                            actualizarOrdenCompleta();
                        });
                        
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'Producto eliminado correctamente',
                            icon: 'success',
                            timer: 1500
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message || 'Error al eliminar',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Error en nueva ruta:', {
                        status: xhr.status,
                        error: error,
                        response: xhr.responseText
                    });
                    
                    var mensaje = 'Error al eliminar el producto. ';
                    
                    if (xhr.status === 404) {
                        mensaje += 'La ruta no existe. ';
                        mensaje += '¿Agregaste la ruta en routes/web.php?';
                    }
                    
                    if (xhr.responseText) {
                        try {
                            var jsonResp = JSON.parse(xhr.responseText);
                            mensaje += jsonResp.message || '';
                        } catch(e) {
                            mensaje += xhr.responseText.substring(0, 100);
                        }
                    }
                    
                    Swal.fire({
                        title: 'Error',
                        text: mensaje,
                        icon: 'error'
                    });
                }
            });
        }
    });
}
// Función para agregar nuevo producto
function agregarNuevoProducto() {
    if ($('#fila-nuevo-producto').length > 0) {
        Swal.fire({
            title: 'Atención',
            text: 'Ya hay un producto en proceso de agregado',
            icon: 'warning'
        });
        return;
    }
    
    var nuevaFilaHtml = `
        <tr id="fila-nuevo-producto">
            <td>Nuevo</td>
            <td>
                <input type="text" class="form-control form-control-sm producto-nombre-nuevo" 
                       placeholder="Nombre del producto" required>
            </td>
            <td>
                <select class="form-control form-control-sm unidad-nuevo" required>
                    <option value="">Seleccionar unidad</option>
                </select>
            </td>
            <td class="text-right">
                <input type="text" class="form-control form-control-sm cantidad-nuevo text-right" 
                       value="1.00" required>
            </td>
            <td class="text-right">
                <input type="text" class="form-control form-control-sm precio-nuevo text-right" 
                       value="0.00" required>
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
    
    // Cargar unidades para el nuevo producto
    cargarUnidadesParaNuevoProducto();
    
    // Configurar eventos
    $('#fila-nuevo-producto .cantidad-nuevo, #fila-nuevo-producto .precio-nuevo').on('input', function() {
        calcularSubtotalNuevoProducto();
    });
    
    $('#fila-nuevo-producto .btn-guardar-nuevo').click(function() {
        guardarNuevoProducto();
    });
    
    $('#fila-nuevo-producto .btn-cancelar-nuevo').click(function() {
        $('#fila-nuevo-producto').remove();
        if ($('#productosBody tr').length === 0) {
            $('#productosBody').html('<tr><td colspan="7" class="text-center">No hay productos registrados</td></tr>');
        }
    });
    
    // Calcular subtotal inicial
    calcularSubtotalNuevoProducto();
}

// Función para cargar unidades para nuevo producto
function cargarUnidadesParaNuevoProducto() {
    console.log('Cargando unidades para nuevo producto...');
    
    // PRIMERO intentar usar globalUnidades
    if (typeof globalUnidades !== 'undefined' && globalUnidades !== null && Array.isArray(globalUnidades) && globalUnidades.length > 0) {
        cargarUnidadesNuevoDesdeArray(globalUnidades);
    }
    // SEGUNDO intentar usar window.unidadesData
    else if (typeof window.unidadesData !== 'undefined' && window.unidadesData !== null && Array.isArray(window.unidadesData) && window.unidadesData.length > 0) {
        cargarUnidadesNuevoDesdeArray(window.unidadesData);
    }
    else {
        console.warn('No hay unidades disponibles para nuevo producto');
        $('#fila-nuevo-producto .unidad-nuevo').html('<option value="">Error: No hay unidades disponibles</option>');
    }
}

// Función para cargar unidades para nuevo producto desde array
function cargarUnidadesNuevoDesdeArray(unidadesArray) {
    var unidadesHtml = '<option value="">Seleccionar unidad</option>';
    unidadesArray.forEach(function(unidad) {
        var unidadId = unidad.id || unidad.id_unidad;
        var unidadNombre = unidad.abreviatura || unidad.nombre;
        unidadesHtml += `<option value="${unidadId}">${unidadNombre}</option>`;
    });
    
    $('#fila-nuevo-producto .unidad-nuevo').html(unidadesHtml);
}

// Función para guardar nuevo producto
function guardarNuevoProducto() {
    var $fila = $('#fila-nuevo-producto');
    var nombre = $fila.find('.producto-nombre-nuevo').val().trim();
    var unidadId = $fila.find('.unidad-nuevo').val();
    var unidadTexto = $fila.find('.unidad-nuevo option:selected').text();
    var cantidad = parseUserInput($fila.find('.cantidad-nuevo').val());
    var precio = parseUserInput($fila.find('.precio-nuevo').val());
    
    console.log('=== DATOS A ENVIAR ===');
    console.log('Orden ID:', ordenActualId);
    console.log('Nombre:', nombre);
    console.log('Cantidad:', cantidad);
    console.log('Precio:', precio);
    console.log('Unidad ID:', unidadId);
    
    // Validaciones
    if (!nombre || !unidadId || cantidad <= 0 || precio <= 0) {
        Swal.fire({
            title: 'Error',
            text: 'Todos los campos son requeridos y valores deben ser mayores a 0',
            icon: 'warning'
        });
        return;
    }
    
    $.ajax({
        url: '/agregar-producto-orden',
        type: 'POST',
        data: {
            _token: window.csrfToken || '{{ csrf_token() }}',
            orden_id: ordenActualId,
            producto: nombre,  // 🔥 CAMBIA 'nombre' por 'producto' (como en actualizarProductoOrden)
            cantidad: cantidad,
            precio: precio,
            id_unidad: unidadId
        },
        beforeSend: function() {
            $fila.find('.btn-guardar-nuevo').prop('disabled', true);
            console.log('Enviando datos...');
        },
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            
            if (response.success) {
                // Calcular subtotal
                var subtotal = Math.round(cantidad * precio * 100) / 100;
                
                // Obtener el ID del nuevo detalle - depende de cómo tu controller lo devuelve
                var nuevoDetalleId = response.detalle_id || 
                                     response.data?.detalle_id || 
                                     response.id ||
                                     Date.now(); // Temporal
                
                console.log('Nuevo detalle ID:', nuevoDetalleId);
                
                // Guardar valor exacto
                valoresExactosProductos[nuevoDetalleId] = {
                    cantidad: cantidad,
                    precio: precio,
                    subtotal: subtotal
                };
                
                // Crear nueva fila
                var nuevaFilaHtml = `
                    <tr data-producto-id="${nuevoDetalleId}" data-subtotal="${subtotal}">
                        <td>${$('#productosBody tr').length}</td>
                        <td>
                            <span class="producto-nombre-view">${nombre}</span>
                            <input type="text" class="form-control form-control-sm producto-nombre-edit" 
                                   value="${nombre}" style="display: none;">
                        </td>
                        <td>
                            <span class="unidad-view">${unidadTexto}</span>
                            <select class="form-control form-control-sm unidad-edit" style="display: none;">
                                <option value="">Seleccionar unidad</option>
                            </select>
                        </td>
                        <td class="text-right">
                            <span class="cantidad-view">${formatNumber2Decimals(cantidad)}</span>
                            <input type="text" class="form-control form-control-sm cantidad-edit text-right" 
                                   value="${cantidad}" style="display: none;">
                        </td>
                        <td class="text-right">
                            <span class="precio-view">${formatNumber2Decimals(precio)}</span>
                            <input type="text" class="form-control form-control-sm precio-edit text-right" 
                                   value="${precio}" style="display: none;">
                        </td>
                        <td class="subtotal text-right subtotal-producto" data-subtotal="${subtotal}">
                            ${formatNumber2Decimals(subtotal)}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-warning btn-sm btn-editar-producto" 
                                        data-producto-id="${nuevoDetalleId}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-success btn-sm btn-guardar-producto" 
                                        data-producto-id="${nuevoDetalleId}" style="display: none;">
                                    <i class="fas fa-save"></i>
                                </button>
                                <button class="btn btn-danger btn-sm btn-eliminar-producto" 
                                        data-producto-id="${nuevoDetalleId}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                
                // Reemplazar fila
                $fila.replaceWith(nuevaFilaHtml);
                
                // Actualizar totales
                actualizarTotalesGeneralesExactos();
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
                    text: response.message || 'Error desconocido',
                    icon: 'error'
                });
                $fila.find('.btn-guardar-nuevo').prop('disabled', false);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error AJAX:', xhr.responseText);
            console.error('Status:', status);
            console.error('Error:', error);
            
            Swal.fire({
                title: 'Error AJAX',
                text: 'Error al agregar el producto: ' + xhr.status,
                icon: 'error'
            });
            $fila.find('.btn-guardar-nuevo').prop('disabled', false);
        }
    });
}

// Función para actualizar la orden completa
function actualizarOrdenCompleta() {
    if (!ordenActualId) return;
    
    $.ajax({
        url: '/ordenes/actualizar-totales/' + ordenActualId,
        type: 'POST',
        data: {
            _token: window.csrfToken || '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success && typeof window.ordersTable !== 'undefined') {
                window.ordersTable.ajax.reload(null, false);
            }
        }
    });
}

// =================================================================
// FUNCIÓN PARA IMPRIMIR ORDEN
// =================================================================
window.imprimirOrden = function() {
    var orderIdFormatted = $('#modalOrdenId').text();
    var orderIdOriginal = orderIdFormatted.replace('CZ', '').replace(/^0+/, '');
    window.open('/orden-compras/plantilla/' + orderIdOriginal, '_blank');
};

// =================================================================
// FUNCIÓN DE FORMATO GLOBAL PARA NÚMEROS DE CONTROL
// =================================================================
function formatoNumeroControl(numero) {
    if (!numero) return 'CZ000000';
    
    var numeroStr = numero.toString();
    numeroStr = numeroStr.replace(/^CZ\s*/i, '');
    numeroStr = numeroStr.replace(/\D/g, '');
    
    if (!numeroStr) numeroStr = '0';
    
    return 'CZ' + numeroStr.padStart(6, '0');
}

// =================================================================
// INICIALIZACIÓN
// =================================================================
$(document).ready(function() {
    if (!window.baseUrl) {
        window.baseUrl = window.location.origin;
    }
    
    if (!window.csrfToken) {
        window.csrfToken = $('meta[name="csrf-token"]').attr('content');
    }
    
   
});