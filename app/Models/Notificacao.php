<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;

    protected $table = 'notificacoes';

    protected $primaryKey = 'id_notificacao';

    protected $fillable = [
        'tipo',
        'id_usuario',
        'data_envio',
        'id_lancamento',
        'data_inicio',
        'data_fim'
    ];

}
