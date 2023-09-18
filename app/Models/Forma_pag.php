<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forma_pag extends Model
{
    use HasFactory;
    protected $table = 'forma_pags';
    protected $primaryKey = 'id_pag';
    
    protected $fillable = [
        'id_pag','nome', 'id_usuario', 'status','created_at','updated_at','tipo','data_vencimento'
    ];
}
