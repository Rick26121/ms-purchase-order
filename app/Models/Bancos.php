<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
    use HasFactory;

    protected $table = 'bancos';
    
    // Si la clave primaria se llama diferente, ajusta esto:
    protected $primaryKey = 'id_banco';
    
    // Si no tienes timestamps en esta tabla
    public $timestamps = false;
    
    protected $fillable = [
        'id_proveedor',
        'pagomovil',
        'bancos1',
        'bancos2'
    ];

    // Relación inversa con proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor', 'id_proveedor');
    }
}