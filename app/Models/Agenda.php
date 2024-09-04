<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $table = 'agendas';

    protected $fillable = [
        'id','id_usuario', 'id_for_cli', 'titulo', 'created_at', 'data', 'descricao', 'cor','updated_at','contrato'
    ];
}
