<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Fonecedor_cliente;
use App\Models\Produto;
use App\Models\Medicao;
use App\Models\Lancamento;
use App\Models\Notificacao;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class MedicaoController extends Controller
{


    public function medicao(){
        $user_id = auth()->user()->id;
        if($user_id){
            $medicoes = DB::table('medicoes_contratos')
            ->select([
                'medicoes_contratos.*',
                'produtos.nome as produto',
                'contratos.numero_contrato',
                'fornecedor_clientes.nome as cliente',
                'lancamentos.valor as valor'
            ])
            ->leftJoin('contratos', 'medicoes_contratos.id_contrato', '=', 'contratos.id_contrato')
            ->leftJoin('produtos', 'medicoes_contratos.id_produto', '=', 'produtos.id_produto')
            ->leftJoin('fornecedor_clientes', 'contratos.id_for_cli', '=', 'fornecedor_clientes.id_for_cli')
            ->leftJoin('lancamentos', 'lancamentos.id_lancamento', '=', 'medicoes_contratos.id_lancamento')
            ->where('medicoes_contratos.id_usuario', $user_id)
            ->orderBy('medicoes_contratos.id_medicao', 'DESC')
            ->get();

            $for_cli = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();
            $produto = Produto::select('nome','id_produto')->where('id_usuario', $user_id)->orderBy('nome')->get();

            return view ('contrato/medicao',['medicoes' => $medicoes,'for_cli' => $for_cli,'produtos' => $produto]);

        }else{
            return redirect('/');
        }
    }

    public function nova_medicao(){
        $user_id = auth()->user()->id;
        if ($user_id) {
            $contratos = DB::table('contratos')
                ->select([
                    'contratos.id_contrato',
                    'contratos.numero_contrato',
                    'contratos.data_pagamento',
                    'produtos.nome as produto',
                    'fornecedor_clientes.nome as cliente',
                    'contratos.valor',
                    'contratos.status'
                ])
                ->leftJoin('produtos', 'contratos.id_produto', '=', 'produtos.id_produto')
                ->leftJoin('fornecedor_clientes', 'contratos.id_for_cli', '=', 'fornecedor_clientes.id_for_cli')
                ->where('contratos.id_usuario', $user_id)
                ->where('contratos.status', 1)
                ->orderBy('contratos.id_contrato', 'DESC')
                ->get();

            return view('contrato/nova_medicao', ['contratos' => $contratos]);

        } else {
            return redirect('/');
        }
    }

    public function salvar_medicao(Request $request){

        $user_id = auth()->user()->id;
        if (!$user_id) {
            return redirect('/');
        }

        if (!$request->has('medicoes') || empty($request->medicoes)) {
            return response()->json([
                'status' => false,
                'message' => 'Nenhuma medição foi enviada.'
            ]);
        }

        DB::beginTransaction();
        try {
            // Percorre cada medição e salva no banco de dados
            foreach ($request->medicoes as $medicao) {
                // Verifica se o contrato é do usuário autenticado
                $contrato = Contrato::where('id_contrato', $medicao['id'])
                                    ->where('id_usuario', $user_id)
                                    ->first();

                if (!$contrato) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Contrato não encontrado.'
                    ]);
                }

                // Cria um novo lançamento
                $lancamento = new Lancamento();
                $lancamento->id_usuario = $user_id;
                $lancamento->id_produto = $contrato->id_produto;
                $lancamento->id_centro_custo = $contrato->id_centro_custo;
                $lancamento->id_for_cli = $contrato->id_for_cli;
                $lancamento->valor = !empty($medicao['valor']) ? abs(floatval($medicao['valor'])) : 0;
                $lancamento->tipo = 1;
                $lancamento->data_vencimento = $medicao['data_vencimento'];
                $lancamento->id_status = 2;
                $lancamento->save();


                $novaMedicao = new Medicao();
                $novaMedicao->id_usuario = $user_id;
                $novaMedicao->id_contrato = $contrato->id_contrato;
                $novaMedicao->ano_mes_referencia = $medicao['ano_mes_referencia'];
                $novaMedicao->id_produto = $contrato->id_produto;
                $novaMedicao->id_for_cli = $contrato->id_for_cli;
                $novaMedicao->vencimento = $medicao['data_vencimento'];
                $novaMedicao->id_lancamento = $lancamento->id_lancamento;
                $novaMedicao->save();

                if($medicao['notificacao']>0){
                    $data_vencimento = new DateTime($medicao['data_vencimento']);
                    $notificacao = $medicao['notificacao'];

                    switch ($notificacao) {
                        case 0:
                            $data_notificacao = null;
                            break;
                        case 1:
                            $data_notificacao = $data_vencimento->modify('-3 days')->format('Y-m-d');
                            break;
                        case 2:
                            $data_notificacao = $data_vencimento->format('Y-m-d'); // Dia do vencimento
                            break;
                        case 3:
                            $data_notificacao = $data_vencimento->modify('+1 day')->format('Y-m-d');
                            break;
                        case 4:
                            $data_notificacao = $data_vencimento->modify('+2 days')->format('Y-m-d');
                            break;
                        case 5:
                            $data_notificacao = $data_vencimento->modify('+3 days')->format('Y-m-d');
                            break;
                        case 6:
                            $data_notificacao = $data_vencimento->modify('+5 days')->format('Y-m-d');
                            break;
                        default:
                            $data_notificacao = null;
                            break;
                    }
                    $notificacao = new Notificacao();
                    $notificacao->id_usuario = $user_id;
                    $notificacao->tipo = '1';
                    $notificacao->id_lancamento = $lancamento->id_lancamento;
                    $notificacao->data_envio = $data_notificacao;
                    $notificacao->save();
                }


            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Medições e lançamentos salvos com sucesso.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Erro ao salvar as medições: ' . $e->getMessage()
            ], 500);
        }
    }

    public function del_medicao(Request $request){
        $user_id = auth()->user()->id;

        if (!$user_id) {
            return redirect('/');
        }

        $medicao_id = $request->input('id');
        if (!$medicao_id) {
            return response()->json([
                'status' => false,
                'message' => 'ID da medição não fornecido.'
            ]);
        }

        $medicao = Medicao::where('id_medicao', $medicao_id)
                        ->where('id_usuario', $user_id)
                        ->first();

        if(!$medicao){
            return response()->json([
                'status' => false,
                'message' => 'Medição não encontrada.'
            ]);
        }

        if($request->lancamento=='true'){
            $lancamento = Lancamento::where('id_lancamento', $medicao->id_lancamento)
                                    ->where('id_usuario', $user_id)
                                    ->first();

            if($lancamento){
                $lancamento->delete();
            }
        }

        $medicao->delete();

        return response()->json([
            'status' => true,
            'message' => 'Medição deletada com sucesso.'
        ]);
    }


}
