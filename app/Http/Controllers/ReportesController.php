<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdenCompra;
use Carbon\Carbon;
use App\Models\Reportes;

class ReportesController extends Controller
{
    public function generarReporte()
    {
        $totalOrdenes = OrdenCompra::count();
        $ordenesHoy = OrdenCompra::whereDate('created_at', Carbon::today())->count();
        
        return view('reportes.menu', compact('totalOrdenes', 'ordenesHoy'));
    }

    public function ordenesHoy()
    {
        $ordenes = Reportes::obtenerOrdenesHoy();
        $titulo = "Órdenes de Compra - Hoy (" . date('d/m/Y') . ")";
        
        return view('reportes.ordenes-hoy', compact('ordenes', 'titulo'));
    }
    
    public function ordenesPorFechaForm()
    {
        $fechaHoy = Carbon::now()->format('Y-m-d');
        $fechaAyer = Carbon::yesterday()->format('Y-m-d');
        
        return view('reportes.buscar-fechas', compact('fechaHoy', 'fechaAyer'));
    }
    
    public function ordenesPorFecha(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:todas,aprobadas,pendientes'
        ]);
        
        $fechaInicio = $request->fecha_inicio;
        $fechaFin = $request->fecha_fin;
        $estado = $request->estado;
        
        // Determinar el estatus a filtrar
        switch ($estado) {
            case 'aprobadas':
                $estatus = 1;
                $textoEstado = 'Aprobadas';
                break;
            case 'pendientes':
                $estatus = 0;
                $textoEstado = 'Pendientes';
                break;
            case 'todas':
            default:
                $estatus = null;
                $textoEstado = 'Todas';
                break;
        }
        
        $ordenes = Reportes::obtenerOrdenesPorFecha($fechaInicio, $fechaFin, $estatus);
        
        $titulo = "Órdenes de Compra " . $textoEstado . " del " . 
                 Carbon::parse($fechaInicio)->format('d/m/Y') . " al " . 
                 Carbon::parse($fechaFin)->format('d/m/Y');
        
        // Pasar las variables adicionales necesarias
        $totalOrdenes = $ordenes->count();
        $totalMontoBs = $ordenes->sum('Monto_en_Bs');
        $totalMontoDolares = $ordenes->sum('Monto_en_dolares');
        $tasaPromedio = $ordenes->avg('Tasa_usada') ?: 0;
        
        return view('reportes.ordenes-fechas', compact(
            'ordenes', 
            'titulo', 
            'fechaInicio', 
            'fechaFin', 
            'estado',
            'totalOrdenes',
            'totalMontoBs',
            'totalMontoDolares',
            'tasaPromedio'
        ));
    }
    
    // MÉTODO PARA EXPORTAR EXCEL (corregido)
 public function exportarExcel(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date',
        'estado' => 'required|in:todas,aprobadas,pendientes'
    ]);
    
    $fechaInicio = $request->fecha_inicio;
    $fechaFin = $request->fecha_fin;
    $estado = $request->estado;
    
    // Determinar el estatus a filtrar
    switch ($estado) {
        case 'aprobadas':
            $estatus = 1;
            $textoEstado = 'Aprobadas';
            break;
        case 'pendientes':
            $estatus = 0;
            $textoEstado = 'Pendientes';
            break;
        case 'todas':
        default:
            $estatus = null;
            $textoEstado = 'Todas';
            break;
    }
    
    $ordenes = Reportes::obtenerOrdenesPorFecha($fechaInicio, $fechaFin, $estatus);
    
    // Nombre del archivo
    $filename = 'MISUPER_Ordenes_' . 
                Carbon::parse($fechaInicio)->format('Ymd') . '_al_' . 
                Carbon::parse($fechaFin)->format('Ymd') . '_' . 
                strtolower(str_replace(' ', '_', $textoEstado)) . '.xls';
    
    // Configurar headers para descarga
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Transfer-Encoding: binary");
    header("Cache-Control: max-age=0");
    
    // Inicio del documento HTML para Excel
    echo '<html>';
    echo '<head>';
    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
    echo '<title>MISUPER - Reporte de Órdenes</title>';
    echo '<style>';
    echo 'body { font-family: Arial, sans-serif; font-size: 11px; }';
    echo 'table { border-collapse: collapse; width: 100%; }';
    echo 'th { background-color: #8a0a27; color: white; font-weight: bold; padding: 8px; border: 1px solid #ddd; text-align: left; }';
    echo 'td { padding: 6px; border: 1px solid #ddd; vertical-align: top; }';
    echo '.header { background-color: #f2f2f2; padding: 15px; margin-bottom: 20px; border: 1px solid #ddd; }';
    echo '.totals { font-weight: bold; background-color: #f8f9fa; }';
    echo '.text-right { text-align: right; }';
    echo '.text-center { text-align: center; }';
    echo '.text-left { text-align: left; }';
    echo '.text-bold { font-weight: bold; }';
    echo '.bg-gray { background-color: #f9f9f9; }';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    
    // Encabezado del reporte
    echo '<div class="header">';
    echo '<h2 style="color: #8a0a27; margin: 0 0 10px 0;">MISUPER - REPORTE DE ÓRDENES DE COMPRA</h2>';
    echo '<p><strong>Período:</strong> ' . Carbon::parse($fechaInicio)->format('d/m/Y') . ' al ' . Carbon::parse($fechaFin)->format('d/m/Y') . '</p>';
    echo '<p><strong>Estado:</strong> ' . $textoEstado . '</p>';
    echo '<p><strong>Total registros:</strong> ' . $ordenes->count() . '</p>';
    echo '<p><strong>Total Bs:</strong> ' . number_format($ordenes->sum('Monto_en_Bs'), 2, ',', '.') . ' | ';
    echo '<strong>Total $:</strong> $' . number_format($ordenes->sum('Monto_en_dolares'), 2, ',', '.') . '</p>';
    echo '<p><strong>Fecha de generación:</strong> ' . now()->format('d/m/Y H:i:s') . '</p>';
    echo '</div>';
    
    // Tabla de datos
    echo '<table>';
    
    // Encabezados de columnas - ACTUALIZADO con código de factura
    echo '<thead>';
    echo '<tr>';
    echo '<th>Fecha Creación</th>';
    echo '<th>Correlativo</th>';
    echo '<th>Código Factura</th>';  // NUEVA COLUMNA
    echo '<th>Beneficiario</th>';
    echo '<th>Proveedor</th>';
    echo '<th class="text-right">Monto Bs</th>';
    echo '<th class="text-right">Monto $</th>';
    echo '<th class="text-center">Tasa</th>';
    echo '<th>Responsable</th>';
    echo '<th>Método de Pago</th>';
    echo '<th>Referencia</th>';
    echo '<th class="text-center">Estado</th>';
    echo '</tr>';
    echo '</thead>';
    
    echo '<tbody>';
    
    foreach ($ordenes as $orden) {
        // CORRECCIÓN: Formatear correlativo CORRECTAMENTE
        $correlativo = $this->formatearCorrelativo($orden->Correlativo);
        
        $estadoTexto = $orden->Estatus == 1 ? 'Aprobada' : 'Pendiente';
        $estadoColor = $orden->Estatus == 1 ? '#28a745' : '#ffc107';
        
        // Formatear referencia - si es null, vacío o 0, mostrar "No aplica"
        $referencia = $orden->Referencia;
        if ($referencia === null || $referencia === '' || $referencia === '0' || trim($referencia) === '') {
            $referencia = 'No aplica';
        }
        
        // Formatear código de factura - si es null o vacío
        $codigoFactura = $orden->codigo_Factura ?? null;
        if ($codigoFactura === null || $codigoFactura === '' || trim($codigoFactura) === '') {
            $codigoFactura = 'Sin factura';
        }
        
        echo '<tr>';
        echo '<td>' . Carbon::parse($orden->Fecha)->format('d/m/Y H:i') . '</td>';
        echo '<td>' . $correlativo . '</td>';
        echo '<td>' . htmlspecialchars($codigoFactura, ENT_QUOTES, 'UTF-8') . '</td>';  // NUEVA COLUMNA
        echo '<td>' . htmlspecialchars($orden->Beneficiario, ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td>' . htmlspecialchars($orden->PROVEEDORES, ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td class="text-right">' . number_format($orden->Monto_en_Bs, 2, ',', '.') . '</td>';
        echo '<td class="text-right">$' . number_format($orden->Monto_en_dolares, 2, ',', '.') . '</td>';
        echo '<td class="text-center">' . number_format($orden->Tasa_usada, 2, ',', '.') . '</td>';
        echo '<td>' . htmlspecialchars($orden->Responsable, ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td class="text-left">' . htmlspecialchars($orden->Metodo_de_pago ?? 'No especificado', ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td class="text-left">' . htmlspecialchars($referencia, ENT_QUOTES, 'UTF-8') . '</td>';
        echo '<td class="text-center" style="color: ' . $estadoColor . '; font-weight: bold;">' . $estadoTexto . '</td>';
        echo '</tr>';
    }
    
    // Línea de totales - ACTUALIZADO
    echo '<tr class="totals">';
    echo '<td colspan="5" class="text-right text-bold">TOTALES:</td>';  // Cambiado de 4 a 5
    echo '<td class="text-right text-bold">' . number_format($ordenes->sum('Monto_en_Bs'), 2, ',', '.') . '</td>';
    echo '<td class="text-right text-bold">$' . number_format($ordenes->sum('Monto_en_dolares'), 2, ',', '.') . '</td>';
    echo '<td colspan="5"></td>';  // Ajustado para cubrir las columnas restantes
    echo '</tr>';
    
    echo '</tbody>';
    echo '</table>';
    
    // Pie de página
    echo '<div style="margin-top: 20px; padding: 10px; border-top: 1px solid #ddd; font-size: 10px; color: #666;">';
    echo '<p><em>Documento generado por MISUPER - Sistema de Órdenes de Compra</em></p>';
    echo '<p><em>Impreso el ' . now()->format('d/m/Y H:i:s') . '</em></p>';
    echo '</div>';
    
    echo '</body>';
    echo '</html>';
    
    // IMPORTANTE: Terminar ejecución correctamente
    exit();
}
    
    // FUNCIÓN AUXILIAR: Formatear correlativo correctamente
    private function formatearCorrelativo($numero)
    {
        if (empty($numero)) {
            return 'CZ000000';
        }
        
        // Si ya empieza con CZ, extraer solo los números
        if (strpos($numero, 'CZ') === 0) {
            $numero = substr($numero, 2);
        }
        
        // Extraer solo números
        $soloNumeros = preg_replace('/[^0-9]/', '', $numero);
        
        // Si no hay números, retornar CZ000000
        if (empty($soloNumeros)) {
            return 'CZ000000';
        }
        
        // Formatear a 6 dígitos con ceros a la izquierda
        $numeroFormateado = str_pad($soloNumeros, 6, '0', STR_PAD_LEFT);
        
        return 'CZ' . $numeroFormateado;
    }
}