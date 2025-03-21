<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $table = 'produtos';
    protected $primaryKey = 'id_produto';
    
    protected $fillable = [
        'id_usuario','nome','created_at','updated_at','descricao'
    ];
}
