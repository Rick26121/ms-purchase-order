<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'visible'
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
}