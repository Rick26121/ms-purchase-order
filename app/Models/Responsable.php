<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;

    protected $table = 'responsable';
    
    // Si la clave primaria se llama diferente, ajusta esto:
    protected $primaryKey = 'id';
    
    // Si no tienes timestamps en esta tabla
    public $timestamps = false;
    
    protected $fillable = [
        'nombre'];

    
}
