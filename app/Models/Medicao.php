<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicao extends Model
{
    use HasFactory;

    protected $table = 'medicoes_contratos';

    protected $primaryKey = 'id_medicao';

    protected $fillable = [
        'id_contrato',
        'id_usuario',
        'id_produto',
        'id_lancamento',
        'id_for_cli',
        'ano_mes_referencia',
        'data_inicio',
        'data_fim'
    ];

}
