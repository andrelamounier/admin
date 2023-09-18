<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
class Helper
{
    public static function qutAgenda(){
        $user_id = auth()->user()->id;
        $sql = "SELECT COUNT(id) as qut
        FROM agendas 
        WHERE id_usuario=$user_id  AND data='".date("Y-m-d")."'";
        $notifi_agendas = DB::select($sql);
        return $notifi_agendas;
    }

    public static function qutContas(){
        $user_id = auth()->user()->id;
        $sql = "SELECT COUNT(id_lancamento) as qut
                    FROM lancamentos 
                    WHERE lancamentos.id_usuario=$user_id 
                    AND lancamentos.data_vencimento='".date("Y-m-d")."'
                    AND id_status in(2,3)";
        $notifi_contas = DB::select($sql);
        return $notifi_contas;
    }

}