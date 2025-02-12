<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeria_item extends Model
{
    use HasFactory;
    protected $table = 'galeria_item';

    protected $fillable = [
        'id','id_usuario', 'id_documento', 'id_galeria', 'created_at','updated_at'
    ];
}
