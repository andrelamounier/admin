<?php

namespace App\Http\Controllers;

use App\Models\Centro_custo;
use App\Models\Contrato;
use App\Models\Fonecedor_cliente;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
        public function contratos(){
            $user_id = auth()->user()->id;
            if($user_id){
                $contratos = DB::table('contratos')
                ->select(['produtos.nome as produto','contratos.id_centro_custo','contratos.id_produto','fornecedor_clientes.nome as cliente','contratos.id_for_cli','contratos.data_pagamento','contratos.numero_contrato', 'contratos.data_inicio', 'contratos.data_fim', 'contratos.id_contrato', 'contratos.numero_contrato', 'contratos.data_reajuste', 'contratos.status', 'contratos.descricao', 'contratos.valor'])
               ->leftJoin('produtos', 'produtos.id_produto', '=', 'contratos.id_produto')
               ->join('fornecedor_clientes', 'fornecedor_clientes.id_for_cli', '=', 'contratos.id_for_cli')
               ->where('contratos.id_usuario', $user_id)
               ->orderBy('contratos.id_contrato', 'DESC')
               ->get();
               $for_cli = Fonecedor_cliente::select('nome','id_for_cli')->where('id_usuario', $user_id)->orderBy('nome')->get();
               $produto = Produto::select('nome','id_produto')->where('id_usuario', $user_id)->orderBy('nome')->get();
               $centro_custo = Centro_custo::select('nome','id_centro_custo')->where('id_usuario', $user_id)->orderBy('nome')->get();

                return view ('contrato/contrato',['contratos' => $contratos,'for_cli' => $for_cli,'produtos' => $produto,'centro_custo' => $centro_custo]);

            }else{
                return redirect('/');
            }
        }

        public function busca_contrato(Request $request){
            $numero = $request->numero;
            $user_id = auth()->user()->id;

            $contrato = Contrato::where('id_usuario', $user_id)
                                ->where('numero_contrato', $numero)
                                ->first();

            if ($contrato){
                return response()->json([
                    'status' => false,
                    'message' => 'Número de contrato já utilizado'
                ]);
            }else{
                return response()->json([
                    'status' => true
                ]);
            }
        }

        public function add_contrato(Request $request){
            if (!auth()->check()) {
                return redirect('/');
            }
            $user_id = auth()->user()->id;

            $numero_contrato = $request->numero_contrato;
            $id_contrato = $request->id_contrato;
            if (!$numero_contrato || !$request->for_cli_contrato || !$request->centro_custo_contrato || !$request->status_contrato) {
                return response()->json([
                    'status' => false,
                    'message' => 'Campos obrigatórios estão ausentes.'
                ]);
            }

            $contrato_existente = Contrato::where('id_usuario', $user_id)
                                        ->where('numero_contrato', $numero_contrato)
                                        ->first();

            if($contrato_existente && (!$id_contrato || $contrato_existente->id_contrato != $id_contrato)){
                return response()->json([
                    'status' => false,
                    'message' => 'Número de contrato já utilizado.'
                ]);
            }

            if($id_contrato){
                $contrato = Contrato::where('id_usuario', $user_id)
                                    ->where('id_contrato', $id_contrato)
                                    ->first();

                if(!$contrato){
                    return response()->json([
                        'status' => false,
                        'message' => 'Contrato não encontrado.'
                    ]);
                }
            }else{
                $contrato = new Contrato();
                $contrato->id_usuario = $user_id;
            }

            $contrato->id_produto = $request->produto_contrato;
            $contrato->valor = $request->valor_contrato;
            $contrato->status = $request->status_contrato;
            $contrato->data_inicio = $request->data_inicio_contrato;
            $contrato->data_fim = $request->data_fim_contrato;
            $contrato->data_reajuste = $request->data_reajuste_contrato;
            $contrato->data_pagamento = $request->data_vencimento_contrato;
            $contrato->id_for_cli = $request->for_cli_contrato;
            $contrato->numero_contrato = $numero_contrato;
            $contrato->descricao = $request->descricao_contrato;
            $contrato->id_centro_custo = $request->centro_custo_contrato;
            $contrato->save();

            return response()->json([
                'status' => true,
                'message' => 'Contrato salvo com sucesso.'
            ]);
        }



}
