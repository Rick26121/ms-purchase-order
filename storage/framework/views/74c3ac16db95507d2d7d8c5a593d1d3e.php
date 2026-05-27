

<?php $__env->startSection('title', isset($orden) ? 'Editar Orden de Compra' : 'Crear Orden de Compra'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><?php echo e(isset($orden) ? 'Editar Orden de Compra #' . $orden->id : 'Crear Orden de Compra'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?php echo e(isset($orden) ? 'Editar Orden' : 'Nueva Orden de Compra'); ?></h3>
    </div>
    <div class="card-body">
        
        <?php if(isset($orden)): ?>
        <div class="alert alert-info mb-4">
            <h5><i class="fas fa-info-circle"></i> Editando Orden #<?php echo e($orden->id); ?></h5>
            <p><strong>Estado:</strong> 
                <span class="badge badge-<?php echo e($orden->estado == 'COMPLETADA' ? 'success' : ($orden->estado == 'PENDIENTE' ? 'warning' : 'danger')); ?>">
                    <?php echo e($orden->estado); ?>

                </span>
            </p>
            <p><strong>Creada el:</strong> <?php echo e($orden->created_at->format('d/m/Y H:i')); ?></p>
        </div>
        <?php endif; ?>

        <div class="row">
            
           
        </div>

        
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
                           value="<?php echo e(isset($orden) ? $orden->fecha->format('Y-m-d') : date('Y-m-d')); ?>" required>
                </div>
            </div>
            <?php if(isset($orden)): ?>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="estadoSelect">Estado</label>
                    <select id="estadoSelect" name="estado" class="form-control">
                        <option value="PENDIENTE" <?php echo e($orden->estado == 'PENDIENTE' ? 'selected' : ''); ?>>PENDIENTE</option>
                        <option value="PROCESADA" <?php echo e($orden->estado == 'PROCESADA' ? 'selected' : ''); ?>>PROCESADA</option>
                        <option value="COMPLETADA" <?php echo e($orden->estado == 'COMPLETADA' ? 'selected' : ''); ?>>COMPLETADA</option>
                        <option value="CANCELADA" <?php echo e($orden->estado == 'CANCELADA' ? 'selected' : ''); ?>>CANCELADA</option>
                    </select>
                </div>
            </div>
            <?php endif; ?>
        </div>

        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="proveedorInput">Proveedor <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" id="proveedorInput" class="form-control"
                               placeholder="Escriba el nombre del proveedor..."
                               autocomplete="off"
                               value="<?php echo e(isset($orden) ? $orden->proveedor->nombre : ''); ?>">
                        <input type="hidden" id="proveedor_id" name="proveedor_id" 
                               value="<?php echo e(isset($orden) ? $orden->proveedor_id : ''); ?>">
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
                           value="<?php echo e(isset($orden) ? $orden->proveedor->rif : ''); ?>" 
                           placeholder="RIF del proveedor">
                </div>
            </div>
        </div>

        
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" class="form-control" readonly 
                           value="<?php echo e(isset($orden) ? $orden->proveedor->telefono : ''); ?>" 
                           placeholder="Teléfono del proveedor">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="text" id="correo" class="form-control" readonly 
                           value="<?php echo e(isset($orden) ? $orden->proveedor->correo : ''); ?>" 
                           placeholder="Correo del proveedor">
                </div>
            </div>
        </div>

        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="monedaSelect">Moneda <span class="text-danger">*</span></label>
                    <select id="monedaSelect" name="moneda" class="form-control" required>
                        <option value="usd" <?php echo e(isset($orden) && $orden->moneda == 'usd' ? 'selected' : ''); ?>>Dólar (USD)</option>
                        <option value="eur" <?php echo e(isset($orden) && $orden->moneda == 'eur' ? 'selected' : ''); ?>>Euro (EUR)</option>
                        <option value="bs" <?php echo e(isset($orden) && $orden->moneda == 'bs' ? 'selected' : ''); ?>>Bolívares (BS)</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="tasaDia">Tasa del Día <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" id="tasaDia" name="tasa" class="form-control" step="0.0001" min="0" required 
                               value="<?php echo e(isset($orden) ? number_format($orden->tasa, 4, '.', '') : ''); ?>" 
                               placeholder="0.0000">
                        
                        <div class="input-group-append">
                            <button type="button" id="btnAlternarCalculo" class="btn btn-outline-info" 
                                    title="Alternar modo de cálculo">
                                <i class="fas fa-exchange-alt"></i> <span id="modoCalculoTexto">USD → BS</span>
                            </button>
                        </div>
                    </div>
                    <small class="form-text text-muted" id="ayudaCalculo">
                        Precio en dólares se multiplica por la tasa
                    </small>
                </div>
            </div>

            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Opciones de IVA</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="ivaNinguno" name="opcionIva" 
                                           value="ninguno" <?php echo e((!isset($orden) || ($orden->aplicarIva == 0 && $orden->aplicarIvaDeduccion == 0)) ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="ivaNinguno">
                                        Sin IVA
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="ivaNormal" name="opcionIva" 
                                           value="normal" <?php echo e(isset($orden) && $orden->aplicarIva == 1 ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="ivaNormal">
                                        IVA Normal (16%)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" id="ivaDeduccion" name="opcionIva" 
                                           value="deduccion" <?php echo e(isset($orden) && $orden->aplicarIvaDeduccion == 1 ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="ivaDeduccion">
                                        IVA con Deducción (16% - 75%)
                                    </label>
                                    <small class="form-text text-muted">Se aplica 16% y luego 75% de deducción sobre el IVA</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <input type="hidden" id="modoCalculo" name="modo_calculo" value="<?php echo e(isset($orden) && $orden->modo_calculo == 'directo' ? '1' : '0'); ?>">

        
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="observacion">Observaciones / Notas Internas</label>
                    <textarea id="observacion" name="observacion" class="form-control" rows="3" 
                              placeholder="Ingrese cualquier observación, nota interna o comentario sobre esta orden..."
                              maxlength="500"><?php echo e(isset($orden) ? $orden->observacion : ''); ?></textarea>
                    <small class="form-text text-muted">Máximo 500 caracteres</small>
                </div>
            </div>
        </div>

        <hr>

        
        <div id="seccionProductosCompleto" style="<?php echo e(isset($orden) && $orden->detalles->count() == 0 ? 'display: none;' : ''); ?>">
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
                    
                    <?php if(isset($orden) && $orden->detalles->count() > 0): ?>
                        <?php $__currentLoopData = $orden->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr id="fila_existente_<?php echo e($detalle->id); ?>">
                            <td>
                                <input type="hidden" name="detalle_id[]" value="<?php echo e($detalle->id); ?>">
                                <input type="text" name="producto[]" class="form-control producto-input" 
                                       value="<?php echo e($detalle->nombre); ?>" required>
                            </td>
                            <td>
                                <input type="number" name="cantidad[]" class="form-control cantidad-input" 
                                       min="1" step="0.01" value="<?php echo e(number_format($detalle->cantidad, 2, '.', '')); ?>" required>
                            </td>
                            <td>
                                <select name="id_unidad[]" class="form-control unidad-select" required>
                                    <option value="">Seleccione</option>
                                    <?php $__currentLoopData = $unidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($unidad->id_unidad ?? $unidad->id); ?>"
                                            <?php echo e(($detalle->id_unidad == ($unidad->id_unidad ?? $unidad->id)) ? 'selected' : ''); ?>>
                                        <?php echo e($unidad->nombre ?? $unidad->abreviatura); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="precio[]" class="form-control precio-input" 
                                       min="0" step="0.01" value="<?php echo e(number_format($detalle->precio, 2, '.', '')); ?>" required>
                            </td>
                            <td>
                                <input type="text" class="form-control total-input" readonly 
                                       value="<?php echo e(number_format($detalle->cantidad * $detalle->precio, 2, '.', '')); ?>">
                                <?php if($detalle->modo_calculo === 0): ?>
                                <small class="form-text text-muted subtotal-bs">
                                    ≈ <?php echo e(number_format($detalle->cantidad * $detalle->precio * $orden->tasa, 2, '.', '')); ?> Bs
                                </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm btn-eliminar-fila" 
                                        data-detalle-id="<?php echo e($detalle->id); ?>"
                                        data-fila="fila_existente_<?php echo e($detalle->id); ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </tbody>
            </table>

            
            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            
                            <tr class="table-info">
                                <th>Total General (USD):</th>
                                <td class="text-right"><strong><span id="totalGeneralDolares"><?php echo e(isset($orden) ? number_format($orden->total_general, 2) : '0.00'); ?></span></strong></td>
                            </tr>
                            
                            
                            <tr id="filaIvaNormal" style="display: none;">
                                <th>IVA Normal (16%):</th>
                                <td class="text-right"><span id="montoIvaNormal">0.00</span></td>
                            </tr>
                            <tr id="filaIvaDeduccion" style="display: none;">
                                <th>IVA con Deducción (16%):</th>
                                <td class="text-right"><span id="montoIvaDeduccion">0.00</span></td>
                            </tr>
                            <tr id="filaDeduccion" style="display: none;">
                                <th>Deducción (75% del IVA):</th>
                                <td class="text-right text-danger"><span id="montoDeduccion">0.00</span></td>
                            </tr>
                            <tr id="filaTotalConIvaDolares" style="display: none;">
                                <th>Total con IVA (USD):</th>
                                <td class="text-right"><span id="totalConIvaDolares">0.00</span></td>
                            </tr>
                            <tr id="infoModoCalculo">
                                <th><small class="text-muted">Modo:</small></th>
                                <td class="text-right">
                                    <small class="<?php echo e(isset($orden) && $orden->modo_calculo == 'directo' ? 'text-modo-directo' : 'text-modo-conversion'); ?>">
                                        <?php echo e(isset($orden) && $orden->modo_calculo == 'directo' ? 'Directo en BS' : 'Conversión USD → BS'); ?>

                                    </small>
                                </td>
                            </tr>
                            <tr class="table-success">
                                <th><strong>Total en Bs:</strong></th>
                                <td class="text-right"><strong><span id="totalEnBs"><?php echo e(isset($orden) ? number_format($orden->total_bs, 2) : '0.00'); ?></span></strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            
            <div class="row mt-3">
                <div class="col-md-12 text-right">
                    <?php if(isset($orden)): ?>
                    <a href="<?php echo e(route('ordenes.index')); ?>" class="btn btn-secondary mr-2">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <?php endif; ?>
                    <button type="button" id="btnGuardarCompleto" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> <?php echo e(isset($orden) ? 'Actualizar Orden' : 'Guardar Orden Completa'); ?>

                    </button>
                </div>
            </div>
        </div>

        
        <div id="seccionDinamica" style="<?php echo e(isset($orden) && $orden->detalles->count() == 0 ? '' : 'display: none;'); ?>">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle"></i> Modo Dinámico Activado</h5>
                <p>Primero debe crear/actualizar la orden y luego podrá agregar productos uno por uno.</p>
            </div>

            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="button" id="btnCrearOrdenVacia" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-invoice"></i> <?php echo e(isset($orden) ? 'Actualizar Orden' : 'Crear Orden (Sin Productos)'); ?>

                    </button>
                </div>
            </div>

            
            <div id="infoOrdenCreada" class="mt-4" style="<?php echo e(isset($orden) ? '' : 'display: none;'); ?>">
                <?php if(isset($orden)): ?>
                <div class="alert alert-success">
                    <h5><i class="fas fa-check-circle"></i> Editando Orden Existente</h5>
                    <p><strong>N° de Orden:</strong> <span id="numeroOrden"><?php echo e($orden->id); ?></span></p>
                    <p><strong>Estado:</strong> <span class="badge badge-<?php echo e($orden->estado == 'COMPLETADA' ? 'success' : ($orden->estado == 'PENDIENTE' ? 'warning' : 'danger')); ?>"><?php echo e($orden->estado); ?></span></p>
                </div>
                <?php else: ?>
                <div class="alert alert-success">
                    <h5><i class="fas fa-check-circle"></i> Orden Creada Exitosamente</h5>
                    <p><strong>N° de Orden:</strong> <span id="numeroOrden"></span></p>
                    <p><strong>Estado:</strong> <span class="badge badge-warning">PENDIENTE</span></p>
                </div>
                <?php endif; ?>

                
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
                            <?php if(isset($orden) && $orden->detalles->count() > 0): ?>
                                <?php $__currentLoopData = $orden->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr data-producto-id="<?php echo e($detalle->id); ?>" data-detalle-id="<?php echo e($detalle->id); ?>">
                                    <td><?php echo e($detalle->nombre); ?></td>
                                    <td><?php echo e(number_format($detalle->cantidad, 2)); ?></td>
                                    <td><?php echo e($detalle->unidad->nombre ?? 'N/A'); ?></td>
                                    <td><?php echo e(number_format($detalle->precio, 2)); ?></td>
                                    <td><?php echo e(number_format($detalle->cantidad * $detalle->precio, 2)); ?></td>
                                    <td>
                                        <button class="btn btn-warning btn-sm btn-editar-producto mr-1" 
                                                data-id="<?php echo e($detalle->id); ?>"
                                                data-nombre="<?php echo e($detalle->nombre); ?>"
                                                data-cantidad="<?php echo e($detalle->cantidad); ?>"
                                                data-precio="<?php echo e($detalle->precio); ?>"
                                                data-unidad="<?php echo e($detalle->id_unidad); ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm btn-eliminar-producto" 
                                                data-detalle-id="<?php echo e($detalle->id); ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                            <tr id="sinProductos">
                                <td colspan="6" class="text-center text-muted">No hay productos agregados</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <th colspan="4" class="text-right">TOTAL EN DÓLARES:</th>
                                <th id="totalOrdenDinamicaDolares">
                                    <?php echo e(isset($orden) ? number_format($orden->total_general, 2) : '0.00'); ?>

                                </th>
                                <th></th>
                            </tr>
                            <tr class="table-success">
                                <th colspan="4" class="text-right">TOTAL EN BS:</th>
                                <th id="totalOrdenDinamicaBs">
                                    <?php echo e(isset($orden) ? number_format($orden->total_bs, 2) : '0.00'); ?>

                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                
                <div class="row mt-3">
                    <div class="col-md-12 text-right">
                        <button type="button" id="btnVerOrden" class="btn btn-info">
                            <i class="fas fa-eye"></i> Ver Orden Completa
                        </button>
                        <button type="button" id="btnImprimirOrden" class="btn btn-secondary">
                            <i class="fas fa-print"></i> Imprimir
                        </button>
                        <?php if(isset($orden)): ?>
                        <a href="<?php echo e(route('ordenes.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const proveedores = <?php echo json_encode($proveedores, 15, 512) ?>;
    const unidades = <?php echo json_encode($unidades, 15, 512) ?>;
    const ordenExistente = <?php echo json_encode(isset($orden) ? $orden : null, 15, 512) ?>;
    let ordenId = ordenExistente ? ordenExistente.id : null;
    let modoEdicion = ordenExistente ? true : false;
    
    // 🔹 VARIABLE GLOBAL PARA EL MODO DE CÁLCULO
    // 0 = USD → BS (Conversión)
    // 1 = Directo en BS
    let modoCalculo = parseInt($('#modoCalculo').val()) || 0;
    
    // 🔹 INICIALIZACIÓN
    function inicializar() {
        cargarSucursales();
        cargarUnidadesSelect();
        cargarUnidadesModal();
        if (!modoEdicion) cargarTasaDolar();
        setupProveedores();
        configurarModoCalculo();
        setupProductosCompletos();
        setupModoDinamico();
        setupCalculos();
        if (modoEdicion) {
            actualizarCamposProveedor();
            calcularTotales();
        }
    }

    // 🔹 CONFIGURAR MODO DE CÁLCULO
    function configurarModoCalculo() {
        $('#btnAlternarCalculo').click(function() {
            alternarModoCalculo();
        });
        
        actualizarVisualizacionModoCalculo();
    }

    // 🔹 FUNCIÓN PARA ALTERNAR ENTRE MODOS
    function alternarModoCalculo() {
        if (modoCalculo === 0) {
            modoCalculo = 1; // Cambia a directo
        } else {
            modoCalculo = 0; // Cambia a conversión
        }
        
        $('#modoCalculo').val(modoCalculo);
        actualizarVisualizacionModoCalculo();
        calcularTotales();
        
        Swal.fire({
            icon: 'info',
            title: 'Modo cambiado',
            text: modoCalculo === 0 
                ? 'Ahora el precio se multiplica por la tasa (USD → BS)' 
                : 'Ahora el precio es directo en bolívares',
            timer: 1500,
            showConfirmButton: false
        });
    }

    // 🔹 ACTUALIZAR VISUALIZACIÓN DEL MODO
    function actualizarVisualizacionModoCalculo() {
        const $boton = $('#btnAlternarCalculo');
        const $texto = $('#modoCalculoTexto');
        const $ayuda = $('#ayudaCalculo');
        
        if (modoCalculo === 0) {
            $texto.html('<i class="fas fa-dollar-sign"></i> → <i class="fas fa-bs"></i>');
            $ayuda.text('Precio en dólares se multiplica por la tasa');
            $boton.removeClass('btn-modo-activo');
        } else {
            $texto.html('<i class="fas fa-bs"></i> Directo');
            $ayuda.text('Precio ya está en bolívares (no se aplica tasa)');
            $boton.addClass('btn-modo-activo');
        }
        
        $('.precio-input').each(function() {
            const $input = $(this);
            const placeholder = modoCalculo === 0 
                ? 'Precio en dólares' 
                : 'Precio en bolívares';
            $input.attr('placeholder', placeholder);
        });
    }

    // 🔹 CARGAR SUCURSALES
    async function cargarSucursales() {
        try {
            const response = await fetch('<?php echo e(url("/consultar/sucursales")); ?>');
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
    let tasa = 0; // Valor por defecto
    
    try {
        const response = await fetch('http://192.168.101.12:8004/tasas');
        if (!response.ok) throw new Error('API no responde');
        
        const data = await response.json();
        
        // Buscar tasa en diferentes posibles estructuras
        if (data.dolar) tasa = parseFloat(data.dolar);
        else if (data.usd) tasa = parseFloat(data.usd);
        else if (data.tasa) tasa = parseFloat(data.tasa);
        else if (data.valor) tasa = parseFloat(data.valor);
        // Si no encuentra, queda en 0
        
    } catch (error) {
        console.error('Error API tasa:', error);
        // Simplemente se queda en 0
    }
    
    $('#tasaDia').val(tasa.toFixed(4));
    calcularTotales();
}

    // 🔹 CONFIGURAR PROVEEDORES
    function setupProveedores() {
        const proveedorInput = $('#proveedorInput');
        const listaProveedores = $('#listaProveedores');
        const btnBuscar = $('#btnBuscarProveedor');

        btnBuscar.click(function() {
            mostrarListaProveedores();
        });

        proveedorInput.on('input', function() {
            const texto = $(this).val().toLowerCase();
            const filtrados = proveedores.filter(p => 
                p.nombre.toLowerCase().includes(texto) || 
                (p.rif && p.rif.toLowerCase().includes(texto))
            );
            mostrarListaProveedores(filtrados);
        });

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

        $(document).on('click', '.proveedor-item', function() {
            const $this = $(this);
            $('#proveedorInput').val($this.data('nombre'));
            $('#proveedor_id').val($this.data('id'));
            $('#rif').val($this.data('rif')); 
            $('#telefono').val($this.data('telefono'));
            $('#correo').val($this.data('correo'));
            listaProveedores.hide();
        });

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

        if (modoEdicion && ordenExistente.detalles && ordenExistente.detalles.length > 0) {
            $('#modoCompleto').prop('checked', true);
            $('#seccionProductosCompleto').show();
            $('#seccionDinamica').hide();
        }
    }

    // 🔹 PRODUCTOS PARA MODO COMPLETO
    function setupProductosCompletos() {
        let contadorFilas = 0;

        $('#btnAgregarProducto').click(function() {
            agregarFilaProducto();
        });

        if ($('#productosTableBody tr').length === 0) {
            agregarFilaProducto();
        }

        function agregarFilaProducto() {
            contadorFilas++;
            const filaId = `fila_nueva_${contadorFilas}`;
            
            const placeholderPrecio = modoCalculo === 0 
                ? 'Precio en dólares' 
                : 'Precio en bolívares';
            
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
                               min="0" step="0.01" value="0.00" placeholder="${placeholderPrecio}" required>
                    </td>
                    <td>
                        <input type="text" class="form-control total-input" readonly value="0.00">
                        <small class="form-text text-muted subtotal-bs" style="display: none;"></small>
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
            
            $(`#${filaId} .cantidad-input, #${filaId} .precio-input`).on('input', calcularFila);
            $(`#${filaId} .btn-eliminar-fila`).click(function() {
                $(`#${filaId}`).remove();
                calcularTotales();
            });
            
            calcularFila.call($(`#${filaId} .cantidad-input`));
        }

        // Calcular subtotal de fila
        // 🔹 Calcular subtotal de fila - SIN REDONDEO
function calcularFila() {
    const $fila = $(this).closest('tr');
    const cantidad = parseFloat($fila.find('.cantidad-input').val()) || 0;
    const precio = parseFloat($fila.find('.precio-input').val()) || 0;
    
    // Calcular sin redondear
    const subtotal = cantidad * precio;
    
    // Mostrar con 4 decimales (sin redondear)
    $fila.find('.total-input').val(subtotal.toFixed(4));
    
    const $subtotalBs = $fila.find('.subtotal-bs');
    if (modoCalculo === 0) {
        const tasa = parseFloat($('#tasaDia').val()) || 0;
        const subtotalBs = subtotal * tasa;
        
        // Mostrar con 4 decimales (sin redondear)
        $subtotalBs.text(`≈ ${subtotalBs.toFixed(4)} Bs`).show();
    } else {
        $subtotalBs.hide();
    }
    
    calcularTotales();
}

        $('.cantidad-input, .precio-input').on('input', calcularFila);
        
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
                    $(`#${filaId}`).find('input[name="detalle_id[]"]').val('eliminar_' + detalleId);
                    $(`#${filaId}`).hide();
                    calcularTotales();
                }
            });
        });

        $(document).on('click', '.btn-eliminar-fila:not([data-detalle-id])', function() {
            const filaId = $(this).data('fila');
            $(`#${filaId}`).remove();
            calcularTotales();
        });
    }

    // 🔹 CÁLCULOS DE TOTALES
    function setupCalculos() {
        $('#tasaDia, #monedaSelect').on('input change', calcularTotales);
        $('input[name="opcionIva"]').on('change', calcularTotales);
        $(document).on('input', '.cantidad-input, .precio-input', calcularTotales);
        $('#btnAlternarCalculo').on('click', calcularTotales);
    }

   function calcularTotales() {
    // Calcular subtotal de productos visibles - SIN REDONDEO
    let subtotalBolivares = 0;
    $('.total-input').each(function() {
        if ($(this).closest('tr').is(':visible')) {
            subtotalBolivares += parseFloat($(this).val()) || 0;
        }
    });

    // Obtener opción de IVA seleccionada
    const opcionIva = $('input[name="opcionIva"]:checked').val();
    const tasa = parseFloat($('#tasaDia').val()) || 0;
    
    // 🔹 CALCULAR TOTAL GENERAL - SIN REDONDEO
    let totalGeneralDolares = 0;
    let totalConIvaDolares = 0;
    let montoIva = 0;
    let montoDeduccion = 0;
    
    if (modoCalculo === 0) {
        // Modo conversión: Precio en dólares
        totalGeneralDolares = subtotalBolivares;
    } else {
        // Modo directo: Precio en bolívares
        totalGeneralDolares = subtotalBolivares / tasa;
    }

    // 🔹 CALCULAR IVA EN DÓLARES - SIN REDONDEO
    if (opcionIva === 'normal') {
        montoIva = totalGeneralDolares * 0.16;
        totalConIvaDolares = totalGeneralDolares + montoIva;
    } else if (opcionIva === 'deduccion') {
        const ivaNormal = totalGeneralDolares * 0.16;
        montoDeduccion = ivaNormal * 0.75;
        montoIva = ivaNormal - montoDeduccion;
        totalConIvaDolares = totalGeneralDolares + montoIva;
    } else {
        totalConIvaDolares = totalGeneralDolares;
    }

    // 🔹 CALCULAR TOTAL EN BOLÍVARES - SIN REDONDEO
    let totalEnBs = 0;
    if (modoCalculo === 0) {
        totalEnBs = totalConIvaDolares * tasa;
    } else {
        const subtotalConIvaBs = totalConIvaDolares * tasa;
        totalEnBs = subtotalConIvaBs;
    }

    // 🔹 ACTUALIZAR DISPLAY - MOSTRAR 4 DECIMALES
    $('#totalGeneralDolares').text(totalGeneralDolares.toFixed(4));
    $('#totalEnBs').text(totalEnBs.toFixed(4));
    
    // Mostrar/ocultar filas de IVA - CON 4 DECIMALES
    if (opcionIva === 'normal') {
        $('#filaIvaNormal').show();
        $('#montoIvaNormal').text(montoIva.toFixed(4));
        $('#filaTotalConIvaDolares').show();
        $('#totalConIvaDolares').text(totalConIvaDolares.toFixed(4));
        $('#filaIvaDeduccion').hide();
        $('#filaDeduccion').hide();
    } else if (opcionIva === 'deduccion') {
        const ivaNormal = totalGeneralDolares * 0.16;
        $('#filaIvaDeduccion').show();
        $('#filaDeduccion').show();
        $('#filaTotalConIvaDolares').show();
        $('#montoIvaDeduccion').text(ivaNormal.toFixed(4));
        $('#montoDeduccion').text(montoDeduccion.toFixed(4));
        $('#totalConIvaDolares').text(totalConIvaDolares.toFixed(4));
        $('#filaIvaNormal').hide();
    } else {
        $('#filaIvaNormal').hide();
        $('#filaIvaDeduccion').hide();
        $('#filaDeduccion').hide();
        $('#filaTotalConIvaDolares').hide();
    }
}

    // 🔹 GUARDAR/ACTUALIZAR ORDEN COMPLETA
  // 🔹 GUARDAR/ACTUALIZAR ORDEN COMPLETA
$('#btnGuardarCompleto').click(async function() {
    // Primero mostrar la alerta de confirmación
    const result = await Swal.fire({
        title: '¿Está seguro de guardar esta orden?',
        html: `
            <div class="text-left">
                <p><strong>ATENCIÓN:</strong> Una vez guardada la orden:</p>
                <ul class="text-left">
                    <li><i class="fas fa-exclamation-triangle text-warning"></i> <strong>Los datos básicos no podrán ser editados</strong></li>
                    <li><i class="fas fa-lock text-danger"></i> Proveedor, sucursal, moneda y tasa quedarán bloqueados</li>
                    <li><i class="fas fa-edit text-info"></i> Solo podrá modificar productos y cantidades</li>
                    <li><i class="fas fa-check-circle text-success"></i> El estado de la orden podrá ser cambiado</li>
                </ul>
                <p class="mt-2">¿Desea continuar con el guardado?</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, guardar orden',
        cancelButtonText: 'Cancelar',
        width: '600px',
        customClass: {
            popup: 'swal2-popup-custom'
        }
    });

    if (!result.isConfirmed) {
        return; // Si cancela, no hacer nada
    }

    // Si confirma, continuar con el proceso normal de guardado
    const proveedor_id = $('#proveedor_id').val();
    const id_sucursal = $('#sucursalSelect').val();
    const fecha = $('#fecha').val();
    const moneda = $('#monedaSelect').val();
    const tasaNum = parseFloat($('#tasaDia').val()) || 0;
    const opcionIva = $('input[name="opcionIva"]:checked').val();
    const observacion = $('#observacion').val();
    
    let aplicarIva = 0;
    let aplicarIvaDeduccion = 0;
    
    if (opcionIva === 'normal') {
        aplicarIva = 1;
        aplicarIvaDeduccion = 0;
    } else if (opcionIva === 'deduccion') {
        aplicarIva = 0;
        aplicarIvaDeduccion = 1;
    }

    if (!proveedor_id || !id_sucursal) {
        Swal.fire('Atención', 'Debe seleccionar proveedor y sucursal', 'warning');
        return;
    }

    // Validar y recopilar productos
    const productos = [];
    let productosValidos = true;
    let total_general = 0;
    
    $('.producto-input').each(function(index) {
        const $fila = $(this).closest('tr');
        if (!$fila.is(':visible')) return;
        
        const detalle_id = $fila.find('input[name="detalle_id[]"]').val();
        const producto = $(this).val().trim();
        const cantidad = parseFloat($fila.find('.cantidad-input').val());
        const precio = parseFloat($fila.find('.precio-input').val());
        const unidad = $fila.find('.unidad-select').val();

        if (detalle_id.startsWith('eliminar_')) {
            productos.push({
                detalle_id: detalle_id.replace('eliminar_', ''),
                accion: 'eliminar'
            });
        } else if (producto && cantidad > 0 && precio > 0 && unidad) {
            const subtotal = cantidad * precio;
            total_general += subtotal;
            
            const productoData = {
                producto: producto,
                cantidad: cantidad,
                precio: precio,
                subtotal: subtotal,
                id_unidad: parseInt(unidad),
                modo_calculo: modoCalculo,
                no_recalcular: true
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

    // Calcular total en BS
    let total_bs = 0;
    if (modoCalculo === 0) {
        total_bs = total_general * tasaNum;
    } else {
        total_bs = total_general;
    }

    // Calcular total con IVA
    let total_con_iva = total_general;
    if (opcionIva === 'normal') {
        total_con_iva = total_general + (total_general * 0.16);
    } else if (opcionIva === 'deduccion') {
        const ivaNormal = total_general * 0.16;
        const deduccion = ivaNormal * 0.75;
        const ivaNeto = ivaNormal - deduccion;
        total_con_iva = total_general + ivaNeto;
    }

    const datos = {
        orden_id: ordenId,
        proveedor_id: parseInt(proveedor_id),
        id_sucursal: parseInt(id_sucursal),
        fecha: fecha,
        moneda: moneda,
        tasa: tasaNum,
        total_general: total_general,
        total_con_iva: total_con_iva,
        total_bs: total_bs,
        aplicarIva: aplicarIva,
        aplicarIvaDeduccion: aplicarIvaDeduccion,
        observacion: observacion,
        modo_calculo: modoCalculo,
        productos: productos
    };

    if (modoEdicion) {
        datos.estado = $('#estadoSelect').val();
    }

    try {
        Swal.fire({
            title: modoEdicion ? 'Actualizando orden...' : 'Guardando orden...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const url = modoEdicion ? '<?php echo e(url("/actualizar-orden-completa")); ?>' : '<?php echo e(url("/guardar-orden-completa")); ?>';
        const method = modoEdicion ? 'PUT' : 'POST';

        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify(datos)
        });

        const resultado = await response.json();

        if (response.ok && resultado.success) {
            if (!modoEdicion) {
                ordenId = resultado.orden_id;
            }
            
            // Mostrar alerta de éxito con información detallada
            Swal.fire({
                icon: 'success',
                title: '¡Orden Guardada!',
                html: `
                    <div class="text-left">
                        <p><strong>Orden ${modoEdicion ? 'actualizada' : 'guardada'} correctamente</strong></p>
                        <p><strong>N° de Orden:</strong> ${ordenId}</p>
                        <p><strong>Total Base:</strong> ${total_general.toFixed(2)} ${modoCalculo === 0 ? 'USD' : 'BS'}</p>
                        <p><strong>Total con IVA:</strong> ${total_con_iva.toFixed(2)} ${modoCalculo === 0 ? 'USD' : 'BS'}</p>
                        <p><strong>Total en Bs:</strong> ${total_bs.toFixed(2)}</p>
                        <p><strong>Modo:</strong> ${modoCalculo === 0 ? 'Conversión USD → BS' : 'Directo en BS'}</p>
                        <hr>
                        <div class="alert alert-warning mt-2">
                            <i class="fas fa-info-circle"></i> <strong>Importante:</strong> Algunos datos ahora están bloqueados para edición:
                            <ul class="mb-0 mt-1">
                                <li>Proveedor</li>
                                <li>Sucursal</li>
                                <li>Moneda</li>
                                <li>Tasa de cambio</li>
                            </ul>
                        </div>
                    </div>
                `,
                confirmButtonText: 'Aceptar',
                width: '650px'
            }).then(() => {
                if (modoEdicion) {
                    location.reload();
                } else {
                    window.location.href = `<?php echo e(url('/orden-compras/plantilla/')); ?>/${ordenId}`;
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
        const proveedor_id = $('#proveedor_id').val();
        const id_sucursal = $('#sucursalSelect').val();
        const fecha = $('#fecha').val();
        const moneda = $('#monedaSelect').val();
        const tasa = parseFloat($('#tasaDia').val());
        const opcionIva = $('input[name="opcionIva"]:checked').val();
        const observacion = $('#observacion').val();
        
        let aplicarIva = 0;
        let aplicarIvaDeduccion = 0;
        
        if (opcionIva === 'normal') {
            aplicarIva = 1;
            aplicarIvaDeduccion = 0;
        } else if (opcionIva === 'deduccion') {
            aplicarIva = 0;
            aplicarIvaDeduccion = 1;
        }

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
            total_general: 0,
            total_con_iva: 0,
            total_bs: 0,
            aplicarIva: aplicarIva,
            aplicarIvaDeduccion: aplicarIvaDeduccion,
            observacion: observacion,
            modo_calculo: modoCalculo
        };

        if (modoEdicion) {
            datos.estado = $('#estadoSelect').val();
        }

        try {
            Swal.showLoading();
            
            const url = modoEdicion ? '<?php echo e(url("/actualizar-orden")); ?>' : '<?php echo e(url("/crear-orden")); ?>';
            const method = modoEdicion ? 'PUT' : 'POST';

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
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
                           <strong>Modo:</strong> ${modoCalculo === 0 ? 'Conversión USD → BS' : 'Directo en BS'}<br>
                           Ahora puede agregar productos`,
                    confirmButtonText: 'Continuar'
                }).then(() => {
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
            id_unidad: parseInt(unidad),
            modo_calculo: modoCalculo
        };

        try {
            Swal.showLoading();
            
            const response = await fetch('<?php echo e(url("/agregar-producto-orden")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (response.ok && resultado.success) {
                agregarFilaProductoOrden(resultado);
                $('#productoInput').val('');
                $('#cantidadProducto').val('1');
                $('#precioProducto').val('0.00');
                calcularTotalOrdenDinamica();
                Swal.fire('¡Éxito!', 'Producto agregado correctamente', 'success');
            } else {
                Swal.fire('Error', resultado.message || 'Error al agregar producto', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Error de conexión con el servidor', 'error');
        }
    });

    // 🔹 CALCULAR TOTAL DE ORDEN DINÁMICA
   function calcularTotalOrdenDinamica() {
    let subtotalBolivares = 0;
    $('#cuerpoProductosOrden tr:not(#sinProductos)').each(function() {
        const subtotal = parseFloat($(this).find('td:eq(4)').text()) || 0;
        subtotalBolivares += subtotal;
    });
    
    const tasa = parseFloat($('#tasaDia').val()) || 0;
    let totalDolares = 0;
    let totalBolivares = 0;
    
    if (modoCalculo === 0) {
        totalDolares = subtotalBolivares;
        totalBolivares = subtotalBolivares * tasa;
    } else {
        totalDolares = subtotalBolivares / tasa;
        totalBolivares = subtotalBolivares;
    }
    
    // Mostrar con 4 decimales
    $('#totalOrdenDinamicaDolares').text(totalDolares.toFixed(4));
    $('#totalOrdenDinamicaBs').text(totalBolivares.toFixed(4));
}

    // 🔹 AGREGAR FILA DE PRODUCTO A TABLA DINÁMICA
    function agregarFilaProductoOrden(datos) {
        $('#sinProductos').hide();
        
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
            id_unidad: unidad,
            modo_calculo: modoCalculo
        };

        try {
            Swal.showLoading();
            
            const response = await fetch('<?php echo e(url("/actualizar-producto-orden")); ?>', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify(datos)
            });

            const resultado = await response.json();

            if (response.ok && resultado.success) {
                const $fila = $(`tr[data-detalle-id="${detalleId}"]`);
                $fila.find('td:eq(0)').text(nombre);
                $fila.find('td:eq(1)').text(cantidad.toFixed(2));
                $fila.find('td:eq(2)').text($('#editarUnidad option:selected').text());
                $fila.find('td:eq(3)').text(precio.toFixed(2));
                $fila.find('td:eq(4)').text((cantidad * precio).toFixed(2));
                
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
                    
                    const response = await fetch(`<?php echo e(url("/eliminar-producto-orden")); ?>/${detalleId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        }
                    });

                    const resultado = await response.json();

                    if (response.ok && resultado.success) {
                        $fila.remove();
                        
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

    // 🔹 VER ORDEN COMPLETA
    $('#btnVerOrden').click(function() {
        if (ordenId) {
            window.open(`<?php echo e(url('/orden-compras/plantilla/')); ?>/${ordenId}`, '_blank');
        }
    });

    // 🔹 IMPRIMIR ORDEN
    $('#btnImprimirOrden').click(function() {
        if (ordenId) {
            window.open(`<?php echo e(url('/orden-compras/plantilla/')); ?>/${ordenId}/imprimir`, '_blank');
        }
    });

    // Inicializar
    inicializar();
});
</script>

<style>
    /* Estilos para SweetAlert personalizado */
.swal2-popup-custom .swal2-html-container {
    text-align: left !important;
}

.swal2-popup-custom ul {
    margin-left: 20px;
    margin-bottom: 10px;
}

.swal2-popup-custom li {
    margin-bottom: 5px;
}
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

/* Estilo para el botón activo */
.btn-modo-activo {
    background-color: #17a2b8 !important;
    color: white !important;
    border-color: #17a2b8 !important;
}

/* Estilo para indicar modo directo */
.text-modo-directo {
    color: #28a745;
    font-weight: bold;
}

.text-modo-conversion {
    color: #007bff;
    font-weight: bold;
}

/* Estilo para subtotal en BS */
.subtotal-bs {
    font-size: 0.8rem;
    color: #6c757d;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/orden_compra/create_orden.blade.php ENDPATH**/ ?>