<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = 'documentos';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nome','extensao','id_usuario','id_for_cli','caminho','tipo','texto','created_at','updated_at'
    ];
}
