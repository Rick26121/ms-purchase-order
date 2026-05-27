<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipofactura extends Model
{
    use HasFactory;

    protected $table = 'tipo_factura';
    
    // Si la clave primaria se llama diferente, ajusta esto:
    protected $primaryKey = 'id';
    
    // Si no tienes timestamps en esta tabla
    public $timestamps = false;
    
    protected $fillable = [
        'tipo'];

}



