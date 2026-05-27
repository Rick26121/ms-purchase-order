<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'ordenes_compras';
    
    protected $fillable = [
        'sucursal',
        'producto',
        'proveedores',
        'cantidad',
        'unidad',
        'totalGeneral',
        'tasa_dia',
        'moneda',
        'iva',
        'totalbs',
        'fecha_orden',
        'estatus',
        'visible',
        'usuario' // Agrega este campo si falta
    ];

    protected $casts = [
        'fecha_orden' => 'datetime',
        'totalGeneral' => 'decimal:2',
        'tasa_dia' => 'decimal:2',
        'iva' => 'decimal:2',
        'totalbs' => 'decimal:2',
        'cantidad' => 'integer',
        'visible' => 'boolean'
    ];

    // Relaciones
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedores');
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'unidad');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario');
    }

    /**
     * Scope para obtener datos completos de una orden
     */
    public function scopeConDetallesCompletos($query, $ordenId = null)
    {
        return $query->select(
            // Datos de la orden de compra
            'ordenes_compras.id AS orden_id',
            'ordenes_compras.fecha_orden',
            'ordenes_compras.cantidad',
            'un.abreviatura AS unidad',
            'ordenes_compras.totalGeneral AS total_general',
            'ordenes_compras.tasa_dia',
            'ordenes_compras.moneda',
            'ordenes_compras.iva',
            'ordenes_compras.totalbs',
            'ordenes_compras.estatus',
            'ordenes_compras.visible',
            
            // Datos de la sucursal
            's.nombre AS nombre_sucursal',
            's.direccion AS direccion_sucursal',
            's.telefono AS telefono_sucursal',
            
            // Datos del producto
            'p.nombre AS nombre_producto',
            'p.id AS codigo_producto',
            
            // Datos del proveedor
            'pr.nombre AS nombre_proveedor',
            'pr.rif AS rif_proveedor',
            'pr.direccion AS direccion_proveedor',
            'pr.telefono AS telefono_proveedor',
            'pr.correo AS email_proveedor',
            
            // Datos bancarios del proveedor
            'b.pagomovil',
            'b.bancos1',
            'b.bancos2',
            
            // Datos del usuario que registró
            'u.name AS nombre_usuario',
            
            // Fechas de auditoría
            'ordenes_compras.created_at',
            'ordenes_compras.updated_at'
        )
        ->leftJoin('sucursales AS s', 'ordenes_compras.sucursal', '=', 's.id')
        ->leftJoin('productos AS p', 'ordenes_compras.producto', '=', 'p.id')
        ->leftJoin('proveedores AS pr', 'ordenes_compras.proveedores', '=', 'pr.id_proveedor')
        ->leftJoin('bancos AS b', 'pr.id_proveedor', '=', 'b.id_proveedor')
        ->leftJoin('users AS u', 'ordenes_compras.usuario', '=', 'u.id')
        ->leftJoin('unidades AS un', 'ordenes_compras.unidad', '=', 'un.id_unidad')
        ->when($ordenId, function ($query) use ($ordenId) {
            return $query->where('ordenes_compras.id', $ordenId);
        })
        ->orderBy('ordenes_compras.id', 'DESC');
    }

    /**
     * Método estático para obtener una orden específica con detalles completos
     */
    public static function obtenerOrdenCompleta($ordenId)
    {
        return self::conDetallesCompletos($ordenId)->first();
    }

    /**
     * Método para ejecutar la consulta SQL pura (opcional)
     */
    public static function consultaRaw($ordenId)
    {
        return DB::select("
            SELECT 
                oc.id AS orden_id,
                oc.fecha_orden,
                oc.cantidad,
                un.abreviatura AS unidad,
                oc.totalGeneral AS total_general,
                oc.tasa_dia,
                oc.moneda,
                oc.iva,
                oc.totalbs,
                oc.estatus,
                oc.visible,
                
                s.nombre AS nombre_sucursal,
                s.direccion AS direccion_sucursal,
                s.telefono AS telefono_sucursal,
                
                p.nombre AS nombre_producto,
                p.id AS codigo_producto,
                
                pr.nombre AS nombre_proveedor,
                pr.rif AS rif_proveedor,
                pr.direccion AS direccion_proveedor,
                pr.telefono AS telefono_proveedor,
                pr.correo AS email_proveedor,
                
                b.pagomovil,
                b.bancos1,
                b.bancos2,
                
                u.name AS nombre_usuario,
                
                oc.created_at,
                oc.updated_at
                
            FROM ordenes_compras oc
            LEFT JOIN sucursales s ON oc.sucursal = s.id
            LEFT JOIN productos p ON oc.producto = p.id
            LEFT JOIN proveedores pr ON oc.proveedores = pr.id_proveedor
            LEFT JOIN bancos b ON pr.id_proveedor = b.id_proveedor
            LEFT JOIN users u ON oc.usuario = u.id
            LEFT JOIN unidades un ON oc.unidad = un.id_unidad
            WHERE oc.id = ?
            ORDER BY oc.id DESC
        ", [$ordenId]);
    }


public static function actualizarLlamado($id)
{
    return DB::select("
        SELECT 
            oc.sucursal,
            oc.proveedores,
            oc.moneda,
            oc.tasa_dia,
            oc.iva,
            oc.totalbs,
            prd.nombre,
            prd.precio,
            dto.cantidad,
            dto.unidad
        FROM ordenes_compras oc 
        INNER JOIN detalles_o dto ON oc.id = dto.ordenes
        INNER JOIN productos prd ON dto.producto = prd.id 
        WHERE oc.id = ?
    ", [$id]);
}


  public static function obtenerOrdenesActivas()
    {
        return self::select('id', 'tasa_dia', 'totalGeneral', 'totalbs', 'iva')
            ->where('estatus', '!=', 1)
            ->get();
    }
}




    
