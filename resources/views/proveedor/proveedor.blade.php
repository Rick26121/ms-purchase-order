@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1>Gestión de Proveedores</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title">Lista de Proveedores</h3>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <div class="input-group" style="width: 300px;">
                        <input type="text" class="form-control form-control-sm" 
                               id="search-input" 
                               placeholder="Buscar por nombre, RIF o correo...">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btn-buscar">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btn-limpiar-busqueda">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm ml-2" data-toggle="modal" data-target="#modalCrearProveedor">
                        <i class="fas fa-plus"></i> Nuevo
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- Contenedor para alertas --}}
        <div id="alert-container"></div>

        {{-- Tabla de proveedores --}}
        <div id="tabla-proveedores-container">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>RIF</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-proveedores">
                        @include('proveedor.partials.tabla')
                    </tbody>
                </table>
            </div>

            <div class="mt-3" id="pagination-container">
                {{ $proveedor->links() }}
            </div>
        </div>

        {{-- Loading spinner --}}
        <div id="loading-spinner" class="text-center" style="display: none;">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
            <p class="mt-2">Cargando proveedores...</p>
        </div>
    </div>
</div>

{{-- Modal para crear proveedor --}}
<div class="modal fade" id="modalCrearProveedor" tabindex="-1" role="dialog" aria-labelledby="modalCrearProveedorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title" id="modalCrearProveedorLabel">
                    <i class="fas fa-user-plus"></i> Crear Nuevo Proveedor
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formCrearProveedor" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre" class="font-weight-bold">
                            <i class="fas fa-building"></i> Nombre / Razón Social *
                        </label>
                        <input type="text" class="form-control" 
                               id="nombre" name="nombre" required 
                               placeholder="Ej: Empresa XYZ C.A.">
                        <div class="invalid-feedback" id="error-nombre"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo_rif" class="font-weight-bold">
                                    <i class="fas fa-id-card"></i> Tipo *
                                </label>
                                <select class="form-control" 
                                        id="tipo_rif" name="tipo_rif" required>
                                    <option value="">Seleccionar</option>
                                    <option value="J">J</option>
                                    <option value="V">V</option>
                                    <option value="G">G</option>
                                    <option value="E">E</option>
                                </select>
                                <div class="invalid-feedback" id="error-tipo_rif"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="numero_rif" class="font-weight-bold">
                                    <i class="fas fa-hashtag"></i> Número de Documento *
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-light font-weight-bold" 
                                              id="prefijo_rif" style="min-width: 30px;">-</span>
                                    </div>
                                    <input type="text" class="form-control" 
                                           id="numero_rif" name="numero_rif" 
                                           required placeholder="Ej: 12345678 ó 12345678-0" maxlength="20">
                                </div>
                                <small class="form-text text-muted">Ej: 29968295 ó 29968295-0</small>
                                <div class="invalid-feedback" id="error-numero_rif"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="correo">
                                    <i class="fas fa-envelope"></i> Correo Electrónico
                                </label>
                                <input type="email" class="form-control" 
                                       id="correo" name="correo" 
                                       placeholder="ejemplo@empresa.com">
                                <div class="invalid-feedback" id="error-correo"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono" class="font-weight-bold">
                                    <i class="fas fa-phone"></i> Teléfono *
                                </label>
                                <input type="text" class="form-control" 
                                       id="telefono" name="telefono" 
                                       required placeholder="Ej: 04141234567" maxlength="15">
                                <small class="form-text text-muted">Incluir código de área</small>
                                <div class="invalid-feedback" id="error-telefono"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion">
                            <i class="fas fa-map-marker-alt"></i> Dirección
                        </label>
                        <textarea class="form-control" 
                                  id="direccion" name="direccion" rows="2" 
                                  placeholder="Dirección completa"></textarea>
                        <div class="invalid-feedback" id="error-direccion"></div>
                    </div>

                    {{-- Sección de Datos Bancarios --}}
                    <div class="card mt-3">
                        <div class="card-header bg-info text-white py-2">
                            <h6 class="mb-0">
                                <i class="fas fa-university"></i> Datos Bancarios
                            </h6>
                        </div>
                        <div class="card-body py-3">
                            <div class="form-group">
                                <label for="pagomovil">
                                    <i class="fas fa-mobile-alt"></i> Pago Móvil
                                </label>
                                 <textarea class="form-control" 
                                       id="pagomovil" name="pagomovil"
                                       placeholder="Ej: 04141234567 o información de pago móvil"></textarea>
                                <div class="invalid-feedback" id="error-pagomovil"></div>
                            </div>

                            <div class="form-group">
                                <label for="bancos1">
                                    <i class="fas fa-credit-card"></i> Información Bancaria 1
                                </label>
                                <textarea class="form-control" 
                                          id="bancos1" name="bancos1" rows="3"
                                          placeholder="Banco, tipo de cuenta, número, titular"></textarea>
                                <div class="invalid-feedback" id="error-bancos1"></div>
                            </div>

                            <div class="form-group mb-0">
                                <label for="bancos2">
                                    <i class="fas fa-credit-card"></i> Información Bancaria 2
                                </label>
                                <textarea class="form-control" 
                                          id="bancos2" name="bancos2" rows="3"
                                          placeholder="Banco, tipo de cuenta, número, titular"></textarea>
                                <div class="invalid-feedback" id="error-bancos2"></div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info py-2 mb-0 mt-3">
                        <i class="fas fa-info-circle"></i> Campos marcados con * son obligatorios
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success" id="btnGuardar">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para editar proveedor --}}
<div class="modal fade" id="modalEditarProveedor" tabindex="-1" role="dialog" aria-labelledby="modalEditarProveedorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title" id="modalEditarProveedorLabel">
                    <i class="fas fa-edit"></i> Editar Proveedor
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditarProveedor" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" id="edit-modal-body">
                    <!-- Aquí se cargará dinámicamente el formulario -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnActualizar">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal para ver detalles del proveedor --}}
