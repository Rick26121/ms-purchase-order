<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class metodoP extends Model
{
    use HasFactory;
    protected $table = 'metodopago';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = ['nombre'];

}


