@extends('adminlte::page')

@section('title', isset($orden) ? 'Editar Orden de Compra' : 'Crear Orden de Compra')

@section('content_header')
    <h1>{{ isset($orden) ? 'Editar Orden de Compra #' . $orden->id : 'Crear Orden de Compra' }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ isset($orden) ? 'Editar Orden' : 'Nueva Orden de Compra' }}</h3>
    </div>
    <div class="card-body">
        {{-- 🔹 INFORMACIÓN DE ORDEN EXISTENTE --}}
        @if(isset($orden))
        <div class="alert alert-info mb-4">
            <h5><i class="fas fa-info-circle"></i> Editando Orden #{{ $orden->id }}</h5>
            <p><strong>Estado:</strong> 
                <span class="badge badge-{{ $orden->estado == 'COMPLETADA' ? 'success' : ($orden->estado == 'PENDIENTE' ? 'warning' : 'danger') }}">
                    {{ $orden->estado }}
                </span>
            </p>
            <p><strong>Creada el:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>
        </div>
        @endif

        <div class="row">
            {{-- 🔹 MODO DE TRABAJO --}}
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <label>Modo de trabajo:</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="modoTrabajo" id="modoCompleto" value="completo" 
                               {{ !isset($orden) || $orden->detalles->count() > 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="modoCompleto">Guardar todo de una vez</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="modoTrabajo" id="modoDinamico" value="dinamico"
                               {{ isset($orden) && $orden->detalles->count() == 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="modoDinamico">Crear y luego agregar productos</label>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🔹 SECCIÓN INFORMACIÓN BÁSICA --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sucursalSelect">Sucursal <span class="text-danger">*</span></label>
                    <select id="sucursalSelect" name="id_sucursal" class="form-control" required>
                        <option value="">Seleccione una sucursal</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" 
                           value="{{ isset($orden) ? $orden->fecha->format('Y-m-d') : date('Y-m-d') }}" required>
                </div>
            </div>
            @if(isset($orden))
            <div class="col-md-4">
                <div class="form-group">
                    <label for="estadoSelect">Estado</label>
                    <select id="estadoSelect" name="estado" class="form-control">
                        <option value="PENDIENTE" {{ $orden->estado == 'PENDIENTE' ? 'selected' : '' }}>PENDIENTE</option>
                        <option value="PROCESADA" {{ $orden->estado == 'PROCESADA' ? 'selected' : '' }}>PROCESADA</option>
                        <option value="COMPLETADA" {{ $orden->estado == 'COMPLETADA' ? 'selected' : '' }}>COMPLETADA</option>
                        <option value="CANCELADA" {{ $orden->estado == 'CANCELADA' ? 'selected' : '' }}>CANCELADA</option>
                    </select>
                </div>
            </div>
            @endif
        </div>

        {{-- 🔹 FILA 1: Proveedor, RIF --}}
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="proveedorInput">Proveedor <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" id="proveedorInput" class="form-control"
                               placeholder="Escriba el nombre del proveedor..."
                               autocomplete="off"
                               value="{{ isset($orden) ? $orden->proveedor->nombre : '' }}">
                        <input type="hidden" id="proveedor_id" name="proveedor_id" 
                               value="{{ isset($orden) ? $orden->proveedor_id : '' }}">
                        <div class="input-group-append">
                            <button type="button" id="btnBuscarProveedor" class="btn btn-primary">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                    <div id="listaProveedores" class="border mt-1" style="display:none; max-height:200px; overflow-y:auto; position:absolute; z-index:1000; background:white; width:100%;"></div>
                    <small class="form-text text-muted">Escriba y presione Buscar o haga clic en un proveedor de la lista</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="rif">RIF</label>
                    <input type="text" id="rif" class="form-control" readonly 
                           value="{{ isset($orden) ? $orden->proveedor->rif : '' }}" 
                           placeholder="RIF del proveedor">
                </div>
            </div>
        </div>

        {{-- 🔹 FILA 2: Teléfono y Correo --}}
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" class="form-control" readonly 
                           value="{{ isset($orden) ? $orden->proveedor->telefono : '' }}" 
                           placeholder="Teléfono del proveedor">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" id="correo" class="form-control" readonly 
                           value="{{ isset($orden) ? $orden->proveedor->correo : '' }}" 
                           placeholder="Correo del proveedor">
                </div>
            </div>
        </div>

        {{-- 🔹 MONEDA Y TASA --}}
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="monedaSelect">Moneda <span class="text-danger">*</span></label>
                    <select id="monedaSelect" name="moneda" class="form-control" required>
                        <option value="usd" {{ isset($orden) && $orden->moneda == 'usd' ? 'selected' : '' }}>Dólar (USD)</option>
                        <option value="eur" {{ isset($orden) && $orden->moneda == 'eur' ? 'selected' : '' }}>Euro (EUR)</option>
                        <option value="bs" {{ isset($orden) && $orden->moneda == 'bs' ? 'selected' : '' }}>Bolívares (BS)</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="tasaDia">Tasa del Día <span class="text-danger">*</span></label>
                    <input type="number" id="tasaDia" name="tasa" class="form-control" step="0.01" min="0" required 
                           value="{{ isset($orden) ? number_format($orden->tasa, 2, '.', '') : '' }}" 
                           placeholder="0.00">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-check mt-4 pt-3">
                    <input class="form-check-input" type="checkbox" id="ivaCheck" name="aplicarIva"
                           {{ isset($orden) && $orden->aplicarIva ? 'checked' : '' }}>
                    <label class="form-check-label" for="ivaCheck">Aplicar IVA (16%)</label>
                </div>
            </div>
        </div>

        <hr>

        {{-- 🔹 SECCIÓN PRODUCTOS (Para modo completo) --}}
        <div id="seccionProductosCompleto" style="{{ isset($orden) && $orden->detalles->count() == 0 ? 'display: none;' : '' }}">
            <h4>Productos</h4>
            
            <div class="mb-2">
                <button type="button" id="btnAgregarProducto" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar Producto
                </button>
            </div>

            <table class="table table-bordered table-striped" id="productosTable">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Producto <span class="text-danger">*</span></th>
                        <th style="width: 120px;">Cantidad <span class="text-danger">*</span></th>
                        <th style="width: 150px;">Unidad <span class="text-danger">*</span></th>
                        <th style="width: 150px;">Precio Unitario <span class="text-danger">*</span></th>
                        <th style="width: 150px;">Total</th>
                        <th style="width: 80px;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="productosTableBody">
                    {{-- Productos existentes para edición --}}
                    @if(isset($orden) && $orden->detalles->count() > 0)
                        @foreach($orden->detalles as $detalle)
                        <tr id="fila_existente_{{ $detalle->id }}">
                            <td>
                                <input type="hidden" name="detalle_id[]" value="{{ $detalle->id }}">
                                <input type="text" name="producto[]" class="form-control producto-input" 
                                       value="{{ $detalle->nombre }}" required>
                            </td>
                            <td>
                                <input type="number" name="cantidad[]" class="form-control cantidad-input" 
                                       min="1" step="0.01" value="{{ number_format($detalle->cantidad, 2, '.', '') }}" required>
                            </td>
                            <td>
                                <select name="id_unidad[]" class="form-control unidad-select" required>
                                    <option value="">Seleccione</option>
                                    @foreach($unidades as $unidad)
                                    <option value="{{ $unidad->id_unidad ?? $unidad->id }}"
                                            {{ ($detalle->id_unidad == ($unidad->id_unidad ?? $unidad->id)) ? 'selected' : '' }}>
                                        {{ $unidad->nombre ?? $unidad->abreviatura }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="precio[]" class="form-control precio-input" 
                                       min="0" step="0.01" value="{{ number_format($detalle->precio, 2, '.', '') }}" required>
                            </td>
                            <td>
                                <input type="text" class="form-control total-input" readonly 
                                       value="{{ number_format($detalle->cantidad * $detalle->precio, 2, '.', '') }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm btn-eliminar-fila" 
                                        data-detalle-id="{{ $detalle->id }}"
                                        data-fila="fila_existente_{{ $detalle->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            {{-- 🔹 TOTALES --}}
            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Total General:</th>
                                <td class="text-right"><span id="totalGeneral">{{ isset($orden) ? number_format($orden->total_general, 2) : '0.00' }}</span></td>
                            </tr>
                            <tr>
                                <th>IVA (16%):</th>
                                <td class="text-right"><span id="montoIva">{{ isset($orden) ? number_format($orden->monto_iva, 2) : '0.00' }}</span></td>
                            </tr>
                            <tr>
                                <th>Total con IVA:</th>
                                <td class="text-right"><span id="totalConIva">{{ isset($orden) ? number_format($orden->total_con_iva, 2) : '0.00' }}</span></td>
                            </tr>
                            <tr class="table-success">
                                <th><strong>Total en Bs:</strong></th>
                                <td class="text-right"><strong><span id="totalEnBs">{{ isset($orden) ? number_format($orden->total_bs, 2) : '0.00' }}</span></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 🔹 BOTONES PARA MODO COMPLETO --}}
            <div class="row mt-3">
                <div class="col-md-12 text-right">
                    @if(isset($orden))
                    <a href="{{ route('ordenes.index') }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    @endif
                    <button type="button" id="btnGuardarCompleto" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> {{ isset($orden) ? 'Actualizar Orden' : 'Guardar Orden Completa' }}
                    </button>
                </div>
            </div>
        </div>

        {{-- 🔹 SECCIÓN PARA MODO DINÁMICO --}}
        <div id="seccionDinamica" style="{{ isset($orden) && $orden->detalles->count() == 0 ? '' : 'display: none;' }}">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle"></i> Modo Dinámico Activado</h5>
                <p>Primero debe crear/actualizar la orden y luego podrá agregar productos uno por uno.</p>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="button" id="btnCrearOrdenVacia" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-invoice"></i> {{ isset($orden) ? 'Actualizar Orden' : 'Crear Orden (Sin Productos)' }}
                    </button>
                </div>
            </div>

            {{-- 🔹 INFORMACIÓN DE ORDEN CREADA --}}
            <div id="infoOrdenCreada" class="mt-4" style="{{ isset($orden) ? '' : 'display: none;' }}">
                @if(isset($orden))
                <div class="alert alert-success">
                    <h5><i class="fas fa-check-circle"></i> Editando Orden Existente</h5>
                    <p><strong>N° de Orden:</strong> <span id="numeroOrden">{{ $orden->id }}</span></p>
                    <p><strong>Estado:</strong> <span class="badge badge-{{ $orden->estado == 'COMPLETADA' ? 'success' : ($orden->estado == 'PENDIENTE' ? 'warning' : 'danger') }}">{{ $orden->estado }}</span></p>
                </div>
                @else
                <div class="alert alert-success">
                    <h5><i class="fas fa-check-circle"></i> Orden Creada Exitosamente</h5>
                    <p><strong>N° de Orden:</strong> <span id="numeroOrden"></span></p>
                    <p><strong>Estado:</strong> <span class="badge badge-warning">PENDIENTE</span></p>
                </div>
                @endif

                {{-- 🔹 AGREGAR PRODUCTOS A ORDEN EXISTENTE --}}
                <h4>Productos de la Orden</h4>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="productoInput">Producto <span class="text-danger">*</span></label>
                                    <input type="text" id="productoInput" class="form-control" placeholder="Nombre del producto">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cantidadProducto">Cantidad <span class="text-danger">*</span></label>
                                    <input type="number" id="cantidadProducto" class="form-control" min="1" value="1" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="unidadProducto">Unidad <span class="text-danger">*</span></label>
                                    <select id="unidadProducto" class="form-control">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="precioProducto">Precio <span class="text-danger">*</span></label>
                                    <input type="number" id="precioProducto" class="form-control" min="0" step="0.01" value="0.00">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <button type="button" id="btnAgregarProductoOrden" class="btn btn-primary btn-block">
                                        <i class="fas fa-plus"></i> Agregar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 🔹 LISTA DE PRODUCTOS AGREGADOS --}}
                <div class="mt-4">
                    <h5>Productos Agregados</h5>
                    <table class="table table-bordered table-striped" id="tablaProductosOrden">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoProductosOrden">
                            @if(isset($orden) && $orden->detalles->count() > 0)
                                @foreach($orden->detalles as $detalle)
                                <tr data-producto-id="{{ $detalle->id }}" data-detalle-id="{{ $detalle->id }}">
                                    <td>{{ $detalle->nombre }}</td>
                                    <td>{{ number_format($detalle->cantidad, 2) }}</td>
                                    <td>{{ $detalle->unidad->nombre ?? 'N/A' }}</td>
                                    <td>{{ number_format($detalle->precio, 2) }}</td>
                                    <td>{{ number_format($detalle->cantidad * $detalle->precio, 2) }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-editar-producto mr-1" 
                                                data-id="{{ $detalle->id }}"
                                                data-nombre="{{ $detalle->nombre }}"
                                                data-cantidad="{{ $detalle->cantidad }}"
                                                data-precio="{{ $detalle->precio }}"
                                                data-unidad="{{ $detalle->id_unidad }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-eliminar-producto" 
                                                data-detalle-id="{{ $detalle->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr id="sinProductos">
                                <td colspan="6" class="text-center text-muted">No hay productos agregados</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="table-success">
                                <th colspan="4" class="text-right">TOTAL:</th>
                                <th id="totalOrdenDinamica">
                                    {{ isset($orden) ? number_format($orden->detalles->sum(function($detalle) { return $detalle->cantidad * $detalle->precio; }), 2) : '0.00' }}
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- 🔹 BOTONES PARA MODO DINÁMICO --}}
                <div class="row mt-3">
                    <div class="col-md-12 text-right">
                        <button type="button" id="btnVerOrden" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver Orden Completa
                        </button>
                        <button type="button" id="btnImprimirOrden" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        @if(isset($orden))
                        <a href="{{ route('ordenes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 🔹 MODAL PARA EDITAR PRODUCTO --}}
