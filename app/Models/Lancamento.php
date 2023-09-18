<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lancamento extends Model
{
    use HasFactory;
    protected $table = 'lancamentos';
    protected $primaryKey = 'id_lancamento';
    
    protected $fillable = [
        'id_usuario','id_produto','id_centro_custo','id_for_cli','valor','tipo','id_status','created_at','updated_at',
        'data_vencimento','descricao','id_forma_pags','forma_pag'
    ];

    public function produtos(){
        return $this->hasOne(Produto::class, 'id_produto', 'id_produto');
    }

    public function centro_custos(){
        return $this->hasOne(Centro_custo::class, 'id_centro_custo', 'id_centro_custo');
    }

    public function fornecedor_clientes(){
        return $this->hasOne(Fonecedor_cliente::class, 'id_for_cli', 'id_for_cli');
    }

    public function status(){
        return $this->hasOne(Statu::class, 'id_status', 'id_status');
    }

}
