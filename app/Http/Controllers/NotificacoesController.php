<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Models\Notificacao;
use App\Models\Fonecedor_cliente;
use App\Models\Lancamento;
use App\Models\Produto;
use App\Models\User;
use Carbon\Carbon;

class NotificacoesController extends Controller
{
        public function email_vencimento(){
            $dataAtual = Carbon::today();

            // Buscar notificações com data_envio igual à data atual
            $notificacoes = Notificacao::whereDate('data_envio', $dataAtual)
                           ->where('enviado', 0)
                           ->get();


            foreach ($notificacoes as $notificacao) {
                $assunto = $notificacao->assunto;
                $de = $notificacao->de;
                $para = $notificacao->para;
                $mensagem = $notificacao->mensagem;
                // Enviar o e-mail
                Mail::raw($mensagem, function($message) use ($de, $para, $assunto) {
                    $message->from($de)
                            ->to($para)
                            ->subject($assunto);
                });
                $notificacao->enviado = 1;
                $notificacao->save();
            }
        }





}
