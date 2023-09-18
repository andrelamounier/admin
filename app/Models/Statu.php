<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statu extends Model
{
    use HasFactory;
    protected $table = 'status';
    protected $primaryKey = 'id_status';
    
    protected $fillable = [
        'id_usuario','nome','created_at','updated_at','descricao','status'
    ];
}
