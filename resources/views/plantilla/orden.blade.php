<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Compra #{{ $calculos['numeroOrden'] }}</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos personalizados - Tema Vinotinto */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            background-color: #f8f9fa;
        }
        
        .container {
            max-width: 1000px;
            margin: 20px auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Encabezado con logo */
        .header-section {
            background: linear-gradient(135deg, #8a0a27, #B22222);
            color: white;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .header-logo {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .logo-container {
            background: white;
            padding: 10px;
            border-radius: 8px;
            margin-right: 15px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        
        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: #f8f9fa;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8a0a27;
            font-size: 24px;
            border: 2px solid #eaeaea;
        }
        
        .header-info {
            flex: 1;
            text-align: center;
        }
        
        .header-section h1 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: 700;
            color: white;
        }
        
        .header-section h2 {
            font-size: 20px;
            margin-bottom: 5px;
            font-weight: 400;
            opacity: 0.9;
            color: white;
        }
        
        .header-section .badge-status {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
        }
        
        /* Colores de estado en tema vinotinto */
        .badge-pendiente { background-color: #FFA500; color: #212529; }
        .badge-aprobado { background-color: #32CD32; color: white; }
        .badge-rechazado { background-color: #DC143C; color: white; }
        .badge-procesado { background-color: #1E90FF; color: white; }
        .badge-completado { background-color: #228B22; color: white; }
        .badge-0 { background-color: #6c757d; color: white; }
        
        .info-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 3px 10px rgba(139, 0, 0, 0.05);
            border: 1px solid #eaeaea;
            border-left: 4px solid #8a0a27;
        }
        
        .info-card h4 {
            color: #8a0a27;
            border-bottom: 2px solid #B22222;
            padding-bottom: 10px;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 10px;
            align-items: flex-start;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
            min-width: 160px;
            display: flex;
            align-items: center;
        }
        
        .info-label i {
            margin-right: 8px;
            width: 20px;
            color: #8a0a27;
        }
        
        .info-value {
            color: #333;
            flex: 1;
            padding-top: 2px;
        }
        
        /* Estilos para valores vacíos o nulos */
        .info-value .empty-value {
            color: #6c757d;
            font-style: italic;
            font-size: 0.95em;
        }
        
        .info-value .badge-null {
            background-color: #e9ecef;
            color: #6c757d;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.85em;
            font-style: italic;
        }
        
        .table-container {
            margin: 25px 0;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(139, 0, 0, 0.05);
        }
        
        .table-custom {
            margin-bottom: 0;
        }
        
        .table-custom thead {
            background: linear-gradient(135deg, #8a0a27, #B22222);
            color: white;
        }
        
        .table-custom th {
            border: none;
            padding: 12px 15px;
            font-weight: 600;
        }
        
        .table-custom td {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #eee;
        }
        
        .totals-card {
            background: linear-gradient(135deg, #fff5f5, #ffe6e6);
            border-radius: 10px;
            padding: 20px;
            margin: 25px 0;
            border-left: 5px solid #8a0a27;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }
        
        .total-row.highlight {
            font-weight: 700;
            font-size: 18px;
            color: #8a0a27;
            border-top: 2px solid #8a0a27;
            border-bottom: 2px solid #8a0a27;
            margin-top: 10px;
            padding-top: 15px;
            padding-bottom: 15px;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 25px 0;
            padding: 20px;
            background: #fff5f5;
            border-radius: 10px;
        }
        
        .btn-custom {
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        /* Botones en tema vinotinto */
        .btn-print {
            background: linear-gradient(135deg, #8a0a27, #B22222);
            color: white;
            border: none;
        }
        
        .btn-print:hover {
            background: linear-gradient(135deg, #6B0000, #9B1A1A);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(139, 0, 0, 0.3);
        }
        
        .btn-download {
            background: linear-gradient(135deg, #228B22, #32CD32);
            color: white;
            border: none;
        }
        
        .btn-download:hover {
            background: linear-gradient(135deg, #1A7A1A, #28A428);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }
        
        .btn-share {
            background: linear-gradient(135deg, #1E90FF, #4169E1);
            color: white;
            border: none;
        }
        
        .btn-share:hover {
            background: linear-gradient(135deg, #187BCD, #3159B9);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
        }
        
        .btn-back {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            border: none;
        }
        
        .btn-back:hover {
            background: linear-gradient(135deg, #5a6268, #343a40);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
        }
        
        .payment-section {
            background: linear-gradient(135deg, #f8f9ff, #e6e9ff);
            border-left: 4px solid #4169E1;
        }
        
        .bank-info {
            background: #f0f8ff;
            border: 1px solid #d0e7ff;
            border-radius: 6px;
            padding: 10px;
            margin-top: 5px;
            font-size: 0.9em;
        }
        
        .bank-info div {
            margin-bottom: 8px;
            line-height: 1.4;
        }
        
        .bank-info div:last-child {
            margin-bottom: 0;
        }
        
        /* Estilos para campos condicionales */
        .conditional-field {
            display: none;
        }
        
        .conditional-field.show {
            display: flex;
        }
        
        /* Ajustes para mejorar la legibilidad */
        .compact-text {
            font-size: 0.9em;
            line-height: 1.4;
            margin-bottom: 3px;
        }
        
        .multi-line-value {
            white-space: pre-line;
            line-height: 1.4;
        }
        
        /* Estado específico */
        .estado-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .header-section {
                flex-direction: column;
                text-align: center;
                padding: 20px 15px;
            }
            
            .header-logo {
                justify-content: center;
                margin-bottom: 15px;
                width: 100%;
            }
            
            .header-section h1 {
                font-size: 22px;
            }
            
            .info-label {
                min-width: 130px;
            }
            
            .action-buttons {
                flex-wrap: wrap;
            }
            
            .btn-custom {
                flex: 1;
                min-width: 140px;
            }
        }
    </style>
</head>
<body>
    <!-- Contenedor principal -->
    <div class="container">
        <!-- Encabezado con logo y estado -->
        <div class="header-section">
            <div class="header-logo">
                <div class="logo-container">
                    <div class="logo-placeholder">
                       <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" style="width: 60px; height: 60px;">
                    </div>
                </div>
                <div class="header-info">
                    <h1><i class="fas fa-file-invoice-dollar me-2"></i>ORDEN DE COMPRA</h1>
                    <h2>{{ $orden->sucursal->nombre ?? 'Sucursal' }}</h2>
                </div>
            </div>
            <div class="mt-2">
                @php
                    $estatus = $orden->estatus ?? 'pendiente';
                    // Convertir estado numérico a texto
                    if ($estatus === '0' || $estatus === 0) {
                        $estatus = 'pendiente';
                        $estatusTexto = 'Pendiente';
                    } else {
                        $estatusTexto = ucfirst($estatus);
                    }
                @endphp
                <span class="badge-status badge-{{ strtolower($estatus) }}">
                    {{ $estatusTexto }}
                </span>
                <span class="badge bg-light text-dark ms-2">
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ $calculos['fechaEmision'] }}
                </span>
            </div>
        </div>
        
        <!-- Botones de acción -->
        <div class="action-buttons no-print">
            <button class="btn btn-custom btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <button class="btn btn-custom btn-download" id="downloadPdf">
                <i class="fas fa-download"></i> Descargar PDF
            </button>
            <button class="btn btn-custom btn-share" id="shareOrder">
                <i class="fas fa-share-alt"></i> Compartir
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-custom btn-back">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        
        <div class="container-fluid">
            <div class="row">
                <!-- Columna izquierda: Información de proveedor y sucursal -->
                <div class="col-md-6">
                    <!-- Información del proveedor -->
                    <div class="info-card">
                        <h4><i class="fas fa-truck me-2"></i>Información del Proveedor</h4>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-building"></i> Empresa:
                            </div>
                            <div class="info-value">{{ $orden->proveedor->nombre ?? 'Proveedor' }}</div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-id-card"></i> R.I.F.:
                            </div>
                            <div class="info-value">{{ $orden->proveedor->rif ?? 'RIF' }}</div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt"></i> Dirección:
                            </div>
                            <div class="info-value">{{ $orden->proveedor->direccion ?? 'Dirección no especificada' }}</div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-phone"></i> Teléfono:
                            </div>
                            <div class="info-value">
                                @php
                                    $telefono = $orden->proveedor->telefono ?? null;
                                @endphp
                                @if(!empty($telefono) && strtolower($telefono) != 'nan' && $telefono != 'null')
                                    {{ $telefono }}
                                @else
                                    <span class="empty-value">No especificado</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i> Correo:
                            </div>
                            <div class="info-value">
                                @php
                                    $correo = $orden->proveedor->correo ?? null;
                                @endphp
                                @if(!empty($correo) && strtolower($correo) != 'nan' && $correo != 'null')
                                    {{ $correo }}
                                @else
                                    <span class="empty-value">No especificado</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de bancos y pago móvil -->
                    @if(isset($orden->bancos_info) && ($orden->bancos_info->pago_movil || $orden->bancos_info->banco_1 || $orden->bancos_info->banco_2))
                    <div class="info-card payment-section">
                        <h4><i class="fas fa-university me-2"></i>Información de Pago</h4>
                        
                        <!-- Mostrar Pago Móvil si existe -->
                        @if($orden->bancos_info->pago_movil)
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-mobile-alt"></i> Pago Móvil:
                            </div>
                            <div class="info-value">
                                <div class="multi-line-value compact-text">
                                    {{ $orden->bancos_info->pago_movil }}
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Mostrar información del titular si existe -->
                        @if($orden->bancos_info->titular)
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-user"></i> Titular:
                            </div>
                            <div class="info-value">{{ $orden->bancos_info->titular }}</div>
                        </div>
                        @endif
                        
                        @if($orden->bancos_info->cedula)
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-id-card"></i> Cédula:
                            </div>
                            <div class="info-value">{{ $orden->bancos_info->cedula }}</div>
                        </div>
                        @endif
                        
                        @if($orden->bancos_info->telefono)
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-phone"></i> Teléfono:
                            </div>
                            <div class="info-value">{{ $orden->bancos_info->telefono }}</div>
                        </div>
                        @endif
                        
                        <!-- Mostrar Bancos si existen -->
                        @if($orden->bancos_info->banco_1 || $orden->bancos_info->banco_2)
                        <div class="info-row">
                            <div class="info-label">
                                <i class="fas fa-credit-card"></i> Bancos:
                            </div>
                            <div class="info-value">
                                <div class="bank-info">
                                    @if($orden->bancos_info->banco_1)
                                    <div class="compact-text">
                                        <strong>Banco 1:</strong> 
                                        <div class="multi-line-value">{{ $orden->bancos_info->banco_1 }}</div>
                                    </div>
                                    @endif
                                    
                                    @if($orden->bancos_info->banco_2)
                                    <div class="compact-text">
                                        <strong>Banco 2:</strong> 
                                        <div class="multi-line-value">{{ $orden->bancos_info->banco_2 }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <!-- Información de la orden -->
                    <div class="info-card">
                        <h4><i class="fas fa-info-circle me-2"></i>Detalles de la Orden</h4>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-hashtag"></i> Nº de orden:
                            </div>
                            <div class="info-value">
                                <span class="badge" style="background: #8a0a27;">{{ $calculos['numeroOrden'] }}</span>
                            </div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-calendar"></i> Fecha:
                            </div>
                            <div class="info-value">{{ $calculos['fechaEmision'] }}</div>
                        </div>
                        
                        <!-- Responsable - SOLO SI EXISTE -->
                        @if(isset($orden->responsable_id) && $orden->responsable_id)
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-user-tie"></i> Responsable:
                            </div>
                            <div class="info-value">
                                <select class="form-select-custom" id="responsable-select">
                                    <option value="">Cargando responsables...</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        
                        <!-- Tipo de Factura - SOLO SI EXISTE -->
                        @if(isset($orden->tipo_factura_id) && $orden->tipo_factura_id)
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-file-invoice"></i> Tipo Factura:
                            </div>
                            <div class="info-value">
                                <select class="form-select-custom" id="tipofactura-select">
                                    <option value="">Cargando tipos...</option>
                                </select>
                            </div>
                        </div>
                        @endif
                        
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-money-bill-wave"></i> Moneda:
                            </div>
                            <div class="info-value">
                                <span class="badge" style="background: #228B22;">{{ strtoupper($orden->moneda) }}</span>
                            </div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-chart-line"></i> Tasa del día:
                            </div>
                            <div class="info-value">Bs. {{ $calculos['tasa'] }}</div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-user"></i> Registrado por:
                            </div>
                            <div class="info-value">{{ $orden->usuario->name ?? 'Sistema' }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Columna derecha: Información de sucursal y productos -->
                <div class="col-md-6">
                    <!-- Información de la sucursal -->
                    <div class="info-card">
                        <h4><i class="fas fa-store me-2"></i>Información de la Sucursal</h4>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-store"></i> Sucursal:
                            </div>
                            <div class="info-value">{{ $orden->sucursal->nombre ?? 'Sucursal' }}</div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-map-marker-alt"></i> Dirección:
                            </div>
                            <div class="info-value">{{ $orden->sucursal->direccion ?? 'Dirección no especificada' }}</div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-phone"></i> Teléfono:
                            </div>
                            <div class="info-value">
                                @php
                                    $telefonoSucursal = $orden->sucursal->telefono ?? null;
                                @endphp
                                @if(!empty($telefonoSucursal) && strtolower($telefonoSucursal) != 'nan' && $telefonoSucursal != 'null')
                                    {{ $telefonoSucursal }}
                                @else
                                    <span class="empty-value">No especificado</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Resumen rápido -->
                    <div class="info-card">
                        <h4><i class="fas fa-chart-bar me-2"></i>Resumen Rápido</h4>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-boxes"></i> Productos:
                            </div>
                            <div class="info-value">{{ count($productos) }} productos</div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-balance-scale"></i> Cantidad total:
                            </div>
                            @php
                                $cantidadTotal = 0;
                                foreach($productos as $producto) {
                                    $cantidadTotal += $producto->cantidad;
                                }
                            @endphp
                            <div class="info-value">{{ number_format($cantidadTotal, 0) }} unidades</div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-clock"></i> Creado:
                            </div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($orden->fecha_orden)->format('d/m/Y H:i') }}
                            </div>
                        </div>
                        <div class="info-row align-items-center">
                            <div class="info-label">
                                <i class="fas fa-sync-alt"></i> Estado:
                            </div>
                            <div class="info-value">
                                @php
                                    $estatus = $orden->estatus ?? 'pendiente';
                                    $estatusTexto = $estatusTexto ?? ucfirst($estatus);
                                @endphp
                                <span class="badge-status badge-{{ strtolower($estatus) }}">
                                    {{ $estatusTexto }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Tabla de productos -->
            @if(count($productos) > 0)
            <div class="table-container">
                <h4 class="mb-3" style="color: #8a0a27;"><i class="fas fa-shopping-cart me-2"></i>Detalle de Productos ({{ count($productos) }})</h4>
                <div class="table-responsive">
                    <table class="table table-custom table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center"><i class="fas fa-hashtag"></i> Cantidad</th>
                                <th class="text-center"><i class="fas fa-ruler"></i> Unidad</th>
                                <th><i class="fas fa-tag"></i> Producto</th>
                                <th class="text-center"><i class="fas fa-dollar-sign"></i> Precio unitario</th>
                                <th class="text-center"><i class="fas fa-calculator"></i> Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $index => $producto)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill" style="background: #8a0a27; font-size: 14px;">
                                        {{ number_format($producto->cantidad, 0) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill" style="background: #1E90FF; font-size: 14px;">
                                        {{ $producto->unidad_abreviatura ?? 'UND' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-box text-muted me-2"></i>
                                        <div>
                                            <strong>{{ $producto->producto_nombre ?? 'Producto' }}</strong>
                                            @if($producto->producto_id ?? false)
                                                <br>
                                                <small class="text-muted">ID: {{ $producto->producto_id }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="text-success fw-bold">
                                        $ {{ number_format($producto->precio, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold" style="color: #8a0a27;">
                                        $ {{ number_format($producto->subtotal, 2, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No se encontraron productos para esta orden.
            </div>
            @endif
            
            <!-- Totales -->
            <div class="totals-card">
                <h4 class="mb-4" style="color: #8a0a27;"><i class="fas fa-calculator me-2"></i>Resumen de Totales</h4>
                <div class="total-row">
                    <span class="total-label">SUBTOTAL $</span>
                    <span class="total-value fw-bold">$ {{ $calculos['subtotal'] }}</span>
                </div>
                @if($calculos['aplicaIVA'])
                <div class="total-row">
                    <span class="total-label">IVA ({{ $calculos['ivaPorcentaje'] }}%)</span>
                    <span class="total-value text-success fw-bold">$ {{ $calculos['iva'] }}</span>
                </div>
                @endif
                <div class="total-row highlight">
                    <span class="total-label">TOTAL EN DÓLARES</span>
                    <span class="total-value" style="color: #8a0a27;">$ {{ $calculos['totalUSD'] }}</span>
                </div>
                <div class="total-row">
                    <span class="total-label">TOTAL EN BOLÍVARES</span>
                    <span class="total-value fw-bold" style="color: #B22222;">Bs. {{ $calculos['totalBS'] }}</span>
                </div>
                @if(!$calculos['aplicaIVA'])
                <div class="total-row mt-2">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Esta orden no aplica IVA
                    </small>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Pie de página -->
        <div class="footer-section">
            <p>
                <i class="fas fa-lock me-1"></i>
                Documento generado por el Sistema de Órdenes de Compra
            </p>
            <p class="mb-0">
                <i class="fas fa-calendar-alt me-1"></i>
                Generado el {{ now()->format('d/m/Y H:i') }} | 
                <i class="fas fa-user me-1"></i>
                Usuario: {{ $orden->usuario->name ?? 'Sistema' }}
            </p>
            <p class="mt-2" style="font-size: 12px; opacity: 0.8;">
                <i class="fas fa-info-circle me-1"></i>
                Este es un documento oficial. Cualquier modificación debe ser autorizada.
            </p>
        </div>
    </div>
    
    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Botón de descarga PDF
            document.getElementById('downloadPdf').addEventListener('click', function() {
                alert('Funcionalidad de descarga PDF será implementada próximamente');
            });
            
            // Botón de compartir
            document.getElementById('shareOrder').addEventListener('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: 'Orden de Compra #{{ $calculos['numeroOrden'] }}',
                        text: 'Orden de compra de {{ $orden->sucursal->nombre ?? "Sucursal" }}',
                        url: window.location.href
                    })
                    .catch((error) => console.log('Error al compartir', error));
                } else {
                    prompt('Copia esta URL para compartir:', window.location.href);
                }
            });
            
            // Formatear texto multilínea en información de pago
            const multiLineElements = document.querySelectorAll('.multi-line-value');
            multiLineElements.forEach(el => {
                // Reemplazar múltiples espacios por un solo espacio
                let text = el.textContent.trim();
                text = text.replace(/\s+/g, ' ');
                el.textContent = text;
            });
        });
    </script>
</body>
</html>