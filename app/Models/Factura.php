<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'factura';
    
    // Si la clave primaria se llama diferente, ajusta esto:
    protected $primaryKey = 'id';
    
    // Si no tienes timestamps en esta tabla
    public $timestamps = false;
    
    protected $fillable = [
        'tipo',
        'numero',
        'orden_compra',
        'fecha_registro'
    ];

    // Relación inversa con proveedor
    public function orden_compra()
    {
        return $this->belongsTo(orden_compra::class, 'id', 'orden_compra');
    }

}
