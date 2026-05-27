<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.tipo_documento')); ?> #<?php echo e($calculos['numeroOrden']); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- html2pdf.js para exportar a PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* =========================================== */
        /* ESTILOS OPTIMIZADOS PARA 1 PÁGINA A4 */
        /* =========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.4; /* Reducido para ahorrar espacio */
            background-color: #f8f9fa;
            font-size: 12px; /* Tamaño base más pequeño */
        }
        
        .container {
            width: 21cm; /* Ancho exacto A4 */
            min-height: 29.7cm; /* Alto exacto A4 */
            margin: 0 auto;
            background: white;
            padding: 10px; /* Reducido al mínimo */
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            position: relative;
        }
        
        /* ========== ENCABEZADO COMPACTO ========== */
        .header-section {
            background: linear-gradient(135deg, #8a0a27, #B22222);
            color: white;
            padding: 8px 12px; /* Reducido significativamente */
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 8px;
            border-radius: 4px;
        }
        
        .header-logo {
            display: flex;
            align-items: center;
        }
        
        .logo-container {
            background: white;
            padding: 4px;
            border-radius: 4px;
            margin-right: 8px;
        }
        
        .logo-placeholder img {
            width: 40px; /* Reducido */
            height: 40px; /* Reducido */
            object-fit: contain;
        }
        
        .header-info {
            flex: 1;
            text-align: center;
        }
        
        .header-section h1 {
            font-size: 16px; /* MUCHO más pequeño */
            margin-bottom: 2px;
            font-weight: 700;
            color: white;
        }
        
        .header-section h2 {
            font-size: 12px; /* Reducido */
            margin-bottom: 2px;
            font-weight: 400;
            opacity: 0.9;
            color: white;
        }
        
        /* ========== BOTONES DE ACCIÓN ========== */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
            padding: 10px;
            background: #fff5f5;
            border-radius: 6px;
        }
        
        .btn-custom {
            padding: 6px 12px; /* Más compacto */
            border-radius: 4px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.3s ease;
            font-size: 11px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        
        .btn-pdf {
            background: linear-gradient(135deg, #8a0a27, #B22222);
            color: white;
        }
        
        .btn-print {
            background: linear-gradient(135deg, #228B22, #32CD32);
            color: white;
        }
        
        .btn-back {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
        }
        
        /* ========== BADGES COMPACTOS ========== */
        .badge-status {
            display: inline-block;
            padding: 3px 8px; /* Más pequeño */
            border-radius: 3px;
            font-size: 10px; /* Más pequeño */
            font-weight: 600;
            margin: 2px;
        }
        
        .badge-pendiente { background-color: #FFA500; color: #212529; }
        .badge-aprobado { background-color: #32CD32; color: white; }
        .badge-rechazado { background-color: #DC143C; color: white; }
        .badge-procesado { background-color: #1E90FF; color: white; }
        .badge-completado { background-color: #228B22; color: white; }
        
        /* Colores para tipos de IVA */
        .badge-iva-normal { background-color: #28a745; color: white; }
        .badge-iva-deduccion { background-color: #17a2b8; color: white; }
        .badge-sin-iva { background-color: #6c757d; color: white; }
        
        .nro-control-formateado {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            background: #8a0a27;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            letter-spacing: 0.5px;
            font-size: 11px;
        }
        
        /* ========== TARJETAS DE INFORMACIÓN ========== */
        .info-card {
            background: white;
            border-radius: 6px;
            padding: 10px; /* Reducido */
            margin-bottom: 10px; /* Reducido */
            border: 1px solid #eaeaea;
            border-left: 3px solid #8a0a27;
            box-shadow: 0 1px 3px rgba(139, 0, 0, 0.05);
        }
        
        .info-card h4 {
            color: #8a0a27;
            border-bottom: 1px solid #B22222;
            padding-bottom: 5px;
            margin-bottom: 8px;
            font-size: 13px; /* Más pequeño */
        }
        
        .info-row {
            display: flex;
            margin-bottom: 5px; /* Reducido */
            align-items: flex-start;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
            min-width: 100px; /* Reducido */
            display: flex;
            align-items: center;
            font-size: 11px;
        }
        
        .info-label i {
            margin-right: 5px;
            width: 16px;
            color: #8a0a27;
            font-size: 11px;
        }
        
        .info-value {
            color: #333;
            flex: 1;
            font-size: 11px;
        }
        
        .empty-value {
            color: #6c757d;
            font-style: italic;
            font-size: 10px;
        }
        
        /* ========== TABLA COMPACTA ========== */
        .table-container {
            margin: 10px 0;
            overflow: hidden;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        
        .table-container h4 {
            color: #8a0a27;
            font-size: 13px;
            padding: 8px;
            margin: 0;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        
        .table-custom {
            margin-bottom: 0;
            width: 100%;
            border-collapse: collapse;
            font-size: 10px; /* Tabla más pequeña */
        }
        
        .table-custom thead {
            background: #8a0a27;
            color: white;
        }
        
        .table-custom th {
            border: none;
            padding: 6px 8px; /* Reducido */
            font-weight: 600;
            text-align: left;
            font-size: 10px;
            white-space: nowrap;
        }
        
        .table-custom td {
            padding: 6px 8px; /* Reducido */
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }
        
        .table-custom tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        /* ========== TOTALES COMPACTOS ========== */
        .totals-card {
            background: linear-gradient(135deg, #fff5f5, #ffe6e6);
            border-radius: 6px;
            padding: 12px;
            margin: 10px 0;
            border-left: 4px solid #8a0a27;
        }
        
        .totals-card h4 {
            color: #8a0a27;
            font-size: 13px;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #B22222;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
        }
        
        .total-row.highlight {
            font-weight: 700;
            font-size: 12px;
            color: #8a0a27;
            border-top: 1px solid #8a0a27;
            border-bottom: 1px solid #8a0a27;
            margin-top: 5px;
            padding: 6px 0;
        }
        
        .bs-conversion {
            font-size: 9px;
            color: #6c757d;
            margin-left: 5px;
        }
        
        /* ========== SECCIÓN OBSERVACIONES ========== */
        .observaciones-card {
            background: white;
            border-radius: 6px;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #eaeaea;
            border-left: 3px solid #6f42c1;
            box-shadow: 0 1px 3px rgba(111, 66, 193, 0.05);
        }
        
        .observaciones-card h4 {
            color: #6f42c1;
            border-bottom: 1px solid #6f42c1;
            padding-bottom: 5px;
            margin-bottom: 8px;
            font-size: 13px;
        }
        
        .observaciones-content {
            font-size: 11px;
            line-height: 1.3;
            color: #333;
            background: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
            border-left: 2px solid #6f42c1;
            min-height: 40px;
        }
        
        /* ========== PIE DE PÁGINA COMPACTO ========== */
        .footer-section {
            padding: 8px;
            text-align: center;
            color: #424242;
            font-size: 10px;
            border-top: 1px solid #eee;
            margin-top: 10px;
        }
        
        /* ========== CLASE PARA OCULTAR EN IMPRESIÓN/PDF ========== */
        .no-print {
            display: block;
        }
        
        /* =========================================== */
        /* ESTILOS PARA IMPRESIÓN Y PDF (1 PÁGINA) */
        /* =========================================== */
        @media print {
            /* Forzar todos los elementos a imprimir en escala de grises */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
                color: #000000 !important;
                background-color: #ffffff !important;
                background: #ffffff !important;
            }
            
            /* Forzar texto negro */
            body, h1, h2, h3, h4, h5, h6, p, span, div, td, th, label, strong, b {
                color: #000000 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background-color: transparent !important;
            }
            
            /* Quitar fondos de colores */
            .header-section,
            .badge-status,
            .nro-control-formateado,
            .info-card,
            .totals-card,
            .observaciones-card,
            .table-custom thead,
            .action-buttons {
                background-color: #ffffff !important;
                background: #ffffff !important;
            }
            
            /* Forzar bordes negros */
            .header-section,
            .info-card,
            .totals-card,
            .observaciones-card,
            .table-container,
            .table-custom th,
            .table-custom td,
            .table-custom thead {
                border-color: #000000 !important;
                border: 1px solid #000000 !important;
            }
            
            /* Badges en impresión */
            .badge-status {
                border: 1px solid #000000 !important;
                background-color: #f0f0f0 !important;
                color: #000000 !important;
            }
            
            /* Tabla header en impresión */
            .table-custom thead {
                background-color: #f0f0f0 !important;
                color: #000000 !important;
            }
            
            /* Filas alternas de tabla */
            .table-custom tbody tr:nth-child(even) {
                background-color: #f8f8f8 !important;
            }
            
            /* Quitar degradados */
            .header-section,
            .btn-custom,
            .totals-card {
                background-image: none !important;
            }
            
            /* Forzar que los enlaces sean negros */
            a, a:visited {
                color: #000000 !important;
                text-decoration: underline;
            }
            
            /* Configuración adicional de página */
            @page {
                margin: 0.5cm;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .container {
                width: 100%;
                padding: 5px;
            }
            
            .header-section {
                flex-direction: column;
                text-align: center;
                padding: 10px;
            }
            
            .header-logo {
                justify-content: center;
                margin-bottom: 5px;
            }
            
            .action-buttons {
                flex-wrap: wrap;
            }
            
            .btn-custom {
                flex: 1;
                min-width: 100px;
            }
        }
    </style>
</head>
<body>
    <!-- Contenedor principal optimizado para A4 -->
    <div class="container" id="pdf-content">
        <!-- Encabezado compacto -->
        <div class="header-section">
            <div class="header-logo">
                <div class="logo-container">
                    <div class="logo-placeholder">
                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo">
                    </div>
                </div>
                <div class="header-info">
                    <h1><?php echo e(config('app.tipo_documento')); ?></h1>
                    <h2><?php echo e($orden->sucursal->nombre ?? 'Sucursal'); ?></h2>
                </div>
            </div>
            <div>
               <?php
                    // Función para formatear el número de control en PHP
                    function formatoNumeroControl($numero) {
                        // Obtener el prefijo desde la variable de entorno
                        $prefijoControl = env('PREFIJO_CONTROL', 'CZ');
                        
                        if (!$numero) return $prefijoControl . '000000';
                        
                        $numeroStr = (string) $numero;
                        
                        // Remover cualquier prefijo del inicio
                        $numeroStr = preg_replace('/^' . preg_quote($prefijoControl, '/') . '\s*/i', '', $numeroStr);
                        
                        // Dejar solo números
                        $numeroStr = preg_replace('/\D/', '', $numeroStr);
                        
                        if (!$numeroStr) $numeroStr = '0';
                        
                        // Formatear con ceros a la izquierda (6 dígitos)
                        return $prefijoControl . str_pad($numeroStr, 6, '0', STR_PAD_LEFT);
                    }
                    
                    // Formatear número de orden
                    $nroControlOriginal = $calculos['numeroOrden'] ?? $orden->id ?? '0';
                    $nroControlFormateado = formatoNumeroControl($nroControlOriginal);
                    
                    // Manejar estatus
                    $estatus = $orden->estatus ?? 'pendiente';
                    if ($estatus === '0' || $estatus === 0) {
                        $estatus = 'pendiente';
                        $estatusTexto = 'Pendiente';
                    } elseif ($estatus === '1' || $estatus === 1) {
                        $estatus = 'aprobado';
                        $estatusTexto = 'Aprobado';
                    } else {
                        $estatusTexto = ucfirst($estatus);
                    }
                    
                    // Determinar tipo de IVA
                    $tipoIVA = 'sin-iva';
                    $tipoIVATexto = 'Sin IVA';
                    if ($calculos['aplicaIVA'] && !$calculos['aplicaIvaDeduccion']) {
                        $tipoIVA = 'iva-normal';
                        $tipoIVATexto = 'IVA Normal (16%)';
                    } elseif (!$calculos['aplicaIVA'] && $calculos['aplicaIvaDeduccion']) {
                        $tipoIVA = 'iva-deduccion';
                        $tipoIVATexto = 'IVA con Deducción (75%)';
                    }
                ?>
                
                <div style="display: flex; flex-wrap: wrap; gap: 5px; justify-content: center; margin-top: 5px;">
                    <span class="nro-control-formateado"><?php echo e($nroControlFormateado); ?></span>
                    <span class="badge-status badge-<?php echo e(strtolower($estatus)); ?>"><?php echo e($estatusTexto); ?></span>
                    <span class="badge-status badge-<?php echo e($tipoIVA); ?>"><?php echo e($tipoIVATexto); ?></span>
                    <span style="background: #f8f9fa; color: #333; padding: 2px 6px; border-radius: 3px; font-size: 10px;">
                        <i class="fas fa-calendar-alt me-1"></i><?php echo e($calculos['fechaEmision']); ?>

                    </span>
                </div>
            </div>
        </div>
        
        <!-- Botones de acción -->
        <div class="action-buttons no-print">
            <button class="btn btn-custom btn-pdf" id="btn-generar-pdf">
                <i class="fas fa-file-pdf"></i> Guardar PDF
            </button>
            <button class="btn btn-custom btn-print" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimir
            </button>
            <a href="<?php echo e(route('ordenes.menu')); ?>" class="btn btn-custom btn-back">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        
        <!-- Información en dos columnas -->
        <div class="container-fluid">
            <div class="row">
                <!-- Columna izquierda: Información del proveedor -->
                <div class="col-md-6">
                    <div class="info-card">
                        <h4><i class="fas fa-truck me-2"></i> Proveedor</h4>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-building"></i> Empresa:</div>
                            <div class="info-value"><?php echo e($orden->proveedor->nombre ?? 'Proveedor'); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-id-card"></i> R.I.F.:</div>
                            <div class="info-value"><?php echo e($orden->proveedor->rif ?? 'RIF'); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-map-marker-alt"></i> Dirección:</div>
                            <div class="info-value"><?php echo e($orden->proveedor->direccion ?? 'Dirección no especificada'); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-phone"></i> Teléfono:</div>
                            <div class="info-value">
                                <?php $telefono = $orden->proveedor->telefono ?? null; ?>
                                <?php if(!empty($telefono) && strtolower($telefono) != 'nan' && $telefono != 'null'): ?>
                                    <?php echo e($telefono); ?>

                                <?php else: ?>
                                    <span class="empty-value">No especificado</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-envelope"></i> Correo:</div>
                            <div class="info-value">
                                <?php $correo = $orden->proveedor->correo ?? null; ?>
                                <?php if(!empty($correo) && strtolower($correo) != 'nan' && $correo != 'null'): ?>
                                    <?php echo e($correo); ?>

                                <?php else: ?>
                                    <span class="empty-value">No especificado</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información de pago si existe - VERSIÓN CORREGIDA -->
                    <?php if(isset($orden->bancos_info)): ?>
                        <?php
                            $hayDatosBancos = false;
                            $datosBancos = [];
                            
                            // Verificar cada campo individualmente
                            $camposBancos = ['pago_movil', 'banco_1', 'banco_2', 'titular'];
                            foreach($camposBancos as $campo) {
                                if(isset($orden->bancos_info->$campo)) {
                                    $valor = $orden->bancos_info->$campo;
                                    if(!empty($valor) && strtolower($valor) != 'nan' && $valor != 'null') {
                                        $hayDatosBancos = true;
                                        $datosBancos[$campo] = $valor;
                                    }
                                }
                            }
                        ?>
                        
                        <?php if($hayDatosBancos): ?>
                        <div class="info-card" style="border-left-color: #4169E1;">
                            <h4><i class="fas fa-university me-2"></i> Información de Pago</h4>
                            
                            <!-- Pago Móvil -->
                            <?php if(isset($datosBancos['pago_movil'])): ?>
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-mobile-alt"></i> Pago Móvil:</div>
                                <div class="info-value" style="font-size: 10px;"><?php echo e($datosBancos['pago_movil']); ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Banco 1 -->
                            <?php if(isset($datosBancos['banco_1'])): ?>
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-university"></i> Banco 1:</div>
                                <div class="info-value" style="font-size: 10px;">
                                    <?php
                                        $banco1 = trim($datosBancos['banco_1']);
                                        // Verificar si tiene pipes o formato especial
                                        if(strpos($banco1, '|') !== false) {
                                            $lineas = array_filter(explode('|', $banco1));
                                            foreach($lineas as $linea) {
                                                $lineaTrim = trim($linea);
                                                if(!empty($lineaTrim)) {
                                                    echo $lineaTrim . '<br>';
                                                }
                                            }
                                        } else {
                                            echo nl2br(e($banco1));
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Banco 2 -->
                            <?php if(isset($datosBancos['banco_2'])): ?>
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-university"></i> Banco 2:</div>
                                <div class="info-value" style="font-size: 10px;">
                                    <?php
                                        $banco2 = trim($datosBancos['banco_2']);
                                        // Verificar si tiene pipes o formato especial
                                        if(strpos($banco2, '|') !== false) {
                                            $lineas = array_filter(explode('|', $banco2));
                                            foreach($lineas as $linea) {
                                                $lineaTrim = trim($linea);
                                                if(!empty($lineaTrim)) {
                                                    echo $lineaTrim . '<br>';
                                                }
                                            }
                                        } else {
                                            echo nl2br(e($banco2));
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <!-- Titular -->
                            <?php if(isset($datosBancos['titular'])): ?>
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-user"></i> Titular:</div>
                                <div class="info-value"><?php echo e($datosBancos['titular']); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Columna derecha: Información de la sucursal -->
                <div class="col-md-6">
                    <div class="info-card">
                        <h4><i class="fas fa-store me-2"></i> Sucursal</h4>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-store"></i> Sucursal:</div>
                            <div class="info-value"><?php echo e($orden->sucursal->nombre ?? 'Sucursal'); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-map-marker-alt"></i> Dirección:</div>
                            <div class="info-value"><?php echo e($orden->sucursal->direccion ?? 'Dirección no especificada'); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-phone"></i> Teléfono:</div>
                            <div class="info-value">
                                <?php $telefonoSucursal = $orden->sucursal->telefono ?? null; ?>
                                <?php if(!empty($telefonoSucursal) && strtolower($telefonoSucursal) != 'nan' && $telefonoSucursal != 'null'): ?>
                                    <?php echo e($telefonoSucursal); ?>

                                <?php else: ?>
                                    <span class="empty-value">No especificado</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Información adicional de la orden -->
                    <div class="info-card" style="border-left-color: #28a745;">
                        <h4><i class="fas fa-info-circle me-2"></i> Información de la Orden</h4>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-boxes"></i> Productos:</div>
                            <div class="info-value"><?php echo e(count($productos)); ?> items</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-calendar"></i> Fecha:</div>
                            <div class="info-value"><?php echo e($calculos['fechaEmision']); ?></div>
                        </div>
                        <div class="info-row">
                            <div class="info-label"><i class="fas fa-hashtag"></i> N° Control:</div>
                            <div class="info-value"><span class="nro-control-formateado"><?php echo e($nroControlFormateado); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ========== SECCIÓN DE OBSERVACIONES ========== -->
            <?php if(!empty($orden->observacion)): ?>
            <div class="observaciones-card">
                <h4><i class="fas fa-sticky-note me-2"></i> Observaciones</h4>
                <div class="observaciones-content">
                    <?php echo e(nl2br(e($orden->observacion))); ?>

                </div>
            </div>
            <?php else: ?>
            <!-- Si no hay observaciones, puedes mostrar una versión mínima o omitir -->
            <div class="observaciones-card" style="opacity: 0.7; padding: 6px 10px;">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="color: #6f42c1; font-size: 11px; font-weight: 600;">
                        <i class="fas fa-sticky-note me-1"></i> Observaciones:
                    </span>
                    <span class="empty-value" style="font-size: 10px;">Sin observaciones registradas</span>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Tabla de productos COMPACTA -->
            <?php if(count($productos) > 0): ?>
            <div class="table-container">
                <h4><i class="fas fa-shopping-cart me-2"></i> Productos (<?php echo e(count($productos)); ?>)</h4>
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="12%" class="text-center">Cantidad</th>
                                <th width="10%" class="text-center">Unidad</th>
                                <th width="43%">Producto</th>
                                <th width="15%" class="text-end">Precio Unit.</th>
                                <th width="15%" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                 
                        <tbody id="productos-tbody">
                            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="text-center"><?php echo e($index + 1); ?></td>
                                <td class="text-center">
                                    <span style="background: #8a0a27; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">
                                       <?php echo e(number_format($producto->cantidad, 2, ',', '.')); ?>

                                    </span>
                                </td>
                                <td class="text-center">
                                    <span style="background: #1E90FF; color: white; padding: 2px 6px; border-radius: 3px; font-size: 10px;">
                                        <?php echo e($producto->unidad_abreviatura ?? 'UND'); ?>

                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 10px; line-height: 1.3;">
                                        <strong><?php echo e($producto->producto_nombre ?? 'Producto'); ?></strong>
                                        <?php if($producto->producto_id ?? false): ?>
                                            <br><span style="color: #6c757d; font-size: 9px;">ID: <?php echo e($producto->producto_id); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="precio-unitario" data-precio="<?php echo e($producto->precio); ?>">
                                        $ <?php echo e(number_format($producto->precio, 4, ',', '.')); ?>

                                    </span>
                                </td>
                                <td class="text-end">
                                    <span class="subtotal-producto" data-subtotal="<?php echo e($producto->subtotal); ?>">
                                        $ <?php echo e(number_format($producto->subtotal, 4, ',', '.')); ?>

                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Totales COMPACTOS -->
            <div class="totals-card">
                <h4><i class="fas fa-calculator me-2"></i> Resumen de Totales</h4>
                
                <!-- Total General -->
                <div class="total-row">
                    <span>TOTAL GENERAL</span>
                    <span id="total-general">
                        $ 0,00
                        <span class="bs-conversion">(Bs. 0,00)</span>
                    </span>
                </div>
                
                <!-- IVA Normal (16%) -->
                <div id="iva-normal-section" style="display: none;">
                    <div class="total-row">
                        <span>IVA (16%)</span>
                        <span id="iva-normal">
                            $ 0,00
                            <span class="bs-conversion">(Bs. 0,00)</span>
                        </span>
                    </div>
                    
                    <div class="total-row highlight">
                        <span>TOTAL CON IVA</span>
                        <span id="total-con-iva-normal">
                            $ 0,00
                            <span class="bs-conversion">(Bs. 0,00)</span>
                        </span>
                    </div>
                </div>
                
                <!-- IVA con Deducción -->
                <div id="iva-deduccion-section" style="display: none;">
                    <div class="total-row">
                        <span>IVA (16%)</span>
                        <span id="iva-calculado">
                            $ 0,00
                            <span class="bs-conversion">(Bs. 0,00)</span>
                        </span>
                    </div>
                    
                    <div class="total-row" style="color: #dc3545; font-style: italic;">
                        <span>DEDUCCIÓN (75%)</span>
                        <span id="deduccion-iva">
                            - $ 0,00
                            <span class="bs-conversion">(Bs. 0,00)</span>
                        </span>
                    </div>
                    
                    <div class="total-row" style="color: #28a745;">
                        <span>AHORRO</span>
                        <span id="ahorro-deduccion">
                            $ 0,00
                            <span class="bs-conversion">(Bs. 0,00)</span>
                        </span>
                    </div>
                    
                    
                </div>
                
                <!-- Total Final -->
                <div class="total-row highlight">
                    <span>TOTAL FINAL</span>
                    <span id="total-final">
                        $ 0,00
                        <span class="bs-conversion fw-bold">(Bs. 0,00)</span>
                    </span>
                </div>
                
                <!-- Nota de tasa con 4 decimales -->
                <div style="text-align: center; margin-top: 8px;">
                    <small id="tasa-info" style="color: #6c757d; font-size: 9px;">
                        <i class="fas fa-info-circle me-1"></i>
                        Tasa de cambio: Bs. 0,0000 por $
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Pie de página COMPACTO -->
        <div class="footer-section">
            <p style="margin-bottom: 5px;">
                <i class="fas fa-lock me-1"></i>
                Documento generado por el Sistema de Órdenes de Compra
            </p>
            <p style="margin-bottom: 5px; font-size: 9px;">
                <i class="fas fa-calendar-alt me-1"></i>
                Generado el <?php echo e(now()->format('d/m/Y H:i')); ?> | 
                <i class="fas fa-user me-1"></i>
                Usuario: <?php echo e($orden->usuario->name ?? 'Sistema'); ?>

            </p>
            <p style="font-size: 8px; color: #999;">
                <i class="fas fa-info-circle me-1"></i>
                Documento oficial - N° Control: <span class="nro-control-formateado"><?php echo e($nroControlFormateado); ?></span> | 
                <span id="tasa-footer">Tasa: Bs. 0,0000</span>
            </p>
        </div>
    </div>
    
    
    
    <style>

    /* Para asegurar que solo afecte a los dólares (primer span) */
#total-final > span:first-of-type {
    color: #6c757d !important;
    font-size: 10px !important;
    opacity: 0.8 !important;
    order: 2; /* Si usas flex, ponerlo abajo */
}

/* Para asegurar que solo afecte a los bolívares (.bs-conversion) */
#total-final > span.bs-conversion {
    color: #DC143C !important;
    font-size: 14px !important;
    font-weight: bold !important;
    order: 1; /* Si usas flex, ponerlo arriba */
}

/* Contenedor flex para ordenarlos */
#total-final {
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-end !important;
}
    </style>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
// =========================================================================
// FUNCIONES SIN REDONDEO - DECIMALES EXACTOS CON FORMATO ESPAÑOL
// =========================================================================

// Convertir número con formato español (1.234,56) a número decimal
// =========================================================================
// FUNCIONES SIN REDONDEO - DECIMALES EXACTOS CON FORMATO ESPAÑOL
// =========================================================================

// Convertir número con formato español (1.234,56) a número decimal
function parseNumberES(value) {
    if (typeof value === 'number') return value;
    if (!value) return 0;
    
    let cleanValue = String(value).trim();
    
    if (cleanValue.includes(',')) {
        cleanValue = cleanValue.replace(/\.(?=\d{3})/g, '');
        cleanValue = cleanValue.replace(',', '.');
    }
    else if (cleanValue.includes('.')) {
        cleanValue = cleanValue.replace(/,/g, '');
    }
    
    const result = parseFloat(cleanValue);
    return isNaN(result) ? 0 : result;
}

// Formatear número MOSTRANDO DECIMALES EXACTOS (truncar sin redondear)
function formatNumberCliente(value, decimals = 4) {
    if (value == null || isNaN(value)) {
        return '0' + (decimals > 0 ? ',' + '0'.repeat(decimals) : '');
    }
    
    // Convertir a string para ver decimales reales
    let valueStr = value.toString();
    
    // Si tiene notación científica, convertirla
    if (valueStr.includes('e')) {
        valueStr = value.toFixed(20).replace(/0+$/, '').replace(/\.$/, '');
    }
    
    // Separar parte entera y decimal
    let [entero, decimal = ''] = valueStr.split('.');
    
    // Tomar exactamente 'decimals' sin redondear (truncar)
    decimal = decimal.substring(0, decimals).padEnd(decimals, '0');
    
    // Formato con puntos para miles en la parte entera
    entero = entero.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
    // Juntar con coma decimal
    return decimals > 0 ? `${entero},${decimal}` : entero;
}

// Formatear número con 4 decimales (para tasa y dólares)
function formatNumber4DecimalsCliente(value) {
    return formatNumberCliente(value, 4);
}

// Formatear número con 2 decimales (para bolívares)
function formatNumber2DecimalsCliente(value) {
    return formatNumberCliente(value, 2);
}

// Calcular total general SIN REDONDEO
function calcularTotalGeneral() {
    let total = 0;
    const subtotalElements = document.querySelectorAll('.subtotal-producto');
    
    subtotalElements.forEach(element => {
        const subtotal = parseNumberES(element.dataset.subtotal);
        total += subtotal; // Suma exacta
    });
    
    return total; // SIN REDONDEO
}

// Calcular IVA normal (16%) SIN REDONDEO
function calcularIVANormal(totalGeneral) {
    return totalGeneral * 0.16; // Cálculo exacto
}

// Calcular total con IVA normal SIN REDONDEO
function calcularTotalConIVANormal(totalGeneral, ivaNormal) {
    return totalGeneral + ivaNormal; // Suma exacta
}

// Calcular IVA con deducción SIN REDONDEO
function calcularIVADeduccion(totalGeneral) {
    const ivaCalculado = totalGeneral * 0.16;
    const deduccion = ivaCalculado * 0.75;
    const ahorro = deduccion;
    const totalConDeduccion = totalGeneral + ivaCalculado - deduccion;
    
    return {
        ivaCalculado: ivaCalculado,
        deduccion: deduccion,
        ahorro: ahorro,
        totalConDeduccion: totalConDeduccion
    };
}

// Mostrar valores formateados SIN REDONDEO
function mostrarValorFormateadoCliente(elementId, valorDolares, tasa, prefix = '$ ', decimals = 4) {
    const elemento = document.getElementById(elementId);
    if (!elemento) return;
    
    // Formatear dólares con los decimales especificados
    const valorDolaresFormateado = formatNumberCliente(valorDolares, decimals);
    
    // Extraer valor numérico limpio para cálculo (quitar puntos, reemplazar coma por punto)
    const valorDolaresLimpio = parseFloat(
        valorDolaresFormateado.replace(/\./g, '').replace(',', '.')
    );
    
    // Calcular valor en bolívares usando el valor formateado/truncado
    const valorBs = valorDolaresLimpio * tasa;
    
    // Formatear bolívares (2 decimales para bolívares)
    const valorBsFormateado = formatNumber2DecimalsCliente(valorBs);
    
    elemento.innerHTML = `
        ${prefix}${valorDolaresFormateado}
        <span class="bs-conversion">(Bs. ${valorBsFormateado})</span>
    `;
}

// Mostrar valores negativos formateados SIN REDONDEO
function mostrarValorNegativoFormateadoCliente(elementId, valorDolares, tasa) {
    const elemento = document.getElementById(elementId);
    if (!elemento) return;
    
    // Formatear dólares a 4 decimales para truncar
    const valorAbsoluteFormateado = formatNumberCliente(Math.abs(valorDolares), 4)
        .replace(/\./g, '')
        .replace(',', '.');
    const valorAbsoluteParaCalculo = parseFloat(valorAbsoluteFormateado);
    
    const valorBs = valorAbsoluteParaCalculo * tasa;
    
    elemento.innerHTML = `
        - $ ${formatNumberCliente(Math.abs(valorDolares), 4)}
        <span class="bs-conversion">(Bs. ${formatNumber2DecimalsCliente(valorBs)})</span>
    `;
}

// Configuración desde PHP
document.addEventListener('DOMContentLoaded', function() {
    // Obtener configuración desde PHP
    const config = {
        aplicaIVA: <?php echo json_encode($calculos['aplicaIVA'] ?? false, 15, 512) ?>,
        aplicaIvaDeduccion: <?php echo json_encode($calculos['aplicaIvaDeduccion'] ?? false, 15, 512) ?>,
        tasa: parseNumberES(<?php echo json_encode($calculos['tasa'] ?? '0', 15, 512) ?>),
        totalGeneral: <?php echo json_encode($orden->totalGeneral ?? 0, 15, 512) ?>
    };
     // Pasar el tipo de documento desde el backend
    const tipoDocumento = <?php echo json_encode(config('app.tipo_documento', 'Orden de Compra'), 512) ?>;
    
    // Actualizar título
    document.title = `${tipoDocumento} <?php echo e($nroControlFormateado); ?>`;
    
    
    // Calcular valores SIN REDONDEO
    const totalGeneral = calcularTotalGeneral();
    const tasa = config.tasa; // Tasa exacta
    
    // DEBUG: Mostrar valores exactos
    console.log("=== VALORES EXACTOS ===");
    console.log("Total General:", totalGeneral);
    console.log("IVA (16%):", totalGeneral * 0.16);
    console.log("Tasa:", tasa);
    
    // Mostrar tasa de cambio
    const tasaFormateada = formatNumber4DecimalsCliente(tasa);
    document.getElementById('tasa-info').innerHTML = `
        <i class="fas fa-info-circle me-1"></i>
        Tasa de cambio: Bs. ${tasaFormateada} por $
    `;
    document.getElementById('tasa-footer').textContent = `Tasa: Bs. ${tasaFormateada}`;
    
    // Mostrar total general con 4 decimales
    mostrarValorFormateadoCliente('total-general', totalGeneral, tasa, '$ ', 4);
    
    let totalFinal = totalGeneral;
    
    // Mostrar secciones según tipo de IVA
    if (config.aplicaIVA && !config.aplicaIvaDeduccion) {
        // IVA Normal
        document.getElementById('iva-normal-section').style.display = 'block';
        document.getElementById('iva-deduccion-section').style.display = 'none';
        
        const ivaNormal = calcularIVANormal(totalGeneral);
        const totalConIvaNormal = calcularTotalConIVANormal(totalGeneral, ivaNormal);
        totalFinal = totalConIvaNormal;
        
        console.log("IVA Normal exacto:", ivaNormal);
        console.log("Total con IVA exacto:", totalConIvaNormal);
        
        mostrarValorFormateadoCliente('iva-normal', ivaNormal, tasa, '$ ', 4);
        mostrarValorFormateadoCliente('total-con-iva-normal', totalConIvaNormal, tasa, '$ ', 4);
        
    } else if (!config.aplicaIVA && config.aplicaIvaDeduccion) {
        // IVA con Deducción
        document.getElementById('iva-normal-section').style.display = 'none';
        document.getElementById('iva-deduccion-section').style.display = 'block';
        
        const calculosDeduccion = calcularIVADeduccion(totalGeneral);
        totalFinal = calculosDeduccion.totalConDeduccion;
        
        mostrarValorFormateadoCliente('iva-calculado', calculosDeduccion.ivaCalculado, tasa, '$ ', 4);
        mostrarValorNegativoFormateadoCliente('deduccion-iva', calculosDeduccion.deduccion, tasa);
        mostrarValorFormateadoCliente('ahorro-deduccion', calculosDeduccion.ahorro, tasa, '$ ', 4);
        mostrarValorFormateadoCliente('total-con-iva-deduccion', calculosDeduccion.totalConDeduccion, tasa, '$ ', 4);
        
    } else {
        // Sin IVA
        document.getElementById('iva-normal-section').style.display = 'none';
        document.getElementById('iva-deduccion-section').style.display = 'none';
    }
    
    // Mostrar total final con 4 decimales
    mostrarValorFormateadoCliente('total-final', totalFinal, tasa, '$ ', 4);
    
    // =========================================================================
    // FUNCIONALIDAD PDF E IMPRESIÓN
    // =========================================================================
    
    // Generar PDF
    document.getElementById('btn-generar-pdf').addEventListener('click', function() {
        generarPDF();
    });
    
    function generarPDF() {
        const btn = document.getElementById('btn-generar-pdf');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generando...';
        btn.disabled = true;
        
        const element = document.getElementById('pdf-content');
        
        const opt = {
            margin: [0.3, 0.3, 0.3, 0.3],
            filename: 'Orden_Compra_<?php echo e($nroControlFormateado); ?>.pdf',
            image: { type: 'jpeg', quality: 0.95 },
            html2canvas: { 
                scale: 2,
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff',
                width: element.scrollWidth,
                height: element.scrollHeight
            },
            jsPDF: { 
                unit: 'cm', 
                format: 'a4',
                orientation: 'portrait'
            },
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
        };
        
        html2pdf().set(opt).from(element).save().then(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }).catch(err => {
            console.error('Error:', err);
            btn.innerHTML = originalText;
            btn.disabled = false;
            alert('Error al generar PDF. Use la opción de imprimir.');
        });
    }
    
    // Preparar para impresión
    function prepararParaImprimir() {
        document.querySelectorAll('.container, .container-fluid, .table-responsive').forEach(el => {
            el.style.overflow = 'visible';
            el.style.height = 'auto';
        });
    }
    
    window.addEventListener('beforeprint', prepararParaImprimir);
});
</script>
</body>
</html><?php /**PATH /var/www/html/resources/views/plantilla/orden.blade.php ENDPATH**/ ?>