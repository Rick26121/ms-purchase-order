<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    // 🔹 Nombre de la tabla (opcional si sigue la convención "unidades")
    protected $table = 'unidades';

    // 🔹 Clave primaria (opcional si es 'id')
     protected $primaryKey = 'id_unidad';

    // 🔹 Campos que se pueden asignar en masa
 
    // 🔹 Si no usas timestamps (created_at, updated_at)
    public $timestamps = false;
    protected $fillable = ['abreviatura', 'nombre'];
    // 🔹 Si en algún momento una unidad tiene relación con productos:
    // public function productos()
    // {
    //     return $this->hasMany(Producto::class, 'unidad_id');
    // }
}
