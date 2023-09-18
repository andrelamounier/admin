<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centro_custo extends Model
{
    use HasFactory;
    protected $table = 'centro_custos';
    protected $primaryKey = 'id_centro_custo';
    
    protected $fillable = [
        'id_centro_custo','nome', 'id_usuario', 'status','created_at','updated_at'
    ];
}
