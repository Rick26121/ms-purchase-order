<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Orden #{{ $data['orden']['id'] }}</title>
    
    <!-- Estilos CSS -->
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .card { border: 1px solid #ddd; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .card-title { background-color: #f8f9fa; padding: 10px; margin: -15px -15px 15px -15px; border-bottom: 1px solid #ddd; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; }
        .totales { background-color: #e9ecef; padding: 15px; border-radius: 5px; }
        .campo-form { margin-bottom: 15px; }
        .campo-form label { display: block; margin-bottom: 5px; font-weight: bold; }
        .campo-form input, .campo-form select, .campo-form textarea { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
        }
        .btn { 
            padding: 10px 20px; 
            background-color: #007bff; 
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
        }
        .btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Editar Orden de Compra #{{ $data['orden']['id'] }}</h1>
    
    <!-- Formulario de edición -->
    <form id="formEditarOrden" method="POST" action="{{ route('orden.actualizar', $data['orden']['id']) }}">
        @csrf
        @method('PUT')
        
        <!-- Información General -->
        <div class="card">
            <div class="card-title">
                <h3>Información General</h3>
            </div>
            
            <div class="campo-form">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" value="{{ date('Y-m-d', strtotime($data['orden']['created_at'])) }}" required>
            </div>
            
            <div class="campo-form">
                <label for="observacion">Observación:</label>
                <textarea id="observacion" name="observacion" rows="3">{{ $data['orden']['observacion'] }}</textarea>
            </div>
            
            <div class="campo-form">
                <label for="moneda">Moneda:</label>
                <select id="moneda" name="moneda" required>
                    <option value="USD" {{ $data['orden']['moneda'] == 'USD' ? 'selected' : '' }}>USD</option>
                    <option value="BS" {{ $data['orden']['moneda'] == 'BS' ? 'selected' : '' }}>Bolívares</option>
                </select>
            </div>
            
            <div class="campo-form">
                <label for="tasa_dia">Tasa del Día:</label>
                <input type="number" id="tasa_dia" name="tasa_dia" step="0.0001" value="{{ $data['orden']['tasa_dia'] }}" required>
            </div>
        </div>
        
        <!-- Productos -->
        <div class="card">
            <div class="card-title">
                <h3>Productos</h3>
            </div>
            
            <div id="productos-container">
                @foreach($data['productos'] as $index => $producto)
                <div class="producto-item" data-index="{{ $index }}">
                    <h4>Producto {{ $index + 1 }}</h4>
                    
                    <div class="campo-form">
                        <label for="producto_{{ $index }}">Producto:</label>
                        <select name="productos[{{ $index }}][producto_id]" class="select-producto" required>
                            <!-- Aquí deberías cargar opciones de productos desde tu base de datos -->
                            <option value="{{ $producto['producto_id'] }}" selected>
                                {{ $producto['producto_nombre'] }}
                            </option>
                        </select>
                    </div>
                    
                    <div class="campo-form">
                        <label for="cantidad_{{ $index }}">Cantidad:</label>
                        <input type="number" name="productos[{{ $index }}][cantidad]" 
                               class="input-cantidad" step="0.001" 
                               value="{{ $producto['cantidad'] }}" required>
                    </div>
                    
                    <div class="campo-form">
                        <label for="precio_{{ $index }}">Precio:</label>
                        <input type="number" name="productos[{{ $index }}][precio]" 
                               class="input-precio" step="0.0001" 
                               value="{{ $producto['precio'] }}" required>
                    </div>
                    
                    <div class="campo-form">
                        <label for="unidad_{{ $index }}">Unidad:</label>
                        <select name="productos[{{ $index }}][unidad_id]" required>
                            <option value="{{ $producto['unidad_id'] }}" selected>
                                {{ $producto['unidad_abreviatura'] }} ({{ $producto['unidad_nombre'] }})
                            </option>
                        </select>
                    </div>
                    
                    <div class="campo-form">
                        <label>Subtotal:</label>
                        <span class="subtotal-producto">{{ number_format($producto['subtotal'], 4, ',', '.') }}</span>
                        <input type="hidden" name="productos[{{ $index }}][detalle_id]" value="{{ $producto['detalle_id'] }}">
                    </div>
                    
                    <hr>
                </div>
                @endforeach
            </div>
            
            <button type="button" id="btn-agregar-producto" class="btn">+ Agregar Producto</button>
        </div>
        
        <!-- Opciones de IVA -->
        <div class="card">
            <div class="card-title">
                <h3>Configuración de IVA</h3>
            </div>
            
            <div class="campo-form">
                <label>
                    <input type="radio" name="iva_option" value="sin_iva" 
                           {{ !$data['orden']['iva'] && !$data['orden']['iva_deduccion'] ? 'checked' : '' }}>
                    Sin IVA
                </label>
            </div>
            
            <div class="campo-form">
                <label>
                    <input type="radio" name="iva_option" value="iva_normal" 
                           {{ $data['orden']['iva'] && !$data['orden']['iva_deduccion'] ? 'checked' : '' }}>
                    IVA Normal (16%)
                </label>
            </div>
            
            <div class="campo-form">
                <label>
                    <input type="radio" name="iva_option" value="iva_deduccion" 
                           {{ !$data['orden']['iva'] && $data['orden']['iva_deduccion'] ? 'checked' : '' }}>
                    IVA con Deducción (4%)
                </label>
            </div>
        </div>
        
        <!-- Resumen -->
        <div class="card totales">
            <div class="card-title">
                <h3>Resumen</h3>
            </div>
            
            <table>
                <tr>
                    <td>Subtotal Productos:</td>
                    <td id="subtotal-productos">{{ $data['calculos']['subtotalProductos_formateado'] }}</td>
                </tr>
                <tr>
                    <td>Subtotal:</td>
                    <td id="subtotal">{{ $data['calculos']['subtotal_formateado'] }}</td>
                </tr>
                <tr>
                    <td id="iva-label">IVA ({{ $data['calculos']['iva_porcentaje'] }}%):</td>
                    <td id="iva-monto">{{ $data['calculos']['iva_formateado'] }}</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td>Total USD:</td>
                    <td id="total-usd">{{ $data['calculos']['totalUSD_formateado'] }}</td>
                </tr>
                <tr>
                    <td>Tasa del día:</td>
                    <td id="tasa-display">{{ $data['calculos']['tasa_formateada'] }}</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td>Total BS:</td>
                    <td id="total-bs">{{ $data['calculos']['totalBS_formateado'] }}</td>
                </tr>
                <tr>
                    <td>Total General:</td>
                    <td id="total-general">{{ $data['calculos']['totalGeneral_formateado'] }}</td>
                </tr>
            </table>
        </div>
        
        <!-- Botones de acción -->
        <div class="acciones">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="{{ route('ruta.de.lista.ordenes') }}" class="btn">Cancelar</a>
        </div>
    </form>

    <!-- Scripts -->
    <script>
        // Datos iniciales
        const ordenData = @json($data);
        
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Datos de la orden:', ordenData);
            
            // Configurar eventos
            configurarEventos();
            
            function configurarEventos() {
                // Calcular cuando cambian cantidad o precio
                document.querySelectorAll('.input-cantidad, .input-precio').forEach(input => {
                    input.addEventListener('input', calcularSubtotales);
                });
                
                // Calcular cuando cambia la tasa
                document.getElementById('tasa_dia').addEventListener('input', function() {
                    document.getElementById('tasa-display').textContent = 
                        parseFloat(this.value).toLocaleString('es-VE', {
                            minimumFractionDigits: 4,
                            maximumFractionDigits: 4
                        });
                    calcularTotales();
                });
                
                // Calcular cuando cambian las opciones de IVA
                document.querySelectorAll('input[name="iva_option"]').forEach(radio => {
                    radio.addEventListener('change', calcularTotales);
                });
                
                // Agregar nuevo producto
                document.getElementById('btn-agregar-producto').addEventListener('click', function() {
                    agregarNuevoProducto();
                });
            }
            
            function calcularSubtotales() {
                // Calcular subtotal por producto
                document.querySelectorAll('.producto-item').forEach(item => {
                    const cantidad = parseFloat(item.querySelector('.input-cantidad').value) || 0;
                    const precio = parseFloat(item.querySelector('.input-precio').value) || 0;
                    const subtotal = cantidad * precio;
                    
                    item.querySelector('.subtotal-producto').textContent = 
                        subtotal.toLocaleString('es-VE', {
                            minimumFractionDigits: 4,
                            maximumFractionDigits: 4
                        });
                });
                
                calcularTotales();
            }
            
            function calcularTotales() {
                // Calcular subtotal de productos
                let subtotalProductos = 0;
                document.querySelectorAll('.producto-item').forEach(item => {
                    const cantidad = parseFloat(item.querySelector('.input-cantidad').value) || 0;
                    const precio = parseFloat(item.querySelector('.input-precio').value) || 0;
                    subtotalProductos += cantidad * precio;
                });
                
                // Actualizar subtotal productos
                document.getElementById('subtotal-productos').textContent = 
                    subtotalProductos.toLocaleString('es-VE', {
                        minimumFractionDigits: 4,
                        maximumFractionDigits: 4
                    });
                
                // Calcular IVA según opción seleccionada
                const ivaOption = document.querySelector('input[name="iva_option"]:checked').value;
                let porcentajeIVA = 0;
                
                if (ivaOption === 'iva_normal') {
                    porcentajeIVA = 16;
                } else if (ivaOption === 'iva_deduccion') {
                    porcentajeIVA = 4;
                }
                
                const montoIVA = subtotalProductos * (porcentajeIVA / 100);
                const totalUSD = subtotalProductos + montoIVA;
                
                // Actualizar etiqueta de IVA
                document.getElementById('iva-label').textContent = `IVA (${porcentajeIVA}%):`;
                
                // Actualizar montos
                document.getElementById('iva-monto').textContent = 
                    montoIVA.toLocaleString('es-VE', {
                        minimumFractionDigits: 4,
                        maximumFractionDigits: 4
                    });
                
                document.getElementById('subtotal').textContent = 
                    subtotalProductos.toLocaleString('es-VE', {
                        minimumFractionDigits: 4,
                        maximumFractionDigits: 4
                    });
                
                document.getElementById('total-usd').textContent = 
                    totalUSD.toLocaleString('es-VE', {
                        minimumFractionDigits: 4,
                        maximumFractionDigits: 4
                    });
                
                // Calcular total en BS
                const tasaDia = parseFloat(document.getElementById('tasa_dia').value) || 0;
                const totalBS = totalUSD * tasaDia;
                
                document.getElementById('total-bs').textContent = 
                    totalBS.toLocaleString('es-VE', {
                        minimumFractionDigits: 4,
                        maximumFractionDigits: 4
                    });
                
                document.getElementById('total-general').textContent = 
                    totalUSD.toLocaleString('es-VE', {
                        minimumFractionDigits: 4,
                        maximumFractionDigits: 4
                    });
            }
            
            function agregarNuevoProducto() {
                const container = document.getElementById('productos-container');
                const index = container.children.length;
                
                const nuevoProductoHTML = `
                    <div class="producto-item" data-index="${index}">
                        <h4>Producto ${index + 1}</h4>
                        
                        <div class="campo-form">
                            <label for="producto_${index}">Producto:</label>
                            <select name="productos[${index}][producto_id]" class="select-producto" required>
                                <option value="">Seleccionar producto...</option>
                                <!-- Las opciones se cargarían dinámicamente -->
                            </select>
                        </div>
                        
                        <div class="campo-form">
                            <label for="cantidad_${index}">Cantidad:</label>
                            <input type="number" name="productos[${index}][cantidad]" 
                                   class="input-cantidad" step="0.001" value="0" required>
                        </div>
                        
                        <div class="campo-form">
                            <label for="precio_${index}">Precio:</label>
                            <input type="number" name="productos[${index}][precio]" 
                                   class="input-precio" step="0.0001" value="0" required>
                        </div>
                        
                        <div class="campo-form">
                            <label for="unidad_${index}">Unidad:</label>
                            <select name="productos[${index}][unidad_id]" required>
                                <option value="">Seleccionar unidad...</option>
                            </select>
                        </div>
                        
                        <div class="campo-form">
                            <label>Subtotal:</label>
                            <span class="subtotal-producto">0,0000</span>
                            <input type="hidden" name="productos[${index}][detalle_id]" value="0">
                        </div>
                        
                        <button type="button" class="btn-eliminar-producto" onclick="eliminarProducto(this)">Eliminar</button>
                        <hr>
                    </div>
                `;
                
                container.insertAdjacentHTML('beforeend', nuevoProductoHTML);
                
                // Reconfigurar eventos para el nuevo producto
                const nuevoItem = container.lastElementChild;
                nuevoItem.querySelector('.input-cantidad').addEventListener('input', calcularSubtotales);
                nuevoItem.querySelector('.input-precio').addEventListener('input', calcularSubtotales);
            }
            
            // Función para eliminar producto
            window.eliminarProducto = function(button) {
                if (confirm('¿Está seguro de eliminar este producto?')) {
                    button.closest('.producto-item').remove();
                    calcularTotales();
                }
            };
        });
    </script>
</body>
</html>