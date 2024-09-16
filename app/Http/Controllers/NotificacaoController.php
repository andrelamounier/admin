<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Notificacao;
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

        public function emails(){
            $user_id = auth()->user()->id;
            if($user_id){
                $emails = Notificacao::join('lancamentos', 'notificacoes.id_lancamento', '=', 'lancamentos.id_lancamento')
                                        ->join('fornecedor_clientes', 'lancamentos.id_for_cli', '=', 'fornecedor_clientes.id_for_cli')
                                        ->where('notificacoes.id_usuario', $user_id)
                                        ->orderBy('notificacoes.created_at', 'DESC')
                                        ->select('notificacoes.*', 'fornecedor_clientes.nome as cliente_nome')
                                        ->get();
                return view ('notificacoes_emails',['emails' => $emails]);
            }else{
                return redirect('/');
            }
        }


        public function getMensagem($id){
            $userId = auth()->id();
            $notificacao = Notificacao::where('id_notificacao', $id)
                ->where('id_usuario', $userId)
                ->first();

            if ($notificacao) {
                $mensagem = nl2br(e($notificacao->mensagem));
                return response()->json(['mensagem' => $mensagem]);
            } else {
                return response()->json(['mensagem' => 'Mensagem não encontrada.'], 404);
            }
        }



}
