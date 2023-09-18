<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    
    public function index(){
        $user_id = auth()->user()->id;
        if($user_id){
            $produto = Produto::where('id_usuario', $user_id)->orderBy('nome')->get();
            return view ('financeiro/produto',['produtos' => $produto]);     
        }else{
            return redirect('/');
        }
    }

    public function add_produto(Request $request){

        $nome = $request->nome_produtos;
        $descricao = $request->descricao_produtos;
        $id = $request->id_produtos;
        $user_id = auth()->user()->id;
        
        if($user_id && $nome){
            if($id!=''){
                try {
                    $produto = Produto::where('id_usuario', $user_id )->where('id_produto', $id)->firstOrFail();
                } catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 203, tente novamente mais tarde ou entre em contado com suporte.']);
                }
                $produto->nome=$nome;
                $produto->descricao=$descricao;
                try{
                    $produto->save();
                }catch (\Exception $e) {
                    return response()->json(['status' => false, 'message' => 'Erro 204, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }else{
                $produto = Produto::where('id_usuario', $user_id )->where('nome', $nome)->first();
                if(!$produto){
                    $produto = new Produto;
                    $produto->nome=$nome;
                    $produto->descricao=$descricao;
                    $produto->id_usuario = $user_id;
                    try{
                        $produto->save();
                    }catch (\Exception $e) {
                        return response()->json(['status' => false, 'message' => 'Erro 209, tente novamente mais tarde ou entre em contado com suporte.']);
                    }
                }else{
                    return response()->json(['status' => false, 'message' => 'Erro 201, tente novamente mais tarde ou entre em contado com suporte.']);
                }
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Erro 202, tente novamente mais tarde ou entre em contado com suporte.']);
        }
        return response()->json(['status' => true]);
    }
    
    public function produtos(Request $request){
        $user_id = auth()->user()->id;
        if($user_id){
            $array= array(
                'consulta'=>$request->consulta,
                'Boleto'=>$request->boleto,
                'Conta'=>$request->conta,
                'Aluguel'=>$request->aluguel,
                'Salário'=>$request->salario,
                'Alimentação'=>$request->alimentacao,
                'Uber'=>$request->uber,
                'Indefinido'=>$request->indefinido
                );
            foreach($array as $k =>$item){
                if($item==1){
                    $produto = new Produto;
                    $produto->id_usuario=$user_id;
                    $produto->nome=$k;
                    $produto->save();
                }
            }
            $status['status']= true;
        }else{
            $status['status']=false;
        }
        echo json_encode($status);
    }

    function buscar_Prod(){
        $user_id = auth()->user()->id;
        $produto = Produto::where('id_usuario', $user_id)->orderBy('nome')->get();
        $status['options']='';
        foreach($produto as $item){
            $status['options'].="<option value='$item->id_produto'>$item->nome</option>";
        }
        $status['status']= true;
        return response()->json($status);
    }
    
}
