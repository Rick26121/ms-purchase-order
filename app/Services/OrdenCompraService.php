<?php

namespace App\Services;

use App\Models\OrdenCompra;
use App\Models\DetalleOrden;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrdenCompraService
{
    public function crearOrden(array $datos)
    {
        try {
            DB::beginTransaction();

            $orden = OrdenCompra::create([
                'sucursal' => $datos['id_sucursal'],
                'proveedores' => $datos['proveedor_id'],
                'totalGeneral' => 0,
                'tasa_dia' => $datos['tasa'],
                'moneda' => $datos['moneda'],
                'iva' => $datos['aplicarIva'],
                'totalbs' => 0,
                'usuario' => Auth::id(),
                'fecha_orden' => $datos['fecha'],
                'estatus' => 'pendiente',
                'visible' => true
            ]);

            DB::commit();
            Log::info("Orden creada exitosamente ID: {$orden->id}");

            return $orden;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear orden: ' . $e->getMessage());
            throw $e;
        }
    }

    public function agregarProducto(int $ordenId, array $productoData)
    {
        try {
            DB::beginTransaction();

            $orden = OrdenCompra::activas()->porEstatus('pendiente')->findOrFail($ordenId);

            // Buscar o crear producto
            $producto = Producto::firstOrCreate(
                ['nombre' => $productoData['producto']],
                ['precio' => $productoData['precio']]
            );

            // Crear detalle
            $detalle = DetalleOrden::create([
                'ordenes' => $ordenId,
                'producto' => $producto->id,
                'unidad' => $productoData['id_unidad'],
                'cantidad' => $productoData['cantidad'],
                'precio' => $productoData['precio']
            ]);

            // Recalcular orden
            $this->recalcularOrden($orden);

            DB::commit();
            
            return [
                'orden' => $orden,
                'detalle' => $detalle,
                'producto' => $producto
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al agregar producto: ' . $e->getMessage());
            throw $e;
        }
    }

    public function crearOrdenCompleta(array $datos)
    {
        try {
            DB::beginTransaction();

            // Crear orden
            $orden = $this->crearOrden($datos);

            // Procesar productos
            $totalGeneral = 0;
            
            foreach ($datos['productos'] as $productoData) {
                $resultado = $this->agregarProducto($orden->id, $productoData);
                $detalle = $resultado['detalle'];
                $totalGeneral += $detalle->calcularSubtotal();
            }

            // Calcular totales finales
            $totales = $orden->calcularTotales();
            
            $orden->update([
                'totalGeneral' => $totales['total_general'],
                'totalbs' => $totales['total_bs']
            ]);

            DB::commit();

            return [
                'orden' => $orden->fresh(),
                'totales' => $totales,
                'productos_count' => count($datos['productos'])
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear orden completa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function obtenerOrdenCompleta(int $ordenId)
    {
        try {
            $orden = OrdenCompra::activas()
                ->conRelaciones()
                ->with(['proveedor.bancos'])
                ->findOrFail($ordenId);

            $totales = $orden->calcularTotales();

            return [
                'orden' => $orden,
                'totales' => $totales,
                'detalles' => $orden->detalles->map(function($detalle) {
                    return [
                        'detalle' => $detalle,
                        'subtotal' => $detalle->calcularSubtotal(),
                        'producto' => $detalle->producto,
                        'unidad' => $detalle->unidad
                    ];
                })
            ];

        } catch (\Exception $e) {
            Log::error('Error al obtener orden completa: ' . $e->getMessage());
            throw $e;
        }
    }

    public function eliminarProducto(int $ordenId, int $detalleId)
    {
        try {
            DB::beginTransaction();

            $detalle = DetalleOrden::where('ordenes', $ordenId)->findOrFail($detalleId);
            $detalle->delete();

            $orden = OrdenCompra::findOrFail($ordenId);
            $this->recalcularOrden($orden);

            DB::commit();

            return $orden;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar producto: ' . $e->getMessage());
            throw $e;
        }
    }

    public function cambiarEstatusOrden(int $ordenId, string $estatus)
    {
        try {
            $orden = OrdenCompra::activas()->findOrFail($ordenId);
            $orden->cambiarEstatus($estatus);

            return $orden;

        } catch (\Exception $e) {
            Log::error('Error al cambiar estatus: ' . $e->getMessage());
            throw $e;
        }
    }

    private function recalcularOrden(OrdenCompra $orden)
    {
        $totales = $orden->calcularTotales();
        
        $orden->update([
            'totalGeneral' => $totales['total_general'],
            'totalbs' => $totales['total_bs']
        ]);

        return $orden;
    }

    public function buscarOrdenes(array $filtros = [])
    {
        $query = OrdenCompra::activas()
            ->conRelaciones()
            ->orderBy('id', 'desc');

        if (!empty($filtros['estatus'])) {
            $query->where('estatus', $filtros['estatus']);
        }

        if (!empty($filtros['proveedor_id'])) {
            $query->where('proveedores', $filtros['proveedor_id']);
        }

        if (!empty($filtros['sucursal_id'])) {
            $query->where('sucursal', $filtros['sucursal_id']);
        }

        if (!empty($filtros['fecha_desde'])) {
            $query->whereDate('fecha_orden', '>=', $filtros['fecha_desde']);
        }

        if (!empty($filtros['fecha_hasta'])) {
            $query->whereDate('fecha_orden', '<=', $filtros['fecha_hasta']);
        }

        return $query->paginate($filtros['per_page'] ?? 15);
    }
}