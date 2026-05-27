<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Reportes extends Model
{
    protected $table = 'ordenes_compras';
    
    /**
     * Obtener órdenes de compra creadas hoy
     */
    public static function obtenerOrdenesHoy()
    {
        return DB::table('ordenes_compras as oc')
            ->select(
                'oc.created_at as Fecha',
                'oc.id as Correlativo',
                'suc.nombre as Beneficiario',
                'pr.nombre as PROVEEDORES',
                'oc.totalbs as Monto_en_Bs',
                'oc.totalGeneral as Monto_en_dolares',
                'oc.tasa_dia AS Tasa_usada',
                're.nombre as Responsable',
                'oc.estatus as Estatus',
                'f.fecha_factura as Fecha_Factura',
                'f.n_referencia as Referencia',
                'f.numero As codigo_Factura',
                'mp.nombre as Metodo_de_pago'

            )
            ->join('sucursales as suc', 'oc.sucursal', '=', 'suc.id')
            ->join('proveedores as pr', 'oc.proveedores', '=', 'pr.id_proveedor')
            ->join('responsable as re', 'oc.responsable', '=', 're.id')
            ->join('factura as f', 'oc.id', '=', 'f.orden_compra')
            ->join('metodopago as mp', 'f.metodo', '=', 'mp.id')
            ->where('oc.visible', '!=', 0) // <-- Añadido
            ->whereDate('f.fecha_factura', now()->toDateString())
            ->orderBy('f.fecha_factura', 'desc')
            ->get();
    }
    
    /**
     * Obtener órdenes de compra por rango de fechas
     * $estatus: null = todas, 1 = aprobadas, 0 = pendientes
     */
    public static function obtenerOrdenesPorFecha($fechaInicio = null, $fechaFin = null, $estatus = null)
{
    $query = DB::table('ordenes_compras as oc')
        ->select(
            'oc.created_at as Fecha',
            'oc.id as Correlativo',
            'suc.nombre as Beneficiario',
            'pr.nombre as PROVEEDORES',
            'oc.totalbs as Monto_en_Bs',
            'oc.totalGeneral as Monto_en_dolares',
            'oc.tasa_dia AS Tasa_usada',
            're.nombre as Responsable',
            'oc.estatus as Estatus',
            'f.fecha_factura as Fecha_Factura',
            'mp.nombre as Metodo_de_pago',
            'f.n_referencia as Referencia',
            'f.numero As codigo_Factura'
        )
        ->join('sucursales as suc', 'oc.sucursal', '=', 'suc.id')
        ->join('proveedores as pr', 'oc.proveedores', '=', 'pr.id_proveedor')
        ->join('responsable as re', 'oc.responsable', '=', 're.id')
        ->leftJoin('factura as f', 'oc.id', '=', 'f.orden_compra')
        ->join('metodopago as mp', 'f.metodo', '=', 'mp.id')
        ->where('oc.visible', '!=', 0)
        ->whereNotNull('f.id'); // Filtrar solo órdenes que tengan factura
    
    // Filtrar por fechas si se proporcionan
    if ($fechaInicio)
    {
        $query->whereDate('f.fecha_factura', '>=', $fechaInicio);
    }
    
    if ($fechaFin)
    {
        $query->whereDate('f.fecha_factura', '<=', $fechaFin);
    }
    
    // Filtrar por estatus si se proporciona
    if ($estatus !== null)
    {
        $query->where('oc.estatus', $estatus);
    }
    
    return $query->orderBy('f.fecha_factura', 'desc')->get();
}
    
    /**
     * Obtener órdenes de hoy usando Eloquent
     */
    public static function obtenerOrdenesHoyEloquent($estatus = null)
    {
        $query = self::with(['sucursal', 'proveedor', 'responsable'])
            ->where('visible', '!=', 0) // <-- Añadido
            ->whereDate('created_at', now()->toDateString())
            ->orderBy('created_at', 'desc');
            
        if ($estatus !== null)
        {
            $query->where('estatus', $estatus);
        }
        
        return $query->get()
            ->map(function ($orden)
            {
                return [
                    'Fecha' => $orden->created_at,
                    'Correlativo' => $orden->id,
                    'Beneficiario' => $orden->sucursal->nombre ?? '',
                    'PROVEEDORES' => $orden->proveedor->nombre ?? '',
                    'Monto_en_Bs' => $orden->totalbs,
                    'Monto_en_dolares' => $orden->totalGeneral,
                    'Tasa_usada' => $orden->tasa_dia,
                    'Responsable' => $orden->responsable->nombre ?? '',
                    'Estatus' => $orden->estatus
                ];
            });
    }
    
    /**
     * Obtener estadísticas por estado
     */
    public static function obtenerEstadisticasPorFecha($fechaInicio, $fechaFin)
    {
        return DB::table('ordenes_compras')
            ->select(
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN estatus = 1 THEN 1 ELSE 0 END) as aprobadas'),
                DB::raw('SUM(CASE WHEN estatus = 0 THEN 1 ELSE 0 END) as pendientes')
            )
            ->where('visible', '!=', 0) // <-- Añadido
            ->whereDate('created_at', '>=', $fechaInicio)
            ->whereDate('created_at', '<=', $fechaFin)
            ->first();
    }
    
    public static function calcularPorcentajePendientesHoy()
    {
        $estadisticas = DB::table('ordenes_compras')
            ->select(
                DB::raw('COUNT(*) as total_ordenes_hoy'),
                DB::raw('SUM(CASE WHEN estatus = 0 THEN 1 ELSE 0 END) as ordenes_pendientes_hoy')
            )
            ->where('visible', '!=', 0) // <-- Añadido
            ->whereDate('created_at', now()->toDateString())
            ->first();
            
        // Evitar división por cero
        if ($estadisticas->total_ordenes_hoy > 0)
        {
            $porcentaje = ($estadisticas->ordenes_pendientes_hoy / $estadisticas->total_ordenes_hoy) * 100;
        }
        else
        {
            $porcentaje = 0;
        }
        
        return [
            'total_ordenes_hoy' => $estadisticas->total_ordenes_hoy ?? 0,
            'ordenes_pendientes_hoy' => $estadisticas->ordenes_pendientes_hoy ?? 0,
            'porcentaje_pendientes' => round($porcentaje, 2), // Redondeado a 2 decimales
            'fecha' => now()->toDateString()
        ];
    }
    
    // Relaciones
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal', 'id');
    }
    
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedores', 'id_proveedor');
    }
    
    public function responsable()
    {
        return $this->belongsTo(Responsable::class, 'responsable', 'id');
    }
    
    /**
     * Scope global para filtrar registros visibles
     */
    public function scopeVisible($query)
    {
        return $query->where('visible', '!=', 0);
    }
}