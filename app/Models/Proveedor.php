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
    ];

    // Relación con la tabla bancos (uno a uno)
    public function bancos()
    {
        return $this->hasOne(Bancos::class, 'id_proveedor', 'id_proveedor');
    }
}