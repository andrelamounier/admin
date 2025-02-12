<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    use HasFactory;
    protected $table = 'galeria';

    protected $fillable = [
        'id','id_usuario', 'nome', 'titulo', 'created_at','descricao','updated_at'
    ];
}
