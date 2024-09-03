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
            $notificacoes = Notificacao::whereDate('data_envio', $dataAtual)->get();

            foreach ($notificacoes as $notificacao) {
                echo "teste";
                // Buscar o lançamento associado
                $lancamento = Lancamento::find($notificacao->id_lancamento);

                if (!$lancamento) {
                    continue; // Se o lançamento não existir, ignore
                }

                // Buscar o fornecedor
                $fornecedor = Fonecedor_cliente::find($lancamento->id_for_cli);

                if (!$fornecedor) {
                    continue; // Se o fornecedor não existir, ignore
                }

                $produto = Produto::find($lancamento->id_produto);

                if (!$produto) {
                    $nomeProduto = '';
                } else {
                    $nomeProduto = $produto->nome;
                }

                $user = User::find($lancamento->id_usuario);
                $nomeUsuario = $user->name;

                // Gerar a mensagem
                $dataPagamento = Carbon::parse($lancamento->data_pagamento);
                $mensagem = "Bom dia,\n\n";

                if ($dataPagamento->isToday()) {
                    $mensagem .= "Gostaríamos de lembrá-lo que hoje é a data de vencimento para o pagamento de \"$nomeProduto\".\n\n";
                } elseif ($dataPagamento->isPast()) {
                    $mensagem .= "Atenção! A data de vencimento para o pagamento da \"$nomeProduto\" já passou.\n\n";
                } else {
                    $mensagem .= "Estamos enviando este lembrete para o próximo vencimento do pagamento da \"$nomeProduto\".\n\n";
                }

                $mensagem .= "Data de Vencimento: " . $dataPagamento->format('d/m/Y') . "\n\n";
                $mensagem .= "Por favor, desconsidere este e-mail caso já tenha efetuado o pagamento. Não responda a este e-mail.\n\n";
                $mensagem .= "Atenciosamente,\n$nomeUsuario";

                // Enviar o e-mail
                Mail::raw($mensagem, function($message) use ($fornecedor) {
                    $message->to($fornecedor->email)
                            ->subject('Aviso de Vencimento de Pagamento');
                });

                $notificacao->enviado = 1;
                $notificacao->save();
            }
        }





}
