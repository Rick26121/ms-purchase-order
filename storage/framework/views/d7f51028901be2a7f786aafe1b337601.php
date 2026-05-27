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
                                            <p><strong>Responsable:</strong> <span id="ordenResponsable"></span></p>
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
                                    <!-- 🔹 SECCIÓN DE OBSERVACIÓN AGREGADA -->
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="alert alert-secondary" role="alert">
                                                <h6 class="alert-heading mb-2"><i class="fas fa-sticky-note"></i> Observación</h6>
                                                <p class="mb-0" id="ordenObservacion">Sin observaciones</p>
                                            </div>
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
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productosBody">
                                                <!-- Los productos se cargarán aquí -->
                                            </tbody>
                                            <tfoot class="bg-light">
                                                <tr>
                                                    <td colspan="6" class="text-right"><strong>Subtotal:</strong></td>
                                                    <td id="subtotalOrden" class="text-right">0.00</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="text-right"><strong>IVA (16%):</strong></td>
                                                    <td id="ivaOrden" class="text-right">0.00</td>
                                                </tr>
                                                <tr class="bg-success text-white">
                                                    <td colspan="6" class="text-right"><strong>Total General:</strong></td>
                                                    <td id="totalOrden" class="text-right">0.00</td>
                                                </tr>
                                                <tr class="bg-primary text-white">
                                                    <td colspan="6" class="text-right"><strong>Total en Bs:</strong></td>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-outline-primary btn-sm" id="btnImprimirOrden" onclick="imprimirOrden()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
                <button type="button" class="btn btn-success btn-sm" id="btnAgregarProductoModal">
                    <i class="fas fa-plus"></i> Agregar Producto
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/resources/views/Modal/vista.blade.php ENDPATH**/ ?>