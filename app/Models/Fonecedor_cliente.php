<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fonecedor_cliente extends Model
{
    use HasFactory;
    protected $table = 'fornecedor_clientes';
    protected $primaryKey = 'id_for_cli';
    
    protected $fillable = [
        'nome','descricao','id_usuario','cpfcnpj','cep','rua','bairro','created_at','updated_at','cidade','estado',
        'numero','telefone','email','complemento'
    ];
}
