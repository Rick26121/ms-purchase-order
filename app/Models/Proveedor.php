<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'rif',
        'correo',
        'telefono',
        'direccion',
        'fecha_registro',
    ];      
    
    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

    public function scopeBuscar($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('rif', 'like', "%{$search}%")
                    ->orWhere('correo', 'like', "%{$search}%");
    }

    public function scopeOrdenarPorFecha($query, $orden = 'desc')
    {
        return $query->orderBy('fecha_registro', $orden);
    }

    // Relación con bancos (1:1)
    public function bancos()
    {
        return $this->hasOne(Bancos::class, 'id_proveedor', 'id_proveedor');
    }
}