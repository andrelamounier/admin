<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificacaoController extends Controller
{
    

        public function notificacoes(){

            $user_id = auth()->user()->id;
            $dataHoje = Carbon::now()->toDateString();

            DB::table('alertas')
            ->where('id_usuario', $user_id)
            ->whereDate('created_at', $dataHoje)
            ->update(['lida' => 1]);

            return response()->json(['status' => true]);
        }

}
