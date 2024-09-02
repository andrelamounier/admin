<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contratos';

    protected $primaryKey = 'id_contrato';

    protected $fillable = [
        'id_for_cli',
        'id_produto',
        'id_usuario',
        'numero_contrato',
        'data_inicio',
        'data_fim',
        'data_reajuste',
        'data_pagamento',
        'valor',
        'status',
        'descricao',
        'id_centro_custo'
    ];

}
