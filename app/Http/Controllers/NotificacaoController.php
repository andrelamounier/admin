<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Notificacao;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        public function del_email(Request $request){
            $userId = auth()->id();

            $notificacao = Notificacao::where('id_notificacao', $request->id_notificacao)
                ->where('id_usuario', $userId)
                ->first();

            if ($notificacao){
                $notificacao->delete();
                $status['status']=true;
            }else{
                $status['status']=false;
            }
            echo json_encode($status);
        }


        public function edit_email($id){
            if (!Auth::check()) {
                return redirect('/');
            }
            $userId = auth()->id();

            $email = Notificacao::where('id_notificacao', $id)
                ->where('id_usuario', $userId)
                ->first();

            if ($email) {
                return view('editar_email', ['email' => $email]);
            } else {
                return redirect('/notificacoes')
                    ->with('error', 'Email não encontrada.');
            }
        }

        public function editar_email(Request $request){
            if (!Auth::check()) {
                return redirect('/');
            }
            $userId = auth()->id();
            $id = $request->id;
            $email = Notificacao::where('id_notificacao', $id)
                ->where('id_usuario', $userId)
                ->first();

            if($email){
                $email->data_envio = $request->data;
                $email->enviado = $request->status;
                $email->para = $request->para;
                $email->assunto = $request->assunto;
                $email->mensagem = $request->texto;
                $email->save();
                return redirect('/notificacoes');
            }else{
                return redirect('/notificacoes')
                    ->with('error', 'Erro ao editar.');
            }
        }

}
