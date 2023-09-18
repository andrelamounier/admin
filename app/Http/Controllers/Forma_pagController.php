<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forma_pag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class Forma_pagController extends Controller
{
    
    public function cartao(){
        $user_id = auth()->user()->id;
        if($user_id){
            $cartao = Forma_pag::where('id_usuario', $user_id)->where('tipo', 1)->orderBy('nome')->get();
            return view ('financeiro/cadastro_cartao',['cartao' => $cartao]);
        }else{
            return redirect('/');
        }
    }
    
    public function add_cartao(Request $request){
   
        $validator = Validator::make($request->all(), [
            'nome_cartao' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Insira um nome para o cartão.']);
        }
        if($request->get('data_fechamento_cartao')=='' || $request->get('data_fechamento_cartao')<1 || $request->get('data_fechamento_cartao')>31){
            return response()->json(['status' => false, 'message' => 'Preencha o campo data fechamento com o dia em que o cartão fecha.']);
        }
        if($request->get('data_vencimento_cartao')=='' || $request->get('data_vencimento_cartao')<1 || $request->get('data_vencimento_cartao')>31){
            return response()->json(['status' => false, 'message' => 'Preencha o campo data vencimento com o dia de vencimento da fatura do cartão.']);
        }
        $user_id = auth()->user()->id;
     
        if($request->get('id_cartao')){
            try {
                $cartao = Forma_pag::where('id_pag', $request->get('id_cartao'))->where('id_usuario', $user_id)->firstOrFail();
            } catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 401, tente novamente mais tarde ou entre em contado com suporte.']);
            }
            $cartao->nome = $request->get('nome_cartao');
            $cartao->status = $request->get('ativo_cartao') == 'on' ? 1 : 0;
            $cartao->data_vence = $request->get('data_vencimento_cartao');
            $cartao->data_fecha = $request->get('data_fechamento_cartao');
            try{
                $cartao->save();
            }catch (\Exception $e) {
                return response()->json(['status' => false, 'message' => 'Erro 402, tente novamente mais tarde ou entre em contado com suporte.']);
            }
        }else{
            $verifica_unico = Forma_pag::where('id_usuario', $user_id )->where('nome', $request->get('nome_cartao'))->first();
            if(!$verifica_unico){
                $cartao = new Forma_pag;
                $cartao->nome = $request->get('nome_cartao');
                $cartao->status = $request->get('ativo_cartao') == 'on' ? 1 : 0;
                $cartao->id_usuario = auth()->user()->id;
                $cartao->tipo = 1;
                $cartao->data_vence = $request->get('data_vencimento_cartao');
                $cartao->data_fecha = $request->get('data_fechamento_cartao');
                try{
                    $cartao->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 403, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }else{
                return response()->json(['status' => false, 'message' => 'Já existe um Cartão com esse nome.']);
            }

        }
        return response()->json(['status' => true]);
    }
    
}
