<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;
    protected $table = 'alertas';

    protected $fillable = [
        'id_usuario', 'tipo', 'qut', 'created_at','updated_at'
    ];
}