<div class="modal fade" id="modalVerProveedor" tabindex="-1" role="dialog" aria-labelledby="modalVerProveedorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="modalVerProveedorLabel">
                    <i class="fas fa-eye"></i> Detalles del Proveedor
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ver-modal-body">
                <!-- Aquí se cargarán los detalles -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .table th {
            background-color: #f8f9fa;
        }
        .modal-content {
            border-radius: 10px;
        }
        .form-group {
            margin-bottom: 1.2rem;
        }
        textarea.form-control {
            min-height: 80px;
            resize: vertical;
        }
        .card-header.bg-info {
            background-color: #17a2b8 !important;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        .mr-1 {
            margin-right: 5px;
        }
    </style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Token CSRF para AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // URLs para AJAX
    const baseUrl = window.location.origin;
    const URLS = {
        listar: "{{ route('proveedor.listar') }}",
        obtener: baseUrl + "/proveedor/obtener/",
        ver: baseUrl + "/proveedor/ver/",
        guardar: "{{ route('proveedor.guardar') }}",
        actualizar: baseUrl + "/proveedor/actualizar/"
    };

    // Variables para control de edición
    let proveedorEditando = null;
    let datosOriginales = null;
    let searchTimeout = null;

    // ========== FUNCIONES GENERALES ==========
    function mostrarAlerta(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check' : 'fa-exclamation-triangle';
        const title = type === 'success' ? 'Éxito!' : 'Error!';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5><i class="icon fas ${iconClass}"></i> ${title}</h5>
                ${message}
            </div>
        `;
        
        $('#alert-container').html(alertHtml);
        
        setTimeout(() => {
            $('.alert').alert('close');
        }, 5000);
    }

    function limpiarErrores() {
        $('.invalid-feedback').html('');
        $('.form-control').removeClass('is-invalid');
        $('textarea').removeClass('is-invalid');
        $('select').removeClass('is-invalid');
    }

    function mostrarErrores(errors, prefix = '') {
        limpiarErrores();
        
        $.each(errors, function(field, messages) {
            const fieldId = prefix ? `#${prefix}${field}` : `#${field}`;
            const errorId = prefix ? `#error-${prefix}${field}` : `#error-${field}`;
            const $field = $(fieldId);
            const $error = $(errorId);
            
            if ($field.length) {
                $field.addClass('is-invalid');
                if ($error.length) {
                    $error.html(messages[0]);
                } else {
                    $field.after(`<div class="invalid-feedback">${messages[0]}</div>`);
                }
            }
        });
    }

    // Función para separar el RIF
    function separarRIF(rifCompleto) {
        if (!rifCompleto) return { tipo: '', numeroCompleto: '' };
        
        rifCompleto = rifCompleto.trim().toUpperCase();
        
        // Verificar formato J-12345678-0
        const regex = /^([JVGE])-(\d{5,9})(?:-(\d))?$/;
        const match = rifCompleto.match(regex);
        
        if (match) {
            return { 
                tipo: match[1], 
                numeroCompleto: match[3] ? `${match[2]}-${match[3]}` : match[2]
            };
        }
        
        // Si no coincide, intentar separar manualmente
        const partes = rifCompleto.split('-');
        if (partes.length >= 2) {
            const posibleTipo = partes[0];
            if (['J', 'V', 'G', 'E'].includes(posibleTipo)) {
                return { 
                    tipo: posibleTipo, 
                    numeroCompleto: partes.slice(1).join('-')
                };
            }
        }
        
        return { 
            tipo: '', 
            numeroCompleto: rifCompleto
        };
    }

    // ========== FUNCIÓN DE FORMATEO DE TEXTO ==========
    function mostrarTextoConSaltos(texto) {
        if (!texto || texto.trim() === '') return 'N/A';
        return texto.replace(/\n/g, '<br>');
    }

    // ========== CARGA DE DATOS CON AJAX ==========
    function cargarProveedores(url = null, search = null) {
        const loadUrl = url || URLS.listar;
        const searchParam = search !== undefined ? search : $('#search-input').val();
        
        $('#tabla-proveedores-container').hide();
        $('#loading-spinner').show();
        
        const data = {};
        if (searchParam) {
            data.search = searchParam;
        }
        
        $.ajax({
            url: loadUrl,
            type: 'GET',
            data: data,
            success: function(response) {
                $('#tbody-proveedores').html(response.tabla);
                $('#pagination-container').html(response.pagination);
                $('#loading-spinner').hide();
                $('#tabla-proveedores-container').show();
            },
            error: function() {
                mostrarAlerta('error', 'Error al cargar los proveedores');
                $('#loading-spinner').hide();
                $('#tabla-proveedores-container').show();
            }
        });
    }

    // ========== BÚSQUEDA ==========
    function buscarProveedores() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const search = $('#search-input').val();
            cargarProveedores(URLS.listar, search);
        }, 500);
    }

    function limpiarBusqueda() {
        $('#search-input').val('');
        cargarProveedores();
    }

    // ========== PAGINACIÓN ==========
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        if (url && url !== '#') {
            cargarProveedores(url);
        }
    });

    // ========== CREACIÓN DE PROVEEDOR ==========
    $('#formCrearProveedor').on('submit', function(e) {
        e.preventDefault();
        if (confirm('¿Está seguro de que desea crear este nuevo proveedor?')) {
            realizarGuardado();
        }
    });

    function realizarGuardado() {
        const $btn = $('#btnGuardar');
        const originalText = $btn.html();
        
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
        $btn.prop('disabled', true);
        
        $.ajax({
            url: URLS.guardar,
            type: 'POST',
            data: $('#formCrearProveedor').serialize(),
            success: function(response) {
                if (response.success) {
                    $('#modalCrearProveedor').modal('hide');
                    $('#formCrearProveedor')[0].reset();
                    limpiarErrores();
                    $('#prefijo_rif').text('-');
                    mostrarAlerta('success', response.message);
                    cargarProveedores();
                } else {
                    mostrarErrores(response.errors || {});
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    mostrarErrores(xhr.responseJSON.errors || {});
                } else {
                    mostrarAlerta('error', 'Error al guardar el proveedor');
                }
            },
            complete: function() {
                $btn.html(originalText);
                $btn.prop('disabled', false);
            }
        });
    }

    // ========== EDICIÓN DE PROVEEDOR ==========
    $(document).on('click', '.btn-editar-proveedor', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        cargarDatosProveedor(id);
    });

    function cargarDatosProveedor(id) {
        $('#edit-modal-body').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <p class="mt-2">Cargando datos del proveedor...</p>
            </div>
        `);
        
        $('#modalEditarProveedor').modal('show');
        
        $.ajax({
            url: URLS.obtener + id,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    datosOriginales = response.data;
                    proveedorEditando = response.data;
                    llenarFormularioEdicion(response.data);
                } else {
                    $('#modalEditarProveedor').modal('hide');
                    mostrarAlerta('error', response.error || 'Error al cargar datos');
                }
            },
            error: function() {
                $('#modalEditarProveedor').modal('hide');
                mostrarAlerta('error', 'Error al cargar los datos del proveedor');
            }
        });
    }

    function llenarFormularioEdicion(proveedor) {
        const rifSeparado = separarRIF(proveedor.rif);
        const bancosInfo = proveedor.bancos || {};
        
        const formularioHtml = `
            <input type="hidden" name="id" id="edit_id" value="${proveedor.id_proveedor}">
            
            <div class="form-group">
                <label for="edit_nombre" class="font-weight-bold">
                    <i class="fas fa-building"></i> Nombre / Razón Social *
                </label>
                <input type="text" class="form-control" 
                       id="edit_nombre" name="nombre" required 
                       value="${proveedor.nombre || ''}">
                <div class="invalid-feedback" id="error-edit-nombre"></div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="edit_tipo_rif" class="font-weight-bold">
                            <i class="fas fa-id-card"></i> Tipo *
                        </label>
                        <select class="form-control" 
                                id="edit_tipo_rif" name="tipo_rif" required>
                            <option value="">Seleccionar</option>
                            <option value="J" ${rifSeparado.tipo === 'J' ? 'selected' : ''}>J</option>
                            <option value="V" ${rifSeparado.tipo === 'V' ? 'selected' : ''}>V</option>
                            <option value="G" ${rifSeparado.tipo === 'G' ? 'selected' : ''}>G</option>
                            <option value="E" ${rifSeparado.tipo === 'E' ? 'selected' : ''}>E</option>
                        </select>
                        <div class="invalid-feedback" id="error-edit-tipo_rif"></div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="edit_numero_rif" class="font-weight-bold">
                            <i class="fas fa-hashtag"></i> Número de Documento *
                        </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light font-weight-bold" 
                                      id="edit_prefijo_rif" style="min-width: 30px;">${rifSeparado.tipo ? rifSeparado.tipo + '-' : '-'}</span>
                            </div>
                            <input type="text" class="form-control" 
                                   id="edit_numero_rif" name="numero_rif" 
                                   required maxlength="20"
                                   value="${rifSeparado.numeroCompleto || ''}">
                        </div>
                        <div class="invalid-feedback" id="error-edit-numero_rif"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="edit_correo">
                            <i class="fas fa-envelope"></i> Correo Electrónico
                        </label>
                        <input type="email" class="form-control" 
                               id="edit_correo" name="correo" 
                               value="${proveedor.correo || ''}">
                        <div class="invalid-feedback" id="error-edit-correo"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="edit_telefono" class="font-weight-bold">
                            <i class="fas fa-phone"></i> Teléfono *
                        </label>
                        <input type="text" class="form-control" 
                               id="edit_telefono" name="telefono" 
                               required maxlength="15"
                               value="${proveedor.telefono || ''}">
                        <div class="invalid-feedback" id="error-edit-telefono"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="edit_direccion">
                    <i class="fas fa-map-marker-alt"></i> Dirección
                </label>
                <textarea class="form-control" 
                          id="edit_direccion" name="direccion" rows="2">${proveedor.direccion || ''}</textarea>
                <div class="invalid-feedback" id="error-edit-direccion"></div>
            </div>

            {{-- Sección de Datos Bancarios (Opcionales) --}}
            <div class="card mt-3">
                <div class="card-header bg-info text-white py-2">
                    <h6 class="mb-0">
                        <i class="fas fa-university"></i> Datos Bancarios 
                    </h6>
                </div>
                <div class="card-body py-3">
                    <div class="form-group">
                        <label for="edit_pagomovil">
                            <i class="fas fa-mobile-alt"></i> Pago Móvil
                        </label>
                       <textarea class="form-control" 
                               id="edit_pagomovil" name="pagomovil">${bancosInfo.pagomovil || ''}</textarea>
                        <div class="invalid-feedback" id="error-edit-pagomovil"></div>
                    </div>

                    <div class="form-group">
                        <label for="edit_bancos1">
                            <i class="fas fa-credit-card"></i> Información Bancaria 1
                        </label>
                        <textarea class="form-control" 
                                  id="edit_bancos1" name="bancos1" rows="3">${bancosInfo.bancos1 || ''}</textarea>
                        <div class="invalid-feedback" id="error-edit-bancos1"></div>
                    </div>

                    <div class="form-group mb-0">
                        <label for="edit_bancos2">
                            <i class="fas fa-credit-card"></i> Información Bancaria 2
                        </label>
                        <textarea class="form-control" 
                                  id="edit_bancos2" name="bancos2" rows="3">${bancosInfo.bancos2 || ''}</textarea>
                        <div class="invalid-feedback" id="error-edit-bancos2"></div>
                    </div>
                </div>
            </div>

            <div class="alert alert-info py-2 mb-0 mt-3">
                <i class="fas fa-info-circle"></i> Campos marcados con * son obligatorios
            </div>
        `;
        
        $('#edit-modal-body').html(formularioHtml);
        configurarEventosEdicion();
    }

    function configurarEventosEdicion() {
        $('#edit_tipo_rif').on('change', function() {
            const tipo = $(this).val();
            $('#edit_prefijo_rif').text(tipo ? tipo + '-' : '-');
        });
        
        $('#edit_numero_rif').on('input', function() {
            let valor = $(this).val();
            valor = valor.replace(/--+/g, '-');
            valor = valor.replace(/[^\d\-]/g, '');
            
            if (valor.startsWith('-')) valor = valor.substring(1);
            
            const guiones = valor.split('-').length - 1;
            if (guiones > 1) {
                const partes = valor.split('-');
                valor = partes[0] + (partes[1] ? '-' + partes[1] : '');
            }
            
            $(this).val(valor);
        });
        
        $('#edit_telefono').on('input', function() {
            $(this).val($(this).val().replace(/[^\d\s\-\(\)\+]/g, ''));
        });
        
        $('#formEditarProveedor').off('submit').on('submit', function(e) {
            e.preventDefault();
            
            if (!verificarCambios()) {
                alert('No se detectaron cambios en los datos del proveedor.');
                $('#modalEditarProveedor').modal('hide');
                return;
            }
            
            if (confirm('¿Está seguro de que desea guardar los cambios en este proveedor?')) {
                realizarActualizacion();
            }
        });
    }

    function verificarCambios() {
        if (!proveedorEditando || !datosOriginales) return true;
        
        const nombreActual = $('#edit_nombre').val();
        const tipoActual = $('#edit_tipo_rif').val();
        const numeroActual = $('#edit_numero_rif').val();
        const correoActual = $('#edit_correo').val();
        const telefonoActual = $('#edit_telefono').val();
        const direccionActual = $('#edit_direccion').val();
        
        const pagomovilActual = $('#edit_pagomovil').val();
        const bancos1Actual = $('#edit_bancos1').val();
        const bancos2Actual = $('#edit_bancos2').val();
        
        const rifSeparado = separarRIF(datosOriginales.rif);
        const rifActual = tipoActual + '-' + numeroActual;
        
        const bancosOriginal = datosOriginales.bancos || {};
        
        return (
            nombreActual !== datosOriginales.nombre ||
            rifActual !== datosOriginales.rif ||
            correoActual !== (datosOriginales.correo || '') ||
            telefonoActual !== (datosOriginales.telefono || '') ||
            direccionActual !== (datosOriginales.direccion || '') ||
            pagomovilActual !== (bancosOriginal.pagomovil || '') ||
            bancos1Actual !== (bancosOriginal.bancos1 || '') ||
            bancos2Actual !== (bancosOriginal.bancos2 || '')
        );
    }

    function realizarActualizacion() {
        const $btn = $('#btnActualizar');
        const originalText = $btn.html();
        const id = $('#edit_id').val();
        
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
        $btn.prop('disabled', true);
        
        $.ajax({
            url: URLS.actualizar + id,
            type: 'PUT',
            data: $('#formEditarProveedor').serialize(),
            success: function(response) {
                if (response.success) {
                    $('#modalEditarProveedor').modal('hide');
                    limpiarErrores();
                    mostrarAlerta('success', response.message);
                    cargarProveedores();
                } else {
                    mostrarErrores(response.errors || {}, 'edit-');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    mostrarErrores(xhr.responseJSON.errors || {}, 'edit-');
                } else {
                    mostrarAlerta('error', 'Error al actualizar el proveedor');
                }
            },
            complete: function() {
                $btn.html(originalText);
                $btn.prop('disabled', false);
            }
        });
    }

    // ========== VER DETALLES DEL PROVEEDOR ==========
    $(document).on('click', '.btn-ver-proveedor', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        cargarDetallesProveedor(id);
    });

    function cargarDetallesProveedor(id) {
        $('#ver-modal-body').html(`
            <div class="text-center py-5">
                <div class="spinner-border text-info" role="status">
                    <span class="sr-only">Cargando...</span>
                </div>
                <p class="mt-2">Cargando detalles del proveedor...</p>
            </div>
        `);
        
        $('#modalVerProveedor').modal('show');
        
        $.ajax({
            url: URLS.ver + id,
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    mostrarDetallesProveedor(response.data);
                } else {
                    $('#modalVerProveedor').modal('hide');
                    mostrarAlerta('error', response.error || 'Error al cargar los detalles');
                }
            },
            error: function() {
                $('#modalVerProveedor').modal('hide');
                mostrarAlerta('error', 'Error al cargar los detalles del proveedor');
            }
        });
    }

    function mostrarDetallesProveedor(proveedor) {
        const bancosInfo = proveedor.bancos || {};
        
        let fechaRegistro = 'N/A';
        if (proveedor.fecha_registro) {
            const fecha = new Date(proveedor.fecha_registro);
            fechaRegistro = fecha.toLocaleDateString();
        }
        
        const detallesHtml = `
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-building text-primary"></i> Datos del Proveedor
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>ID:</strong> ${proveedor.id_proveedor || 'N/A'}</p>
                                    <p><strong>Nombre:</strong> ${proveedor.nombre || 'N/A'}</p>
                                    <p><strong>RIF:</strong> ${proveedor.rif || 'N/A'}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Teléfono:</strong> ${proveedor.telefono || 'N/A'}</p>
                                    <p><strong>Correo:</strong> ${proveedor.correo || 'N/A'}</p>
                                    <p><strong>Fecha Registro:</strong> ${fechaRegistro}</p>
                                </div>
                            </div>
                            <p><strong>Dirección:</strong><br>${mostrarTextoConSaltos(proveedor.direccion)}</p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fas fa-university text-success"></i> Datos Bancarios
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p><strong>Pago Móvil:</strong></p>
                                    <div class="border p-2 bg-light rounded">
                                        ${mostrarTextoConSaltos(bancosInfo.pagomovil)}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <p><strong>Información Bancaria 1:</strong></p>
                                    <div class="border p-2 bg-light rounded">
                                        ${mostrarTextoConSaltos(bancosInfo.bancos1)}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <p><strong>Información Bancaria 2:</strong></p>
                                    <div class="border p-2 bg-light rounded">
                                        ${mostrarTextoConSaltos(bancosInfo.bancos2)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('#ver-modal-body').html(detallesHtml);
    }

    // ========== VALIDACIÓN DE FORMULARIOS ==========
    function inicializarEventosValidacion() {
        $('#tipo_rif').on('change', function() {
            const tipo = $(this).val();
            $('#prefijo_rif').text(tipo ? tipo + '-' : '-');
        });
        
        $('#numero_rif').on('input', function() {
            let valor = $(this).val();
            valor = valor.replace(/--+/g, '-');
            valor = valor.replace(/[^\d\-]/g, '');
            
            if (valor.startsWith('-')) valor = valor.substring(1);
            
            const guiones = valor.split('-').length - 1;
            if (guiones > 1) {
                const partes = valor.split('-');
                valor = partes[0] + (partes[1] ? '-' + partes[1] : '');
            }
            
            $(this).val(valor);
        });
        
        $('#telefono').on('input', function() {
            $(this).val($(this).val().replace(/[^\d\s\-\(\)\+]/g, ''));
        });
        
        $('#search-input').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                buscarProveedores();
            }
        });
        
        $('#search-input').on('input', function() {
            buscarProveedores();
        });
        
        $('#btn-buscar').on('click', function() {
            buscarProveedores();
        });
        
        $('#btn-limpiar-busqueda').on('click', function() {
            limpiarBusqueda();
        });
    }

    // ========== LIMPIAR MODALES AL CERRAR ==========
    $('#modalCrearProveedor').on('hidden.bs.modal', function() {
        $(this).find('form')[0].reset();
        limpiarErrores();
        $('#prefijo_rif').text('-');
        $('#btnGuardar').html('<i class="fas fa-save"></i> Guardar').prop('disabled', false);
    });
    
    $('#modalEditarProveedor').on('hidden.bs.modal', function() {
        $('#edit-modal-body').empty();
        $('#btnActualizar').html('<i class="fas fa-save"></i> Actualizar').prop('disabled', false);
        proveedorEditando = null;
        datosOriginales = null;
    });
    
    $('#modalVerProveedor').on('hidden.bs.modal', function() {
        $('#ver-modal-body').empty();
    });

    // ========== INICIALIZACIÓN ==========
    inicializarEventosValidacion();
});
</script>
@stop