<div class="modal fade" id="modalEditarProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editarDetalleId">
                <div class="form-group">
                    <label for="editarProductoNombre">Producto</label>
                    <input type="text" id="editarProductoNombre" class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="editarCantidad">Cantidad</label>
                            <input type="number" id="editarCantidad" class="form-control" min="1" step="0.01">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="editarPrecio">Precio</label>
                            <input type="number" id="editarPrecio" class="form-control" min="0" step="0.01">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editarUnidad">Unidad</label>
                    <select id="editarUnidad" class="form-control">
                        <option value="">Seleccione</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnActualizarProducto">Actualizar</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const proveedores = @json($proveedores);
    const unidades = @json($unidades);
    const ordenExistente = @json(isset($orden) ? $orden : null);
    let ordenId = ordenExistente ? ordenExistente.id : null;
    let modoEdicion = ordenExistente ? true : false;
    
    // 🔹 INICIALIZACIÓN
    function inicializar() {
        cargarSucursales();
        cargarUnidadesSelect();
        cargarUnidadesModal();
        if (!modoEdicion) cargarTasaDolar();
        setupProveedores();
        setupProductosCompletos();
        setupModoDinamico();
        setupCalculos();
        if (modoEdicion) {
            actualizarCamposProveedor();
            calcularTotales();
        }
    }

    // 🔹 CARGAR SUCURSALES
    async function cargarSucursales() {
        try {
            const response = await fetch('{{ url("/consultar/sucursales") }}');
            const data = await response.json();
            const select = $('#sucursalSelect');
            select.empty().append('<option value="">Seleccione una sucursal</option>');
            
            if (data.success && Array.isArray(data.data)) {
                data.data.forEach(sucursal => {
                    select.append(`<option value="${sucursal.id}" 
                        ${ordenExistente && ordenExistente.id_sucursal == sucursal.id ? 'selected' : ''}>
                        ${sucursal.nombre}
                    </option>`);
                });
            }
        } catch (error) {
            console.error('Error cargando sucursales:', error);
            Swal.fire('Error', 'No se pudieron cargar las sucursales', 'error');
        }
    }

    // 🔹 ACTUALIZAR CAMPOS DEL PROVEEDOR
    function actualizarCamposProveedor() {
        if (ordenExistente && ordenExistente.proveedor) {
            const prov = ordenExistente.proveedor;
            $('#proveedorInput').val(prov.nombre);
            $('#rif').val(prov.rif);
            $('#telefono').val(prov.telefono);
            $('#correo').val(prov.correo);
        }
    }

    // 🔹 CARGAR UNIDADES EN SELECT
    function cargarUnidadesSelect() {
        const selectGeneral = $('#unidadProducto');
        selectGeneral.empty().append('<option value="">Seleccione</option>');
        
        unidades.forEach(unidad => {
            const id = unidad.id_unidad || unidad.id;
            const nombre = unidad.nombre || unidad.abreviatura;
            selectGeneral.append(`<option value="${id}">${nombre}</option>`);
        });
    }

    function cargarUnidadesModal() {
        const selectModal = $('#editarUnidad');
        selectModal.empty().append('<option value="">Seleccione</option>');
        
        unidades.forEach(unidad => {
            const id = unidad.id_unidad || unidad.id;
            const nombre = unidad.nombre || unidad.abreviatura;
            selectModal.append(`<option value="${id}">${nombre}</option>`);
        });
    }

    // 🔹 CARGAR TASA DEL DÓLAR
    async function cargarTasaDolar() {
        try {
            const response = await fetch('https://api.dolarvzla.com/public/exchange-rate');
            const data = await response.json();
            const tasa = data.current?.usd || 36.00;
            $('#tasaDia').val(tasa.toFixed(2));
            calcularTotales();
        } catch (error) {
            console.error('Error cargando tasa:', error);
            $('#tasaDia').val('36.00');
        }
    }

    // 🔹 CONFIGURAR PROVEEDORES
    function setupProveedores() {
        const proveedorInput = $('#proveedorInput');
        const listaProveedores = $('#listaProveedores');
        const btnBuscar = $('#btnBuscarProveedor');

        // Mostrar lista al hacer clic en buscar
        btnBuscar.click(function() {
            mostrarListaProveedores();
        });

        // Filtrar mientras escribe
        proveedorInput.on('input', function() {
            const texto = $(this).val().toLowerCase();
            const filtrados = proveedores.filter(p => 
                p.nombre.toLowerCase().includes(texto) || 
                (p.rif && p.rif.toLowerCase().includes(texto))
            );
            mostrarListaProveedores(filtrados);
        });

        // Mostrar lista de proveedores
        function mostrarListaProveedores(filtrados = proveedores) {
            listaProveedores.empty();
            
            if (filtrados.length === 0) {
                listaProveedores.append('<div class="p-2 text-muted">No se encontraron proveedores</div>');
            } else {
                filtrados.forEach(proveedor => {
                    listaProveedores.append(`
                        <div class="p-2 border-bottom proveedor-item" 
                             data-id="${proveedor.id_proveedor}" 
                             data-rif="${proveedor.rif || ''}"
                             data-telefono="${proveedor.telefono || ''}"
                             data-correo="${proveedor.correo || ''}"
                             data-nombre="${proveedor.nombre}">
                            <strong>${proveedor.nombre}</strong><br>
                            <small>${proveedor.rif || 'Sin RIF'}</small>
                        </div>
                    `);
                });
            }
            listaProveedores.show();
        }

        // Seleccionar proveedor
        $(document).on('click', '.proveedor-item', function() {
            const $this = $(this);
            $('#proveedorInput').val($this.data('nombre'));
            $('#proveedor_id').val($this.data('id'));
            $('#rif').val($this.data('rif')); 
            $('#telefono').val($this.data('telefono'));
            $('#correo').val($this.data('correo'));
            listaProveedores.hide();
        });

        // Ocultar lista al hacer clic fuera
        $(document).click(function(e) {
            if (!$(e.target).closest('#proveedorInput, #listaProveedores, #btnBuscarProveedor').length) {
                listaProveedores.hide();
            }
        });
    }

    // 🔹 MODO DE TRABAJO
    function setupModoDinamico() {
        $('input[name="modoTrabajo"]').change(function() {
            const modo = $(this).val();
            
            if (modo === 'completo') {
                $('#seccionProductosCompleto').show();
                $('#seccionDinamica').hide();
            } else {
                $('#seccionProductosCompleto').hide();
                $('#seccionDinamica').show();
                if (modoEdicion) {
                    $('#infoOrdenCreada').show();
                }
            }
        });

        // Si estamos editando y hay productos, mostrar modo completo
        if (modoEdicion && ordenExistente.detalles && ordenExistente.detalles.length > 0) {
            $('#modoCompleto').prop('checked', true);
            $('#seccionProductosCompleto').show();
            $('#seccionDinamica').hide();
        }
    }

    // 🔹 PRODUCTOS PARA MODO COMPLETO
    function setupProductosCompletos() {
        let contadorFilas = 0;

        // Agregar nueva fila de producto
        $('#btnAgregarProducto').click(function() {
            agregarFilaProducto();
        });

        // Agregar fila vacía si no hay productos
        if ($('#productosTableBody tr').length === 0) {
            agregarFilaProducto();
        }

        function agregarFilaProducto() {
            contadorFilas++;
            const filaId = `fila_nueva_${contadorFilas}`;
            
            const fila = `
                <tr id="${filaId}">
                    <td>
                        <input type="hidden" name="detalle_id[]" value="nuevo">
                        <input type="text" name="producto[]" class="form-control producto-input" 
                               placeholder="Nombre del producto" required>
                    </td>
                    <td>
                        <input type="number" name="cantidad[]" class="form-control cantidad-input" 
                               min="1" step="0.01" value="1" required>
                    </td>
                    <td>
                        <select name="id_unidad[]" class="form-control unidad-select" required>
                            <option value="">Seleccione</option>
                            ${unidades.map(u => `
                                <option value="${u.id_unidad || u.id}">
                                    ${u.nombre || u.abreviatura}
                                </option>
                            `).join('')}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="precio[]" class="form-control precio-input" 
                               min="0" step="0.01" value="0.00" required>
                    </td>
                    <td>
                        <input type="text" class="form-control total-input" readonly value="0.00">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm btn-eliminar-fila" 
                                data-fila="${filaId}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            
            $('#productosTableBody').append(fila);
            
            // Configurar eventos para la nueva fila
            $(`#${filaId} .cantidad-input, #${filaId} .precio-input`).on('input', calcularFila);
            $(`#${filaId} .btn-eliminar-fila`).click(function() {
                $(`#${filaId}`).remove();
                calcularTotales();
            });
            
            calcularFila.call($(`#${filaId} .cantidad-input`));
        }

        // Calcular subtotal de fila
        function calcularFila() {
            const $fila = $(this).closest('tr');
            const cantidad = parseFloat($fila.find('.cantidad-input').val()) || 0;
            const precio = parseFloat($fila.find('.precio-input').val()) || 0;
            const total = cantidad * precio;
            
            $fila.find('.total-input').val(total.toFixed(2));
            calcularTotales();
        }

        // Configurar eventos para filas existentes
        $('.cantidad-input, .precio-input').on('input', calcularFila);
        
        // Eliminar fila con confirmación para detalles existentes
        $(document).on('click', '.btn-eliminar-fila[data-detalle-id]', function() {
            const detalleId = $(this).data('detalle-id');
            const filaId = $(this).data('fila');
            
            Swal.fire({
                title: '¿Eliminar producto?',
                text: "Esta acción eliminará el producto de la orden",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Marcar para eliminación
                    $(`#${filaId}`).find('input[name="detalle_id[]"]').val('eliminar_' + detalleId);
                    $(`#${filaId}`).hide();
                    calcularTotales();
                }
            });
        });

        // Eliminar fila nueva
        $(document).on('click', '.btn-eliminar-fila:not([data-detalle-id])', function() {
            const filaId = $(this).data('fila');
            $(`#${filaId}`).remove();
            calcularTotales();
        });
    }

    // 🔹 CÁLCULOS DE TOTALES
    function setupCalculos() {
        // Recalcular cuando cambian inputs relevantes
        $('#tasaDia, #monedaSelect, #ivaCheck').on('input change', calcularTotales);
        
        // También recalcular cuando cambian productos
        $(document).on('input', '.cantidad-input, .precio-input', calcularTotales);
    }

    function calcularTotales() {
        // Calcular total general de productos visibles
        let totalGeneral = 0;
        $('.total-input').each(function() {
            if ($(this).closest('tr').is(':visible')) {
                totalGeneral += parseFloat($(this).val()) || 0;
            }
        });

        // Calcular IVA
        const aplicarIva = $('#ivaCheck').is(':checked');
        const ivaPorcentaje = aplicarIva ? 0.16 : 0;
        const montoIva = totalGeneral * ivaPorcentaje;
        const totalConIva = totalGeneral + montoIva;

        // Calcular total en Bs
        const tasa = parseFloat($('#tasaDia').val()) || 0;
        const totalBs = totalConIva * tasa;

        // Actualizar display
        $('#totalGeneral').text(totalGeneral.toFixed(2));
        $('#montoIva').text(montoIva.toFixed(2));
        $('#totalConIva').text(totalConIva.toFixed(2));
        $('#totalEnBs').text(totalBs.toFixed(2));
    }

    // 🔹 GUARDAR/ACTUALIZAR ORDEN COMPLETA
    $('#btnGuardarCompleto').click(async function() {
        // Validar datos básicos
        const proveedor_id = $('#proveedor_id').val();
        const id_sucursal = $('#sucursalSelect').val();
        const fecha = $('#fecha').val();
        const moneda = $('#monedaSelect').val();
        const tasa = parseFloat($('#tasaDia').val());
        const aplicarIva = $('#ivaCheck').is(':checked') ? 1 : 0;

        if (!proveedor_id || !id_sucursal) {
            Swal.fire('Atención', 'Debe seleccionar proveedor y sucursal', 'warning');
            return;
        }

        // Validar productos
        const productos = [];
        let productosValidos = true;
        
        $('.producto-input').each(function(index) {
            const $fila = $(this).closest('tr');
            if (!$fila.is(':visible')) return;
            
            const detalle_id = $fila.find('input[name="detalle_id[]"]').val();
            const producto = $(this).val().trim();
            const cantidad = parseFloat($fila.find('.cantidad-input').val());
            const precio = parseFloat($fila.find('.precio-input').val());
            const unidad = $fila.find('.unidad-select').val();

            if (detalle_id.startsWith('eliminar_')) {
                // Producto marcado para eliminación
                productos.push({
                    detalle_id: detalle_id.replace('eliminar_', ''),
                    accion: 'eliminar'
                });
            } else if (producto && cantidad > 0 && precio > 0 && unidad) {
                // Producto válido
                const productoData = {
                    producto: producto,
                    cantidad: cantidad,
                    precio: precio,
                    id_unidad: parseInt(unidad)
                };
                
                if (detalle_id && detalle_id !== 'nuevo') {
                    productoData.detalle_id = detalle_id;
                    productoData.accion = 'actualizar';
                } else {
                    productoData.accion = 'crear';
                }
                
                productos.push(productoData);
            } else if (producto || cantidad > 0 || precio > 0 || unidad) {
                productosValidos = false;
            }
        });

        if (productos.length === 0) {
            Swal.fire('Atención', 'Debe agregar al menos un producto válido', 'warning');
            return;
        }

        if (!productosValidos) {
            Swal.fire('Atención', 'Todos los campos de productos deben estar completos y válidos', 'warning');
            return;
        }

        // Preparar datos
        const datos = {
            orden_id: ordenId,
            proveedor_id: parseInt(proveedor_id),
            id_sucursal: parseInt(id_sucursal),
            fecha: fecha,
            moneda: moneda,
            tasa: tasa,
            aplicarIva: aplicarIva,
            productos: productos
        };

        // Si estamos editando, agregar estado
        if (modoEdicion) {
            datos.estado = $('#estadoSelect').val();
        }

        console.log('Datos a enviar:', datos);

        try {
            // Mostrar loading
            Swal.fire({
                title: modoEdicion ? 'Actualizando orden...' : 'Guardando orden...',
                text: 'Por favor espere',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Determinar URL y método
            const url = modoEdicion ? '{{ url("/actualizar-orden-completa") }}' : '{{ url("/guardar-orden-completa") }}';
            const method = modoEdicion ? 'PUT' : 'POST';

            // Enviar datos
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (response.ok && resultado.success) {
                if (!modoEdicion) {
                    ordenId = resultado.orden_id;
                }
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    html: `${modoEdicion ? 'Orden actualizada' : 'Orden guardada'} correctamente<br>
                           <strong>N° de Orden:</strong> ${ordenId}<br>
                           <strong>Total:</strong> ${resultado.total_bs.toFixed(2)} Bs`,
                    confirmButtonText: 'Aceptar'
                }).then(() => {
                    if (modoEdicion) {
                        // Recargar página para ver cambios
                        location.reload();
                    } else {
                        // Redirigir a vista de orden
                        window.location.href = `{{ url('/orden') }}/${ordenId}`;
                    }
                });
            } else {
                Swal.fire('Error', resultado.message || 'Error al guardar la orden', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión con el servidor', 'error');
        }
    });

    // 🔹 MODO DINÁMICO: CREAR/ACTUALIZAR ORDEN VACÍA
    $('#btnCrearOrdenVacia').click(async function() {
        // Validar datos básicos
        const proveedor_id = $('#proveedor_id').val();
        const id_sucursal = $('#sucursalSelect').val();
        const fecha = $('#fecha').val();
        const moneda = $('#monedaSelect').val();
        const tasa = parseFloat($('#tasaDia').val());
        const aplicarIva = $('#ivaCheck').is(':checked') ? 1 : 0;

        if (!proveedor_id || !id_sucursal) {
            Swal.fire('Atención', 'Debe seleccionar proveedor y sucursal', 'warning');
            return;
        }

        const datos = {
            orden_id: ordenId,
            proveedor_id: parseInt(proveedor_id),
            id_sucursal: parseInt(id_sucursal),
            fecha: fecha,
            moneda: moneda,
            tasa: tasa,
            aplicarIva: aplicarIva
        };

        // Si estamos editando, agregar estado
        if (modoEdicion) {
            datos.estado = $('#estadoSelect').val();
        }

        try {
            Swal.showLoading();
            
            // Determinar URL y método
            const url = modoEdicion ? '{{ url("/actualizar-orden") }}' : '{{ url("/crear-orden") }}';
            const method = modoEdicion ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (response.ok && resultado.success) {
                if (!modoEdicion) {
                    ordenId = resultado.orden_id;
                }
                
                Swal.fire({
                    icon: 'success',
                    title: modoEdicion ? '¡Orden Actualizada!' : '¡Orden Creada!',
                    html: `${modoEdicion ? 'Orden actualizada' : 'Orden creada'} exitosamente<br>
                           <strong>N° de Orden:</strong> ${ordenId}<br>
                           Ahora puede agregar productos`,
                    confirmButtonText: 'Continuar'
                }).then(() => {
                    // Mostrar sección para agregar productos
                    $('#infoOrdenCreada').show();
                    $('#numeroOrden').text(ordenId);
                    modoEdicion = true;
                });
            } else {
                Swal.fire('Error', resultado.message || 'Error al procesar la orden', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión con el servidor', 'error');
        }
    });

    // 🔹 MODO DINÁMICO: AGREGAR PRODUCTO A ORDEN
    $('#btnAgregarProductoOrden').click(async function() {
        if (!ordenId) {
            Swal.fire('Atención', 'Primero debe crear/actualizar una orden', 'warning');
            return;
        }

        const producto = $('#productoInput').val().trim();
        const cantidad = parseFloat($('#cantidadProducto').val());
        const unidad = $('#unidadProducto').val();
        const precio = parseFloat($('#precioProducto').val());

        if (!producto) {
            Swal.fire('Atención', 'Debe ingresar el nombre del producto', 'warning');
            return;
        }

        if (!cantidad || cantidad <= 0) {
            Swal.fire('Atención', 'La cantidad debe ser mayor a 0', 'warning');
            return;
        }

        if (!unidad) {
            Swal.fire('Atención', 'Debe seleccionar una unidad', 'warning');
            return;
        }

        if (!precio || precio < 0) {
            Swal.fire('Atención', 'El precio debe ser válido', 'warning');
            return;
        }

        const datos = {
            orden_id: ordenId,
            producto: producto,
            cantidad: cantidad,
            precio: precio,
            id_unidad: parseInt(unidad)
        };

        try {
            Swal.showLoading();
            
            const response = await fetch('{{ url("/agregar-producto-orden") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (response.ok && resultado.success) {
                // Agregar fila a la tabla
                agregarFilaProductoOrden(resultado);
                
                // Limpiar formulario
                $('#productoInput').val('');
                $('#cantidadProducto').val('1');
                $('#precioProducto').val('0.00');
                
                Swal.fire('¡Éxito!', 'Producto agregado correctamente', 'success');
            } else {
                Swal.fire('Error', resultado.message || 'Error al agregar producto', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión con el servidor', 'error');
        }
    });

    // 🔹 EDITAR PRODUCTO EN MODO DINÁMICO
    $(document).on('click', '.btn-editar-producto', function() {
        const detalleId = $(this).data('id');
        const nombre = $(this).data('nombre');
        const cantidad = $(this).data('cantidad');
        const precio = $(this).data('precio');
        const unidad = $(this).data('unidad');
        
        $('#editarDetalleId').val(detalleId);
        $('#editarProductoNombre').val(nombre);
        $('#editarCantidad').val(cantidad);
        $('#editarPrecio').val(precio);
        $('#editarUnidad').val(unidad);
        
        $('#modalEditarProducto').modal('show');
    });

    // 🔹 ACTUALIZAR PRODUCTO
    $('#btnActualizarProducto').click(async function() {
        const detalleId = $('#editarDetalleId').val();
        const nombre = $('#editarProductoNombre').val().trim();
        const cantidad = parseFloat($('#editarCantidad').val());
        const precio = parseFloat($('#editarPrecio').val());
        const unidad = $('#editarUnidad').val();

        if (!nombre || !cantidad || !precio || !unidad) {
            Swal.fire('Atención', 'Todos los campos son requeridos', 'warning');
            return;
        }

        const datos = {
            detalle_id: detalleId,
            producto: nombre,
            cantidad: cantidad,
            precio: precio,
            id_unidad: unidad
        };

        try {
            Swal.showLoading();
            
            const response = await fetch('{{ url("/actualizar-producto-orden") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (response.ok && resultado.success) {
                // Actualizar fila en la tabla
                const $fila = $(`tr[data-detalle-id="${detalleId}"]`);
                $fila.find('td:eq(0)').text(nombre);
                $fila.find('td:eq(1)').text(cantidad.toFixed(2));
                $fila.find('td:eq(2)').text($('#editarUnidad option:selected').text());
                $fila.find('td:eq(3)').text(precio.toFixed(2));
                $fila.find('td:eq(4)').text((cantidad * precio).toFixed(2));
                
                // Actualizar botones de edición
                $fila.find('.btn-editar-producto')
                    .data('nombre', nombre)
                    .data('cantidad', cantidad)
                    .data('precio', precio)
                    .data('unidad', unidad);
                
                $('#modalEditarProducto').modal('hide');
                calcularTotalOrdenDinamica();
                Swal.fire('¡Éxito!', 'Producto actualizado correctamente', 'success');
            } else {
                Swal.fire('Error', resultado.message || 'Error al actualizar producto', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión con el servidor', 'error');
        }
    });

    // 🔹 AGREGAR FILA DE PRODUCTO A TABLA DINÁMICA
    function agregarFilaProductoOrden(datos) {
        // Ocultar mensaje de "sin productos"
        $('#sinProductos').hide();
        
        // Obtener nombre de unidad
        const unidadNombre = unidades.find(u => 
            (u.id_unidad || u.id) == datos.detalle?.id_unidad
        )?.nombre || 'N/A';
        
        const subtotal = datos.detalle?.cantidad * datos.detalle?.precio || 0;
        
        const fila = `
            <tr data-producto-id="${datos.producto_id}" data-detalle-id="${datos.detalle_id}">
                <td>${datos.detalle?.nombre || datos.producto}</td>
                <td>${datos.detalle?.cantidad || 1}</td>
                <td>${unidadNombre}</td>
                <td>${parseFloat(datos.detalle?.precio || 0).toFixed(2)}</td>
                <td>${subtotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-warning btn-sm btn-editar-producto mr-1"
                            data-id="${datos.detalle_id}"
                            data-nombre="${datos.detalle?.nombre || datos.producto}"
                            data-cantidad="${datos.detalle?.cantidad || 1}"
                            data-precio="${datos.detalle?.precio || 0}"
                            data-unidad="${datos.detalle?.id_unidad}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btn-eliminar-producto" 
                            data-detalle-id="${datos.detalle_id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        
        $('#cuerpoProductosOrden').append(fila);
        calcularTotalOrdenDinamica();
    }

    // 🔹 ELIMINAR PRODUCTO DE ORDEN DINÁMICA
    $(document).on('click', '.btn-eliminar-producto', function() {
        const detalleId = $(this).data('detalle-id');
        const $fila = $(this).closest('tr');
        
        Swal.fire({
            title: '¿Eliminar producto?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(async (result) => {
            if (result.isConfirmed) {
                try {
                    Swal.showLoading();
                    
                    const response = await fetch(`{{ url("/eliminar-producto-orden") }}/${detalleId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const resultado = await response.json();

                    if (response.ok && resultado.success) {
                        $fila.remove();
                        
                        // Mostrar mensaje si no hay productos
                        if ($('#cuerpoProductosOrden tr').length === 1) {
                            $('#sinProductos').show();
                        }
                        
                        calcularTotalOrdenDinamica();
                        Swal.fire('¡Éxito!', 'Producto eliminado correctamente', 'success');
                    } else {
                        Swal.fire('Error', resultado.message || 'Error al eliminar producto', 'error');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Error de conexión con el servidor', 'error');
                }
            }
        });
    });

    // 🔹 CALCULAR TOTAL DE ORDEN DINÁMICA
    function calcularTotalOrdenDinamica() {
        let total = 0;
        $('#cuerpoProductosOrden tr:not(#sinProductos)').each(function() {
            const subtotal = parseFloat($(this).find('td:eq(4)').text()) || 0;
            total += subtotal;
        });
        
        $('#totalOrdenDinamica').text(total.toFixed(2));
    }

    // 🔹 VER ORDEN COMPLETA
    $('#btnVerOrden').click(function() {
        if (ordenId) {
            window.open(`{{ url('/orden') }}/${ordenId}`, '_blank');
        }
    });

    // 🔹 IMPRIMIR ORDEN
    $('#btnImprimirOrden').click(function() {
        if (ordenId) {
            window.open(`{{ url('/orden') }}/${ordenId}/imprimir`, '_blank');
        }
    });

    // Inicializar
    inicializar();
});
</script>

<style>
.proveedor-item {
    cursor: pointer;
    padding: 8px;
    border-bottom: 1px solid #eee;
}
.proveedor-item:hover {
    background-color: #f8f9fa;
}
.proveedor-item small {
    color: #6c757d;
}
</style>
@stop