<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\OrdenCompra;
use App\Models\Proveedor;
use App\Models\Sucursal;
use App\Models\Unidad;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;

class PDFController extends Controller
{
    public function generarOrdenPDF($ordenId)
    {
        try {
            // Obtener la orden con todas las relaciones
            $orden = OrdenCompra::with([
                'sucursal',
                'producto',
                'proveedor',
                'unidad',
                'usuario' // Asumiendo que tienes relación con usuario
            ])->find($ordenId);

            if (!$orden) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden no encontrada'
                ], 404);
            }

            // Obtener productos adicionales (si los guardaste en otra tabla)
            // Esto depende de cómo estés almacenando múltiples productos
            $productosOrden = DB::table('productos_orden')
                ->where('orden_id', $ordenId)
                ->get();

            // Calcular totales
            $subtotal = $orden->totalGeneral;
            $iva = $orden->iva;
            $totalUSD = $subtotal + $iva;
            $totalBS = $orden->totalbs;

            // Formatear fechas
            $fechaEmision = date('d/m/Y', strtotime($orden->fecha_orden));

            $data = [
                'orden' => $orden,
                'productos' => $productosOrden,
                'subtotal' => number_format($subtotal, 2, ',', '.'),
                'iva' => number_format($iva, 2, ',', '.'),
                'totalUSD' => number_format($totalUSD, 2, ',', '.'),
                'totalBS' => number_format($totalBS, 2, ',', '.'),
                'tasa' => number_format($orden->tasa_dia, 5, ',', '.'),
                'fechaEmision' => $fechaEmision,
                'numeroOrden' => 'CZ-' . str_pad($orden->id, 3, '0', STR_PAD_LEFT),
            ];

            // Generar PDF
            $pdf = Pdf::loadView('plantilla.orden', $data);
            
            // Opciones del PDF
            $pdf->setPaper('A4', 'portrait');
            
            // Devolver el PDF para descarga
            return $pdf->download('orden-compra-' . $orden->id . '.pdf');
            
        } catch (\Exception $e) {
            \Log::error('Error generando PDF: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    // Vista previa del PDF
    public function vistaPreviaPDF($ordenId)
    {
        // Similar al método anterior pero con stream en lugar de download
        $orden = OrdenCompra::with(['sucursal', 'producto', 'proveedor', 'unidad'])->find($ordenId);
        
        if (!$orden) {
            abort(404);
        }

        $data = [
            'orden' => $orden,
            'productos' => DB::table('productos_orden')->where('orden_id', $ordenId)->get(),
            'fechaEmision' => date('d/m/Y', strtotime($orden->fecha_orden)),
            'numeroOrden' => 'CZ-' . str_pad($orden->id, 3, '0', STR_PAD_LEFT),
        ];

        $pdf = Pdf::loadView('plantilla.orden', $data);
        return $pdf->stream('orden-compra-' . $orden->id . '.pdf');
    }
}