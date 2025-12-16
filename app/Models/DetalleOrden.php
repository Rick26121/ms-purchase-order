<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    use HasFactory;

    protected $table = 'detalles_o';
    
    protected $fillable = [
        'ordenes',
        'producto',
        'unidad',
        'cantidad',
        'precio'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'precio' => 'decimal:2'
    ];

    // Relaciones
    public function orden()
    {
        return $this->belongsTo(OrdenCompra::class, 'ordenes');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto');
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'unidad');
    }

    // Métodos de negocio
    public function calcularSubtotal()
    {
        return $this->cantidad * $this->precio;
    }
}